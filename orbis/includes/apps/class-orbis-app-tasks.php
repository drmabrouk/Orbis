<?php

/**
 * The Tasks Application class.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/apps
 */

require_once plugin_dir_path( __FILE__ ) . 'class-orbis-app-base.php';

class Orbis_App_Tasks extends Orbis_App_Base {

    protected function define_hooks() {
        parent::define_hooks();
        add_action( 'init', array( $this, 'register_cpt' ) );
    }

    public function register_cpt() {
        register_post_type( 'orbis_task', array(
            'labels'      => array( 'name' => 'Tasks', 'singular_name' => 'Task' ),
            'public'      => true,
            'has_archive' => true,
            'supports'    => array( 'title', 'editor', 'author', 'custom-fields' ),
            'menu_icon'   => 'dashicons-list-view',
            'show_in_rest' => true,
        ) );
    }

    protected function register_ajax_handlers() {
        $this->add_ajax( 'get_tasks', 'handle_get_tasks' );
        $this->add_ajax( 'save_task', 'handle_save_task' );
        $this->add_ajax( 'toggle_task', 'handle_toggle_task' );
        $this->add_ajax( 'delete_task', 'handle_delete_task' );
    }

    public function handle_get_tasks() {
        $this->verify_nonce();
        $user_id = get_current_user_id();
        $tasks = get_posts( array(
            'post_type' => 'orbis_task',
            'author'    => $user_id,
            'posts_per_page' => -1,
            'orderby'   => 'date',
            'order'     => 'DESC'
        ) );

        $data = array();
        foreach ( $tasks as $t ) {
            $data[] = array(
                'id'       => $t->ID,
                'title'    => $t->post_title,
                'deadline' => get_post_meta( $t->ID, '_orbis_task_deadline', true ),
                'priority' => get_post_meta( $t->ID, '_orbis_task_priority', true ),
                'status'   => get_post_meta( $t->ID, '_orbis_task_status', true ) ?: 'pending'
            );
        }

        wp_send_json_success( $data );
    }

    public function handle_save_task() {
        $this->verify_nonce();
        $user_id = get_current_user_id();
        $task_id = isset( $_POST['task_id'] ) ? intval( $_POST['task_id'] ) : 0;
        $title   = sanitize_text_field( $_POST['task_title'] );
        $deadline = sanitize_text_field( $_POST['task_deadline'] );
        $priority = sanitize_text_field( $_POST['task_priority'] );

        $args = array(
            'post_title'   => $title,
            'post_type'    => 'orbis_task',
            'post_status'  => 'publish',
            'post_author'  => $user_id
        );

        if ( $task_id > 0 ) {
            $args['ID'] = $task_id;
            wp_update_post( $args );
        } else {
            $task_id = wp_insert_post( $args );
            update_post_meta( $task_id, '_orbis_task_status', 'pending' );
        }

        update_post_meta( $task_id, '_orbis_task_deadline', $deadline );
        update_post_meta( $task_id, '_orbis_task_priority', $priority );

        wp_send_json_success( array( 'message' => 'Task saved!', 'id' => $task_id ) );
    }

    public function handle_toggle_task() {
        $this->verify_nonce();
        $task_id = intval( $_POST['task_id'] );
        if ( get_post_field( 'post_author', $task_id ) == get_current_user_id() ) {
            $status = get_post_meta( $task_id, '_orbis_task_status', true ) === 'completed' ? 'pending' : 'completed';
            update_post_meta( $task_id, '_orbis_task_status', $status );
            wp_send_json_success( array( 'status' => $status ) );
        }
        wp_send_json_error();
    }

    public function handle_delete_task() {
        $this->verify_nonce();
        $task_id = intval( $_POST['task_id'] );
        if ( get_post_field( 'post_author', $task_id ) == get_current_user_id() ) {
            wp_delete_post( $task_id, true );
            wp_send_json_success();
        }
        wp_send_json_error();
    }
}
