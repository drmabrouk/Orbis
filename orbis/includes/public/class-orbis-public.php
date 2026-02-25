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
        add_shortcode( 'orbis_auth', array( $this, 'display_auth_interface' ) );
        add_shortcode( 'orbis_profile', array( $this, 'display_profile_editor' ) );

        // Map old shortcodes to the unified interface
        add_shortcode( 'orbis_login', array( $this, 'display_auth_interface' ) );
        add_shortcode( 'orbis_register', array( $this, 'display_auth_interface' ) );

        // Redirects
        add_filter( 'login_redirect', array( $this, 'orbis_login_redirect' ), 10, 3 );
        add_filter( 'logout_redirect', array( $this, 'orbis_logout_redirect' ), 10, 3 );

        // AJAX handlers
        add_action( 'wp_ajax_nopriv_orbis_register_user', array( $this, 'handle_registration' ) );
        add_action( 'wp_ajax_orbis_update_profile', array( $this, 'handle_profile_update' ) );
        add_action( 'wp_ajax_orbis_export_data', array( $this, 'handle_export_data' ) );
        add_action( 'wp_ajax_orbis_reset_account', array( $this, 'handle_reset_account' ) );
        add_action( 'wp_ajax_orbis_delete_account', array( $this, 'handle_delete_account' ) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/orbis-public.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name . '-main', plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/css/orbis-main.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name . '-auth', plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/css/orbis-auth.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/orbis-public.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name . '-auth', plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/js/orbis-auth.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . '-account', plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/js/orbis-account.js', array( 'jquery' ), $this->version, true );

        wp_localize_script( $this->plugin_name . '-auth', 'orbis_auth_params', array(
            'ajax_url'      => admin_url( 'admin-ajax.php' ),
            'dashboard_url' => site_url( 'orbis-dashboard' ),
            'home_url'      => home_url()
        ) );
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
     * Render the unified authentication interface.
     */
    public function display_auth_interface() {
        if ( is_user_logged_in() ) {
            return '<p>You are already logged in. <a href="' . site_url('orbis-dashboard') . '">Go to Dashboard</a></p>';
        }
        ob_start();
        include_once plugin_dir_path( __FILE__ ) . 'partials/orbis-auth-display.php';
        return ob_get_clean();
    }

    /**
     * Redirect users to the Orbis Dashboard after login.
     */
    public function orbis_login_redirect( $redirect_to, $request, $user ) {
        if ( ! is_wp_error( $user ) && isset( $user->roles ) && is_array( $user->roles ) ) {
            return site_url( '/orbis-dashboard' );
        }
        return $redirect_to;
    }

    /**
     * Redirect users to the home page after logout.
     */
    public function orbis_logout_redirect( $redirect_to, $requested_redirect_to, $user ) {
        return home_url();
    }

    /**
     * Handle AJAX registration.
     */
    public function handle_registration() {
        check_ajax_referer( 'orbis_register_nonce', 'orbis_register_nonce_field' );

        $email    = sanitize_email( $_POST['user_email'] );
        $password = $_POST['user_pass'];
        $confirm  = $_POST['user_pass_confirm'];
        $first    = sanitize_text_field( $_POST['first_name'] );
        $last     = sanitize_text_field( $_POST['last_name'] );
        $lang     = sanitize_text_field( $_POST['pref_lang'] );
        $terms    = isset( $_POST['terms_agree'] );

        if ( ! $terms ) {
            wp_send_json_error( array( 'message' => 'You must agree to the Terms & Conditions.' ) );
        }

        if ( $password !== $confirm ) {
            wp_send_json_error( array( 'message' => 'Passwords do not match.' ) );
        }

        if ( email_exists( $email ) ) {
            wp_send_json_error( array( 'message' => 'This email is already registered.' ) );
        }

        // Use email as username
        $username = $email;

        $user_id = wp_create_user( $username, $password, $email );

        if ( is_wp_error( $user_id ) ) {
            wp_send_json_error( array( 'message' => $user_id->get_error_message() ) );
        }

        // Update meta
        wp_update_user( array(
            'ID'         => $user_id,
            'first_name' => $first,
            'last_name'  => $last
        ) );
        update_user_meta( $user_id, 'orbis_pref_lang', $lang );

        // Log the user in
        wp_set_current_user( $user_id );
        wp_set_auth_cookie( $user_id );

        wp_send_json_success( array( 'message' => 'Registration successful! Redirecting...' ) );
    }

    /**
     * Render the profile editor.
     */
    public function display_profile_editor() {
        if ( ! is_user_logged_in() ) {
            return '<p>Please log in to edit your profile.</p>';
        }

        if ( isset( $_POST['orbis_save_profile'] ) ) {
            $this->handle_profile_update();
        }

        ob_start();
        include_once plugin_dir_path( __FILE__ ) . 'partials/orbis-profile-display.php';
        return ob_get_clean();
    }

    /**
     * Handle profile update.
     */
    public function handle_profile_update() {
        check_admin_referer( 'orbis_profile_update', 'orbis_profile_nonce' );

        $user_id = get_current_user_id();
        $errors = array();

        $first_name = sanitize_text_field( $_POST['first_name'] );
        $last_name  = sanitize_text_field( $_POST['last_name'] );
        $email      = sanitize_email( $_POST['user_email'] );
        $phone      = sanitize_text_field( $_POST['phone'] );
        $country    = sanitize_text_field( $_POST['country'] );
        $bio        = sanitize_textarea_field( $_POST['bio'] );
        $social_fb  = esc_url_raw( $_POST['social_fb'] );
        $social_tw  = esc_url_raw( $_POST['social_tw'] );
        $notif_email = isset( $_POST['notif_email'] ) ? '1' : '0';
        $notif_inapp = isset( $_POST['notif_inapp'] ) ? '1' : '0';
        $password   = $_POST['new_password'];

        // Update core user data
        $user_data = array(
            'ID'           => $user_id,
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'user_email'   => $email,
            'description'  => $bio
        );

        if ( ! empty( $password ) ) {
            $user_data['user_pass'] = $password;
        }

        $update_id = wp_update_user( $user_data );

        if ( is_wp_error( $update_id ) ) {
            echo '<div class="notice notice-error"><p>' . $update_id->get_error_message() . '</p></div>';
        } else {
            // Update meta
            update_user_meta( $user_id, 'orbis_phone', $phone );
            update_user_meta( $user_id, 'orbis_country', $country );
            update_user_meta( $user_id, 'orbis_social_fb', $social_fb );
            update_user_meta( $user_id, 'orbis_social_tw', $social_tw );
            update_user_meta( $user_id, 'orbis_notif_email', $notif_email );
            update_user_meta( $user_id, 'orbis_notif_inapp', $notif_inapp );

            // Handle Profile Picture
            if ( ! empty( $_FILES['orbis_profile_pic']['name'] ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
                $override = array( 'test_form' => false );
                $file = wp_handle_upload( $_FILES['orbis_profile_pic'], $override );

                if ( isset( $file['url'] ) ) {
                    update_user_meta( $user_id, 'orbis_profile_pic', $file['url'] );
                }
            }

            echo '<div class="notice notice-success" style="color:green; font-weight:bold;"><p>Profile updated successfully!</p></div>';
        }
    }

    /**
     * Handle Account Export.
     */
    public function handle_export_data() {
        check_ajax_referer( 'orbis_account_action', 'orbis_account_nonce' );
        $user_id = get_current_user_id();

        $data = array(
            'user' => get_userdata( $user_id )->data,
            'meta' => get_user_meta( $user_id ),
            'content' => array()
        );

        $post_types = array( 'orbis_note', 'orbis_task', 'orbis_project', 'orbis_form' );
        foreach ( $post_types as $pt ) {
            $posts = get_posts( array(
                'post_type' => $pt,
                'author'    => $user_id,
                'posts_per_page' => -1
            ) );
            foreach ( $posts as $p ) {
                $p->meta = get_post_meta( $p->ID );
                $data['content'][] = $p;
            }
        }

        wp_send_json_success( array(
            'message' => 'Data exported successfully.',
            'filename' => 'orbis-backup-' . date('Y-m-d') . '.json',
            'data' => json_encode( $data, JSON_PRETTY_PRINT )
        ) );
    }

    /**
     * Handle Account Reset.
     */
    public function handle_reset_account() {
        check_ajax_referer( 'orbis_account_action', 'orbis_account_nonce' );
        $user_id = get_current_user_id();

        // Delete all Orbis posts
        $post_types = array( 'orbis_note', 'orbis_task', 'orbis_project', 'orbis_form' );
        foreach ( $post_types as $pt ) {
            $posts = get_posts( array(
                'post_type' => $pt,
                'author'    => $user_id,
                'posts_per_page' => -1,
                'fields'    => 'ids'
            ) );
            foreach ( $posts as $pid ) {
                wp_delete_post( $pid, true );
            }
        }

        // Reset specific user meta
        $metas = array( 'orbis_phone', 'orbis_country', 'orbis_timezone', 'orbis_social_fb', 'orbis_social_tw', 'orbis_notif_email', 'orbis_notif_inapp', 'orbis_profile_pic' );
        foreach ( $metas as $m ) {
            delete_user_meta( $user_id, $m );
        }

        wp_send_json_success( array( 'message' => 'Account reset successfully.' ) );
    }

    /**
     * Handle Account Deletion.
     */
    public function handle_delete_account() {
        check_ajax_referer( 'orbis_account_action', 'orbis_account_nonce' );
        $user_id = get_current_user_id();

        // 1. Delete all Orbis posts
        $post_types = array( 'orbis_note', 'orbis_task', 'orbis_project', 'orbis_form' );
        foreach ( $post_types as $pt ) {
            $posts = get_posts( array(
                'post_type' => $pt,
                'author'    => $user_id,
                'posts_per_page' => -1,
                'fields'    => 'ids'
            ) );
            foreach ( $posts as $pid ) {
                wp_delete_post( $pid, true );
            }
        }

        // 2. Delete the user
        require_once( ABSPATH . 'wp-admin/includes/user.php' );
        wp_delete_user( $user_id );

        wp_send_json_success( array( 'message' => 'Account deleted successfully. Redirecting...' ) );
    }

}
