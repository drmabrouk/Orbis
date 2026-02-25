<?php
/**
 * Frontend Admin Dashboard for Orbis
 */
$site_title = get_option( 'orbis_site_title', get_bloginfo('name') );
$site_desc  = get_option( 'orbis_site_description', get_bloginfo('description') );
$contact_email = get_option( 'orbis_contact_email', '' );
$primary_color = get_option( 'orbis_primary_color', '#007cba' );
$logo_url = get_option( 'orbis_site_logo', '' );
?>

<div class="orbis-admin-frontend">
    <header class="orbis-admin-dash-header">
        <h1>Orbis Site Management</h1>
        <div class="orbis-admin-status">Administrator Mode</div>
    </header>

    <div class="orbis-admin-dash-container">
        <!-- Sidebar -->
        <aside class="orbis-admin-sidebar">
            <nav>
                <ul>
                    <li class="active"><a href="#general" data-tab="general">General Settings</a></li>
                    <li><a href="#structure" data-tab="structure">Structure (Header/Footer)</a></li>
                    <li><a href="#appearance" data-tab="appearance">Appearance & Style</a></li>
                    <li><a href="#plugin" data-tab="plugin">Plugin Features</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="orbis-admin-main-content">

            <!-- General Tab -->
            <section id="orbis-tab-general" class="orbis-admin-tab-section active">
                <h3>General Site Information</h3>
                <form id="orbis-site-settings-form">
                    <?php wp_nonce_field( 'orbis_save_settings', 'orbis_settings_nonce' ); ?>
                    <div class="orbis-auth-form-group">
                        <label>Site Title</label>
                        <input type="text" name="orbis_site_title" value="<?php echo esc_attr($site_title); ?>">
                    </div>
                    <div class="orbis-auth-form-group">
                        <label>Site Description</label>
                        <textarea name="orbis_site_description"><?php echo esc_textarea($site_desc); ?></textarea>
                    </div>
                    <div class="orbis-auth-form-group">
                        <label>Contact Email</label>
                        <input type="email" name="orbis_contact_email" value="<?php echo esc_attr($contact_email); ?>">
                    </div>
                    <div class="orbis-auth-form-group">
                        <label>Site Logo</label>
                        <div class="orbis-logo-preview">
                            <?php if ($logo_url): ?>
                                <img src="<?php echo esc_url($logo_url); ?>" style="max-width: 150px; display: block; margin-bottom: 10px;">
                            <?php endif; ?>
                        </div>
                        <button type="button" class="orbis-upload-button button" id="orbis-select-logo">Choose Logo</button>
                        <input type="hidden" name="orbis_site_logo" id="orbis_site_logo_val" value="<?php echo esc_attr($logo_url); ?>">
                    </div>
                    <button type="submit" class="orbis-auth-submit">Save General Changes</button>
                </form>
            </section>

            <!-- Structure Tab -->
            <section id="orbis-tab-structure" class="orbis-admin-tab-section">
                <h3>Structural Management</h3>
                <p>Configure what appears in your header, footer, and sidebars.</p>
                <div class="orbis-structure-grid">
                    <div class="orbis-structure-item">
                        <h4>Header Configuration</h4>
                        <label><input type="checkbox" name="orbis_show_header_search" <?php checked(get_option('orbis_show_header_search'), 'on'); ?>> Show Search in Header</label>
                    </div>
                    <div class="orbis-structure-item">
                        <h4>Footer Content</h4>
                        <textarea name="orbis_footer_text" placeholder="Custom footer copyright text..."><?php echo esc_textarea(get_option('orbis_footer_text')); ?></textarea>
                    </div>
                </div>
            </section>

            <!-- Appearance Tab -->
            <section id="orbis-tab-appearance" class="orbis-admin-tab-section">
                <h3>Appearance & Styling</h3>
                <div class="orbis-auth-form-group">
                    <label>Primary Theme Color</label>
                    <input type="color" name="orbis_primary_color" value="<?php echo esc_attr($primary_color); ?>">
                </div>
                <div class="orbis-auth-form-group">
                    <label>Typography (Font Family)</label>
                    <select name="orbis_font_family">
                        <option value="sans-serif">Modern Sans-Serif</option>
                        <option value="serif">Classic Serif</option>
                        <option value="monospace">Clean Monospace</option>
                    </select>
                </div>
            </section>

            <div id="orbis-admin-mgmt-msg"></div>
        </main>
    </div>
</div>

<style>
.orbis-admin-dash-container { display: flex; gap: 30px; margin-top: 20px; }
.orbis-admin-sidebar { width: 250px; background: #f9f9f9; padding: 20px; border-radius: 8px; }
.orbis-admin-sidebar ul { list-style: none; padding: 0; }
.orbis-admin-sidebar li { margin-bottom: 10px; }
.orbis-admin-sidebar a { text-decoration: none; color: #333; font-weight: 600; padding: 10px; display: block; border-radius: 4px; }
.orbis-admin-sidebar li.active a { background: #007cba; color: #fff; }
.orbis-admin-tab-section { display: none; }
.orbis-admin-tab-section.active { display: block; }
.orbis-admin-main-content { flex-grow: 1; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
</style>
