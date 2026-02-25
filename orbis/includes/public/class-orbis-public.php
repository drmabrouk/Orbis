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
        add_shortcode( 'orbis_admin_dashboard', array( $this, 'display_admin_dashboard' ) );
        add_shortcode( 'orbis_auth', array( $this, 'display_auth_interface' ) );
        add_shortcode( 'orbis_profile', array( $this, 'display_profile_editor' ) );

        // Map old shortcodes to the unified interface
        add_shortcode( 'orbis_login', array( $this, 'display_auth_interface' ) );
        add_shortcode( 'orbis_register', array( $this, 'display_auth_interface' ) );

        // Redirects
        add_filter( 'login_redirect', array( $this, 'orbis_login_redirect' ), 10, 3 );
        add_filter( 'logout_redirect', array( $this, 'orbis_logout_redirect' ), 10, 3 );
        add_action( 'wp_head', array( $this, 'output_custom_styles' ) );

        // AJAX handlers
        add_action( 'wp_ajax_nopriv_orbis_register_user', array( $this, 'handle_registration' ) );
        add_action( 'wp_ajax_orbis_update_profile', array( $this, 'handle_profile_update' ) );
        add_action( 'wp_ajax_orbis_export_data', array( $this, 'handle_export_data' ) );
        add_action( 'wp_ajax_orbis_reset_account', array( $this, 'handle_reset_account' ) );
        add_action( 'wp_ajax_orbis_delete_account', array( $this, 'handle_delete_account' ) );
        add_action( 'wp_ajax_orbis_save_site_settings', array( $this, 'handle_save_site_settings' ) );
        add_action( 'wp_ajax_orbis_save_translations', array( $this, 'handle_save_translations' ) );

        // Form Submission AJAX
        add_action( 'wp_ajax_nopriv_orbis_submit_form', array( $this, 'handle_submit_form' ) );
        add_action( 'wp_ajax_orbis_submit_form', array( $this, 'handle_submit_form' ) );

        // BMI AJAX
        add_action( 'wp_ajax_orbis_save_bmi', array( $this, 'handle_save_bmi' ) );

        // Password Manager AJAX
        add_action( 'wp_ajax_orbis_get_passwords', array( $this, 'handle_get_passwords' ) );
        add_action( 'wp_ajax_orbis_save_password', array( $this, 'handle_save_password' ) );
        add_action( 'wp_ajax_orbis_delete_password', array( $this, 'handle_delete_password' ) );

        // Finance AJAX
        add_action( 'wp_ajax_orbis_get_finance_data', array( $this, 'handle_get_finance_data' ) );
        add_action( 'wp_ajax_orbis_save_transaction', array( $this, 'handle_save_transaction' ) );

        // Notes AJAX
        add_action( 'wp_ajax_orbis_get_notes', array( $this, 'handle_get_notes' ) );
        add_action( 'wp_ajax_orbis_save_note', array( $this, 'handle_save_note' ) );
        add_action( 'wp_ajax_orbis_delete_note', array( $this, 'handle_delete_note' ) );
        add_action( 'wp_ajax_orbis_toggle_pin_note', array( $this, 'handle_toggle_pin_note' ) );

        // Tasks AJAX
        add_action( 'wp_ajax_orbis_get_tasks', array( $this, 'handle_get_tasks' ) );
        add_action( 'wp_ajax_orbis_save_task', array( $this, 'handle_save_task' ) );
        add_action( 'wp_ajax_orbis_toggle_task', array( $this, 'handle_toggle_task' ) );
        add_action( 'wp_ajax_orbis_delete_task', array( $this, 'handle_delete_task' ) );

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
        wp_enqueue_script( $this->plugin_name . '-mgmt', plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/js/orbis-dashboard-mgmt.js', array( 'jquery' ), $this->version, true );

        // Shared parameters for all Orbis frontend scripts
        $shared_params = array(
            'ajax_url'      => admin_url( 'admin-ajax.php' ),
            'dashboard_url' => site_url( 'orbis-dashboard' ),
            'home_url'      => home_url()
        );
        wp_localize_script( $this->plugin_name, 'orbis_params', $shared_params );
        // Legacy support if scripts expect the old name
        wp_localize_script( $this->plugin_name, 'orbis_auth_params', $shared_params );
	}

    /**
     * Output dynamic CSS variables.
     */
    public function output_custom_styles() {
        $primary_color = get_option( 'orbis_primary_color', '#007cba' );
        echo '<style>:root { --orbis-primary: ' . esc_attr( $primary_color ) . '; }</style>';
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
        if ( ! is_wp_error( $user ) ) {
            if ( user_can( $user, 'manage_options' ) ) {
                return site_url( '/orbis-admin-dashboard' );
            } else if ( isset( $user->roles ) && is_array( $user->roles ) ) {
                return site_url( '/orbis-dashboard' );
            }
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
     * Render the admin dashboard.
     */
    public function display_admin_dashboard() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return '<p>Access denied. This page is for administrators only.</p>';
        }
        wp_enqueue_media();
        ob_start();
        include_once plugin_dir_path( __FILE__ ) . 'partials/orbis-admin-frontend-display.php';
        return ob_get_clean();
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
     * Handle Translations saving from frontend admin.
     */
    public function handle_save_translations() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => 'Unauthorized.' ) );
        }
        check_ajax_referer( 'orbis_save_translations', 'orbis_translations_nonce' );

        $translations = $_POST['translations'];
        if ( is_array( $translations ) ) {
            $existing = get_option( 'orbis_translations', array() );
            foreach ( $translations as $key => $data ) {
                if ( isset( $existing[$key] ) ) {
                    $existing[$key]['en'] = sanitize_textarea_field( $data['en'] );
                    $existing[$key]['ar'] = sanitize_textarea_field( $data['ar'] );
                }
            }
            update_option( 'orbis_translations', $existing );
            wp_send_json_success( array( 'message' => 'Translations updated successfully.' ) );
        }
        wp_send_json_error( array( 'message' => 'No data received.' ) );
    }

    /**
     * Handle Site Settings saving from frontend admin.
     */
    public function handle_save_site_settings() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => 'Unauthorized.' ) );
        }
        check_ajax_referer( 'orbis_save_settings', 'orbis_settings_nonce' );

        $options = array(
            'orbis_site_title'       => sanitize_text_field( $_POST['orbis_site_title'] ),
            'orbis_site_description' => sanitize_textarea_field( $_POST['orbis_site_description'] ),
            'orbis_contact_email'    => sanitize_email( $_POST['orbis_contact_email'] ),
            'orbis_site_logo'        => esc_url_raw( $_POST['orbis_site_logo'] ),
            'orbis_primary_color'    => sanitize_hex_color( $_POST['orbis_primary_color'] ),
            'orbis_footer_text'      => sanitize_textarea_field( $_POST['orbis_footer_text'] )
        );

        foreach ( $options as $key => $value ) {
            update_option( $key, $value );
        }

        wp_send_json_success( array( 'message' => 'Site settings updated successfully.' ) );
    }

    /**
     * Get Notes for current user.
     */
    public function handle_get_notes() {
        $user_id = get_current_user_id();
        $notes = get_posts( array(
            'post_type' => 'orbis_note',
            'author'    => $user_id,
            'posts_per_page' => -1,
            'orderby'   => 'meta_value_num date',
            'meta_key'  => '_orbis_note_pinned',
            'order'     => 'DESC'
        ) );

        $data = array();
        foreach ( $notes as $n ) {
            $data[] = array(
                'id'       => $n->ID,
                'title'    => $n->post_title,
                'content'  => $n->post_content,
                'pinned'   => get_post_meta( $n->ID, '_orbis_note_pinned', true ) == '1',
                'category' => wp_get_post_terms( $n->ID, 'orbis_note_category', array( 'fields' => 'names' ) )
            );
        }

        wp_send_json_success( $data );
    }

    /**
     * Save or update a note.
     */
    public function handle_save_note() {
        $user_id = get_current_user_id();
        $note_id = isset( $_POST['note_id'] ) ? intval( $_POST['note_id'] ) : 0;
        $title   = sanitize_text_field( $_POST['note_title'] );
        $content = wp_kses_post( $_POST['note_content'] );

        $args = array(
            'post_title'   => $title,
            'post_content' => $content,
            'post_type'    => 'orbis_note',
            'post_status'  => 'publish',
            'post_author'  => $user_id
        );

        if ( $note_id > 0 ) {
            $args['ID'] = $note_id;
            wp_update_post( $args );
        } else {
            $note_id = wp_insert_post( $args );
        }

        wp_send_json_success( array( 'message' => 'Note saved!', 'id' => $note_id ) );
    }

    /**
     * Delete a note.
     */
    public function handle_delete_note() {
        $note_id = intval( $_POST['note_id'] );
        if ( get_post_field( 'post_author', $note_id ) == get_current_user_id() ) {
            wp_delete_post( $note_id, true );
            wp_send_json_success();
        }
        wp_send_json_error();
    }

    /**
     * Toggle pin status.
     */
    public function handle_toggle_pin_note() {
        $note_id = intval( $_POST['note_id'] );
        if ( get_post_field( 'post_author', $note_id ) == get_current_user_id() ) {
            $pinned = get_post_meta( $note_id, '_orbis_note_pinned', true ) == '1' ? '0' : '1';
            update_post_meta( $note_id, '_orbis_note_pinned', $pinned );
            wp_send_json_success( array( 'pinned' => $pinned == '1' ) );
        }
        wp_send_json_error();
    }

    /**
     * Save BMI calculation.
     */
    public function handle_save_bmi() {
        $user_id  = get_current_user_id();
        $bmi      = sanitize_text_field( $_POST['bmi'] );
        $category = sanitize_text_field( $_POST['category'] );

        $history = get_user_meta( $user_id, 'orbis_bmi_history', true ) ?: array();
        $history[] = array(
            'date'     => date('Y-m-d H:i'),
            'bmi'      => $bmi,
            'category' => $category
        );

        update_user_meta( $user_id, 'orbis_bmi_history', array_slice($history, -20) ); // Keep last 20
        wp_send_json_success();
    }

    /**
     * Helper for encryption.
     */
    private function encrypt( $value ) {
        $key = defined('SECURE_AUTH_KEY') ? SECURE_AUTH_KEY : 'orbis-secret-fallback';
        $iv_length = openssl_cipher_iv_length( 'AES-256-CBC' );
        $iv = openssl_random_pseudo_bytes( $iv_length );
        $encrypted = openssl_encrypt( $value, 'AES-256-CBC', $key, 0, $iv );
        return base64_encode( $iv . $encrypted );
    }

    /**
     * Helper for decryption.
     */
    private function decrypt( $value ) {
        $key = defined('SECURE_AUTH_KEY') ? SECURE_AUTH_KEY : 'orbis-secret-fallback';
        $data = base64_decode( $value );
        $iv_length = openssl_cipher_iv_length( 'AES-256-CBC' );
        $iv = substr( $data, 0, $iv_length );
        $encrypted = substr( $data, $iv_length );
        return openssl_decrypt( $encrypted, 'AES-256-CBC', $key, 0, $iv );
    }

    /**
     * Get Password Vault for current user.
     */
    public function handle_get_passwords() {
        $user_id = get_current_user_id();
        $vault = get_user_meta( $user_id, 'orbis_password_vault', true ) ?: array();

        foreach ( $vault as &$entry ) {
            $entry['password'] = $this->decrypt( $entry['password'] );
        }

        wp_send_json_success( array_values($vault) );
    }

    /**
     * Save/Update password entry.
     */
    public function handle_save_password() {
        $user_id = get_current_user_id();
        $pass_id = !empty($_POST['pass_id']) ? $_POST['pass_id'] : uniqid();
        $vault = get_user_meta( $user_id, 'orbis_password_vault', true ) ?: array();

        $vault[$pass_id] = array(
            'id'       => $pass_id,
            'url'      => esc_url_raw( $_POST['pass_url'] ),
            'username' => sanitize_text_field( $_POST['pass_user'] ),
            'password' => $this->encrypt( $_POST['pass_val'] ),
            'notes'    => sanitize_textarea_field( $_POST['pass_notes'] )
        );

        update_user_meta( $user_id, 'orbis_password_vault', $vault );
        wp_send_json_success( array( 'message' => 'Vault updated securely!' ) );
    }

    /**
     * Delete password entry.
     */
    public function handle_delete_password() {
        $user_id = get_current_user_id();
        $pass_id = $_POST['pass_id'];
        $vault = get_user_meta( $user_id, 'orbis_password_vault', true ) ?: array();

        if ( isset( $vault[$pass_id] ) ) {
            unset( $vault[$pass_id] );
            update_user_meta( $user_id, 'orbis_password_vault', $vault );
            wp_send_json_success();
        }
        wp_send_json_error();
    }

    /**
     * Get Finance Data for current user.
     */
    public function handle_get_finance_data() {
        $user_id = get_current_user_id();
        $transactions = get_user_meta( $user_id, 'orbis_finance_transactions', true ) ?: array();
        wp_send_json_success( array_values($transactions) );
    }

    /**
     * Save finance transaction.
     */
    public function handle_save_transaction() {
        $user_id = get_current_user_id();
        $transactions = get_user_meta( $user_id, 'orbis_finance_transactions', true ) ?: array();

        $transactions[] = array(
            'date'   => date('Y-m-d H:i'),
            'type'   => sanitize_text_field( $_POST['trans_type'] ),
            'amount' => floatval( $_POST['trans_amount'] ),
            'desc'   => sanitize_text_field( $_POST['trans_desc'] )
        );

        update_user_meta( $user_id, 'orbis_finance_transactions', array_slice($transactions, -50) ); // Last 50
        wp_send_json_success( array( 'message' => 'Transaction saved!' ) );
    }

    /**
     * Handle Form Submission.
     */
    public function handle_submit_form() {
        $form_id = intval( $_POST['form_id'] );
        $data    = $_POST['form_data']; // Expecting array

        $response_id = wp_insert_post( array(
            'post_title'   => 'Response to Form #' . $form_id,
            'post_content' => json_encode( $data, JSON_PRETTY_PRINT ),
            'post_type'    => 'orbis_response',
            'post_status'  => 'publish'
        ) );

        update_post_meta( $response_id, '_orbis_parent_form', $form_id );

        wp_send_json_success( array( 'message' => 'Response submitted!' ) );
    }

    /**
     * Get Tasks for current user.
     */
    public function handle_get_tasks() {
        $user_id = get_current_user_id();
        $tasks = get_posts( array(
            'post_type' => 'orbis_task',
            'author'    => $user_id,
            'posts_per_page' => -1,
            'orderby'   => 'date',
            'order'     => 'DESC'
        ) );

        $data = array();
        foreach ( $tasks as $t ) {
            $data[] = array(
                'id'       => $t->ID,
                'title'    => $t->post_title,
                'deadline' => get_post_meta( $t->ID, '_orbis_task_deadline', true ),
                'priority' => get_post_meta( $t->ID, '_orbis_task_priority', true ),
                'status'   => get_post_meta( $t->ID, '_orbis_task_status', true ) ?: 'pending'
            );
        }

        wp_send_json_success( $data );
    }

    /**
     * Save or update a task.
     */
    public function handle_save_task() {
        $user_id = get_current_user_id();
        $task_id = isset( $_POST['task_id'] ) ? intval( $_POST['task_id'] ) : 0;
        $title   = sanitize_text_field( $_POST['task_title'] );
        $deadline = sanitize_text_field( $_POST['task_deadline'] );
        $priority = sanitize_text_field( $_POST['task_priority'] );

        $args = array(
            'post_title'   => $title,
            'post_type'    => 'orbis_task',
            'post_status'  => 'publish',
            'post_author'  => $user_id
        );

        if ( $task_id > 0 ) {
            $args['ID'] = $task_id;
            wp_update_post( $args );
        } else {
            $task_id = wp_insert_post( $args );
            update_post_meta( $task_id, '_orbis_task_status', 'pending' );
        }

        update_post_meta( $task_id, '_orbis_task_deadline', $deadline );
        update_post_meta( $task_id, '_orbis_task_priority', $priority );

        wp_send_json_success( array( 'message' => 'Task saved!', 'id' => $task_id ) );
    }

    /**
     * Toggle task status.
     */
    public function handle_toggle_task() {
        $task_id = intval( $_POST['task_id'] );
        if ( get_post_field( 'post_author', $task_id ) == get_current_user_id() ) {
            $status = get_post_meta( $task_id, '_orbis_task_status', true ) === 'completed' ? 'pending' : 'completed';
            update_post_meta( $task_id, '_orbis_task_status', $status );
            wp_send_json_success( array( 'status' => $status ) );
        }
        wp_send_json_error();
    }

    /**
     * Delete a task.
     */
    public function handle_delete_task() {
        $task_id = intval( $_POST['task_id'] );
        if ( get_post_field( 'post_author', $task_id ) == get_current_user_id() ) {
            wp_delete_post( $task_id, true );
            wp_send_json_success();
        }
        wp_send_json_error();
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
