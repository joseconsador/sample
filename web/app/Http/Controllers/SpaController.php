<?php

namespace App\Http\Controllers;

use App\Utility\ApiClient;
use Illuminate\Http\Request;

class SpaController extends Controller
{
    private $apiClient;

    /**
     * SpaController constructor.
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient) {
        $this->apiClient = $apiClient;
    }

    public function index()
    {
        return view('spa');
    }

    public function proxy(Request $request) {
        if ($request->hasCookie('api_token')) {
            $response = $this->apiClient->proxyRequest($request->getRequestUri(), [], $request->cookie('api_token'));
            return response($response->getBody(), $response->getStatusCode(), ['Content-type' => 'application/json']);
        }

        return 'ok';
    }
}