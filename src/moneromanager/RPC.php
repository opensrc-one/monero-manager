<?php
namespace moneromanager;

require_once('utils/Curl.php');
use moneromanager\utils\Curl;
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
     * Execute command on monerod
     * @param string $method method to execute
     * @param array $params method parameters
     * @param bool $as_array return result as array
     * @return string|array daemon response
     */
    public function jsonrpc_command(string $method, array $params=[], bool $as_array=FALSE): string|array {
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

    public function standardrpc_command(string $method, array $params=[], bool $as_array=FALSE): string|array {
        $uri = $this->create_uri($method);

        $post_data = json_encode([
            $params
        ]);

        $response = $this->execute_rpc($uri, $post_data);
        return ($as_array ? json_decode($response, TRUE) : $response);
    }

    private function execute_rpc(string $uri, string $post_data): string {
        $curl = new Curl($uri);

        $curl_options = [
            CURLOPT_POST           => TRUE,
            CURLOPT_POSTFIELDS     => $post_data,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json']
        ];

        $curl->setup($curl_options);
        return $curl->execute();
    }

    /**
     * Create uri for daemon
     * @param string $command daemon command
     * @return string parsed uri string
     */
    private function create_uri(string $command): string {
        return "{$this->daemon['host']}:{$this->daemon['port']}/$command";
    }
}
