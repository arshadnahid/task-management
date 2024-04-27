<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      x={
 *          "logo": {
 *              "url": "https://via.placeholder.com/190x90.png?text=L5-Swagger"
 *          }
 *      },
 *      title="tssk-management ",
 *      description="Task Management Swagger api documentation",
 *      @OA\Contact(
 *          email=""
 *      ),
 * ),
 *   @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token Like Bearer 10|4yB0GEn8fX9JHtXGwT0hOckxIqDkNiiaXmzwOTw36c325624",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     securityScheme="sanctum",
 * )
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
