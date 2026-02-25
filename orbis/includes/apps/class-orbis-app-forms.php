<?php

/**
 * The Forms Application class.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/apps
 */

require_once plugin_dir_path( __FILE__ ) . 'class-orbis-app-base.php';

class Orbis_App_Forms extends Orbis_App_Base {

    protected function define_hooks() {
        parent::define_hooks();
        add_action( 'init', array( $this, 'register_cpt' ) );
    }

    public function register_cpt() {
        register_post_type( 'orbis_form', array(
            'labels'      => array( 'name' => 'Forms', 'singular_name' => 'Form' ),
            'public'      => true,
            'supports'    => array( 'title', 'editor' ),
            'menu_icon'   => 'dashicons-feedback',
            'show_in_rest' => true,
        ) );

        register_post_type( 'orbis_response', array(
            'labels'      => array( 'name' => 'Form Responses', 'singular_name' => 'Response' ),
            'public'      => false,
            'show_ui'     => true,
            'supports'    => array( 'title', 'editor', 'author' ),
            'menu_icon'   => 'dashicons-database',
        ) );
    }

    protected function register_ajax_handlers() {
        $this->add_ajax( 'submit_form', 'handle_submit_form', true );
    }

    public function handle_submit_form() {
        $this->verify_nonce();
        $form_id = intval( $_POST['form_id'] );
        $data    = $_POST['form_data'];

        $response_id = wp_insert_post( array(
            'post_title'   => 'Response to Form #' . $form_id,
            'post_content' => json_encode( $data, JSON_PRETTY_PRINT ),
            'post_type'    => 'orbis_response',
            'post_status'  => 'publish'
        ) );

        update_post_meta( $response_id, '_orbis_parent_form', $form_id );
        wp_send_json_success( array( 'message' => 'Response submitted!' ) );
    }
}
