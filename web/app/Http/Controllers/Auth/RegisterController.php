<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Utility\ApiClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private $apiClient;

    /**
     * Create a new controller instance.
     *
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Proxies a request to the API for user registration.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function register(Request $request)
    {
        try {
            $response = $this->apiClient->proxyRequest('api/users', [
                'method' => 'post',
                'form_params' => $request->post()
            ], config('app.admin_token'));
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        return response($response->getBody(), $response->getStatusCode(), ['Content-type' => 'application/json']);
    }
}
