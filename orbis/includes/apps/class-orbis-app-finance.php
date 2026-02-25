<?php

/**
 * The Finance Application class.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/apps
 */

require_once plugin_dir_path( __FILE__ ) . 'class-orbis-app-base.php';

class Orbis_App_Finance extends Orbis_App_Base {

    protected function register_ajax_handlers() {
        $this->add_ajax( 'get_finance_data', 'handle_get_finance_data' );
        $this->add_ajax( 'save_transaction', 'handle_save_transaction' );
    }

    public function handle_get_finance_data() {
        $this->verify_nonce();
        $user_id = get_current_user_id();
        $transactions = get_user_meta( $user_id, 'orbis_finance_transactions', true ) ?: array();
        wp_send_json_success( array_values($transactions) );
    }

    public function handle_save_transaction() {
        $this->verify_nonce();
        $user_id = get_current_user_id();
        $transactions = get_user_meta( $user_id, 'orbis_finance_transactions', true ) ?: array();

        $transactions[] = array(
            'date'   => date('Y-m-d H:i'),
            'type'   => sanitize_text_field( $_POST['trans_type'] ),
            'amount' => floatval( $_POST['trans_amount'] ),
            'desc'   => sanitize_text_field( $_POST['trans_desc'] )
        );

        update_user_meta( $user_id, 'orbis_finance_transactions', array_slice($transactions, -50) );
        wp_send_json_success( array( 'message' => 'Transaction saved!' ) );
    }
}
