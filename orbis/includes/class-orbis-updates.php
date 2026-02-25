<?php
/**
 * Handles Plugin Updates and Migrations
 */
class Orbis_Updates {

    private $current_version;
    private $option_name = 'orbis_version';
    private $log_option = 'orbis_update_log';

    public function __construct( $version ) {
        $this->current_version = $version;
    }

    /**
     * Check for updates and run migrations
     */
    public function check_and_migrate() {
        $installed_version = get_option( $this->option_name, '0.0.0' );

        if ( version_compare( $installed_version, $this->current_version, '<' ) ) {
            $this->run_migrations( $installed_version );
            update_option( $this->option_name, $this->current_version );
            $this->log( "Updated system from {$installed_version} to {$this->current_version}" );
        }
    }

    /**
     * Run version-specific migrations
     */
    private function run_migrations( $installed_version ) {
        // Example migration for 1.1.0
        if ( version_compare( $installed_version, '1.1.0', '<' ) ) {
            // Perform structural adjustments if any
        }
    }

    /**
     * Log update events
     */
    private function log( $message ) {
        $logs = get_option( $this->log_option, array() );
        $logs[] = array(
            'time'    => time(),
            'version' => $this->current_version,
            'message' => $message
        );
        // Keep only last 50 logs
        if ( count( $logs ) > 50 ) {
            array_shift( $logs );
        }
        update_option( $this->log_option, $logs );
    }

    /**
     * Get update logs
     */
    public function get_logs() {
        return get_option( $this->log_option, array() );
    }
}
