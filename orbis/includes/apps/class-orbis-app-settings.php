<?php

/**
 * The Settings Application class.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/apps
 */

require_once plugin_dir_path( __FILE__ ) . 'class-orbis-app-base.php';

class Orbis_App_Settings extends Orbis_App_Base {

    protected function register_ajax_handlers() {
        // Handled in Orbis_Public for now (Profile/Account)
    }
}
