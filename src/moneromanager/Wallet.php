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
namespace moneromanager;

include('utils/RPC.php');

use moneromanager\utils\RPC;

class Wallet extends RPC {
    private string|NULL $rpc_username, $rpc_password;

    /**
     * Create a wallet object.
     * @param string $host host/ip of daemon.
     * @param string $port port of daemon.
     * @param string|NULL $rpc_username RPC username. (Default: NULL)
     * @param string|NULL $rpc_password RPC password. (Default: NULL)
     */
    public function __construct(string $host, string $port, string|NULL $rpc_username=NULL, string|NULL $rpc_password=NULL) {
        parent::__construct($host, $port);

        $this->rpc_username = $rpc_username;
        $this->rpc_password = $rpc_password;
    }

    /**
     * Connect the RPC server to a Monero daemon.
     * @param string $address The URL of the daemon to connect to.
     * @param bool $trusted If (false), some RPC wallet methods will be disabled. (Default: FALSE)
     * @param string $ssl_support Specifies whether the Daemon uses SSL encryption. (Default: autodetect) [Accepts: disabled, enabled, autodetect]
     * @param string|NULL $ssl_private_key_path The file path location of the SSL key. (Default: NULL)
     * @param string|NULL $ssl_certificate_path The file path location of the SSL certificate. (Default: NULL)
     * @param string|NULL $ssl_ca_file The file path location of the certificate authority file. (Default: NULL)
     * @param array|NULL $ssl_allowed_fingerprints The SHA1 fingerprints accepted by the SSL certificate. (Default: NULL)
     * @param bool $ssl_allow_any_cert If (false), the certificate must be signed by a trusted certificate authority. (Default: FALSE)
     * @param string|NULL $username (Default: NULL)
     * @param string|NULL $password (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array
     */
    public function set_daemon(string $address, bool $trusted=FALSE, string $ssl_support='autodetect',
                               string|NULL $ssl_private_key_path=NULL, string $ssl_certificate_path=NULL,
                               string|NULL $ssl_ca_file=NULL, array|NULL $ssl_allowed_fingerprints=NULL,
                               bool $ssl_allow_any_cert=FALSE, string|NULL $username=NULL, string|NULL $password=NULL,
                               bool $as_array=FALSE): string|array {
        $params = [
            'address'                  => $address,
            'trusted'                  => $trusted,
            'ssl_support'              => $ssl_support,
            'ssl_allow_any_cert'       => $ssl_allow_any_cert,
            'ssl_private_key_path'     => $ssl_private_key_path,
            'ssl_certificate_path'     => $ssl_certificate_path,
            'ssl_ca_file'              => $ssl_ca_file,
            'ssl_allowed_fingerprints' => $ssl_allowed_fingerprints,
            'username'                 => $username,
            'password'                 => $password
        ];

        /*$required_params = ['ssl_private_key_path', 'ssl_certificate_path', 'ssl_ca_file', 'ssl_allowed_fingerprints', 'username', 'password'];
        foreach ($required_params as $param) {
            if (NULL !== $$param) {
                $params[$param] = $$param;
            }
        }*/

        return parent::jsonrpc_command('set_daemon', $params, $as_array);
    }

