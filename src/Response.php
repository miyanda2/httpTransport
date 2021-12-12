<?php

namespace Ajala;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class Response
{
    public function processRequest(GuzzleRequest $request, Array $options)
    {
        $request_headers = array();
        foreach ($request->getHeaders() as $header_name => $header_values) {
            array_push($request_headers, [$header_name => $header_values[0]]);
        }

        $request_array = array(
            'headers' => $request_headers,
            'body' => $request->getBody()->getContents(),
            'method' => $request->getMethod(),
            'url' => array(
                'scheme' => $request->getUri()->getScheme(),
                'host' => $request->getUri()->getHost(),
                'port' => $request->getUri()->getPort(),
                'path' => $request->getUri()->getPath(),
                'query' => $request->getUri()->getQuery()
            )
        );

        $response_code = 500;
        $response_array = array(
            'headers' => null,
            'body' => null
        );

        $client = new Client();
        try {
            $request_content = array();
            $request_content['headers'] = $request_headers;
            $request_content['verify'] = false;
            if ($request_array['body'] != false) {
                $request_content['body'] = $request_array['body'];
            }

            $response = $client->request($request_array['method'], $request->getUri(), $request_content);

            $response_headers = array();
            foreach ($response->getHeaders() as $header_name => $header_values) {
                array_push($response_headers, [$header_name => $header_values[0]]);
            }

            $response_array['headers'] = $response_headers;
            $response_array['body'] = $response->getBody()->getContents();
            $response_code = $response->getStatusCode();
        } catch(RequestException $exception) {
            $response_headers = array();
            foreach ($response->getHeaders() as $header_name => $header_values) {
                array_push($response_headers, [$header_name => $header_values[0]]);
            }

            $response_array['headers'] = $response_headers;
            $response_array['body'] = $response->getBody()->getContents();
            $response_code = $response->getStatusCode();
        }

        $response_payload = array(
            'status_code' => $response_code,
            'response' => $response_array,
            'request' => $request_array
        );

        return json_encode($response_payload);
    }
}