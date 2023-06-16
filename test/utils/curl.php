<?php
namespace test;

include('../../src/moneromanager/utils/Curl.php');
use moneromanager\utils\Curl;

$node = [
    'host' => '127.0.0.1',
    'port' => '18081'
];
$cmd = 'getinfo';

$uri = "{$node['host']}:{$node['port']}/$cmd";
$curl = new Curl($uri);

$curl->setup();
var_dump($curl->execute());
