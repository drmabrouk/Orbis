<?php

/**
 * The Image Storage Application class.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/apps
 */

require_once plugin_dir_path( __FILE__ ) . 'class-orbis-app-base.php';

class Orbis_App_Images extends Orbis_App_Base {

    protected function register_ajax_handlers() {
        // Handled via WP Media
    }
}
