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

require_once('Curl.php');

class RPC {
    protected string $host, $port;
    protected string|NULL $username, $password, $proxy;

    /**
     *
     * @param string $host ip/hostname of daemon
     * @param string $port port of daemon
     * @param string|NULL $username Daemon username. (Default: NULL)
     * @param string|NULL $password Daemon password. (Default: NULL)
     * @param string|NULL $proxy Proxy to connect with in format: ip/host:port. (Default: NULL)
     */
    public function __construct(string $host, string $port, string|NULL $username=NULL, string|NULL $password=NULL, string|NULL $proxy=NULL) {
        $this->host     = $host;
        $this->port     = $port;
        $this->username = $username;
        $this->password = $password;
        $this->proxy    = $proxy;
    }

    public function __get($key) {
        return $this->$key;
    }

    public function __set($key, $value) {
        $this->$key = $value;
    }

    /**
     * Execute JSON RPC command on daemon.
     * @param string $method Function to execute on daemon.
     * @param array|NULL $params Additional parameters to add to RPC request.
     * @param bool $as_array Return result as an array.
     * @return string|array RPC response.
     */
    public function jsonrpc_command(string $method, array|NULL $params=NULL, bool $as_array=FALSE): string|array {
        $uri = $this->create_uri('json_rpc');

        $post_data = json_encode([
            'jsonrpc' => '2.0',
            'id'      => '0',
            'method'  => $method,
            'params'  => $params
        ]);

        $response = $this->execute_rpc($uri, $post_data);
        return ($as_array ? json_decode($response, TRUE) : $response);
    }

    /**
     * Execute standard RPC command on daemon.
     * @param string $method Function to execute on daemon.
     * @param array|NULL $params Additional parameters to add to RPC request. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC response.
     */
    public function standardrpc_command(string $method, array|NULL $params=NULL, bool $as_array=FALSE): string|array {
        $uri = $this->create_uri($method);
        $post_data = (NULL !== $params) ? json_encode($params): NULL;

        $response = $this->execute_rpc($uri, $post_data);
        return ($as_array ? json_decode($response, TRUE) : $response);
    }

    /**
     * Execute RPC request.
     * @param string $uri host:port of daemon.
     * @param string|NULL $post_data Additional parameters to add to POST. (Default: NULL)
     * @return string RPC response.
     */
    private function execute_rpc(string $uri, string|NULL $post_data=NULL): string {
        $curl = new Curl($uri);
        $curl_options = [
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ];

        if (isset($this->username, $this->password)) {
            $extra_curl_options = [
                CURLOPT_USERPWD => "{$this->username}:{$this->password}"
            ];

            $curl_options += $extra_curl_options;
        }

        if (isset($post_data)) {
            $extra_curl_options = [
                CURLOPT_POST       => TRUE,
                CURLOPT_POSTFIELDS => $post_data,
            ];
            $curl_options += $extra_curl_options;
        }

        $curl->setup($curl_options);
        return $curl->execute();
    }

    /**
     * Create uri for RPC requests.
     * @param string $command Daemon command.
     * @return string Parsed uri string.
     */
    private function create_uri(string $command): string {
        return "{$this->username}:{$this->password}/$command";
    }
}
