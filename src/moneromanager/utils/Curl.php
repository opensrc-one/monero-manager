<?php
namespace moneromanager\utils;

use CurlHandle;
use RuntimeException;

// TODO: Add Tor support
class Curl {
    private string $uri;
    protected CurlHandle $curl;

    public function __construct(string $uri='127.0.0.1:80') {
        $this->uri = $uri;
    }

    /**
     * Set cURL options
     * @param array|NULL $curl_options cURL options
     */
    public function setup(array $curl_options=NULL): void {
        $this->curl = curl_init("$this->uri");

        $default_curl_options = [
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER         => FALSE,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120
        ];

        $parsed_curl_options = (NULL !== $curl_options ? ($default_curl_options + $curl_options) : $default_curl_options);
        curl_setopt_array($this->curl, $parsed_curl_options);
    }

    /**
     * Execute created cURL object
     * @return string cURL response
     * @throws RuntimeException On cURL error
     */
    public function execute(): string {
        $response = curl_exec($this->curl);
        $error    = curl_error($this->curl);
        $errno    = curl_errno($this->curl);

        curl_close($this->curl);

        if (0 !== $errno) {
            throw new RuntimeException($error, $errno);
        }

        return strval($response);
    }
}