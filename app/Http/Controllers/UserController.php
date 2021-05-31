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
    
    public function getUser(int $id):collection {
        return User::where('id', $id)->get();
    }

    public function getAllUsers():collection {
        return User::all();
    }

    public function createUser(user $user):bool {
        return $user->save();
    }

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

    public function deleteUser(int $id):bool {
        $userDelete = User::find($id);
        if (!empty($userDelete)) {
            return $userDelete->delete();
        }
        return false;
    }
}
