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

use App\Http\Interfaces\Crud;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller implements Crud
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Get(
     *     path="/api/post/post?id={id}",
     *     summary="Gets a post based on id",
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
    public function get(Request $request) {

        $response = [
            'post' => false,
            'comments' => null,
        ];

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->returnValidation($response, $validator);
        }

        $params = $request->all();
        $response['post'] = Post::where('id', $params['id'])->get();
        $comments = Post::find(8)->comments;

        foreach ($comments as $comment) {
            $response['comments'][] = $comment;
        }

        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/post/all",
     *     summary="Gets all posts",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function getAllPost(Request $request) {
        return Post::all();
    }

    /**
     * @OA\Post(
     *     path="/api/post/post",
     *     summary="Create a post",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="name",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="data",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="category_id",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function create(Request $request) {
        $response = [
            'post' => '',
            'error' => '',
            'status' => null,
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'data' => 'required',
            'category_id' => 'required',
        ]);
        
        if ($validator->fails()) {
           $response['error'] = $this->returnValidation($response, $validator);
           $response['post'] = false;
           return $response;
        }

        $params = $request->all();
        $post = new Post();
        $post->name = $params['name'];
        $post->data = $params['data'];
        $post->category_id = $params['category_id'];

        try {
            
            if (!Category::where('id', $post->category_id)->get()->isEmpty()) {
                $post->save();
                $response['post'] = $post->getAttributes();
                $response['error'] = false;
            } else {
                $response['post'] = false;
                $response['error'] = 'Category does not exists';
            }
            
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            $response['post'] = false;
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

    /**
     * @OA\put(
     *     path="/api/post/post",
     *     summary="Update a post",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="name",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="data",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="category_id",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function update(Request $request) {
        $response = [
            'post' => '',
            'error' => '',
            'status' => null,
        ];

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'data' => 'required',
            'category_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            $response['error'] = $this->returnValidation($response, $validator);
            $response['post'] = false;
            return $response;
         }

        $params = $request->all();
        $post = Post::find($params['id']);
        
        if (empty($post)) {
            $response['post'] = false;
            $response['error'] = '404 Not Found';
            $response['status'] = 404;
            return $response;
        }

        $post->name = $params['name'];
        $post->data = $params['data'];
        $post->category_id = $params['category_id'];
        
        try {

            $post->save();
            $response['post'] = $post->getAttributes();
            $response['error'] = false;
            
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            $response['post'] = false;
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

        /**
     * @OA\Delete(
     *     path="/api/post/post",
     *     summary="Delete a post",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="id",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function delete(Request $request) {
        $response = [
            'post' => null,
            'error' => '',
            'status' => null,
        ];

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        
        if ($validator->fails()) {
            $response['error'] = $this->returnValidation($response, $validator);
            $response['post'] = false;
            return $response;
        }

        $params = $request->all();
        $post = Post::find($params['id']);

        if (empty($post)) {
            $response['post'] = false;
            $response['error'] = '404 Not Found';
            $response['status'] = 404;
            return $response;
        }

        try {
            $response['post'] = $post->delete();
            $response['error'] = false;
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

    private function returnValidation(array $response,  \Illuminate\Validation\Validator $validator) 
    {
        $response['post'] = false;
        foreach($validator->messages()->all() as $msg) {
            $response['error'] .= $msg . ' ';
        }
        return json_encode($response);
    }

}