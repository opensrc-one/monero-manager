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

include('../src/moneromanager/Wallet.php');
use moneromanager\Wallet;

$node = [
    'host' => '127.0.0.1',
    'port' => '28082'
];

$wallet = new Wallet($node['host'], $node['port']);


/*print_r("\n-------create_wallet-------\n".
    "{$wallet->create_wallet('testapi-wallet', 'Letmein123@')}"
);*/

print_r("\n-------open_wallet-------\n".
    "{$wallet->open_wallet('testapi-wallet', 'Letmein123@')}"
);

print_r("\n-------query_key-------\n".
    "{$wallet->query_key('mnemonic')}"
);

print_r("\n-------get_accounts-------\n".
    "{$wallet->get_accounts()}"
);

/*print_r("\n-------create_address-------\n".
    "{$wallet->create_address(0)}"
);*/

print_r("\n-------get_address-------\n".
    "{$wallet->get_address(0)}"
);

print_r("\n-------incoming_transfers-------\n".
    "{$wallet->incoming_transfers('all')}"
);

print_r("\n-------get_transfer_by_txid-------\n".
    "{$wallet->get_transfer_by_txid('29cbfff42f894913c14787218f2598d2103e5f9f854f14ee645a68b0136f6fe2')}"
);