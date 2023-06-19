<?php
namespace test;

include('../../src/moneromanager/utils/RPC.php');

use moneromanager\utils\RPC;

$node = [
    'host' => '127.0.0.1',
    'port' => '38081'
];

$monerod = new RPC($node['host'], $node['port']);

// Get monerod daemon info
print_r($monerod->jsonrpc_command('get_info'));

echo "\n\n";

// Lookup block
$params = [
    'height' => 1177211
];
print_r($monerod->jsonrpc_command('get_block', $params));