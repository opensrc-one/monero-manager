<?php
namespace moneromanager\utils;

require_once('Curl.php');

class RPC {
    protected array $daemon;

    /**
     *
     * @param string $host ip/hostname of daemon
     * @param string $port port of daemon
     */
    public function __construct(string $host, string $port) {
        $this->daemon = [
            'host' => $host,
            'port' => $port
        ];
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
     * @param array|NULL $params Additional parameters to add to RPC request.
     * @param bool $as_array Return result as an array.
     * @return string|array RPC response.
     */
    public function standardrpc_command(string $method, array|NULL $params=NULL, bool $as_array=FALSE): string|array {
        $uri = $this->create_uri($method);

        $post_data = NULL;
        if (NULL !== $params) {
            $post_data = json_encode(
                $params
            );
        }

        $response = $this->execute_rpc($uri, $post_data);
        return ($as_array ? json_decode($response, TRUE) : $response);
    }

    /**
     * Execute RPC request.
     * @param string $uri host:port of daemon.
     * @param string|NULL $post_data Additional parameters to add to POST.
     * @return string RPC response.
     */
    private function execute_rpc(string $uri, string|NULL $post_data): string {
        $curl = new Curl($uri);

        $curl_options = [
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ];

        if (NULL !== $post_data) {
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
        return "{$this->daemon['host']}:{$this->daemon['port']}/$command";
    }
}
