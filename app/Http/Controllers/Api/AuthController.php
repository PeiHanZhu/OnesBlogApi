<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\ResetCodePassword;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use NextApps\VerificationCode\Support\CodeGenerator;
use NextApps\VerificationCode\VerificationCode;

/**
 * Class AuthController.
 *
 * @group 01. Authentication and Users
 */
class AuthController extends Controller
{
    /**
     * Register a user with a personal access token for the device.
     *
     * @bodyParam name string required The name of the user. Example: Han
     * @bodyParam email string required The email of the user. Example: han@gmail.com
     * @bodyParam password string required The password of the user. Example: 123456
     * @bodyParam device_name string required The device name of the user. Example: iPhone
     * @responseFile 201 scenario="when registration succeeded." responses/auth.register/201.json
     * @responseFile 422 scenario="when any validation failed." responses/auth.register/422.json
     *
     * @param param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'device_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $request->only([
            'name',
            'email',
            'password',
        ]);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        VerificationCode::send($data['email']);

        return new UserResource($user);
    }

    /**
     * Login a user with a new personal access token for the device.
     *
     * @bodyParam email string required The email of the user. Example: han@gmail.com
     * @bodyParam password string required The password of the user. Example: 123456
     * @bodyParam device_name string required The device name of the user. Example: iPhone
     * @responseFile 200 scenario="when login succeeded." responses/auth.login/200.json
     * @responseFile 422 scenario="when any validation failed." responses/auth.login/422.json
     *
     * @param param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'device_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where('email', $request->input('email'))->first();
        if (is_null($user) || !Hash::check($request->input('password'), $user->password) || !$user->hasVerifiedEmail()) {
            return response()->json([
                'data' => [
                    'email' => [
                        __('auth.failed'),
                    ],
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->tokens()->where('name', $request->input('device_name'))->delete();
        $user->token = $user->createToken($request->input('device_name'))->plainTextToken;

        return new UserResource($user);
    }

    /**
     * Logout a user with all the personal access tokens being revoked on the device.
     *
     * @authenticated
     * @header Authorization Bearer {personal-access-token}
     * @bodyParam device_name string required The device's name of the user. Example: iPhone
     * @responseFile 200 scenario="when logout succeeded." responses/auth.logout/200.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     *
     * @param param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $request->user();
        $user->tokens()->where('name', $request->input('device_name'))->delete();
        return new UserResource($user);
    }

    /**
     * After registration, verify the user's email with a code.
     *
     * @bodyParam email string required The email of the user. Example: hanTest@gmail.com
     * @bodyParam code string required The code of the user. Example: VYB6P9
     * @responseFile 200 scenario="when verify succeeded." responses/auth.verifyCode/200.json
     * @responseFile 422 scenario="when verify incorrect." responses/auth.verifyCode/422.json
     */
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = User::where('email', $request->input('email'))->first();
        if (VerificationCode::verify($request->input('code'), $request->input('email'))) {
            $user->markEmailAsVerified();
        } else {
            return response()->json([
                'data' => [
                    'email' => [
                        'The code is incorrect.'
                    ],
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new UserResource($user);
    }

    /**
     * After registration, resend verification code to verify the user's email.
     *
     * @bodyParam email string required The email of the user. Example: hanTest@gmail.com
     * @responseFile 200 scenario="when verification code successfully resended." responses/auth.verifyCode/200.json
     * @responseFile 422 scenario="when any validation failed." responses/auth.verifyCode/422.json
     */
    public function resendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        VerificationCode::send($request->input('email'));

        return response()->json([
            'data' => 'Success'
        ], Response::HTTP_OK);
    }

    /**
     * When a user forgot password, send a verification code to the user.
     *
     * @bodyParam email string required The email of the user. Example: hanTest@gmail.com
     * @responseFile 200 scenario="when email successfully sended." responses/auth.forgotPassword/200.json
     * @responseFile 422 scenario="when any validation failed." responses/auth.forgotPassword/422.json
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (is_null(User::where('email', $request->input('email'))->value('email_verified_at'))) {
            return response()->json([
                'data' => [
                    'email' => __('auth.failed')
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        ResetCodePassword::create([
            'email' => $request->input('email'),
            'code' => Hash::make($code = app(CodeGenerator::class)->generate()),
        ]);
        Notification::route('mail', $request->input('email'))->notify(new ResetPasswordNotification($code));

        return response()->json([
            'data' => 'Success'
        ]);
    }

    /**
     * During forgetting password, verify the user's email with a code.
     *
     * @bodyParam email string required The email of the user. Example: hanTest@gmail.com
     * @bodyParam code string required The code of the user. Example: VYB6P9
     * @responseFile 200 scenario="when password successfully updated." responses/auth.checkCode/200.json
     * @responseFile 422 scenario="when any validation failed." responses/auth.checkCode/422.json
     */
    public function checkCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (is_null($resetCodePassword = ResetCodePassword::where([
            ['email', $request->input('email')],
            ['expires_at', '>=', now()],
        ])->first(['code'])) or !Hash::check($request->input('code'), $resetCodePassword->code)) {
            return response()->json([
                'data' => __('auth.code')
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'data' => 'Success'
        ], Response::HTTP_OK);
    }

    /**
     * After the user verified during forgetting password, reset password in storage.
     *
     * @bodyParam email string required The email of the user. Example: hanTest@gmail.com
     * @bodyParam code string required The code of the user. Example: VYB6P9
     * @bodyParam password string required The password of the user. Example: 123456
     * @responseFile 200 scenario="when verify succeeded." responses/auth.verifyCode/200.json
     * @responseFile 422 scenario="when any validation failed." responses/auth.verifyCode/422.json
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $record = ResetCodePassword::where([
            ['email', $request->input('email')],
            ['expires_at', '>=', now()],
        ]);
        if (is_null($record->first(['code']))){
            return response()->json([
                'data' => __('auth.failed')
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $user = User::where('email', $request->input('email'));
            $user->update(['password' => Hash::make($request->input('password'))]);
            $record->delete();
        }

        return response()->json([
            'data' => 'Success'
        ], Response::HTTP_OK);
    }
}
