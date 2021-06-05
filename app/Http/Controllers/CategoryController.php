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

use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;

class CategoryController extends Controller implements Crud
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Get(
     *     path="/api/category/category?id={id}",
     *     summary="Gets a category based on id",
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

        return Category::where('id', $params['id'])->get();

    }

    /**
     * @OA\Get(
     *     path="/api/category/all",
     *     summary="Gets all categories",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    // TODO: add limiter, and range.
    public function getAllCategory() {
        return Category::all();
    }
    
    /**
     * @OA\Post(
     *     path="/api/category/category",
     *     summary="Create a category",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="name",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="parent",
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
            'category' => '',
            'error' => '',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'parent' => 'required',
        ]);
        
        if ($validator->fails()) {
           $response['error'] = $this->returnValidation($response, $validator);
           $response['category'] = false;
           return $response;
        }

        $params = $request->all();
        $category = new Category();
        $category->name = $params['name'];
        $category->parent = $params['parent'];

        try {
            
            if (Category::where('name', $category->name)->get()->isEmpty()) {
                $category->save();
                $response['category'] = $category->getAttributes();
                $response['error'] = false;
            } else {
                $response['category'] = false;
                $response['error'] = 'Category already exists';
            }
            
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            $response['category'] = false;
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

    /**
     * @OA\put(
     *     path="/api/category/category",
     *     summary="Update a category",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="id",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="name",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="parent",
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
            'category' => '',
            'error' => '',
        ];

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'parent' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->returnValidation($response, $validator);
         }

        $params = $request->all();
        $category = Category::find($params['id']);
        $category->name = $params['name'];
        $category->parent = $params['parent'];
      
        try {
            if (Category::where('name', $category->name)->get()->isEmpty()) {
                $category->save();
                $response['category'] = $category->getAttributes();
                $response['error'] = false;
            } else {
                $response['category'] = false;
                $response['error'] = 'Category name already exists';
            }
            
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            $response['category'] = false;
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

    /**
     * @OA\Delete(
     *     path="/api/category/category",
     *     summary="Delete a category",
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
            'error' => '',
        ];

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->returnValidation($response, $validator);
        }

        $params = $request->all();
        $category = Category::find($params['id']);

        if (!empty($category)) {
            try {
                $category->delete();
                $response['error'] = false;
            } catch (Exception $e) {
                Log::debug($e->getMessage());
                $response['error'] = $e->getMessage();
            }
            
        } else {
            $response['error'] = 'category does not exist';
        }

        return $response;
    }

    private function returnValidation(array $response,  \Illuminate\Validation\Validator $validator) 
    {
        $response['category'] = false;
        foreach($validator->messages()->all() as $msg) {
            $response['error'] .= $msg . ' ';
        }
        return json_encode($response);
    }

}