<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Collection;

use App\Models\User;

class UserController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {}
    

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
    public function getUser(int $id):collection {
        return User::where('id', $id)->get();
    }

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
    public function getAllUsers():collection {
        return User::all();
    }

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
    public function createUser(user $user):bool {
        return $user->save();
    }

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
    public function updateUser(user $user):bool {
        $userUpdate = User::find($user->id);
        if (!empty($userUpdate)) {
            $userUpdate->name = $user->name;
            $userUpdate->email = $user->email;
            $userUpdate->password = $user->password;
            return $userUpdate->save();
        }
        return false;
        
    }

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
    public function deleteUser(int $id):bool {
        $userDelete = User::find($id);
        if (!empty($userDelete)) {
            return $userDelete->delete();
        }
        return false;
    }
}
