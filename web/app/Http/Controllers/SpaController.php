<?php

namespace App\Http\Controllers;

use App\Utility\ApiClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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
        } else if ($request->hasCookie('refresh_token')){
            try {
                $response = $this->apiClient->refreshToken($request->cookie('refresh_token'));

                Cookie::queue('api_token', $response['access_token'], $response['expires_in'] / 60);
                Cookie::queue('refresh_token', $response['refresh_token']);

                $response = $this->apiClient->proxyRequest($request->getRequestUri(), [], $request->cookie('api_token'));
                return response($response->getBody(), $response->getStatusCode(), ['Content-type' => 'application/json']);
            } catch (RequestException $e) {
                return response($e->getResponse()->getBody(), $e->getResponse()->getStatusCode());
            }
        }

        return response('Unauthenticated', 401);
    }
}