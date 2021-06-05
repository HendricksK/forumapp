<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
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

Route::prefix('user')->middleware('apilogger')->group(function() {
    Route::get('/all', [UserController::class, 'getAllUsers']);

    Route::get('/user', function(Request $request) {
        $userController = new UserController();
        $response = $userController->getUser($request->query('id'));
        if ($response->isEmpty()) {
            return response()->json(['message' => 'Not Found.'], 404);
        }
        return $response;
    });

    Route::post('/user', function(Request $request) {
        $userController = new UserController();
        $response = $userController->createUser($request);
        if ($response['user']) {
            return $response['user'];
        }
        if ($response['status']) {
            return response()->json(['message' => $response['error']], $response['status']);
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });

    Route::put('/user', function(Request $request) {
        $userController = new UserController();
        $response = $userController->updateUser($request);
        if ($response['user']) {
            return $response['user'];
        }
        if ($response['status']) {
            return response()->json(['message' => $response['error']], $response['status']);
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });

    Route::delete('/user', function(Request $request) {
        $userController = new UserController();
        $response = $userController->deleteUser($request);
        if ($response['error']) {
            return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
        }
        if ($response['status']) {
            return response()->json(['message' => $response['error']], $response['status']);
        }
        return $response;
    });
});

Route::prefix('comment')->middleware('apilogger')->group(function() {
    Route::get('/all', [CommentController::class, 'getAllComment']);
    Route::get('/comment', function(Request $request) {
        $commentController = new CommentController();
        $response = $commentController->get($request);
        if ($response->isEmpty()) {
            return response()->json(['message' => 'Not Found.'], 404);
        }
        return $response;
    });
    Route::post('/comment', function(Request $request) {
        $commentController = new CommentController();
        $response = $commentController->create($request);
        if ($response['comment']) {
            return $response['comment'];
        }
        if ($response['status']) {
            return response()->json(['message' => $response['error']], $response['status']);
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });
    Route::put('/comment', function(Request $request) {
        $commentController = new CommentController();
        $response = $commentController->update($request);
        if ($response['comment']) {
            return $response['comment'];
        }
        if ($response['status']) {
            return response()->json(['message' => $response['error']], $response['status']);
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });
    Route::delete('/comment', function(Request $request) {
        $commentController = new CommentController();
        $response = $commentController->delete($request);

        if ($response['comment']) {
            return $response['comment'];
        }
        if ($response['status']) {
            return response()->json(['message' => $response['error']], $response['status']);
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });
});


Route::prefix('post')->middleware('apilogger')->group(function() {
    Route::get('/all', [PostController::class, 'getAllPost']);
    Route::get('/post', function(Request $request) {
        $postController = new PostController();
        $response = $postController->get($request);
        if ($response->isEmpty()) {
            return response()->json(['message' => 'Not Found.'], 404);
        }
        return $response;
    });
    Route::post('/post', function(Request $request) {
        $postController = new PostController();
        $response = $postController->create($request);
        if ($response['post']) {
            return $response['post'];
        }
        if ($response['status']) {
            return response()->json(['message' => $response['error']], $response['status']);
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });
    Route::put('/post', function(Request $request) {
        $postController = new PostController();
        $response = $postController->update($request);
        if ($response['post']) {
            return $response['post'];
        }
        if ($response['status']) {
            return response()->json(['message' => $response['error']], $response['status']);
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });
    Route::delete('/post', function(Request $request) {
        $postController = new PostController();
        $response = $postController->delete($request);
        if ($response['post']) {
            return $response['post'];
        }
        if ($response['status']) {
            return response()->json(['message' => $response['error']], $response['status']);
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });
});

Route::prefix('category')->middleware('apilogger')->group(function() {
    Route::get('/all', [CategoryController::class, 'getAllCategory']);
    Route::get('/category', function(Request $request) {
        $categoryController = new CategoryController();
        $response = $categoryController->get($request);
        if ($response->isEmpty()) {
            return response()->json(['message' => 'Not Found.'], 404);
        }
        return $response;
    });
    Route::post('/category', function(Request $request) {
        $categoryController = new CategoryController();
        $response = $categoryController->create($request);

        if ($response['category']) {
            return $response['category'];
        }
        if ($response['category']) {
            return response()->json(['message' => $response['error']], $response['status']);
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });
    Route::put('/category', function(Request $request) {
        $categoryController = new CategoryController();
        $response = $categoryController->update($request);

        if ($response['category']) {
            return $response['category'];
        }
        if ($response['category']) {
            return response()->json(['message' => $response['error']], $response['status']);
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });
    Route::delete('/category', function(Request $request) {
        $categoryController = new CategoryController();
        $response = $categoryController->delete($request);
        
        if ($response['category']) {
            return $response['category'];
        }
        if ($response['category']) {
            return response()->json(['message' => $response['error']], $response['status']);
        }
        return response()->json(['message' => 'Bad Request. ' . $response['error']], 400);
    });
});
