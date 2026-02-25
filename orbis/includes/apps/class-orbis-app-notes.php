<?php

/**
 * The Notes Application class.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/apps
 */

require_once plugin_dir_path( __FILE__ ) . 'class-orbis-app-base.php';

class Orbis_App_Notes extends Orbis_App_Base {

    protected function define_hooks() {
        parent::define_hooks();
        add_action( 'init', array( $this, 'register_cpt' ) );
    }

    public function register_cpt() {
        register_post_type( 'orbis_note', array(
            'labels'      => array( 'name' => 'Notes', 'singular_name' => 'Note' ),
            'public'      => true,
            'has_archive' => true,
            'supports'    => array( 'title', 'editor', 'author' ),
            'menu_icon'   => 'dashicons-welcome-write-blog',
            'show_in_rest' => true,
        ) );

        register_taxonomy( 'orbis_note_category', 'orbis_note', array(
            'label'        => 'Note Categories',
            'hierarchical' => true,
            'show_in_rest' => true,
        ) );
    }

    protected function register_ajax_handlers() {
        $this->add_ajax( 'get_notes', 'handle_get_notes' );
        $this->add_ajax( 'save_note', 'handle_save_note' );
        $this->add_ajax( 'delete_note', 'handle_delete_note' );
        $this->add_ajax( 'toggle_pin_note', 'handle_toggle_pin_note' );
    }

    public function handle_get_notes() {
        $this->verify_nonce();
        $user_id = get_current_user_id();
        $notes = get_posts( array(
            'post_type' => 'orbis_note',
            'author'    => $user_id,
            'posts_per_page' => -1,
            'orderby'   => 'meta_value_num date',
            'meta_key'  => '_orbis_note_pinned',
            'order'     => 'DESC'
        ) );

        $data = array();
        foreach ( $notes as $n ) {
            $data[] = array(
                'id'       => $n->ID,
                'title'    => $n->post_title,
                'content'  => $n->post_content,
                'pinned'   => get_post_meta( $n->ID, '_orbis_note_pinned', true ) == '1',
                'category' => wp_get_post_terms( $n->ID, 'orbis_note_category', array( 'fields' => 'names' ) )
            );
        }

        wp_send_json_success( $data );
    }

    public function handle_save_note() {
        $this->verify_nonce();
        $user_id = get_current_user_id();
        $note_id = isset( $_POST['note_id'] ) ? intval( $_POST['note_id'] ) : 0;
        $title   = sanitize_text_field( $_POST['note_title'] );
        $content = wp_kses_post( $_POST['note_content'] );

        $args = array(
            'post_title'   => $title,
            'post_content' => $content,
            'post_type'    => 'orbis_note',
            'post_status'  => 'publish',
            'post_author'  => $user_id
        );

        if ( $note_id > 0 ) {
            $args['ID'] = $note_id;
            wp_update_post( $args );
        } else {
            $note_id = wp_insert_post( $args );
        }

        wp_send_json_success( array( 'message' => 'Note saved!', 'id' => $note_id ) );
    }

    public function handle_delete_note() {
        $this->verify_nonce();
        $note_id = intval( $_POST['note_id'] );
        if ( get_post_field( 'post_author', $note_id ) == get_current_user_id() ) {
            wp_delete_post( $note_id, true );
            wp_send_json_success();
        }
        wp_send_json_error();
    }

    public function handle_toggle_pin_note() {
        $this->verify_nonce();
        $note_id = intval( $_POST['note_id'] );
        if ( get_post_field( 'post_author', $note_id ) == get_current_user_id() ) {
            $pinned = get_post_meta( $note_id, '_orbis_note_pinned', true ) == '1' ? '0' : '1';
            update_post_meta( $note_id, '_orbis_note_pinned', $pinned );
            wp_send_json_success( array( 'pinned' => $pinned == '1' ) );
        }
        wp_send_json_error();
    }
}
