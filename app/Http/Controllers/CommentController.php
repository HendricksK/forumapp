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
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller implements Crud
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Get(
     *     path="/api/comment/comment?id={id}",
     *     summary="Gets a poscommentt based on id",
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

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->returnValidation($response, $validator);
        }

        $params = $request->all();

        return Comment::where('id', $params['id'])->get();
    }

    /**
     * @OA\Get(
     *     path="/api/comment/comment",
     *     summary="Gets all comments",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function getAllComment(Request $request) {
        return Comment::all();
    }

    /**
     * @OA\Post(
     *     path="/api/comment/comment",
     *     summary="Create a comment",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="data",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="post_id",
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
            'comment' => '',
            'error' => '',
            'status' => null,
        ];

        $validator = Validator::make($request->all(), [
            'data' => 'required',
            'post_id' => 'required',
        ]);
        
        if ($validator->fails()) {
           $response['error'] = $this->returnValidation($response, $validator);
           $response['comment'] = false;
           return $response;
        }

        $params = $request->all();
        $comment = new Comment();
        $comment->data = $params['data'];
        $comment->post_id = $params['post_id'];

        try {
            
            if (!Post::where('id', $comment->post_id)->get()->isEmpty()) {
                $comment->save();
                $response['comment'] = $comment->getAttributes();
                $response['error'] = false;
            } else {
                $response['comment'] = false;
                $response['error'] = 'Category does not exists';
            }
            
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            $response['comment'] = false;
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

    /**
     * @OA\put(
     *     path="/api/comment/comment",
     *     summary="Update a comment",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="data",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="post_id",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function update (Request $request) {
        $response = [
            'comment' => '',
            'error' => '',
            'status' => null,
        ];

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'data' => 'required',
            'post_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            $response['error'] = $this->returnValidation($response, $validator);
            $response['comment'] = false;
            return $response;
         }

        $params = $request->all();
        $comment = Comment::find($params['id']);
        
        if (empty($comment)) {
            $response['comment'] = false;
            $response['error'] = '404 Not Found';
            $response['status'] = 404;
            return $response;
        }

        $comment->data = $params['data'];
        $comment->post_id = $params['post_id'];
        
        try {

            $comment->save();
            $response['comment'] = $comment->getAttributes();
            $response['error'] = false;
            
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            $response['comment'] = false;
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

    /**
     * @OA\Delete(
     *     path="/api/comment/comment",
     *     summary="Delete a comment",
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
    public function delete (Request $request) {
        $response = [
            'comment' => null,
            'error' => '',
            'status' => null,
        ];

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        
        if ($validator->fails()) {
            $response['error'] = $this->returnValidation($response, $validator);
            $response['comment'] = false;
            return $response;
        }

        $params = $request->all();
        $comment = Comment::find($params['id']);

        if (empty($comment)) {
            $response['comment'] = false;
            $response['error'] = '404 Not Found';
            $response['status'] = 404;
            return $response;
        }

        try {
            $response['comment'] = $comment->delete();
            $response['error'] = false;
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

    private function returnValidation(array $response,  \Illuminate\Validation\Validator $validator) 
    {
        $response['comment'] = false;
        foreach($validator->messages()->all() as $msg) {
            $response['error'] .= $msg . ' ';
        }
        return json_encode($response);
    }

}