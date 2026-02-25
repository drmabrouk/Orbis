<?php

/**
 * The Tasks module.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/modules/tasks
 */

class Orbis_Tasks {

    public function init() {
        add_action( 'add_meta_boxes', array( $this, 'add_tasks_metaboxes' ) );
        add_action( 'save_post_orbis_task', array( $this, 'save_tasks_meta' ) );
    }

    public function add_tasks_metaboxes() {
        add_meta_box(
            'orbis_task_details',
            'Task Details',
            array( $this, 'render_task_details_metabox' ),
            'orbis_task',
            'normal',
            'high'
        );
    }

    public function render_task_details_metabox( $post ) {
        $deadline = get_post_meta( $post->ID, '_orbis_task_deadline', true );
        $priority = get_post_meta( $post->ID, '_orbis_task_priority', true );

        wp_nonce_field( 'orbis_task_meta_box', 'orbis_task_meta_box_nonce' );

        echo '<p><label for="orbis_task_deadline">Deadline:</label> ';
        echo '<input type="date" id="orbis_task_deadline" name="orbis_task_deadline" value="' . esc_attr( $deadline ) . '"></p>';

        echo '<p><label for="orbis_task_priority">Priority:</label> ';
        echo '<select id="orbis_task_priority" name="orbis_task_priority">';
        echo '<option value="low" ' . selected( $priority, 'low', false ) . '>Low</option>';
        echo '<option value="medium" ' . selected( $priority, 'medium', false ) . '>Medium</option>';
        echo '<option value="high" ' . selected( $priority, 'high', false ) . '>High</option>';
        echo '</select></p>';
    }

    public function save_tasks_meta( $post_id ) {
        if ( ! isset( $_POST['orbis_task_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['orbis_task_meta_box_nonce'], 'orbis_task_meta_box' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['orbis_task_deadline'] ) ) {
            update_post_meta( $post_id, '_orbis_task_deadline', sanitize_text_field( $_POST['orbis_task_deadline'] ) );
        }

        if ( isset( $_POST['orbis_task_priority'] ) ) {
            update_post_meta( $post_id, '_orbis_task_priority', sanitize_text_field( $_POST['orbis_task_priority'] ) );
        }
    }
}
