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

class PostController extends Controller implements Crud
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get (Request $request) {

        $response = [
            'post' => '',
            'error' => '',
        ];

        return $response;
    }

    public function create (Request $request) {
        $response = [
            'post' => '',
            'error' => '',
        ];

        return $response;
    }

    public function update (Request $request) {
        $response = [
            'post' => '',
            'error' => '',
        ];

        return $response;
    }

    public function delete (Request $request) {
        $response = [
            'post' => '',
            'error' => '',
        ];

        return $response;
    }

}