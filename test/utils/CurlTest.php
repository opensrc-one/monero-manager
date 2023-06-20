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
