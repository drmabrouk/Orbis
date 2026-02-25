<?php

/**
 * The Utilities Application class.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/apps
 */

require_once plugin_dir_path( __FILE__ ) . 'class-orbis-app-base.php';

class Orbis_App_Utilities extends Orbis_App_Base {

    protected function register_ajax_handlers() {
        // No AJAX needed yet
    }
}
