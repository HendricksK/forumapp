<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\ApiLogger;

class ApiLoggerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {}

    public function log(Request $request, JsonResponse $response) {
        $logger = new ApiLogger();

        $request_object = [
            'path' => $request->getPathInfo(),
            'method' => $request->getMethod(),
            'attributes' => $request->all(),
        ];
        
        $logger->request = json_encode($request_object);
        $logger->response = $response->getContent();
        $logger->http_code = $response->getStatusCode();
        $logger->method = $request->getMethod();
        $logger->save();
    }
}
