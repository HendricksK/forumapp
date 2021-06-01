<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Validation\Validator;

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
    public function getUser(int $id):collection 
    {
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
    public function getAllUsers():collection 
    {
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
    //TODO: add validation https://laravel.com/docs/8.x/validation
    public function createUser(Request $request) 
    {
        $response = [
            'user' => '',
            'error' => '',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
           return $this->returnValidation($response, $validator);
        }

        $params = $request->all();
        $user = new User();
        $user->name = $params['name'];
        $user->email = $params['email'];
        $user->password = $params['password'];

        try {
            
            if (User::where('email', $user->email)->get()->isEmpty()) {
                $user->save();
                $response['user'] = $user->getAttributes();
                $response['error'] = false;
            } else {
                $response['user'] = false;
                $response['error'] = 'User already exists';
            }
            
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            $response['user'] = false;
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

    /**
     * @OA\Put(
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
    public function updateUser(Request $request) 
    {

        $response = [
            'user' => '',
            'error' => '',
        ];

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->returnValidation($response, $validator);
         }

        $params = $request->all();
        $user = User::find($params['id']);
        $user->name = $params['name'];
        $user->email = $params['email'];
        $user->password = $params['password'];

        try {
            
            if ($user->id) {
                $user->save();
                $response['user'] = $user->getAttributes();
                $response['error'] = false;
            } else {
                $response['user'] = false;
                $response['error'] = 'User does not exist';
            }
            
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            $response['user'] = false;
            $response['error'] = $e->getMessage();
        }

        return $response;
        
    }

    /**
     * @OA\Delete(
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
    public function deleteUser(Request $request) 
    {

        $response = [
            'error' => '',
        ];

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->returnValidation($response, $validator);
         }

        $params = $request->all();
        $user = User::find($params['id']);

        if (!empty($user)) {
            try {
                $user->delete();
                $response['error'] = false;
            } catch (Exception $e) {
                Log::debug($e->getMessage());
                $response['error'] = $e->getMessage();
            }
            
        } else {
            $response['error'] = 'User does not exist';
        }

        return $response;
    }

    private function returnValidation(array $response,  \Illuminate\Validation\Validator $validator):array 
    {
        $response['user'] = false;
        foreach($validator->messages()->all() as $msg) {
            $response['error'] .= $msg . ' ';
        }
        return $response;
    }
}
