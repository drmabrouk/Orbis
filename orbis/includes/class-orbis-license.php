<?php
/**
 * Handles Plugin Licensing
 */
class Orbis_License {

    private $option_name = 'orbis_license_data';

    public function __construct() {
        // Initialization if needed
    }

    /**
     * Activate the license
     */
    public function activate( $license_key ) {
        // Simulated remote validation
        if ( empty( $license_key ) ) {
            return new WP_Error( 'invalid_key', 'License key cannot be empty.' );
        }

        // In a real scenario, this would call a remote API
        $is_valid = ( strlen( $license_key ) > 10 ); // Simple mock validation

        if ( $is_valid ) {
            $data = array(
                'key'         => $license_key,
                'status'      => 'active',
                'activated_at' => time(),
                'expires_at'   => time() + ( 365 * 24 * 60 * 60 ), // 1 year
                'type'        => 'Enterprise'
            );
            update_option( $this->option_name, $data );
            return true;
        }

        return new WP_Error( 'activation_failed', 'Invalid license key. Please check your credentials.' );
    }

    /**
     * Check if the license is active
     */
    public function is_active() {
        $data = get_option( $this->option_name );
        if ( ! $data || $data['status'] !== 'active' ) {
            return false;
        }

        if ( time() > $data['expires_at'] ) {
            $this->deactivate();
            return false;
        }

        return true;
    }

    /**
     * Deactivate the license
     */
    public function deactivate() {
        delete_option( $this->option_name );
    }

    /**
     * Get license data
     */
    public function get_data() {
        return get_option( $this->option_name, array( 'status' => 'inactive' ) );
    }
}
