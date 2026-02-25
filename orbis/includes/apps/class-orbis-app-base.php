<?php

/**
 * Base class for all Orbis applications.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/apps
 */

abstract class Orbis_App_Base {

    protected $slug;
    protected $version;
    protected $name;

    public function __construct( $slug, $name, $version ) {
        $this->slug = $slug;
        $this->name = $name;
        $this->version = $version;

        $this->define_hooks();
    }

    /**
     * Register app-specific hooks.
     */
    protected function define_hooks() {
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_if_needed' ), 20 );
        $this->register_ajax_handlers();
    }

    /**
     * Register app-specific CSS and JS.
     */
    public function register_assets() {
        $base_path = plugin_dir_path( dirname( dirname( __FILE__ ) ) );
        $base_url  = plugin_dir_url( dirname( dirname( __FILE__ ) ) );

        // Register CSS
        $css_rel = "assets/css/apps/{$this->slug}.css";
        if ( file_exists( $base_path . $css_rel ) ) {
            wp_register_style(
                "orbis-app-{$this->slug}",
                $base_url . $css_rel,
                array('orbis-main'),
                $this->version
            );
        }

        // Register JS
        $js_rel = "assets/js/apps/{$this->slug}.js";
        if ( file_exists( $base_path . $js_rel ) ) {
            wp_register_script(
                "orbis-app-{$this->slug}",
                $base_url . $js_rel,
                array('jquery', 'orbis-mgmt'),
                $this->version,
                true
            );
        }
    }

    /**
     * Enqueue only on relevant pages.
     */
    public function enqueue_if_needed() {
        if ( is_page('orbis-dashboard') || is_page('orbis-admin-dashboard') || has_shortcode( get_post()->post_content, 'orbis_dashboard' ) ) {
            wp_enqueue_style( "orbis-app-{$this->slug}" );
            wp_enqueue_script( "orbis-app-{$this->slug}" );
        }
    }

    /**
     * Template for registering AJAX handlers.
     */
    abstract protected function register_ajax_handlers();

    /**
     * Helper to register AJAX with both nopriv and priv if needed.
     */
    protected function add_ajax( $action, $callback, $public = false ) {
        add_action( "wp_ajax_orbis_{$action}", array( $this, $callback ) );
        if ( $public ) {
            add_action( "wp_ajax_nopriv_orbis_{$action}", array( $this, $callback ) );
        }
    }

    /**
     * Verify AJAX nonce.
     */
    protected function verify_nonce() {
        if ( ! check_ajax_referer( 'orbis_app_security', 'nonce', false ) ) {
            wp_send_json_error( array( 'message' => 'Security check failed.' ) );
        }
    }
}
