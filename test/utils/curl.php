<?php
namespace test;

include('../../src/moneromanager/utils/Curl.php');
use moneromanager\utils\Curl;

$node = [
    'host' => '127.0.0.1',
    'port' => '38081'
];
$cmd = 'get_info';

$uri = "{$node['host']}:{$node['port']}/$cmd";
$curl = new Curl($uri);

$curl->setup();
print_r($curl->execute());
