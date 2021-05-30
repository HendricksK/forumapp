<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use OpenApi\Annotations as OA;

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
 *    title="Laravel Forumapp",
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
});
