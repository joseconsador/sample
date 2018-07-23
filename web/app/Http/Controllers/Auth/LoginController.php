<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Utility\ApiClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    private $apiClient;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient)
    {
        $this->middleware('guest')->except('logout');
        $this->apiClient = $apiClient;
    }

    /**
     * Send a token request to the API, stores the token in a cookie to be used on subsequent requests.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws GuzzleException
     */
    public function login(LoginRequest $request)
    {
        try {
            $response = $this->apiClient->requestToken($request->post('email'), $request->post('password'));

            Cookie::queue('api_token', $response['access_token'], $response['expires_in'] / 60);
            Cookie::queue('refresh_token', $response['refresh_token']);
            return response('ok');
        } catch (RequestException $e) {
            return response($e->getResponse()->getBody(), $e->getResponse()->getStatusCode());
        }
    }
}
