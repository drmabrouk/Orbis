<?php

/**
 * The Projects module.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/modules/projects
 */

class Orbis_Projects {

    public function init() {
        add_action( 'add_meta_boxes', array( $this, 'add_projects_metaboxes' ) );
        add_action( 'save_post_orbis_project', array( $this, 'save_projects_meta' ) );
    }

    public function add_projects_metaboxes() {
        add_meta_box(
            'orbis_project_details',
            'Project Details',
            array( $this, 'render_project_details_metabox' ),
            'orbis_project',
            'normal',
            'high'
        );
    }

    public function render_project_details_metabox( $post ) {
        $progress = get_post_meta( $post->ID, '_orbis_project_progress', true );

        wp_nonce_field( 'orbis_project_meta_box', 'orbis_project_meta_box_nonce' );

        echo '<p><label for="orbis_project_progress">Progress (%):</label> ';
        echo '<input type="number" id="orbis_project_progress" name="orbis_project_progress" value="' . esc_attr( $progress ) . '" min="0" max="100"> %</p>';
    }

    public function save_projects_meta( $post_id ) {
        if ( ! isset( $_POST['orbis_project_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['orbis_project_meta_box_nonce'], 'orbis_project_meta_box' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['orbis_project_progress'] ) ) {
            update_post_meta( $post_id, '_orbis_project_progress', sanitize_text_field( $_POST['orbis_project_progress'] ) );
        }
    }
}
