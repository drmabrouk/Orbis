<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Orbis
 * @subpackage Orbis/admin/partials
 */
?>

<div class="wrap orbis-admin-wrap">
	<h2>Orbis Management Dashboard</h2>
    <p>Welcome to the Orbis administration area. Here you can configure the global settings for your personal and business management system.</p>

    <div class="orbis-admin-content">
        <div class="orbis-admin-card">
            <h3>General Settings</h3>
            <form method="post" action="options.php">
                <?php
                // Settings fields would go here
                ?>
                <p>Configuration options for Notes, Tasks, and Projects.</p>
            </form>
        </div>
    </div>
</div>
