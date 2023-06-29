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

include('../src/moneromanager/Monerod.php');

use moneromanager\Monerod;

$node = [
    'host' => '127.0.0.1',
    'port' => '38081'
];

$monerod = new Monerod($node['host'], $node['port']);


print_r("\n-------get_block_count-------\n".
    "{$monerod->get_block_count()}"
);

print_r("\n-------on_get_block_hash-------\n".
    "{$monerod->on_get_block_hash(912345)}"
);

print_r("\n-------get_block_template-------\n".
    "{$monerod->get_block_template('59WGanaZpEXYTZVX5tL8gAaDnh8GacqDnGR77yHLNCCbBWEvY82Bt6ZVNJuxjBccefJQZes9Z8bSp8kES3i3AFF46QHUz3r', 2)}"
);

print_r("\n-------submit_block-------\n".
    "{$monerod->submit_block(['0707e6bdfedc053771512f1bc27c62731ae9e8f2443db64ce742f4e57f5cf8d393de28551e441a0000000002fb830a01ffbf830a018cfe88bee283060274c0aae2ef5730e680308d9c00b6da59187ad0352efe3c71d36eeeb28782f29f2501bd56b952c3ddc3e350c2631d3a5086cac172c56893831228b17de296ff4669de020200000000'])}"
);

print_r("\n-------generateblocks-------\n".
    "{$monerod->generateblocks(1, '59WGanaZpEXYTZVX5tL8gAaDnh8GacqDnGR77yHLNCCbBWEvY82Bt6ZVNJuxjBccefJQZes9Z8bSp8kES3i3AFF46QHUz3r', 0)}"
);

print_r("\n-------get_last_block_header-------\n".
    "{$monerod->get_last_block_header()}"
);

print_r("\n-------get_block_header_by_hash-------\n".
    "{$monerod->get_block_header_by_hash('835bc168936d281439a57396e465431bdc03c2ea6db2378410e98419b376f436')}"
);

print_r("\n-------get_block_header_by_height-------\n".
    "{$monerod->get_block_header_by_height(912345)}"
);

print_r("\n-------get_block_headers_range-------\n".
    "{$monerod->get_block_headers_range(0, 3)}"
);

print_r("\n-------get_block_by_height-------\n".
    "{$monerod->get_block_by_height(912345)}"
);

print_r("\n-------get_block_by_hash-------\n".
    "{$monerod->get_block_by_hash('835bc168936d281439a57396e465431bdc03c2ea6db2378410e98419b376f436')}"
);

print_r("\n-------get_connections-------\n".
    "{$monerod->get_connections()}"
);

print_r("\n-------get_info-------\n".
    "{$monerod->get_info()}"
);

print_r("\n-------hard_fork_info-------\n".
    "{$monerod->hard_fork_info()}"
);

// set_bans
// ----------------------------------------------------
$bans = [
    [
        'host'    => '123.156.231.10',
        'ban'     => TRUE,
        'seconds' => 30
    ],
    [
        'ip'      => 15874548,
        'ban'     => TRUE,
        'seconds' => 30
    ]
];
print_r("\n-------set_bans-------\n".
    "{$monerod->set_bans($bans)}"
);
// ----------------------------------------------------

print_r("\n-------get_bans-------\n".
    "{$monerod->get_bans()}"
);

print_r("\n-------banned-------\n".
    "{$monerod->banned('123.156.231.10')}"
);

// flush_txpool
// ----------------------------------------------------
$txids = [
    'bebc58a9089044383210401613a4771306848a1541c54610b0b55ebbe4fed6cb',
    '77f70b0af91be141025466ca0a2e368b6205150a23673e87676a34c241231f47'
];
print_r("\n-------flush_txpool-------\n".
    "{$monerod->flush_txpool($txids)}"
);
// ----------------------------------------------------

print_r("\n-------get_coinbase_tx_sum-------\n".
    "{$monerod->get_coinbase_tx_sum(156307, 2)}"
);

print_r("\n-------get_version-------\n".
    "{$monerod->get_version()}"
);

print_r("\n-------get_fee_estimate-------\n".
    "{$monerod->get_fee_estimate()}"
);

print_r("\n-------get_alternate_chains-------\n".
    "{$monerod->get_alternate_chains()}"
);

// relay_tx
// ----------------------------------------------------
print_r("\n-------relay_tx-------\n".
    "{$monerod->relay_tx($txids)}"
);
// ----------------------------------------------------

