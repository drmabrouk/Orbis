<?php

/**
 * Fired during plugin activation
 */
class Orbis_Activator {

	public static function activate() {
        self::create_pages();
        self::initialize_system();
        flush_rewrite_rules();
	}

    private static function initialize_system() {
        // Set initial version
        if ( ! get_option( 'orbis_version' ) ) {
            update_option( 'orbis_version', ORBIS_VERSION );
        }

        // Initialize empty logs if not exist
        if ( ! get_option( 'orbis_update_log' ) ) {
            update_option( 'orbis_update_log', array(
                array(
                    'time'    => time(),
                    'version' => ORBIS_VERSION,
                    'message' => 'System successfully initialized.'
                )
            ) );
        }
    }

    private static function create_pages() {
        $pages = array(
            'orbis-login' => array(
                'title' => 'Orbis Login',
                'content' => '[orbis_login]'
            ),
            'orbis-register' => array(
                'title' => 'Orbis Register',
                'content' => '[orbis_register]'
            ),
            'orbis-dashboard' => array(
                'title' => 'Orbis Dashboard',
                'content' => '[orbis_dashboard]'
            ),
            'orbis-admin-dashboard' => array(
                'title' => 'Orbis Admin Dashboard',
                'content' => '[orbis_admin_dashboard]'
            ),
            'orbis-profile' => array(
                'title' => 'Orbis Profile',
                'content' => '[orbis_profile]'
            ),
        );

        foreach ( $pages as $slug => $page ) {
            if ( ! get_page_by_path( $slug ) ) {
                wp_insert_post( array(
                    'post_title'   => $page['title'],
                    'post_content' => $page['content'],
                    'post_status'  => 'publish',
                    'post_type'    => 'page',
                    'post_name'    => $slug
                ) );
            }
        }
    }

}
