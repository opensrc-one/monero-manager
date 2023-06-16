<?php
namespace test;

include('../src/moneromanager/Monerod.php');
use moneromanager\Monerod;

$node = [
    'host' => '127.0.0.1',
    'port' => '18081'
];

$monerod = new Monerod($node['host'], $node['port']);

// Get monerod daemon info
var_dump($monerod->execute_command('get_info'));

echo "\n\n";

// Lookup block
$params = [
    'height' => 2751210
];
var_dump($monerod->execute_command('get_block', $params));