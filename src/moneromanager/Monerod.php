<?php
namespace moneromanager;

require_once('utils/Curl.php');
use moneromanager\utils\Curl;

class Monerod {
    protected array $node;

    public function __construct(string $host, string $port) {
        $this->node = [
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
     * @param string $method monerod method to execute
     * @param array $params monerod method parameters
     * @param bool $as_array return result as array
     * @return string|array monerod response
     */
    public function execute_command(string $method, array $params=[], bool $as_array=FALSE): string|array {
        $uri = $this->create_uri('json_rpc');
        $curl = new Curl($uri);

        $post_data = json_encode([
            'jsonrpc' => '2.0',
            'id'      => '0',
            'method'  => $method,
            'params'  => $params
        ]);

        $curl_options = [
            CURLOPT_POST           => TRUE,
            CURLOPT_POSTFIELDS     => $post_data,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json']
        ];

        $curl->setup($curl_options);
        $response = $curl->execute();

        return ($as_array ? json_decode($response, TRUE) : $response);
    }

    /**
     * Create uri for monerod
     * @param string $command monerod command
     * @return string parsed uri string
     */
    private function create_uri(string $command): string {
        return "{$this->node['host']}:{$this->node['port']}/$command";
    }
}