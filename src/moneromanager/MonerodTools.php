<?php
namespace moneromanager;

include('RPC.php');

use RuntimeException;

class MonerodTools extends RPC {
    public function __construct(string $host, string $port) {
        parent::__construct($host, $port);
    }

    public function get_block_count(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::jsonrpc_command('get_block_count', $params, $as_array);
    }

    public function on_get_block_hash(array $block_height, bool $as_array=FALSE): string|array {
        $params = [
            $block_height
        ];

        return parent::jsonrpc_command('on_get_block_hash', $params, $as_array);
    }

    public function get_block_template(string $wallet_address, int $reserve_size, bool $as_array=FALSE): string|array {
        $params = [
            'wallet_address' => $wallet_address,
            'reserve_size'   => $reserve_size
        ];

        return parent::jsonrpc_command('get_block_template', $params, $as_array);
    }

    public function submit_block(array $block_blob_data, bool $as_array=FALSE): string|array {
        $params = $block_blob_data;
        return parent::jsonrpc_command('submit_block', $params, $as_array);
    }

    public function generateblocks(int $amount_of_blocks, string $wallet_address, int $starting_nonce, bool $as_array=FALSE): string|array {
        $params = [
            'amount_of_blocks' => $amount_of_blocks,
            'wallet_address'   => $wallet_address,
            'starting_nonce'   => $starting_nonce
        ];

        return parent::jsonrpc_command('generateblocks', $params, $as_array);
    }

    public function get_last_block_header(bool $fill_pow_hash=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'fill_pow_hash' => $fill_pow_hash
        ];

