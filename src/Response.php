<?php

namespace Ajala;

use GuzzleHttp\Psr7\Request as GuzzleRequest;

class Response
{
    public function processRequest(GuzzleRequest $request, Array $options)
    {
        $request_headers = array();
        foreach ($request->getHeaders() as $header_name => $header_values) {
            array_push($request_headers, [$header_name => $header_values[0]]);
        }

        $response_array = array(
            'headers' => null,
            'body' => null
        );
    }
}