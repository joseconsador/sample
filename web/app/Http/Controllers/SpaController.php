<?php

namespace App\Http\Controllers;

use App\Utility\ApiClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class SpaController extends Controller
{
    private $apiClient;

    /**
     * SpaController constructor.
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Display the base template.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('spa');
    }

    /**
     * Proxies request to the REST API. Uses the api_token from the cookie as access token,
     * if the access token expires and a refresh_token is available, this requests for a new token
     * and attaches that to the request and response.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function proxy(Request $request)
    {
        if ($request->hasCookie('api_token') || $request->hasCookie('refresh_token')) {
            try {
                $options = ['method' => $request->method()];

                if (in_array($request->method(), ['POST', 'PUT'])) {
                    $options['form_params'] = $request->input();
                }

                $response = $this->apiClient->proxyRequest(
                    $request->getRequestUri(),
                    $options,
                    $request->cookie('api_token')
                );

                return response($response->getBody(), $response->getStatusCode(), ['Content-type' => 'application/json']);
            } catch (RequestException $e) {
                $response = $e->getResponse();

                // If a refresh_token exists and the response was a 401, try a refresh.
                if ($request->hasCookie('refresh_token') && $e->getCode() == Response::HTTP_UNAUTHORIZED) {
                    $response = $this->apiClient->refreshToken($request->cookie('refresh_token'));

                    Cookie::queue('api_token', $response['access_token'], $response['expires_in'] / 60);
                    Cookie::queue('refresh_token', $response['refresh_token']);

                    $response = $this->apiClient->proxyRequest($request->getRequestUri(), [], $response['access_token']);
                }

                return response($response->getBody(), $response->getStatusCode(), ['Content-type' => 'application/json']);
            }
        }

        return response('Unauthenticated', Response::HTTP_UNAUTHORIZED);
    }
}