        return parent::jsonrpc_command('get_last_block_header', $params, $as_array);
    }

    public function get_block_header_by_hash(string $hash, bool $fill_pow_hash=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'hash'          => $hash,
            'fill_pow_hash' => $fill_pow_hash
        ];

        return parent::jsonrpc_command('get_block_header_by_hash', $params, $as_array);
    }

    public function get_block_header_by_height(int $height, bool $fill_pow_hash=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'height'        => $height,
            'fill_pow_hash' => $fill_pow_hash
        ];

        return parent::jsonrpc_command('get_block_header_by_height', $params, $as_array);
    }

    public function get_block_headers_range(int $start_height, int $end_height, bool $fill_pow_hash=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'start_height'  => $start_height,
            'end_height'    => $end_height,
            'fill_pow_hash' => $fill_pow_hash
        ];

        return parent::jsonrpc_command('get_block_headers_range', $params, $as_array);
    }

    public function get_block_by_height(int $height, bool $fill_pow_hash=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'height'        => $height,
            'fill_pow_hash' => $fill_pow_hash
        ];

        return parent::jsonrpc_command('get_block', $params, $as_array);
    }

    public function get_block_by_hash(int $hash, bool $fill_pow_hash=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'hash'          => $hash,
            'fill_pow_hash' => $fill_pow_hash
        ];

        return parent::jsonrpc_command('get_block', $params, $as_array);
    }

    public function get_connections(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::jsonrpc_command('get_connections', $params, $as_array);
    }

    public function get_info(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::jsonrpc_command('get_info', $params, $as_array);
    }

    public function hard_fork_info(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::jsonrpc_command('hard_fork_info', $params, $as_array);
    }

    /**
     * @param array $bans array in format of [string $host, bool $ban, int $seconds]
     * @param bool $as_array
     * @return string|array
     */
    public function set_bans(array $bans, bool $as_array=FALSE): string|array {
        foreach ($bans as $node) {
            $host_set    = isset($node['host']);
            $ip_set      = isset($node['ip']);
            $ban_set     = isset($node['ban']);
            $seconds_set = isset($node['seconds']);

            // Check if all required array indexes are present or throw error.
            if (!($host_set || $ip_set) || !($ban_set && $seconds_set)) {
                throw new RuntimeException('Invalid array data in set_bans()');
            }
        }

        $params = [
            'bans' => $bans
        ];

        return parent::jsonrpc_command('set_bans', $params, $as_array);
    }

    public function get_bans(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::jsonrpc_command('get_bans', $params, $as_array);
    }

    public function banned(string $address, bool $as_array=FALSE): string|array {
        $params = [
            'address' => $address
        ];

        return parent::jsonrpc_command('banned', $params, $as_array);
    }

    public function flush_txpool(array $txids, bool $as_array=FALSE): string|array {
        $params = [
            'txids' => $txids
        ];

        return parent::jsonrpc_command('flush_txpool', $params, $as_array);
    }

    public function get_output_histogram(array $amounts, int $min_count, int $max_count, bool $unlocked,
                                         int $recent_cutoff, bool $as_array=FALSE): string|array {
        $params = [
            'amounts'       => $amounts,
            'min_count'     => $min_count,
            'max_count'     => $max_count,
            'unlocked'      => $unlocked,
            'recent_cutoff' => $recent_cutoff
        ];

        return parent::jsonrpc_command('get_output_histogram', $params, $as_array);
    }

    public function get_coinbase_tx_sum(int $height, int $count, bool $as_array=FALSE): string|array {
        $params = [
            'height' => $height,
            'count'  => $count
        ];

        return parent::jsonrpc_command('get_coinbase_tx_sum', $params, $as_array);
    }

    public function get_version(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::jsonrpc_command('get_version', $params, $as_array);
    }

    public function get_fee_estimate(int $grace_blocks=NULL, bool $as_array=FALSE): string|array {
        $params = [];

        if (NULL !== $grace_blocks) {
            $params = [
                'grace_blocks' => $grace_blocks
            ];
        }

        return parent::jsonrpc_command('get_version', $params, $as_array);
    }

    public function get_alternate_chains(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::jsonrpc_command('get_alternate_chains', $params, $as_array);
    }

    public function relay_tx(array $txids, bool $as_array=FALSE): string|array {
        $params = [
            'txids' => $txids
        ];

        return parent::jsonrpc_command('relay_tx', $params, $as_array);
    }

    public function sync_info(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::jsonrpc_command('sync_info', $params, $as_array);
    }

    public function get_txpool_backlog(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::jsonrpc_command('get_txpool_backlog', $params, $as_array);
    }

    public function get_output_distribution(array $amounts, bool $cumulative=FALSE, int $from_height=0, int $to_height=0,
                                            bool $as_array=FALSE): string|array {
        $params = [
            'amounts'     => $amounts,
            'cumulative'  => $cumulative,
            'from_height' => $from_height,
            'to_height'   => $to_height,
        ];

        return parent::jsonrpc_command('get_output_distribution', $params, $as_array);
    }

    public function get_miner_data(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::jsonrpc_command('get_miner_data', $params, $as_array);
    }

    public function prune_blockchain(bool $check=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'check' => $check
        ];

        return parent::jsonrpc_command('prune_blockchain', $params, $as_array);
    }

    public function calc_pow(int $major_version, int $height, string $blobdata,
                             string $seed_hash, bool $as_array=FALSE): string|array {
        $params = [
            'major_version' => $major_version,
            'height'        => $height,
            'block_blob'    => $blobdata,
            'seed_hash'     => $seed_hash
        ];

        return parent::jsonrpc_command('calc_pow', $params, $as_array);
    }

    public function flush_cache(bool $bad_txs=FALSE, bool $bad_blocks=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'bad_txs'    => $bad_txs,
            'bad_blocks' => $bad_blocks
        ];

        return parent::jsonrpc_command('flush_cache', $params, $as_array);
    }

    /// Standard RPC Commands ///

    public function get_height(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('get_height', $params, $as_array);
    }

    public function get_blocks_bin(array $block_ids, int $start_height, bool $prune, bool $as_array=FALSE): string|array {
        $params = [
            'block_ids'    => $block_ids,
            'start_height' => $start_height,
            'prune'        => $prune
        ];

        return parent::standardrpc_command('get_blocks.bin', $params, $as_array);
    }

    public function get_blocks_by_height_bin(array $heights, bool $as_array=FALSE): string|array {
        $params = [
            'heights' => $heights
        ];

        return parent::standardrpc_command('get_blocks_by_height.bin', $params, $as_array);
    }

    public function get_hashes_bin(array $block_ids, int $start_height, bool $as_array=FALSE): string|array {
        $params = [
            'block_ids'    => $block_ids,
            'start_height' => $start_height
        ];

        return parent::standardrpc_command('get_hashes.bin', $params, $as_array);
    }

    public function get_o_indexes_bin($txid, bool $as_array=FALSE): string|array {
        $params = [
            'txid' => $txid
        ];

        return parent::standardrpc_command('get_o_indexes.bin', $params, $as_array);
    }

    public function get_outs_bin(array $outputs, bool $as_array=FALSE): string|array {
        $params = [
            'outputs' => $outputs
        ];

        return parent::standardrpc_command('get_outs.bin', $params, $as_array);
    }

    public function get_transactions(array $txs_hashes, bool $decode_as_json=FALSE, bool $prune=FALSE,
                                     bool $split=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'txs_hashes'     => $txs_hashes,
            'decode_as_json' => $decode_as_json,
            'prune'          => $prune,
            'split'          => $split
        ];

        return parent::standardrpc_command('get_transactions', $params, $as_array);
    }

    public function get_alt_blocks_hashes(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('get_alt_blocks_hashes', $params, $as_array);
    }

    public function is_key_image_spent(array $key_images, bool $as_array=FALSE): string|array {
        $params = [
            'key_images' => $key_images
        ];

        return parent::standardrpc_command('is_key_image_spent', $params, $as_array);
    }

    public function send_raw_transaction(string $tx_as_hex, bool $do_not_relay=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'tx_as_hex'    => $tx_as_hex,
            'do_not_relay' => $do_not_relay
        ];

        return parent::standardrpc_command('send_raw_transaction', $params, $as_array);
    }

    public function start_mining(bool $do_background_mining, bool $ignore_battery, string $miner_address,
                                 int $threads_count, bool $as_array=FALSE): string|array {
        $params = [
            'do_background_mining' => $do_background_mining,
            'ignore_battery'       => $ignore_battery,
            'miner_address'        => $miner_address,
            'threads_count'        => $threads_count
        ];

        return parent::standardrpc_command('start_mining', $params, $as_array);
    }

    public function stop_mining(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('stop_mining', $params, $as_array);
    }

    public function mining_status(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('mining_status', $params, $as_array);
    }

    public function save_bc(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('save_bc', $params, $as_array);
    }

    public function get_peer_list(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('get_peer_list', $params, $as_array);
    }

    public function set_log_hash_rate(bool $visible, bool $as_array=FALSE): string|array {
        $params = [
            'visible' => $visible
        ];

        return parent::standardrpc_command('set_log_hash_rate', $params, $as_array);
    }

    public function set_log_level(int $level, bool $as_array=FALSE): string|array {
        $params = [
            'level' => $level
        ];

        return parent::standardrpc_command('set_log_level', $params, $as_array);
    }

    public function set_log_categories(string $categories, bool $as_array=FALSE): string|array {
        $params = [
            'categories' => $categories
        ];

        return parent::standardrpc_command('set_log_categories', $params, $as_array);
    }

    public function set_bootstrap_daemon(string $address, string $username, string $password,
                                         string $proxy, bool $as_array=FALSE): string|array {
        $params = [
            'address'  => $address,
            'username' => $username,
            'password' => $password,
            'proxy'    => $proxy
        ];

        return parent::standardrpc_command('set_bootstrap_daemon', $params, $as_array);
    }

    public function get_transaction_pool(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('get_transaction_pool', $params, $as_array);
    }

    public function get_transaction_pool_hashes_bin(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('get_transaction_pool_hashes.bin', $params, $as_array);
    }

    public function get_transaction_pool_stats(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('get_transaction_pool_stats', $params, $as_array);
    }

    public function stop_daemon(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('stop_daemon', $params, $as_array);
    }

    public function get_limit(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('get_limit', $params, $as_array);
    }

    public function set_limit(int $limit_down, int $limit_up, bool $as_array=FALSE): string|array {
        $params = [
            'limit_down' => $limit_down,
            'limit_up'   => $limit_up
        ];

        return parent::standardrpc_command('get_limit', $params, $as_array);
    }

    public function out_peers(int $out_peers, bool $as_array=FALSE): string|array {
        $params = [
            'out_peers' => $out_peers
        ];

        return parent::standardrpc_command('out_peers', $params, $as_array);
    }

    public function in_peers(int $in_peers, bool $as_array=FALSE): string|array {
        $params = [
            'in_peers' => $in_peers
        ];

        return parent::standardrpc_command('in_peers', $params, $as_array);
    }

    public function get_net_stats(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('get_net_stats', $params, $as_array);
    }

    public function start_save_graph(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('start_save_graph', $params, $as_array);
    }

    public function stop_save_graph(bool $as_array=FALSE): string|array {
        $params = [];
        return parent::standardrpc_command('stop_save_graph', $params, $as_array);
    }

    public function get_outs(array $outputs, bool $get_txid, bool $as_array=FALSE): string|array {
        $params = [
            'outputs'  => $outputs,
            'get_txid' => $get_txid
        ];

        return parent::standardrpc_command('get_outs', $params, $as_array);
    }

    public function update_daemon(string $command, string $path, bool $as_array=FALSE): string|array {
        $params = [
            'command'  => $command,
            'path'     => $path
        ];

        return parent::standardrpc_command('update', $params, $as_array);
    }

    public function pop_blocks(int $nblocks, bool $as_array=FALSE): string|array {
        $params = [
            'nblocks' => $nblocks
        ];

        return parent::standardrpc_command('pop_blocks', $params, $as_array);
    }
}