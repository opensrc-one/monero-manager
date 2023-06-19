<?php
namespace moneromanager;

include('utils/RPC.php');

use moneromanager\utils\RPC;
use RuntimeException;

class Monerod extends RPC {
    public function __construct(string $host, string $port) {
        parent::__construct($host, $port);
    }

    /**
     * Look up how many blocks are in the longest chain known to the node.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_block_count(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('get_block_count', $params, $as_array);
    }

    /**
     * Look up a block's hash by its height.
     * @param int $block_height Block height.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function on_get_block_hash(int $block_height, bool $as_array=FALSE): string|array {
        $params = [
            $block_height
        ];

        return parent::jsonrpc_command('on_get_block_hash', $params, $as_array);
    }

    /**
     * Get a block template on which mining a new block.
     * @param string $wallet_address Address of wallet to receive coinbase transactions if block is successfully mined.
     * @param int $reserve_size Reserve size.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_block_template(string $wallet_address, int $reserve_size, bool $as_array=FALSE): string|array {
        $params = [
            'wallet_address' => $wallet_address,
            'reserve_size'   => $reserve_size
        ];

        return parent::jsonrpc_command('get_block_template', $params, $as_array);
    }

    /**
     * Submit a mined block to the network.
     * @param array $block_blob_data List of block blobs which have been mined.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function submit_block(array $block_blob_data, bool $as_array=FALSE): string|array {
        $params = $block_blob_data;
        return parent::jsonrpc_command('submit_block', $params, $as_array);
    }

    /**
     * Generate a block and specify the address to receive the coinbase reward.
     * @param int $amount_of_blocks Number of blocks to be generated.
     * @param string $wallet_address Address to receive the coinbase reward.
     * @param int $starting_nonce Increased by miner until it finds a matching result that solves a block.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function generateblocks(int $amount_of_blocks, string $wallet_address, int $starting_nonce, bool $as_array=FALSE): string|array {
        $params = [
            'amount_of_blocks' => $amount_of_blocks,
            'wallet_address'   => $wallet_address,
            'starting_nonce'   => $starting_nonce
        ];

        return parent::jsonrpc_command('generateblocks', $params, $as_array);
    }

    /**
     * Block header information for the most recent block is easily retrieved with this method. No inputs are needed.
     * @param bool $fill_pow_hash Add PoW hash to block_header response. (Optional)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_last_block_header(bool $fill_pow_hash=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'fill_pow_hash' => $fill_pow_hash
        ];

        return parent::jsonrpc_command('get_last_block_header', $params, $as_array);
    }

    /** Block header information can be retrieved using either a block's hash or height.
     * This method includes a block's hash as an input parameter to retrieve basic information about the block.
     * @param string $hash The block's sha256 hash.
     * @param bool $fill_pow_hash Add PoW hash to block_header response. (Optional)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_block_header_by_hash(string $hash, bool $fill_pow_hash=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'hash'          => $hash,
            'fill_pow_hash' => $fill_pow_hash
        ];

        return parent::jsonrpc_command('get_block_header_by_hash', $params, $as_array);
    }

    /**
     * Similar to get_block_header_by_hash above, this method includes a block's height as an input
     * parameter to retrieve basic information about the block.
     * @param int $height The block's height.
     * @param bool $fill_pow_hash Add PoW hash to block_header response. (Optional)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_block_header_by_height(int $height, bool $fill_pow_hash=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'height'        => $height,
            'fill_pow_hash' => $fill_pow_hash
        ];

        return parent::jsonrpc_command('get_block_header_by_height', $params, $as_array);
    }

    /**
     * Similar to get_block_header_by_height, but for a range of blocks. This method includes a
     * starting block height and an ending block height as parameters to retrieve basic
     * information about the range of blocks.
     * @param int $start_height The starting block's height.
     * @param int $end_height The ending block's height.
     * @param bool $fill_pow_hash Add PoW hash to block_header response. (Optional)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_block_headers_range(int $start_height, int $end_height, bool $fill_pow_hash=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'start_height'  => $start_height,
            'end_height'    => $end_height,
            'fill_pow_hash' => $fill_pow_hash
        ];

        return parent::jsonrpc_command('get_block_headers_range', $params, $as_array);
    }

    /**
     * Full block information can be retrieved by block height, like with the block header calls.
     * For full block information, both lookups use the same method, but with different input parameters.
     * @param int $height The block's height.
     * @param bool $fill_pow_hash Add PoW hash to block_header response. (Optional)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_block_by_height(int $height, bool $fill_pow_hash=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'height'        => $height,
            'fill_pow_hash' => $fill_pow_hash
        ];

        return parent::jsonrpc_command('get_block', $params, $as_array);
    }

    /**
     * Full block information can be retrieved by block hash, like with the block header calls.
     * For full block information, both lookups use the same method, but with different input parameters.
     * @param string $hash The block's hash.
     * @param bool $fill_pow_hash Add PoW hash to block_header response. (Optional)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_block_by_hash(string $hash, bool $fill_pow_hash=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'hash'          => $hash,
            'fill_pow_hash' => $fill_pow_hash
        ];

        return parent::jsonrpc_command('get_block', $params, $as_array);
    }

    /**
     * Retrieve information about incoming and outgoing connections to your node.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_connections(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('get_connections', $params, $as_array);
    }

    /**
     * Retrieve general information about the state of your node and the network.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_info(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('get_info', $params, $as_array);
    }

    /**
     * Look up information regarding hard fork voting and readiness.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function hard_fork_info(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('hard_fork_info', $params, $as_array);
    }

    /**
     * Ban another node by IP.
     * @param array $bans array in format: [['host'=>string, 'ban'=>bool, 'seconds'=>int]] or [['ip'=>int, 'ban'=>bool, 'seconds'=>int]].
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function set_bans(array $bans, bool $as_array=FALSE): string|array {
        $params = [
            'bans' => $bans
        ];

        return parent::jsonrpc_command('set_bans', $params, $as_array);
    }

    /**
     * Get list of banned IPs.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_bans(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('get_bans', $params, $as_array);
    }

    /**
     * Check if an IP address is banned and for how long.
     * @param string $address IP address.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function banned(string $address, bool $as_array=FALSE): string|array {
        $params = [
            'address' => $address
        ];

        return parent::jsonrpc_command('banned', $params, $as_array);
    }

    /**
     * Flush tx ids from transaction pool.
     * @param array|NULL $txids List of transactions IDs to flush from pool (Optional: all tx ids flushed if empty).
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function flush_txpool(array|NULL $txids=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'txids' => $txids
        ];

        return parent::jsonrpc_command('flush_txpool', $params, $as_array);
    }

    /**
     * Get the coinbase amount and the fees amount for n last blocks starting at particular height.
     * @param int $height Block height from which getting the amounts.
     * @param int $count Number of blocks to include in the sum.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_coinbase_tx_sum(int $height, int $count, bool $as_array=FALSE): string|array {
        $params = [
            'height' => $height,
            'count'  => $count
        ];

        return parent::jsonrpc_command('get_coinbase_tx_sum', $params, $as_array);
    }

    /**
     * Give the node current version.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_version(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('get_version', $params, $as_array);
    }

    /**
     * Gives an estimation on fees per byte.
     * @param int|NULL $grace_blocks (Optional)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_fee_estimate(int|NULL $grace_blocks=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'grace_blocks' => $grace_blocks
        ];

        return parent::jsonrpc_command('get_fee_estimate', $params, $as_array);
    }

    /**
     * Display alternative chains seen by the node.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_alternate_chains(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('get_alternate_chains', $params, $as_array);
    }

    /**
     * Relay a list of transaction IDs.
     * @param array $txids List of transaction IDs to relay.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function relay_tx(array $txids, bool $as_array=FALSE): string|array {
        $params = [
            'txids' => $txids
        ];

        return parent::jsonrpc_command('relay_tx', $params, $as_array);
    }

    /**
     * Get synchronisation information.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function sync_info(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('sync_info', $params, $as_array);
    }

    /**
     * Get all transaction pool backlog.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_txpool_backlog(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('get_txpool_backlog', $params, $as_array);
    }

    /**
     * @param array $amounts Amounts to look for.
     * @param bool $cumulative States if the result should be cumulative (true) or not (false). (Optional)
     * @param int $from_height Starting height to check from. (Optional)
     * @param int $to_height Ending height to check up to. (Optional)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
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

    /**
     * Provide the necessary data to create a custom block template. They are used by p2pool.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_miner_data(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('get_miner_data', $params, $as_array);
    }

    /**
     * Prune blockchain data.
     * @param bool $check If set to (true) then pruning status is checked instead of initiating pruning.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function prune_blockchain(bool $check=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'check' => $check
        ];

        return parent::jsonrpc_command('prune_blockchain', $params, $as_array);
    }

    /**
     * Calculate PoW hash for a block candidate.
     * @param int $major_version The major version of the monero protocol at this block height.
     * @param int $height
     * @param string $blobdata
     * @param string $seed_hash
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
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

    /**
     * Flush bad transactions / blocks from the cache.
     * @param bool $bad_txs Flush bad txs. (Optional)
     * @param bool $bad_blocks Flush bad blocks. (Optional)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function flush_cache(bool $bad_txs=FALSE, bool $bad_blocks=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'bad_txs'    => $bad_txs,
            'bad_blocks' => $bad_blocks
        ];

        return parent::jsonrpc_command('flush_cache', $params, $as_array);
    }

    /// Standard RPC Commands ///

    /**
     * Get the node's current height.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_height(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::standardrpc_command('get_height', $params, $as_array);
    }

    /**
     * Get all blocks info. Binary request.
     * @param array $block_ids Binary array of hashes; first 10 blocks id goes sequential, next goes in pow(2,n) offset,
     * like 2, 4, 8, 16, 32, 64 and so on, and the last one is always genesis block.
     * @param int $start_height
     * @param bool $prune
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_blocks_bin(array $block_ids, int $start_height, bool $prune, bool $as_array=FALSE): string|array {
        $params = [
            'block_ids'    => $block_ids,
            'start_height' => $start_height,
            'prune'        => $prune
        ];

        return parent::standardrpc_command('get_blocks.bin', $params, $as_array);
    }

    /**
     * Look up one or more transactions by hash.
     * @param array $txs_hashes List of transaction hashes to look up.
     * @param bool $decode_as_json If set (true), the returned transaction information will be decoded rather than binary. (Optional)
     * @param bool $prune (Optional)
     * @param bool $split (Optional)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
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

    /**
     * Get the known blocks hashes which are not on the main chain.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_alt_blocks_hashes(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::standardrpc_command('get_alt_blocks_hashes', $params, $as_array);
    }

    /**
     * Check if outputs have been spent using the key image associated with the output.
     * @param array $key_images List of key image hex strings to check.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function is_key_image_spent(array $key_images, bool $as_array=FALSE): string|array {
        $params = [
            'key_images' => $key_images
        ];

        return parent::standardrpc_command('is_key_image_spent', $params, $as_array);
    }

    /**
     * Broadcast a raw transaction to the network.
     * @param string $tx_as_hex Full transaction information as hexidecimal string.
     * @param bool $do_not_relay Stop relaying transaction to other nodes.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function send_raw_transaction(string $tx_as_hex, bool $do_not_relay=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'tx_as_hex'    => $tx_as_hex,
            'do_not_relay' => $do_not_relay
        ];

        return parent::standardrpc_command('send_raw_transaction', $params, $as_array);
    }

    /**
     * Start mining on the daemon.
     * @param bool $do_background_mining States if the mining should run in background (true) or foreground (false).
     * @param bool $ignore_battery States if battery state (on laptop) should be ignored (true) or not (false).
     * @param string $miner_address Account address to mine to.
     * @param int $threads_count Number of mining thread to run.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
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

    /**
     * Stop mining on the daemon.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function stop_mining(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::standardrpc_command('stop_mining', $params, $as_array);
    }

    /**
     * Get the mining status of the daemon.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function mining_status(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::standardrpc_command('mining_status', $params, $as_array);
    }

    /**
     * Save the blockchain. The blockchain does not need saving and is always saved when modified, however it does a
     * sync to flush the filesystem cache onto the disk for safety purposes against Operating System or Hardware crashes.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function save_bc(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::standardrpc_command('save_bc', $params, $as_array);
    }

    /**
     * Get the known peers list.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_peer_list(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::standardrpc_command('get_peer_list', $params, $as_array);
    }

    /**
     * Set the log hash rate display mode.
     * @param bool $visible States if hash rate logs should be visible (true) or hidden (false)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function set_log_hash_rate(bool $visible, bool $as_array=FALSE): string|array {
        $params = [
            'visible' => $visible
        ];

        return parent::standardrpc_command('set_log_hash_rate', $params, $as_array);
    }

    /**
     * Set the daemon log level. By default, log level is set to 0.
     * @param int $level Daemon log level to set from 0 (less verbose) to 4 (most verbose)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function set_log_level(int $level, bool $as_array=FALSE): string|array {
        $params = [
            'level' => $level
        ];

        return parent::standardrpc_command('set_log_level', $params, $as_array);
    }

    /**
     * Set the daemon log categories. Categories are represented as a comma separated list of {Category}:{level}
     * (similarly to syslog standard).
     * Find more information at https://www.getmonero.org/resources/developer-guides/daemon-rpc.html#set_log_categories.
     * @param string|null $categories Daemon log categories to enable. (Optional)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function set_log_categories(string $categories=NULL, bool $as_array=FALSE): string|array {
        $params = $categories;
        return parent::standardrpc_command('set_log_categories', $params, $as_array);
    }

    /**
     * Give immediate usability to wallets while syncing by proxying RPC requests.
     * @param string $address host:port
     * @param string|NULL $username
     * @param string|NULL $password
     * @param string|NULL $proxy
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function set_bootstrap_daemon(string $address, string|NULL $username=NULL, string|NULL $password=NULL,
                                         string|NULL $proxy=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'address'  => $address,
            'username' => $username,
            'password' => $password,
            'proxy'    => $proxy
        ];

        return parent::standardrpc_command('set_bootstrap_daemon', $params, $as_array);
    }

    /**
     * Show information about valid transactions seen by the node but not yet mined into a block, as well as spent
     * key image information for the txpool in the node's memory.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_transaction_pool(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::standardrpc_command('get_transaction_pool', $params, $as_array);
    }

    /**
     * Get hashes from transaction pool. Binary request.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_transaction_pool_hashes_bin(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::standardrpc_command('get_transaction_pool_hashes.bin', $params, $as_array);
    }

    /**
     * Get the transaction pool statistics.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_transaction_pool_stats(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::standardrpc_command('get_transaction_pool_stats', $params, $as_array);
    }

    /**
     * Send a command to the daemon to safely disconnect and shut down.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function stop_daemon(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::standardrpc_command('stop_daemon', $params, $as_array);
    }

    /**
     * Get daemon bandwidth limits.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_limit(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::standardrpc_command('get_limit', $params, $as_array);
    }

    /**
     * Set daemon bandwidth limits.
     * @param int $limit_down Download limit in kBytes per second (-1 reset to default, 0 don't change the current limit).
     * @param int $limit_up Upload limit in kBytes per second (-1 reset to default, 0 don't change the current limit).
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function set_limit(int $limit_down, int $limit_up, bool $as_array=FALSE): string|array {
        $params = [
            'limit_down' => $limit_down,
            'limit_up'   => $limit_up
        ];

        return parent::standardrpc_command('get_limit', $params, $as_array);
    }

    /**
     * Limit number of Outgoing peers.
     * @param int $out_peers Max number of outgoing peers.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function out_peers(int $out_peers, bool $as_array=FALSE): string|array {
        $params = [
            'out_peers' => $out_peers
        ];

        return parent::standardrpc_command('out_peers', $params, $as_array);
    }

    /**
     * Limit number of Incoming peers.
     * @param int $in_peers Max number of incoming peers.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function in_peers(int $in_peers, bool $as_array=FALSE): string|array {
        $params = [
            'in_peers' => $in_peers
        ];

        return parent::standardrpc_command('in_peers', $params, $as_array);
    }

    /**
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_net_stats(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::standardrpc_command('get_net_stats', $params, $as_array);
    }

    /**
     * Get outputs.
     * @param array $outputs Outputs array of get_outputs_out structure as follows: [amount, index].
     * @param bool $get_txid If (true), a txid will include for each output in the response.
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function get_outs(array $outputs, bool $get_txid, bool $as_array=FALSE): string|array {
        $params = [
            'outputs'  => $outputs,
            'get_txid' => $get_txid
        ];

        return parent::standardrpc_command('get_outs', $params, $as_array);
    }

    /**
     * Update daemon.
     * @param string $command Command to use, either check or download.
     * @param string|NULL $path Path where to download the update. (Optional)
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function update_daemon(string $command, string|NULL $path=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'command'  => $command,
            'path'     => $path
        ];

        return parent::standardrpc_command('update', $params, $as_array);
    }

    /**
     * @param int $nblocks
     * @param bool $as_array Return result as an array.
     * @return string|array
     */
    public function pop_blocks(int $nblocks, bool $as_array=FALSE): string|array {
        $params = [
            'nblocks' => $nblocks
        ];

        return parent::standardrpc_command('pop_blocks', $params, $as_array);
    }
}