<?php

/**
 * The Forms module.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/modules/forms
 */

class Orbis_Forms {

    public function init() {
        register_post_type( 'orbis_form', array(
            'labels'      => array( 'name' => 'Forms', 'singular_name' => 'Form' ),
            'public'      => true,
            'supports'    => array( 'title', 'editor' ),
            'menu_icon'   => 'dashicons-feedback',
            'show_in_rest' => true,
        ) );

        add_shortcode( 'orbis_form', array( $this, 'render_form_shortcode' ) );
    }

    public function render_form_shortcode( $atts ) {
        return '<form class="orbis-custom-form"><p>Custom Form Logic.</p></form>';
    }
}
