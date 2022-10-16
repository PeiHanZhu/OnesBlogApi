<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserLoginTypeIdEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class UserController.
 *
 * @group 01. Authentication and Users
 */
class UserController extends Controller
{
    /**
     * Update the specified user in storage.
     *
     * @authenticated
     * @header Authorization Bearer {personal-access-token}
     * @urlParam user integer required The id of the user. Example: 34
     * @bodyParam name string The name of the user. Example: Han
     * @bodyParam login_type_id integer The login type id of the user. Example: 1
     * @bodyParam password string The password of the user. Example: 1234567890
     * @responseFile 200 scenario="when user's information updated." responses/users.update/200.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 404 scenario="when user not found." responses/users.update/404.json
     * @responseFile 422 scenario="when any validation failed." responses/users.update/422.json
     * @responseFile 422 scenario="when user without location." responses/users.update/422_without_location.json
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'login_type_id' => 'numeric|between:1,2',
            'password' => 'string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($request->input('login_type_id') == UserLoginTypeIdEnum::LOCATION) {
            if (is_null($user->location) or !$user->location->active) {
                return response()->json([
                    'data' => [
                        'email' => __('auth.none_location_user')
                    ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $data = $request->only([
            'name',
            'login_type_id',
            'password',
        ]);
        !isset($data['password']) ?: $data['password'] = Hash::make($data['password']);

        ($user = $request->user())->update($data);

        return new UserResource($user->refresh());
    }
}
