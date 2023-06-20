<?php
////////////////////////////////////////////////////////////////////////////
// monero-manager                                                         //
// Copyright (c) 2023 opensrc.one                                         //
//                                                                        //
// This program is free software: you can redistribute it and/or modify   //
// it under the terms of the GNU General Public License as published by   //
// the Free Software Foundation, either version 3 of the License, or      //
// (at your option) any later version.                                    //
//                                                                        //
// This program is distributed in the hope that it will be useful,        //
// but WITHOUT ANY WARRANTY; without even the implied warranty of         //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          //
// GNU General Public License for more details.                           //
//                                                                        //
// You should have received a copy of the GNU General Public License      //
// along with this program.  If not, see <https://www.gnu.org/licenses/>. //
////////////////////////////////////////////////////////////////////////////
namespace moneromanager\utils;

use CurlHandle;
use RuntimeException;

class Curl {
    private string $uri;
    private string|NULL $proxy;
    protected CurlHandle $curl;

    /** Create cURL object.
     * @param string $uri URI in the format: 'ip/host:port".
     * @param string|NULL $proxy Proxy to connect with in format: ip/host:port. (Default: NULL)
     */
    public function __construct(string $uri='127.0.0.1:80', string|NULL $proxy=NULL) {
        $this->uri   = $uri;
        $this->proxy = $proxy;
    }

    /**
     * Set cURL options (Defaults: [CURLOPT_RETURNTRANSFER(true), CURLOPT_HEADER(FALSE), CURLOPT_CONNECTTIMEOUT(120),
     * CURLOPT_TIMEOUT(120)]).
     * @param array|NULL $extra_curl_options cURL options.
     */
    public function setup(array|NULL $extra_curl_options=NULL): void {
        $this->curl = curl_init("$this->uri");

        $default_curl_options = [
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER         => FALSE,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120
        ];

        if (isset($this->proxy)) {
            $proxy_curl_options = [
                CURLOPT_HTTPPROXYTUNNEL => 1,
                CURLOPT_PROXY           => $this->proxy,
                CURLOPT_PROXYTYPE       => CURLPROXY_HTTP
            ];

            $default_curl_options += $proxy_curl_options;
        }

        $parsed_curl_options = (NULL !== $extra_curl_options ? ($default_curl_options + $extra_curl_options) : $default_curl_options);
        curl_setopt_array($this->curl, $parsed_curl_options);
    }

    /**
     * Execute created cURL object.
     * @return string cURL response.
     * @throws RuntimeException On cURL error.
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