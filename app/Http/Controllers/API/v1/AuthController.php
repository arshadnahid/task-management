<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdateUserProfileRequest;
use App\Http\Requests\Auth\UserRegistrationRequest;
use App\Services\AuthService;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use  ApiResponses;


    /**
     *  login user
     * @OA\Post(
     *      path="/api/login",
     *      tags={"Auth"},
     *      summary="Login user",
     *      description="The process of gaining access to a website by providing valid credentials.",
     *      operationId="login",
     *      @OA\RequestBody(
     *      required=true,
     *      description="Pass user data",
     *          @OA\JsonContent(
     *              required={"email" , "password"},
     *              @OA\Property(property="email", type="email", example="admin@gmail.com"),
     *              @OA\Property(property="password", type="string", example="123456"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="data", type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Mahmaud Arshad Nahid"),
     *                      @OA\Property(property="email", type="string", example="admin@gmail.com"),
     *                      @OA\Property(property="created_at", type="string", example="2024-02-05T07:52:41.000000Z"),
     *                      @OA\Property(property="updated_at", type="string", example="2024-02-05T07:52:41.000000Z"),
     *               ),
     *              @OA\Property(property="token_details", type="object",
     *                      @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vdGFzay1tYW5hZ2VtZW50LnRlc3QvYXBpL2xvZ2luIiwiaWF0IjoxNzEzOTUzNTk3LCJleHAiOjE3MTM5NTcxOTcsIm5iZiI6MTcxMzk1MzU5NywianRpIjoiNzVkY2FYYlZYUmFVYzVYSyIsInN1YiI6IjExIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.vD4a7RL-ElDK8u1PN1o1anC_N77oJXVKhxd0JvlC3zI"),
     *                      @OA\Property(property="token_type", type="string", example="bearer"),
     *                      @OA\Property(property="expires_in", type="string", example="3600"),
     *              ),
     *              @OA\Property(property="message", type="string", example="Login successful!"),
     *          )
     *      ),
     *     @OA\Response(
     *           response=401,
     *           description="Invalid user",
     *           @OA\JsonContent(
     *               @OA\Property(property="status", type="boolean", example="false"),
     *                @OA\Property(property="data", type="object", example="[]"),
     *                @OA\Property(property="message", type="string", example="Credentials do not match")
     *           )
     *       ),
     *       @OA\Response(
     *            response=422,
     *            description="Validation Error Has Occurred",
     *            @OA\JsonContent(
     *                @OA\Property(property="status", type="boolean", example="false"),
     *                 @OA\Property(property="data", type="object",
     *                       @OA\Property(property="email", type="string", example="The email field is required."),
     *                       @OA\Property(property="email.exists", type="string", example="Invalid Email."),
     *                       @OA\Property(property="password", type="string", example="The password field is required."),
     *                   ),
     *                 @OA\Property(property="message", type="string", example="Validation Error Has Occurred")
     *            )
     *        ),
     *            @OA\Response(
     *            response=404,
     *            description="Data not found!",
     *            @OA\JsonContent(
     *                @OA\Property(property="status", type="boolean", example="false"),
     *                @OA\Property(property="data", type="object", example="[]"),
     *                @OA\Property(property="message", type="string", example="Data not found!")
     *            )
     *        )
     *  )
     *  )
     */
    public function login(LoginRequest $loginRequest, AuthService $authService): JsonResponse
    {
        return $authService->login($loginRequest->email, $loginRequest->password);
    }

    public function userRegister(UserRegistrationRequest $registrationRequest, AuthService $authService): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $authService->userRegistration($registrationRequest->safe());
            DB::commit();
            return $user;
        } catch (\Error $th) {
            DB::rollBack();
            return $this->sendErrors(null, $th);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrors(null, $e);
        }
    }


    public function userProfile(AuthService $authService): JsonResponse
    {
        try {
            return $authService->userProfile();
        } catch (\Error $th) {
            return $this->sendErrors(null, $th);
        } catch (\Exception $e) {
            return $this->sendErrors(null, $e);
        }
    }

    public function updateProfile(UpdateUserProfileRequest $request, AuthService $authService): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $authService->updateProfile($request->safe());
            DB::commit();
            return $user;
        } catch (\Error $th) {
            DB::rollBack();
            return $this->sendErrors(null, $th);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrors(null, $e);
        }
    }

    /**
     * Logout
     *
     * @OA\Post (
     *     path="/api/logout",
     *     tags={"Auth"},
     *     description="Logout",
     *     @OA\RequestBody(
     *       required=false,
     *       description="Logout from the device"
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *
     *          @OA\JsonContent(
     *                   @OA\Property(property="status", type="boolean", example=true),
     *                   @OA\Property(property="data", type="object", example=null),
     *                   @OA\Property(property="message", type="string", example="Successfully Logout")
     *         )
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Invalid user",
     *
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example="false"),
     *               @OA\Property(property="data", type="object", example=null),
     *               @OA\Property(property="message", type="string", example="Invalid User")
     *          )
     *      )
     * )
     */
    public function logout(AuthService $authService): JsonResponse
    {
        try {
            return $authService->logout();
        } catch (\Error $th) {
            return $this->sendErrors(null, $th);
        } catch (\Exception $e) {
            return $this->sendErrors(null, $e);
        }
    }

    public function refreshToken(AuthService $authService): JsonResponse
    {
        try {
            return $authService->refreshToken();
        } catch (\Error $th) {
            return $this->sendErrors(null, $th);
        } catch (\Exception $e) {
            return $this->sendErrors(null, $e);
        }
    }

}
