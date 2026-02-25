<?php

/**
 * The Projects Application class.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/apps
 */

require_once plugin_dir_path( __FILE__ ) . 'class-orbis-app-base.php';

class Orbis_App_Projects extends Orbis_App_Base {

    protected function define_hooks() {
        parent::define_hooks();
        add_action( 'init', array( $this, 'register_cpt' ) );
    }

    public function register_cpt() {
        register_post_type( 'orbis_project', array(
            'labels'      => array( 'name' => 'Projects', 'singular_name' => 'Project' ),
            'public'      => true,
            'has_archive' => true,
            'supports'    => array( 'title', 'editor', 'author' ),
            'menu_icon'   => 'dashicons-portfolio',
            'show_in_rest' => true,
        ) );

        register_taxonomy( 'orbis_project_status', 'orbis_project', array(
            'label'        => 'Project Status',
            'hierarchical' => true,
            'show_in_rest' => true,
        ) );
    }

    protected function register_ajax_handlers() {
        // Future AJAX logic for projects
    }
}
