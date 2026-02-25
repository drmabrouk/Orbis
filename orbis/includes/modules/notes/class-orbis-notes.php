<?php

/**
 * The Notes module.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/modules/notes
 */

class Orbis_Notes {

    public function __construct() {
        // Hooks for Notes module
    }

    /**
     * Add any specific logic for notes here.
     * Since we are using Custom Post Types, much of the CRUD is handled by WP.
     * We can add custom meta boxes or REST API endpoints here.
     */
    public function init() {
        add_action( 'add_meta_boxes', array( $this, 'add_notes_metaboxes' ) );
        add_action( 'save_post_orbis_note', array( $this, 'save_notes_meta' ) );
    }

    public function add_notes_metaboxes() {
        add_meta_box(
            'orbis_note_details',
            'Note Details',
            array( $this, 'render_note_details_metabox' ),
            'orbis_note',
            'side',
            'default'
        );
    }

    public function render_note_details_metabox( $post ) {
        // Render some custom fields if needed
        echo '<p>Custom metadata for notes can be managed here.</p>';
    }

    public function save_notes_meta( $post_id ) {
        // Save metadata
    }
}
