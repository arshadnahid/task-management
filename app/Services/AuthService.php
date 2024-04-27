<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthService
{
    use ApiResponses;


    /**
     * Authenticate user login credentials and return token details if successful.
     *
     * @param string $email The user's email address.
     * @param string $password The user's password.
     * @return JsonResponse The response containing token details or error message.
     */
    public function login(string $email, string $password): JsonResponse
    {
        $data = [];
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (!$token = $this->guard()->attempt($credentials)) {
            return $this->sendErrors('Credentials do not match', [], 401);
        }


        $data['user'] = auth()->user();
        $data['token_details'] = $this->respondWithToken($token);


        return $this->sendResponse('Login successful!', $data);
    }


    public function userRegistration($request): JsonResponse
    {
        $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );
        return $this->sendResponse('Registration successful!', new UserResource($user));
    }


    public function userProfile(): JsonResponse
    {
        return $this->sendResponse('Successfully Get User Data', new UserResource($this->guard()->user()));
    }
    public function updateProfile($request): JsonResponse
    {
        $user=$this->guard()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return $this->sendResponse('Profile updated successfully!', new UserResource($user));
    }

    public function logout(): JsonResponse
    {
        $this->guard()->logout();
        return $this->sendResponse('Successfully logged out',[]);
    }

    public function refreshToken(): JsonResponse
    {
        $data = [];
        $data['user'] = $this->guard()->user();
        $data['token_details'] = $this->respondWithToken($this->guard()->refresh());
        return $this->sendResponse('Successfully Refreshed Token', $data);
    }


    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return array
     */
    protected function respondWithToken($token)
    {
        $data['access_token'] = $token;
        $data['token_type'] = 'bearer';
        $data['expires_in'] = auth()->factory()->getTTL() *    1;
        return $data;
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

}
