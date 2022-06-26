<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register a user with a personal access token for the device.
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

        if($validator->fails()) {
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
        $user->token = $user->createToken($request->input('device_name'))->plainTextToken;

        return new UserResource($user);
    }

    /**
     * Login a user with a new personal access token for the device.
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
        if (is_null($user) || !Hash::check($request->input('password'), $user->password)) {
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
     * Logout a user all the personal access tokens being revoked on the device.
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
}
