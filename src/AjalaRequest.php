<?php

namespace Ajala;

use GuzzleHttp\Psr7\Request;

class AjalaRequest
{
    private string $proxy;

    public function __construct($proxy)
    {
        $this->proxy = $proxy;
    }

    public function send($method, $url, $options = [], $headers = [], $body = null)
    {
        $response = new AjalaResponse();
        if ($this->proxy == true) {
            $method = 'POST';
            $url = 'https://proxy.example.com';
            $proxy_headers = [
                'User-Agent' => 'Ajala/1.0',
                'Content-type' => 'application/json'
            ];
            $payload = array(
                'method' => $method,
                'url' => $url,
                'options' => $options,
                'headers' => $headers,
                'body' => $body
            );

            $request = new Request($method, $url, $proxy_headers, json_encode($payload));
            return $response->processRequest($request, []);
        }
    }
}