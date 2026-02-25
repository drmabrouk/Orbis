<?php

/**
 * Fired during plugin activation
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Orbis
 * @subpackage Orbis/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Orbis
 * @subpackage Orbis/includes
 * @author     Jules
 */
class Orbis_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        self::create_pages();
        flush_rewrite_rules();
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
