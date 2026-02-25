<?php

/**
 * The Password Manager Application class.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/apps
 */

require_once plugin_dir_path( __FILE__ ) . 'class-orbis-app-base.php';

class Orbis_App_Passwords extends Orbis_App_Base {

    protected function register_ajax_handlers() {
        $this->add_ajax( 'get_passwords', 'handle_get_passwords' );
        $this->add_ajax( 'save_password', 'handle_save_password' );
        $this->add_ajax( 'delete_password', 'handle_delete_password' );
    }

    private function encrypt( $value ) {
        $key = defined('SECURE_AUTH_KEY') ? SECURE_AUTH_KEY : 'orbis-secret-fallback';
        $iv_length = openssl_cipher_iv_length( 'AES-256-CBC' );
        $iv = openssl_random_pseudo_bytes( $iv_length );
        $encrypted = openssl_encrypt( $value, 'AES-256-CBC', $key, 0, $iv );
        return base64_encode( $iv . $encrypted );
    }

    private function decrypt( $value ) {
        $key = defined('SECURE_AUTH_KEY') ? SECURE_AUTH_KEY : 'orbis-secret-fallback';
        $data = base64_decode( $value );
        $iv_length = openssl_cipher_iv_length( 'AES-256-CBC' );
        $iv = substr( $data, 0, $iv_length );
        $encrypted = substr( $data, $iv_length );
        return openssl_decrypt( $encrypted, 'AES-256-CBC', $key, 0, $iv );
    }

    public function handle_get_passwords() {
        $this->verify_nonce();
        $user_id = get_current_user_id();
        $vault = get_user_meta( $user_id, 'orbis_password_vault', true ) ?: array();
        foreach ( $vault as &$entry ) {
            $entry['password'] = $this->decrypt( $entry['password'] );
        }
        wp_send_json_success( array_values($vault) );
    }

    public function handle_save_password() {
        $this->verify_nonce();
        $user_id = get_current_user_id();
        $pass_id = !empty($_POST['pass_id']) ? $_POST['pass_id'] : uniqid();
        $vault = get_user_meta( $user_id, 'orbis_password_vault', true ) ?: array();
        $vault[$pass_id] = array(
            'id'       => $pass_id,
            'url'      => esc_url_raw( $_POST['pass_url'] ),
            'username' => sanitize_text_field( $_POST['pass_user'] ),
            'password' => $this->encrypt( $_POST['pass_val'] ),
            'notes'    => sanitize_textarea_field( $_POST['pass_notes'] )
        );
        update_user_meta( $user_id, 'orbis_password_vault', $vault );
        wp_send_json_success();
    }

    public function handle_delete_password() {
        $this->verify_nonce();
        $user_id = get_current_user_id();
        $pass_id = $_POST['pass_id'];
        $vault = get_user_meta( $user_id, 'orbis_password_vault', true ) ?: array();
        if ( isset( $vault[$pass_id] ) ) {
            unset( $vault[$pass_id] );
            update_user_meta( $user_id, 'orbis_password_vault', $vault );
            wp_send_json_success();
        }
        wp_send_json_error();
    }
}
