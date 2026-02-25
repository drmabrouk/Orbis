<?php

/**
 * The Admin Management Application class.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/apps
 */

require_once plugin_dir_path( __FILE__ ) . 'class-orbis-app-base.php';

class Orbis_App_Admin extends Orbis_App_Base {

    protected function register_ajax_handlers() {
        // Handled in Orbis_Public for now
    }

    public function enqueue_if_needed() {
        if ( is_page('orbis-admin-dashboard') || has_shortcode( get_post()->post_content, 'orbis_admin_dashboard' ) ) {
            wp_enqueue_style( "orbis-app-{$this->slug}" );
            wp_enqueue_script( "orbis-app-{$this->slug}" );
        }
    }
}
