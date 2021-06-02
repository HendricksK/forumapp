<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * @OA\Info(
 *    title="Laravel",
 *    version="1.0.0",
 * )
 */

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('users')->group(function() 
{
    Route::get('/all', [UserController::class, 'getAllUsers']);

    Route::get('/user', function(Request $request) 
    {
        $userController = new UserController();
        $response = $userController->getUser($request->query('id'));
        if ($response->isEmpty()) {
            return response()->json(['message' => 'Not Found.'], 404);
        }
        return $response;
    });

    Route::post('/user', function(Request $request) 
    {
        $userController = new UserController();
        $response = $userController->createUser($request);
        if ($response['user']) {
            return $response['user'];
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });

    Route::put('/user', function(Request $request) 
    {
        $userController = new UserController();
        $response = $userController->updateUser($request);
        if ($response['user']) {
            return $response['user'];
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });

    Route::delete('/user', function(Request $request) 
    {
        $userController = new UserController();
        $response = $userController->deleteUser($request);
        if (!empty($response['error'])) {
            return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
        }
        return $response;
    });
});
