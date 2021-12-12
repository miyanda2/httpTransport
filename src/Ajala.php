<?php 
namespace Ajala;

class Ajala
{
    private bool $use_proxy;
    private array $guzzle_options;

    public function __construct()
    {
        $this->use_proxy = false;
        $this->guzzle_options = null;
    }

    public function get($url, $headers = [], $body = null, $proxy = false, $options = null)
    {
        return $this->processRequest('GET', $url, $options, $headers, $body, $proxy);
    }

    public function post($url, $headers = [], $body = null, $proxy = false, $options = null)
    {
        return $this->processRequest('POST', $url, $options, $headers, $body, $proxy);
    }

    public function put($url, $headers = [], $body = null, $proxy = false, $options = null)
    {
        return $this->processRequest('PUT', $url, $options, $headers, $body, $proxy);
    }

    public function delete($url, $headers = [], $body = null, $proxy = false, $options = null)
    {
        return $this->processRequest('DELETE', $url, $options, $headers, $body, $proxy);
    }

    private function processRequest($method, $url, $options, $headers, $body, $proxy)
    {
        $valid_url = filter_var($url, FILTER_VALIDATE_URL);
        if ($valid_url) {
            $request = new Request($proxy);
            return $request->send($method, $url, $options, $headers, $body);
        } else {
            return json_encode(["status" => false, "message"=> "Invalid request url"]);
        }
    }
}