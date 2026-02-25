<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Orbis
 * @subpackage Orbis/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Orbis
 * @subpackage Orbis/public
 * @author     Jules
 */
class Orbis_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        add_shortcode( 'orbis_dashboard', array( $this, 'display_dashboard' ) );
        add_shortcode( 'orbis_login', array( $this, 'display_login' ) );
        add_shortcode( 'orbis_register', array( $this, 'display_register' ) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/orbis-public.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name . '-main', plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/css/orbis-main.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/orbis-public.js', array( 'jquery' ), $this->version, false );
	}

    /**
     * Render the dashboard.
     */
    public function display_dashboard() {
        if ( ! is_user_logged_in() ) {
            return '<p>Please <a href="' . site_url('orbis-login') . '">log in</a> to view your dashboard.</p>';
        }
        ob_start();
        include_once plugin_dir_path( __FILE__ ) . 'partials/orbis-public-display.php';
        return ob_get_clean();
    }

    /**
     * Render the login form.
     */
    public function display_login() {
        if ( is_user_logged_in() ) {
            return '<p>You are already logged in. <a href="' . site_url('orbis-dashboard') . '">Go to Dashboard</a></p>';
        }
        return wp_login_form( array( 'echo' => false, 'redirect' => site_url( 'orbis-dashboard' ) ) );
    }

    /**
     * Render the register form.
     */
    public function display_register() {
        if ( is_user_logged_in() ) {
            return '<p>You are already registered and logged in.</p>';
        }
        if ( ! get_option( 'users_can_register' ) ) {
            return '<p>User registration is currently disabled.</p>';
        }
        // Basic registration link or form
        return '<p>Please <a href="' . wp_registration_url() . '">Register here</a> to start using Orbis.</p>';
    }

}
