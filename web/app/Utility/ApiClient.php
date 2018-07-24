<?php

namespace App\Utility;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class ApiClient
{
    private $httpClient;

    /**
     * ApiClient constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->httpClient = $client;
    }

    /**
     * Requests an access token using email and password.
     *
     * @param $email
     * @param $password
     * @return mixed
     * @throws GuzzleException
     */
    public function requestToken($email, $password) {
        $options = [
            'method' => 'post',
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => config('services.restaurant.client_id'),
                'client_secret' => config('services.restaurant.client_secret'),
                'username' => $email,
                'password' => $password,
                'scope' => '',
            ],
        ];

        return json_decode($this->send('/oauth/token', $options)->getBody(), true);
    }

    /**
     * @param $refreshToken
     * @return mixed
     * @throws GuzzleException
     */
    public function refreshToken($refreshToken) {
        $options = [
            'method' => 'post',
            'form_params' => [
                'grant_type' => 'refresh_token',
                'client_id' => config('services.restaurant.client_id'),
                'client_secret' => config('services.restaurant.client_secret'),
                'refresh_token' => $refreshToken,
                'scope' => '',
            ],
        ];

        return json_decode($this->send('/oauth/token', $options)->getBody(), true);
    }

    /**
     * @param $endpoint
     * @param $options
     * @param $accessToken
     * @return Response
     * @throws GuzzleException
     */
    public function proxyRequest($endpoint, $options, $accessToken) {
        $options = array_merge(
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ],
            $options
        );

        return $this->send($endpoint, $options);
    }

    /**
     * Wraps API calls to attach default headers.
     *
     * @param $endpoint
     * @param $options
     * @return mixed
     * @throws GuzzleException
     */
    private function send($endpoint, $options) {
        $options = array_merge(
            [
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ],
            $options
        );

        return $this->httpClient->request($options['method'], $endpoint, $options);
    }
}