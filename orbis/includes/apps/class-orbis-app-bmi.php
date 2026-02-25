<?php

/**
 * The BMI Calculator Application class.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/apps
 */

require_once plugin_dir_path( __FILE__ ) . 'class-orbis-app-base.php';

class Orbis_App_BMI extends Orbis_App_Base {

    protected function register_ajax_handlers() {
        $this->add_ajax( 'save_bmi', 'handle_save_bmi' );
    }

    public function handle_save_bmi() {
        $this->verify_nonce();
        $user_id  = get_current_user_id();
        $bmi      = sanitize_text_field( $_POST['bmi'] );
        $category = sanitize_text_field( $_POST['category'] );

        $history = get_user_meta( $user_id, 'orbis_bmi_history', true ) ?: array();
        $history[] = array(
            'date'     => date('Y-m-d H:i'),
            'bmi'      => $bmi,
            'category' => $category
        );

        update_user_meta( $user_id, 'orbis_bmi_history', array_slice($history, -20) );
        wp_send_json_success();
    }
}
