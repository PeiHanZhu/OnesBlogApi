<?php

namespace App\Http\Controllers\Api;

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
     * @header token Bearer {personal-access-token}
     * @urlParam user integer required The id of the user. Example: 34
     * @bodyParam name string The name of the user. Example: Han
     * @bodyParam email string The email of the user. Example: han@gmail.com
     * @bodyParam password string The password of the user. Example: 1234567890
     * @responseFile 200 scenario="when user's information updated." responses/users.update/200.json
     * @responseFile 401 scenario="without personal access token." responses/401.json
     * @responseFile 404 scenario="when user not found." responses/users.update/404.json
     * @responseFile 422 scenario="when any validation failed." responses/users.update/422.json
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'email' => 'email|unique:users,email',
            'password' => 'string|min:6',
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
        !isset($data['password']) ?: $data['password'] = Hash::make($data['password']);

        ($user = $request->user())->update($data);

        return new UserResource($user->refresh());
    }
}