    /**
     * Return the wallet's balance.
     * @param int $account_index Return balance for this account.
     * @param array|NULL $address_indices Return balance detail for those subaddresses. (Default: FALSE)
     * @param bool $all_accounts (Default: FALSE)
     * @param bool $strict All changes go to 0-th subaddress (in the current subaddress account). (Default: FALSE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_balance(int $account_index, array|NULL $address_indices=NULL, bool $all_accounts=FALSE,
                                bool $strict=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'account_index'   => $account_index,
            'address_indices' => $address_indices,
            'all_accounts'    => $all_accounts,
            'strict'          => $strict
        ];

        return parent::jsonrpc_command('get_balance', $params, $as_array);
    }

    /**
     * Return the wallet's addresses for an account. Optionally filter for specific set of subaddresses.
     * @param int $account_index Return subaddresses for this account.
     * @param array|NULL $address_index List of subaddresses to return from an account. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_address(int $account_index, array|NULL $address_index=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'account_index' => $account_index,
            'address_index' => $address_index
        ];

        return parent::jsonrpc_command('get_address', $params, $as_array);
    }

    /**
     * Get account and address indexes from a specific (sub)address.
     * @param string $address (Sub)address to look for.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_address_index(string $address, bool $as_array=FALSE): string|array {
        $params = [
            'address' => $address
        ];

        return parent::jsonrpc_command('get_address_index', $params, $as_array);
    }

    /**
     * Create a new address for an account. Optionally, label the new address.
     * @param string $account_index Create a new address for this account.
     * @param string|NULL $label Label for the new address. (Default: NULL)
     * @param int|NULL $count Number of addresses to create (Defaults to 1). (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function create_address(string $account_index, string|NULL $label=NULL, int|NULL $count=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'account_index' => $account_index,
            'label'         => $label,
            'count'         => $count
        ];

        return parent::jsonrpc_command('create_address', $params, $as_array);
    }

    /**
     * Label an address.
     * @param array $index Array object containing the major & minor address index in format ['major'=>int, 'minor'=>int].
     * @param string $label Label for the address.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function label_address(array $index, string $label, bool $as_array=FALSE): string|array {
        $params = [
            'account_index' => $index,
            'label'         => $label
        ];

        return parent::jsonrpc_command('create_address', $params, $as_array);
    }

    /**
     * Label an address.
     * @param string $address The address to validate.
     * @param bool $any_net_type If (true), consider addresses belonging to any of the three Monero networks
     * (mainnet, stagenet, and testnet) valid. Otherwise, only consider an address valid if it belongs to the network on
     * which the rpc-wallet's current daemon is running. (Default: FALSE)
     * @param bool $allow_openalias If true, consider OpenAlias-formatted addresses valid. (Default: FALSE)
     * Learn more: https://www.getmonero.org/resources/moneropedia/openalias.html
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function validate_address(string $address, bool $any_net_type=FALSE, bool $allow_openalias=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'account_index'   => $address,
            'label'           => $any_net_type,
            'allow_openalias' => $allow_openalias
        ];

        return parent::jsonrpc_command('validate_address', $params, $as_array);
    }

    /**
     * Get all accounts for a wallet. Optionally filter accounts by tag.
     * @param string|NULL $tag Tag for filtering accounts. (Default: NULL)
     * @param bool $strict_balances When (true), balance only considers the blockchain, when (false) it considers both the
     * blockchain and some recent actions, such as a recently created transaction which spent some outputs, which isn't yet mined.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_accounts(string|NULL $tag=NULL, bool $strict_balances=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'tag'                    => $tag,
            'strict_balances'        => $strict_balances
        ];

        return parent::jsonrpc_command('get_accounts', $params, $as_array);
    }

    /**
     * Create a new account with an optional label.
     * @param string|NULL $label Label for the account. (Default: NuLL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function create_account(string|NULL $label=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'label' => $label
        ];

        return parent::jsonrpc_command('create_account', $params, $as_array);
    }

    /**
     * Label an account.
     * @param int $account_index Apply label to an account at this index.
     * @param string $label Label for the account.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function label_account(int $account_index, string $label, bool $as_array=FALSE): string|array {
        $params = [
            'account_index' => $account_index,
            'label'         => $label
        ];

        return parent::jsonrpc_command('label_account', $params, $as_array);
    }

    /**
     * Get a list of user-defined account tags.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_account_tags(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('get_account_tags', $params, $as_array);
    }

    /**
     * Apply a filtering tag to a list of accounts.
     * @param string $tag Tag for the accounts.
     * @param array $accounts Tag this list of accounts in format: [int, int, ...].
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function tag_accounts(string $tag, array $accounts, bool $as_array=FALSE): string|array {
        $params = [
            'tag'      => $tag,
            'accounts' => $accounts
        ];

        return parent::jsonrpc_command('tag_accounts', $params, $as_array);
    }

    /**
     * Remove filtering tag from a list of accounts.
     * @param array $accounts Remove tag from this list of accounts in format: [int, int, ...].
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function untag_accounts(array $accounts, bool $as_array=FALSE): string|array {
        $params = [
            'accounts' => $accounts
        ];

        return parent::jsonrpc_command('untag_accounts', $params, $as_array);
    }

    /**
     * Set description for an account tag.
     * @param string $tag Set a description for this tag.
     * @param string $description Description for the tag.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function set_account_tag_description(string $tag, string $description, bool $as_array=FALSE): string|array {
        $params = [
            'tag'         => $tag,
            'description' => $description
        ];

        return parent::jsonrpc_command('set_account_tag_description', $params, $as_array);
    }

    /**
     * Returns the wallet's current block height.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_height(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('get_height', $params, $as_array);
    }

    /**
     * Send monero to a number of recipients.
     * @param array $destinations Array of destinations to receive XMR in format [['amount'=>int, 'address'=>string], [...]],
     * where 'amount' is the amount to send to each destination, in atomic units and 'address' is the destination public address.
     * @param int $account_index Transfer from this account index. (Default: 0)
     * @param array|NULL $subaddr_indices Transfer from this set of subaddresses. (Default: NULL)
     * @param int $priority Set a priority for the transaction. Accepted Values are: 0-3 for: default, unimportant, normal, elevated, priority. (Default: 0)
     * @param int|NULL $mixin Number of outputs from the blockchain to mix with (0 means no mixing). (Default: NULL)
     * @param int|NULL $ring_size Number of outputs to mix in the transaction (this output + N decoys from the blockchain).
     * (Unless dealing with pre rct outputs, this field is ignored on mainnet). (Default: NULL)
     * @param int $unlock_time Number of blocks before the monero can be spent (0 to not add a lock). (Default: 0)
     * @param bool $get_tx_key Return the transaction key after sending. (Default: FALSE)
     * @param bool $do_not_relay If true, the newly created transaction will not be relayed to the monero network. (Default: FALSE)
     * @param bool $get_tx_hex Return the transaction as hex string after sending. (Default: FALSE)
     * @param bool $get_tx_metadata Return the metadata needed to relay the transaction. (Default: FALSE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function transfer(array $destinations, int $account_index=0, array|NULL $subaddr_indices=NULL,
                             int $priority=0, int|NULL $mixin=NULL, int|NULL $ring_size=NULL,
                             int $unlock_time=0, bool $get_tx_key=FALSE, bool $do_not_relay=FALSE,
                             bool $get_tx_hex=FALSE, bool $get_tx_metadata=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'destinations'    => $destinations,
            'account_index'   => $account_index,
            'subaddr_indices' => $subaddr_indices,
            'priority'        => $priority,
            'mixin'           => $mixin,
            'ring_size'       => $ring_size,
            'unlock_time'     => $unlock_time,
            'get_tx_key'      => $get_tx_key,
            'do_not_relay'    => $do_not_relay,
            'get_tx_hex'      => $get_tx_hex,
            'get_tx_metadata' => $get_tx_metadata
        ];

        return parent::jsonrpc_command('transfer', $params, $as_array);
    }

    /**
     * Same as transfer, but can split into more than one tx if necessary.
     * @param array $destinations Array of destinations to receive XMR in format [['amount'=>int, 'address'=>string], [...]],
     * where 'amount' is the amount to send to each destination, in atomic units and 'address' is the destination public address.
     * @param int $account_index Transfer from this account index. (Default: 0)
     * @param array|NULL $subaddr_indices Transfer from this set of subaddresses. (Default: NULL)
     * @param int $priority Set a priority for the transactions. Accepted Values are: 0-3 for: default, unimportant, normal, elevated, priority. (Default: 0)
     * @param int|NULL $ring_size Sets ringsize to n (mixin + 1). (Unless dealing with pre rct outputs, this field is ignored on mainnet). (Default: NULL)
     * @param int $unlock_time Number of blocks before the monero can be spent (0 to not add a lock). (Default: 0)
     * @param string|NULL $payment_id 16 characters hex encoded. (Default: NULL)
     * @param bool $get_tx_key Return the transaction keys after sending. (Default: FALSE)
     * @param bool $do_not_relay If (true), the newly created transaction will not be relayed to the monero network. (Default: FALSE)
     * @param bool $get_tx_hex Return the transactions as hex string after sending. (Default: FALSE)
     * @param bool $get_tx_metadata Return list of transaction metadata needed to relay the transfer later. (Default: FALSE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function transfer_split(array $destinations, int $account_index=0, array|NULL $subaddr_indices=NULL,
                             int $priority=0, int|NULL $ring_size=NULL,
                             int $unlock_time=0, string|NULL $payment_id=NULL, bool $get_tx_key=FALSE, bool $do_not_relay=FALSE,
                             bool $get_tx_hex=FALSE, bool $get_tx_metadata=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'destinations'    => $destinations,
            'account_index'   => $account_index,
            'subaddr_indices' => $subaddr_indices,
            'priority'        => $priority,
            'ring_size'       => $ring_size,
            'unlock_time'     => $unlock_time,
            'payment_id'      => $payment_id,
            'get_tx_key'      => $get_tx_key,
            'do_not_relay'    => $do_not_relay,
            'get_tx_hex'      => $get_tx_hex,
            'get_tx_metadata' => $get_tx_metadata
        ];

        return parent::jsonrpc_command('transfer_split', $params, $as_array);
    }

    /**
     * Sign a transaction created on a read-only wallet (in cold-signing process).
     * @param string $unsigned_txset Set of unsigned tx returned by "transfer" or "transfer_split" methods.
     * @param bool $export_raw If (true), return the raw transaction data. (Default: FALSE)
     * @param bool $get_tx_keys Return the transaction keys after signing. (Default: FALSE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function sign_transfer(string $unsigned_txset, bool $export_raw=FALSE, bool $get_tx_keys=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'unsigned_txset' => $unsigned_txset,
            'export_raw'     => $export_raw,
            'get_tx_keys'    => $get_tx_keys
        ];

        return parent::jsonrpc_command('sign_transfer', $params, $as_array);
    }

    /**
     * Submit a previously signed transaction on a read-only wallet (in cold-signing process).
     * @param string $tx_data_hex Set of signed tx returned by "sign_transfer".
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function submit_transfer(string $tx_data_hex, bool $as_array=FALSE): string|array {
        $params = [
            'unsigned_txset' => $tx_data_hex
        ];

        return parent::jsonrpc_command('submit_transfer', $params, $as_array);
    }

    /**
     * Send all dust outputs back to the wallet's, to make them easier to spend (and mix).
     * @param bool $get_tx_keys Return the transaction keys after sending. (Default: FALSE)
     * @param bool $do_not_relay If true, the newly created transaction will not be relayed to the monero network. (Default: FALSE)
     * @param bool $get_tx_hex Return the transactions as hex string after sending. (Default: FALSE)
     * @param bool $get_tx_metadata Return list of transaction metadata needed to relay the transfer later. (Default: FALSE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function sweep_dust(bool $get_tx_keys=FALSE, bool $do_not_relay=FALSE, bool $get_tx_hex=FALSE, bool $get_tx_metadata=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'get_tx_keys'     => $get_tx_keys,
            'do_not_relay'    => $do_not_relay,
            'get_tx_hex'      => $get_tx_hex,
            'get_tx_metadata' => $get_tx_metadata
        ];

        return parent::jsonrpc_command('sweep_dust', $params, $as_array);
    }

    /**
     * Send all unlocked balance to an address.
     * @param string $address Destination public address.
     * @param int $account_index Sweep transactions from this account.
     * @param int|NULL $subaddr_indices Sweep from this set of subaddresses in the account. (Default: NULL)
     * @param bool $subaddr_indices_all Use outputs in all subaddresses within an account. (Default: FALSE)
     * @param int $priority Priority for sending the sweep transfer, partially determines fee. (Default: 0)
     * @param int|NULL $outputs Specify the number of separate outputs of smaller denomination that will be created by sweep operation. (Default: NULL)
     * @param int|NULL $ring_size Sets ringsize to n (mixin + 1). (Unless dealing with pre rct outputs, this field is ignored on mainnet). (Default: NULL)
     * @param int $unlock_time Number of blocks before the monero can be spent (0 to not add a lock). (Default: 0)
     * @param string|NULL $payment_id 16 characters hex encoded. (Default: NULL)
     * @param bool $get_tx_keys Return the transaction keys after sending. (Default: FALSE)
     * @param int|NULL $below_amount Include outputs below this amount. (Default: NULL)
     * @param bool $do_not_relay If (true), do not relay this sweep transfer. (Default: FALSE)
     * @param bool $get_tx_hex Return the transactions as hex encoded. (Default: FALSE)
     * @param bool $get_tx_metadata Return the transaction metadata as a string. (Default: FALSE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function sweep_all(string $address, int $account_index, int|NULL $subaddr_indices=NULL,
                              bool $subaddr_indices_all=FALSE, int $priority=0, int|NULL $outputs=NULL,
                              int|NULL $ring_size=NULL, int $unlock_time=0, string|NULL $payment_id=NULL,
                              bool $get_tx_keys=FALSE, int|NULL $below_amount=NULL, bool $do_not_relay=FALSE,
                              bool $get_tx_hex=FALSE, bool $get_tx_metadata=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'address'             => $address,
            'account_index'       => $account_index,
            'subaddr_indices'     => $subaddr_indices,
            'subaddr_indices_all' => $subaddr_indices_all,
            'priority'            => $priority,
            'outputs'             => $outputs,
            'ring_size'           => $ring_size,
            'unlock_time'         => $unlock_time,
            'payment_id'          => $payment_id,
            'get_tx_keys'         => $get_tx_keys,
            'below_amount'        => $below_amount,
            'do_not_relay'        => $do_not_relay,
            'get_tx_hex'          => $get_tx_hex,
            'get_tx_metadata'     => $get_tx_metadata
        ];

        return parent::jsonrpc_command('sweep_all', $params, $as_array);
    }

    /**
     * Send all of a specific unlocked output to an address.
     * @param string $address Destination public address.
     * @param int $priority Priority for sending the sweep transfer, partially determines fee. (Default: 0)
     * @param int|NULL $outputs Specify the number of separate outputs of smaller denomination that will be created by sweep operation. (Default: NULL)
     * @param int|NULL $ring_size Sets ringsize to n (mixin + 1). (Unless dealing with pre rct outputs, this field is ignored on mainnet). (Default: NULL)
     * @param int $unlock_time Number of blocks before the monero can be spent (0 to not add a lock). (Default: 0)
     * @param string|NULL $payment_id 16 characters hex encoded. (Default: NULL)
     * @param bool $get_tx_key Return the transaction keys after sending. (Default: FALSE)
     * @param string|NULL $key_image Key image of specific output to sweep. (Default: NULL)
     * @param bool $do_not_relay If (true), do not relay this sweep transfer. (Default: FALSE)
     * @param bool $get_tx_hex Return the transactions as hex encoded string. (Default: FALSE)
     * @param bool $get_tx_metadata Return the transaction metadata as a string. (Default: FALSE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function sweep_single(string $address, int $priority=0, int|NULL $outputs=NULL,
                              int|NULL $ring_size=NULL, int $unlock_time=0, string|NULL $payment_id=NULL,
                              bool $get_tx_key=FALSE, string|NULL $key_image=NULL, bool $do_not_relay=FALSE,
                              bool $get_tx_hex=FALSE, bool $get_tx_metadata=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'address'             => $address,
            'priority'            => $priority,
            'outputs'             => $outputs,
            'ring_size'           => $ring_size,
            'unlock_time'         => $unlock_time,
            'payment_id'          => $payment_id,
            'get_tx_key'         => $get_tx_key,
            'key_image'           => $key_image,
            'do_not_relay'        => $do_not_relay,
            'get_tx_hex'          => $get_tx_hex,
            'get_tx_metadata'     => $get_tx_metadata
        ];

        return parent::jsonrpc_command('sweep_single', $params, $as_array);
    }

    /**
     * Relay a transaction previously created with "do_not_relay":true.
     * @param string $hex Transaction metadata returned from a transfer method with get_tx_metadata set to true.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function relay_tx(string $hex, bool $as_array=FALSE): string|array {
        $params = [
            'hex' => $hex
        ];

        return parent::jsonrpc_command('relay_tx', $params, $as_array);
    }

    /**
     * Save the wallet file.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function store(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('store', $params, $as_array);
    }

    /**
     * Get a list of incoming payments using a given payment id.
     * [WARNING: Verify that the payment has a sensible unlock_time, otherwise the funds might be inaccessible.]
     * @param string $payment_id Payment ID used to find the payments (16 characters hex).
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_payments(string $payment_id, bool $as_array=FALSE): string|array {
        $params = [
            'payment_id' => $payment_id
        ];

        return parent::jsonrpc_command('get_payments', $params, $as_array);
    }

    /**
     * Get a list of incoming payments using a given payment id, or a list of payments ids, from a given height.
     * This method is the preferred method over get_payments because it has the same functionality but is more extendable.
     * Either is fine for looking up transactions by a single payment ID.
     * [WARNING: Verify that the payment has a sensible unlock_time, otherwise the funds might be inaccessible.]
     * @param array $payment_ids Payment IDs used to find the payments (16 characters hex).
     * @param int $min_block_height The block height at which to start looking for payments.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_bulk_payments(array $payment_ids, int $min_block_height, bool $as_array=FALSE): string|array {
        $params = [
            'payment_ids'      => $payment_ids,
            'min_block_height' => $min_block_height
        ];

        return parent::jsonrpc_command('get_bulk_payments', $params, $as_array);
    }

    /**
     * Return a list of incoming transfers to the wallet.
     * @param string $transfer_type "all": all the transfers, "available": only transfers which are not yet spent, OR "unavailable": only transfers which are already spent.
     * @param int $account_index Return transfers for this account. (Default: 0)
     * @param int|NULL $subaddr_indices Return transfers sent to these subaddresses. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function incoming_transfers(string $transfer_type, int $account_index=0, int|NULL $subaddr_indices=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'transfer_type'   => $transfer_type,
            'account_index'   => $account_index,
            'subaddr_indices' => $subaddr_indices
        ];

        return parent::jsonrpc_command('incoming_transfers', $params, $as_array);
    }

    /**
     * Return the spend or view private key.
     * @param string $key_type Which key to retrieve: "mnemonic" - the mnemonic seed (older wallets do not have one) OR "view_key" - the view key OR "spend_key".
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function query_key(string $key_type, bool $as_array=FALSE): string|array {
        $params = [
            'key_type' => $key_type
        ];

        return parent::jsonrpc_command('query_key', $params, $as_array);
    }

    /**
     * Make an integrated address from the wallet address and a payment id.
     * @param string|NULL $standard_address Destination public address. (Default: NULL)
     * @param string|NULL $payment_id 16 characters hex encoded. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function make_integrated_address(string|NULL $standard_address=NULL, string|NULL $payment_id=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'standard_address' => $standard_address,
            'payment_id'       => $payment_id
        ];

        return parent::jsonrpc_command('make_integrated_address', $params, $as_array);
    }

    /**
     * Retrieve the standard address and payment id corresponding to an integrated address.
     * @param string $integrated_address
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function split_integrated_address(string $integrated_address, bool $as_array=FALSE): string|array {
        $params = [
            'integrated_address' => $integrated_address
        ];

        return parent::jsonrpc_command('split_integrated_address', $params, $as_array);
    }

    /**
     * Store the current state of any open wallet and exit the monero-wallet-rpc process.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function stop_wallet(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('stop_wallet', $params, $as_array);
    }

    /**
     * Rescan the blockchain from scratch, losing any information which can not be recovered from the blockchain itself.
     * This includes destination addresses, tx secret keys, tx notes, etc.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function rescan_blockchain(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('rescan_blockchain', $params, $as_array);
    }

    /**
     * Set arbitrary string notes for transactions.
     * @param array $txids Transaction ids.
     * @param array $notes Notes for the transactions.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function set_tx_notes(array $txids, array $notes, bool $as_array=FALSE): string|array {
        $params = [
            'txids' => $txids,
            'notes' => $notes
        ];

        return parent::jsonrpc_command('set_tx_notes', $params, $as_array);
    }

    /**
     * Get string notes for transactions.
     * @param array $txids Transaction ids.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_tx_notes(array $txids, bool $as_array=FALSE): string|array {
        $params = [
            'txids' => $txids
        ];

        return parent::jsonrpc_command('get_tx_notes', $params, $as_array);
    }

    /**
     * Set arbitrary attribute.
     * @param string $key Attribute name.
     * @param string $value Attribute value.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function set_attribute(string $key, string $value, bool $as_array=FALSE): string|array {
        $params = [
            'key' => $key,
            'value' => $value
        ];

        return parent::jsonrpc_command('set_attribute', $params, $as_array);
    }

    /**
     * Get attribute value by name.
     * @param string $key Attribute name.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_attribute(string $key, bool $as_array=FALSE): string|array {
        $params = [
            'key' => $key
        ];

        return parent::jsonrpc_command('get_attribute', $params, $as_array);
    }

    /**
     * Get transaction secret key from transaction id.
     * @param string $txid Transaction id.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_tx_key(string $txid, bool $as_array=FALSE): string|array {
        $params = [
            'txid' => $txid
        ];

        return parent::jsonrpc_command('get_tx_key', $params, $as_array);
    }

    /**
     * Check a transaction in the blockchain with its secret key.
     * @param string $txid Transaction id.
     * @param string $tx_key Transaction secret key.
     * @param string $address Destination public address of the transaction.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function check_tx_key(string $txid, string $tx_key, string $address, bool $as_array=FALSE): string|array {
        $params = [
            'txid'    => $txid,
            'tx_key'  => $tx_key,
            'address' => $address
        ];

        return parent::jsonrpc_command('check_tx_key', $params, $as_array);
    }

    /**
     * Get transaction signature to prove it.
     * @param string $txid Transaction id.
     * @param string $address Destination public address of the transaction.
     * @param string|NULL $message Add a message to the signature to further authenticate the proving process. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_tx_proof(string $txid, string $address, string|NULL $message=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'txid'    => $txid,
            'address' => $address,
            'message' => $message
        ];

        return parent::jsonrpc_command('get_tx_proof', $params, $as_array);
    }

    /**
     * Prove a transaction by checking its signature.
     * @param string $txid Transaction id.
     * @param string $address Destination public address of the transaction.
     * @param string $signature Transaction signature to confirm.
     * @param string|NULL $message Should be the same message used in get_tx_proof. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function check_tx_proof(string $txid, string $address, string $signature, string|NULL $message=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'txid'      => $txid,
            'address'   => $address,
            'signature' => $signature,
            'message'   => $message
        ];

        return parent::jsonrpc_command('check_tx_proof', $params, $as_array);
    }

    /**
     * Generate a signature to prove a spend. Unlike proving a transaction, it does not require the destination public address.
     * @param string $txid Transaction id.
     * @param string|NULL $message Add a message to the signature to further authenticate the proving process. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_spend_proof(string $txid, string|NULL $message=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'txid'    => $txid,
            'message' => $message
        ];

        return parent::jsonrpc_command('get_spend_proof', $params, $as_array);
    }

    /**
     * Prove a spend using a signature. Unlike proving a transaction, it does not require the destination public address.
     * @param string $txid Transaction id..
     * @param string $signature Spend signature to confirm.
     * @param string|NULL $message Should be the same message used in get_spend_proof. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function check_spend_proof(string $txid, string $signature, string|NULL $message=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'txid'      => $txid,
            'signature' => $signature,
            'message'   => $message
        ];

        return parent::jsonrpc_command('check_spend_proof', $params, $as_array);
    }

    /**
     * Generate a signature to prove of an available amount in a wallet.
     * @param bool $all Proves all wallet balance to be disposable.
     * @param int|NULL $account_index Specify the account from which to prove reserve. (ignored if $all is set to true). (Default: NULL)
     * @param int|NULL $amount Amount (in atomic units) to prove the account has in reserve. (ignored if all is set to true).
     * @param string|NULL $message Add a message to the signature to further authenticate the proving process.
     * If a message is added to get_reserve_proof (optional), this message will be required when using check_reserve_proof. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_reserve_proof(bool $all, int|NULL $account_index=NULL, int|NULL $amount=NULL, string|NULL $message=NULL,  bool $as_array=FALSE): string|array {
        $params = [
            'all'           => $all,
            'account_index' => $account_index,
            'amount'        => $amount,
            'message'       => $message
        ];

        return parent::jsonrpc_command('get_reserve_proof', $params, $as_array);
    }

    /**
     * Proves a wallet has a disposable reserve using a signature.
     * @param string $address Public address of the wallet.
     * @param string $signature Reserve signature to confirm.
     * @param string|NULL $message If a message was added to get_reserve_proof (optional),
     * this message will be required when using check_reserve_proof. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function check_reserve_proof(string $address, string $signature, string|NULL $message=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'address'   => $address,
            'signature' => $signature,
            'message'   => $message
        ];

        return parent::jsonrpc_command('check_reserve_proof', $params, $as_array);
    }

    /**
     * Returns a list of transfers.
     * [WARNING: Verify that the transfer has a sensible unlock_time otherwise the funds might be inaccessible.]
     * @param bool $in Include incoming transfers. (Default: FALSE)
     * @param bool $out Include outgoing transfers. (Default: FALSE)
     * @param bool $pending Include pending transfers. (Default: FALSE)
     * @param bool $failed Include failed transfers. (Default: FALSE)
     * @param bool $pool Include transfers from the daemon's transaction pool. (Default: FALSE)
     * @param bool $filter_by_height Filter transfers by block height. (Default: FALSE)
     * @param int|NULL $min_height Minimum block height to scan for transfers, if filtering by height is enabled. (Default: NULL)
     * @param int|NULL $max_height Maximum block height to scan for transfers, if filtering by height is enabled. (Default: NULL)
     * @param int $account_index Index of the account to query for transfers. (Default: 0)
     * @param array|NULL $subaddr_indices List of subaddress indices to query for transfers. (Default: NULL)
     * @param bool $all_accounts (Default: FALSE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_transfers(bool $in=FALSE, bool $out=FALSE, bool $pending=FALSE, bool $failed=FALSE, bool $pool=FALSE,
                                  bool $filter_by_height=FALSE, int|NULL $min_height=NULL, int|NULL $max_height=NULL,
                                  int $account_index=0, array|NULL $subaddr_indices=NULL, bool $all_accounts=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'in'               => $in,
            'out'              => $out,
            'pending'          => $pending,
            'failed'           => $failed,
            'pool'             => $pool,
            'filter_by_height' => $filter_by_height,
            'min_height'       => $min_height,
            'max_height'       => $max_height,
            'account_index'    => $account_index,
            'subaddr_indices'  => $subaddr_indices,
            'all_accounts'     => $all_accounts
        ];

        return parent::jsonrpc_command('get_transfers', $params, $as_array);
    }

    /**
     * Show information about a transfer to/from this address.
     * [WARNING: Verify that the transfer has a sensible unlock_time otherwise the funds might be inaccessible.]
     * @param string $txid Transaction ID used to find the transfer.
     * @param int|NULL $account_index Index of the account to query for the transfer. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_transfer_by_txid(string $txid, int|NULL $account_index=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'txid'          => $txid,
            'account_index' => $account_index
        ];

        return parent::jsonrpc_command('get_transfer_by_txid', $params, $as_array);
    }

    /**
     * These methods return unsigned transaction sets if the wallet is view-only (i.e. the wallet was created without the private spend key).
     * [WARNING: Verify that the transfer has a sensible unlock_time otherwise the funds might be inaccessible.]
     * @param string|NULL $unsigned_txset A hexadecimal string representing a set of unsigned transactions
     * (empty for multisig transactions; non-multisig signed transactions are not supported). (Default: NULL)
     * @param string|NULL $multisig_txset A hexadecimal string representing the set of signing keys used in a multisig transaction
     * (empty for unsigned transactions; non-multisig signed transactions are not supported). (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function describe_transfer(string|NULL $unsigned_txset=NULL, string|NULL $multisig_txset=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'unsigned_txset' => $unsigned_txset,
            'multisig_txset' => $multisig_txset
        ];

        return parent::jsonrpc_command('describe_transfer', $params, $as_array);
    }

    /**
     * Sign a string.
     * @param string $data Anything you need to sign.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function sign(string $data, bool $as_array=FALSE): string|array {
        $params = [
            'data' => $data
        ];

        return parent::jsonrpc_command('sign', $params, $as_array);
    }

    /**
     * Verify a signature on a string.
     * @param string $data What should have been signed.
     * @param string $address Public address of the wallet used to sign the data.
     * @param string $signature Signature generated by sign method.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function verify(string $data, string $address, string $signature, bool $as_array=FALSE): string|array {
        $params = [
            'data'      => $data,
            'address'   => $address,
            'signature' => $signature
        ];

        return parent::jsonrpc_command('verify', $params, $as_array);
    }

    /**
     * Export outputs in hex format.
     * @param bool $all If (true), export all outputs. Otherwise, export outputs since the last export. (Default: FALSE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function export_outputs(bool $all=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'all' => $all
        ];

        return parent::jsonrpc_command('export_outputs', $params, $as_array);
    }

    /**
     * Import outputs in hex format.
     * @param string $outputs_data_hex Wallet outputs in hex format.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function import_outputs(string $outputs_data_hex, bool $as_array=FALSE): string|array {
        $params = [
            'outputs_data_hex' => $outputs_data_hex
        ];

        return parent::jsonrpc_command('import_outputs', $params, $as_array);
    }

    /**
     * Export a signed set of key images.
     * @param bool $all If (true), export all key images. Otherwise, export key images since the last export. (Default: FALSE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function export_key_images(bool $all=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'all' => $all
        ];

        return parent::jsonrpc_command('export_key_images', $params, $as_array);
    }

    /**
     * Import signed key images list and verify their spent status.
     * @param array $signed_key_images Array of signed key images in format: [['key_image'=>string, 'signature'=>string], [...]]
     * @param int|NULL $offset (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function import_key_images(array $signed_key_images, int|NULL $offset=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'signed_key_images' => $signed_key_images,
            'offset'            => $offset
        ];

        return parent::jsonrpc_command('import_key_images', $params, $as_array);
    }

    /**
     * Create a payment URI using the official URI spec.
     * @param string $address Wallet address.
     * @param int $amount The integer amount to receive, in atomic units.
     * @param string|NULL $payment_id 16 characters hex encoded. (Default: NULL)
     * @param string|NULL $recipient_name Name of the payment recipient. (Default: NULL)
     * @param string|NULL $tx_description Description of the reason for the tx. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function make_uri(string $address, int $amount, string|NULL $payment_id=NULL, string|NULL $recipient_name=NULL,
                             string|NULL $tx_description=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'address'        => $address,
            'amount'         => $amount,
            'payment_id'     => $payment_id,
            'recipient_name' => $recipient_name,
            'tx_description' => $tx_description
        ];

        return parent::jsonrpc_command('make_uri', $params, $as_array);
    }

    /**
     * Parse a payment URI to get payment information.
     * @param string $uri This contains all the payment input information as a properly formatted payment URI.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function parse_uri(string $uri, bool $as_array=FALSE): string|array {
        $params = [
            'uri' => $uri
        ];

        return parent::jsonrpc_command('parse_uri', $params, $as_array);
    }

    /**
     * Retrieves entries from the address book.
     * @param array $entries Indices of the requested address book entries in format: [int, int, ...].
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_address_book(array $entries, bool $as_array=FALSE): string|array {
        $params = [
            'entries' => $entries
        ];

        return parent::jsonrpc_command('get_address_book', $params, $as_array);
    }

    /**
     * Add an entry to the address book.
     * @param string $address Wallet address.
     * @param string|NULL $payment_id 16 characters hex encoded. (Default: NULL)
     * @param string|NULL $description (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function add_address_book(string $address, string|NULL $payment_id=NULL, string|NULL $description=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'address'     => $address,
            'payment_id'  => $payment_id,
            'description' => $description
        ];

        return parent::jsonrpc_command('add_address_book', $params, $as_array);
    }

    /**
     * Edit an existing address book entry.
     * @param int $index Index of the address book entry to edit.
     * @param bool $set_address If (true), set the address for this entry to the value of "address". (Default: FALSE)
     * @param string|NULL $address The 95-character public address to set. (Default: NULL)
     * @param bool $set_description If (true), set the description for this entry to the value of "description". (Default: FALSE)
     * @param string|NULL $description Human-readable description for this entry. (Default: NULL)
     * @param bool $set_payment_id If (true), set the payment ID for this entry to the value of "payment_id". (Default: FALSE)
     * @param string|NULL $payment_id 16 characters hex encoded. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function edit_address_book(int $index, bool $set_address, string|NULL $address=NULL,
                                      bool $set_description=FALSE, string|NULL $description=NULL,
                                      bool $set_payment_id=FALSE, string|NULL $payment_id=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'index'           => $index,
            'set_address'     => $set_address,
            'address'         => $address,
            'set_description' => $set_description,
            'description'     => $description,
            'set_payment_id'  => $set_payment_id,
            'payment_id'      => $payment_id
        ];

        return parent::jsonrpc_command('edit_address_book', $params, $as_array);
    }

    /**
     * Delete an entry from the address book.
     * @param int $index The index of the address book entry.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function delete_address_book(int $index, bool $as_array=FALSE): string|array {
        $params = [
            'index' => $index
        ];

        return parent::jsonrpc_command('delete_address_book', $params, $as_array);
    }

    /**
     * Refresh a wallet after opening.
     * @param int|NULL $start_height The block height from which to start refreshing. Passing no value or a value less
     * than the last block scanned by the wallet refreshes from the last block scanned. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function refresh(int|NULL $start_height=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'start_height' => $start_height
        ];

        return parent::jsonrpc_command('refresh', $params, $as_array);
    }

    /**
     * Set whether and how often to automatically refresh the current wallet.
     * @param bool $enable Enable or disable automatic refreshing. (Default: TRUE)
     * @param int|NULL $period The period of the wallet refresh cycle (i.e. time between refreshes) in seconds. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function auto_refresh(bool $enable=TRUE, int|NULL $period=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'enable' => $enable,
            'period' => $period
        ];

        return parent::jsonrpc_command('auto_refresh', $params, $as_array);
    }

    /**
     * Rescan the blockchain for spent outputs.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function rescan_spent(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('rescan_spent', $params, $as_array);
    }

    /**
     * Start mining in the Monero daemon.
     * @param int $threads_count Number of threads created for mining.
     * @param bool $do_background_mining Allow starting the miner in smart mining mode. (Default: FALSE)
     * @param bool $ignore_battery Ignore battery status (for smart mining only). (Default: FALSE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function start_mining(int $threads_count, bool $do_background_mining=FALSE, bool $ignore_battery=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'threads_count'        => $threads_count,
            'do_background_mining' => $do_background_mining,
            'ignore_battery'       => $ignore_battery
        ];

        return parent::jsonrpc_command('start_mining', $params, $as_array);
    }

    /**
     * Stop mining in the Monero daemon.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function stop_mining(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('stop_mining', $params, $as_array);
    }

    /**
     * Get a list of available languages for your wallet's seed.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_languages(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('get_languages', $params, $as_array);
    }

    /**
     * Create a new wallet. You need to have set the argument "–wallet-dir" when launching monero-wallet-rpc to make this work.
     * @param string $filename Wallet file name.
     * @param string|NULL $password Password to protect the wallet. (Default: NULL)
     * @param string $language Language for your wallets' seed. (Default: 'English')
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function create_wallet(string $filename, string|NULL $password=NULL, string $language='English', bool $as_array=FALSE): string|array {
        $params = [
            'filename' => $filename,
            'password' => $password,
            'language' => $language
        ];

        return parent::jsonrpc_command('create_wallet', $params, $as_array);
    }

    /**
     * Restores a wallet from a given wallet address, view key, and optionally spend key.
     * @param string $filename The wallet's file name on the RPC server.
     * @param string $address The wallet's primary address.
     * @param string $viewkey The wallet's private view key.
     * @param string $password The wallet's password.
     * @param int $restore_height The block height to restore the wallet from. (Default: 0)
     * @param string|NULL $spendkey The wallet's private spend key. (Default: NULL)
     * @param bool $autosave_current If (true), save the current wallet before generating the new wallet. (Default: TRUE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function generate_from_keys(string $filename, string $address, string $viewkey, string $password,
                                       int $restore_height=0, string|NULL $spendkey=NULL, bool $autosave_current=TRUE, bool $as_array=FALSE): string|array {
        $params = [
            'filename'         => $filename,
            'address'          => $address,
            'viewkey'          => $viewkey,
            'password'         => $password,
            'restore_height'   => $restore_height,
            'spend_key'        => $spendkey,
            'autosave_current' => $autosave_current
        ];

        return parent::jsonrpc_command('generate_from_keys', $params, $as_array);
    }

    /**
     * Open a wallet. You need to have set the argument "–wallet-dir" when launching monero-wallet-rpc to make this work.
     * @param string $filename Wallet name stored in –wallet-dir.
     * @param string|NULL $password Only needed if the wallet has a password defined. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function open_wallet(string $filename, string|NULL $password=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'filename' => $filename,
            'password' => $password
        ];

        return parent::jsonrpc_command('open_wallet', $params, $as_array);
    }

    /**
     * Create and open a wallet on the RPC server from an existing mnemonic phrase and close the currently open wallet.
     * @param string $filename Name of the wallet.
     * @param string $password Password of the wallet.
     * @param string $seed Mnemonic phrase of the wallet to restore.
     * @param int $restore_height Block height to restore the wallet from. (Default: 0)
     * @param string|NULL $language Language of the mnemonic phrase in case the old language is invalid. (Default: NULL)
     * @param string|NULL $seed_offset Offset used to derive a new seed from the given mnemonic to recover a secret wallet from the mnemonic phrase. (Default: NULL)
     * @param bool $autosave_current Whether to save the currently open RPC wallet before closing it. (Default: TRUE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function restore_deterministic_wallet(string $filename, string $password, string $seed,
                                                 int $restore_height=0, string|NULL $language=NULL, string|NULL $seed_offset=NULL,
                                                 bool $autosave_current=TRUE, bool $as_array=FALSE): string|array {
        $params = [
            'filename'         => $filename,
            'password'         => $password,
            'seed'             => $seed,
            'restore_height'   => $restore_height,
            'language'         => $language,
            'seed_offset'      => $seed_offset,
            'autosave_current' => $autosave_current
        ];

        return parent::jsonrpc_command('restore_deterministic_wallet', $params, $as_array);
    }

    /**
     * Close the currently opened wallet, after trying to save it.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function close_wallet(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('close_wallet', $params, $as_array);
    }

    /**
     * Change a wallet password.
     * @param string|NULL $old_password Current wallet password, if defined. (Default: NULL)
     * @param string|NULL $new_password New wallet password, if not blank. (Default: NULL)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function change_wallet_password(string|NULL $old_password=NULL, string|NULL $new_password=NULL, bool $as_array=FALSE): string|array {
        $params = [
            'old_password' => $old_password,
            'new_password' => $new_password
        ];

        return parent::jsonrpc_command('change_wallet_password', $params, $as_array);
    }

    /**
     * Check if a wallet is multisig.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function is_multisig(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('is_multisig', $params, $as_array);
    }

    /**
     * Prepare a wallet for multisig by generating a multisig string to share with peers.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function prepare_multisig(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('prepare_multisig', $params, $as_array);
    }

    /**
     * Make a wallet multisig by importing peers multisig string.
     * @param array $multisig_info List of multisig string from peers in format: [string, string, ...].
     * @param int $threshold Amount of signatures needed to sign a transfer. Must be less or equal than the amount of signature in multisig_info.
     * @param string $password Wallet password.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function make_multisig(array $multisig_info, int $threshold, string $password, bool $as_array=FALSE): string|array {
        $params = [
            'multisig_info' => $multisig_info,
            'threshold'     => $threshold,
            'password'      => $password
        ];

        return parent::jsonrpc_command('make_multisig', $params, $as_array);
    }

    /**
     * Export multisig info for other participants.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function export_multisig_info(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('export_multisig_info', $params, $as_array);
    }

    /**
     * Import multisig info from other participants.
     * @param array $info List of multisig info in hex format from other participants.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function import_multisig_info(array $info, bool $as_array=FALSE): string|array {
        $params = [
            'info' => $info
        ];

        return parent::jsonrpc_command('import_multisig_info', $params, $as_array);
    }

    /**
     * Turn this wallet into a multisig wallet, extra step for N-1/N wallets.
     * @param array $multisig_info List of multisig string from peers in format: [string, string, ...].
     * @param string $password Wallet password.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function finalize_multisig(array $multisig_info, string $password, bool $as_array=FALSE): string|array {
        $params = [
            'multisig_info' => $multisig_info,
            'password'      => $password
        ];

        return parent::jsonrpc_command('finalize_multisig', $params, $as_array);
    }

    /**
     * Sign a transaction in multisig.
     * @param string $tx_data_hex Multisig transaction in hex format, as returned by transfer under multisig_txset.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function sign_multisig(string $tx_data_hex, bool $as_array=FALSE): string|array {
        $params = [
            'tx_data_hex' => $tx_data_hex
        ];

        return parent::jsonrpc_command('sign_multisig', $params, $as_array);
    }

    /**
     * Submit a signed multisig transaction.
     * @param string $tx_data_hex Multisig transaction in hex format, as returned by sign_multisig under tx_data_hex.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function submit_multisig(string $tx_data_hex, bool $as_array=FALSE): string|array {
        $params = [
            'tx_data_hex' => $tx_data_hex
        ];

        return parent::jsonrpc_command('submit_multisig', $params, $as_array);
    }

    /**
     * Get RPC version Major & Minor integer-format, where Major is the first 16 bits and Minor the last 16 bits.
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function get_version(bool $as_array=FALSE): string|array {
        $params = NULL;
        return parent::jsonrpc_command('get_version', $params, $as_array);
    }

    /**
     * Freeze a single output by key image, so it will not be used.
     * @param string $key_image
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function freeze(string $key_image, bool $as_array=FALSE): string|array {
        $params = [
            'key_image' => $key_image
        ];

        return parent::jsonrpc_command('freeze', $params, $as_array);
    }

    /**
     * Checks whether a given output is currently frozen by key image.
     * @param string $key_image
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function frozen(string $key_image, bool $as_array=FALSE): string|array {
        $params = [
            'key_image' => $key_image
        ];

        return parent::jsonrpc_command('frozen', $params, $as_array);
    }

    /**
     * Thaw a single output by key image, so it may be used again.
     * @param string $key_image
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function thaw(string $key_image, bool $as_array=FALSE): string|array {
        $params = [
            'key_image' => $key_image
        ];

        return parent::jsonrpc_command('thaw', $params, $as_array);
    }

    /**
     * Performs extra multisig keys exchange rounds. Needed for arbitrary M/N multisig wallets.
     * @param string $password
     * @param string $multisig_info
     * @param bool $force_update_use_with_caution Only require the minimum number of signers to complete
     * this round (including local signer) ( minimum = num_signers - (round num - 1).
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function exchange_multisig_keys(string $password, string $multisig_info, bool $force_update_use_with_caution=FALSE, bool $as_array=FALSE): string|array {
        $params = [
            'password'                      => $password,
            'multisig_info'                 => $multisig_info,
            'force_update_use_with_caution' => $force_update_use_with_caution
        ];

        return parent::jsonrpc_command('exchange_multisig_keys', $params, $as_array);
    }

    /**
     * @param int $n_inputs
     * @param int $n_outputs
     * @param int|NULL $ring_size Sets ringsize to n (mixin + 1). (Unless dealing with pre rct outputs, this field is ignored on mainnet). (Default: NULL)
     * @param bool $rct Is this a Ring Confidential Transaction (post blockheight 1220516). (Default: TRUE)
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function estimate_tx_size_and_weight(int $n_inputs, int $n_outputs, int|NULL $ring_size=NULL, bool $rct=TRUE, bool $as_array=FALSE): string|array {
        $params = [
            'n_inputs'  => $n_inputs,
            'n_outputs' => $n_outputs,
            'ring_size' => $ring_size,
            'rct'       => $rct
        ];

        return parent::jsonrpc_command('estimate_tx_size_and_weight', $params, $as_array);
    }

    /**
     * Given a list of txids, scan each for outputs belonging to your wallet. Note that the node will see these specific requests and may be a privacy concern.
     * @param array $txids Array of txids in format [string, string, ...].
     * @param bool $as_array Return result as an array. (Default: FALSE)
     * @return string|array RPC Response.
     */
    public function scan_tx(array $txids, bool $as_array=FALSE): string|array {
        $params = [
            'txids' => $txids
        ];

        return parent::jsonrpc_command('scan_tx', $params, $as_array);
    }
}