print_r("\n-------sync_info-------\n".
    "{$monerod->sync_info()}"
);

print_r("\n-------get_txpool_backlog-------\n".
    "{$monerod->get_txpool_backlog()}"
);

/*// get_output_distribution
// ----------------------------------------------------
$amounts = [
    '628780000'
];
print_r("\n-------get_output_distribution-------\n".
    "{$monerod->get_output_distribution($amounts)}"
);
// ----------------------------------------------------*/

print_r("\n-------get_miner_data-------\n".
    "{$monerod->get_miner_data()}"
);

print_r("\n-------prune_blockchain-------\n".
    "{$monerod->prune_blockchain(TRUE)}"
);

/*print_r("\n-------calc_pow-------\n".
    "{$monerod->calc_pow(14, 2286447)}"
);*/

print_r("\n-------flush_cache-------\n".
    "{$monerod->flush_cache()}"
);

print_r("\n-------get_height-------\n".
    "{$monerod->get_height()}"
);

// get_transactions
// ----------------------------------------------------
$tx_hashes = [
    '6288b3b850dd717426edd139f768c76152983cb4e85c1ad21ce761bde1d30ae0'
];
print_r("\n-------get_transactions-------\n".
    "{$monerod->get_transactions($tx_hashes)}"
);
// ----------------------------------------------------

print_r("\n-------get_alt_blocks_hashes-------\n".
    "{$monerod->get_alt_blocks_hashes()}"
);

// is_key_image_spent
// ----------------------------------------------------
$key_images = [
    '8d1bd8181bf7d857bdb281e0153d84cd55a3fcaa57c3e570f4a49f935850b5e3',
    '7319134bfc50668251f5b899c66b005805ee255c136f0e1cecbb0f3a912e09d4'
];
print_r("\n-------is_key_image_spent-------\n".
    "{$monerod->is_key_image_spent($key_images)}"
);
// ----------------------------------------------------

print_r("\n-------start_mining-------\n".
    "{$monerod->start_mining(FALSE, TRUE, '59WGanaZpEXYTZVX5tL8gAaDnh8GacqDnGR77yHLNCCbBWEvY82Bt6ZVNJuxjBccefJQZes9Z8bSp8kES3i3AFF46QHUz3r', 1)}"
);

print_r("\n-------stop_mining-------\n".
    "{$monerod->stop_mining()}"
);

print_r("\n-------mining_status-------\n".
    "{$monerod->mining_status()}"
);

print_r("\n-------save_bc-------\n".
    "{$monerod->save_bc()}"
);

print_r("\n-------get_peer_list-------\n".
    "{$monerod->get_peer_list()}"
);

print_r("\n-------set_log_hash_rate-------\n".
    "{$monerod->set_log_hash_rate(TRUE)}"
);

print_r("\n-------set_log_level-------\n".
    "{$monerod->set_log_level(0)}"
);

print_r("\n-------set_log_categories-------\n".
    "{$monerod->set_log_categories()}"
);

print_r("\n-------set_bootstrap_daemon-------\n".
    "{$monerod->set_bootstrap_daemon('198.578.54.21:18081')}"
);

print_r("\n-------get_transaction_pool-------\n".
    "{$monerod->get_transaction_pool()}"
);

print_r("\n-------get_transaction_pool_stats-------\n".
    "{$monerod->get_transaction_pool_stats()}"
);

/*print_r("\n-------stop_daemon-------\n".
    "{$monerod->stop_daemon()}"
);*/

print_r("\n-------get_limit-------\n".
    "{$monerod->get_limit()}"
);

print_r("\n-------set_limit-------\n".
    "{$monerod->set_limit(0, 0)}"
);

print_r("\n-------out_peers-------\n".
    "{$monerod->out_peers(30)}"
);

print_r("\n-------in_peers-------\n".
    "{$monerod->in_peers(30)}"
);

print_r("\n-------get_net_stats-------\n".
    "{$monerod->get_net_stats()}"
);

print_r("\n-------get_outs-------\n".
    "{$monerod->get_outs([3, 1], 1)}"
);

print_r("\n-------update_daemon-------\n".
    "{$monerod->update_daemon('check')}"
);

print_r("\n-------pop_blocks-------\n".
    "{$monerod->pop_blocks(5)}"
);