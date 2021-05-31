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

Route::prefix('users')->group(function() {
    /**
     * @OA\Get(
     *     path="/users/all",
     *     summary="Gets all users",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An int value.")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    Route::get('/all', [UserController::class, 'getAllUsers']);
    /**
     * @OA\Get(
     *     path="/users/user{id}",
     *     summary="Gets a user based on id",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An int value.")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    Route::get('/user', function(Request $request) {
        $user = new UserController();
        $response = $user->getUser($request->query('id'));
        if ($response->isEmpty()) {
            return response()->json(['message' => 'Not Found.'], 404);
        }
        return $response;
    });

    /**
     * @OA\Post(
     *     path="/users/user{id}",
     *     summary="Create a user",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An int value.")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    Route::post('/user', function(Request $request) {
        $user = new User();
        $user->name = 'test user';
        $user->email = 'testuser@test' . rand() . '.com';
        $user->password = 'testtesttest';

        $userController = new UserController();
        $response = $userController->createUser($user);

        return $response;
    });

    /**
     * @OA\Post(
     *     path="/users/user{id}",
     *     summary="Create a user",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An int value.")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    Route::put('/user', function(Request $request) {
        $user = new User();
        $user->id = 5;
        $user->name = 'test user';
        $user->email = 'testuser@test' . rand() . '.com';
        $user->password = 'testtesttest';

        $userController = new UserController();
        $response = $userController->updateUser($user);
        if (empty($response)) {
            return response()->json(['message' => 'Not Found.'], 404);
        }
        return $response;
    });

        /**
     * @OA\Post(
     *     path="/users/user{id}",
     *     summary="Create a user",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An int value.")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    Route::patch('/user', function(Request $request) {
        $user = new User();
        $user->id = 5;
        $user->name = 'test user';
        $user->email = 'testuser@test' . rand() . '.com';
        $user->password = 'testtesttest';

        $userController = new UserController();
        $response = $userController->updateUser($user);
        if (empty($response)) {
            return response()->json(['message' => 'Not Found.'], 404);
        }
        return $response;
    });

    /**
     * @OA\Post(
     *     path="/users/user{id}",
     *     summary="Create a user",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An int value.")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    Route::delete('/user', function(Request $request) {
        $userController = new UserController();
        $response = $userController->deleteUser($request->input('id'));
        if (empty($response)) {
            return response()->json(['message' => 'Not Found.'], 404);
        }
        return $response;
    });
});
