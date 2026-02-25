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
                    <li><a href="#translations" data-tab="translations">Internal Translations</a></li>
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

            <!-- Translations Tab -->
            <section id="orbis-tab-translations" class="orbis-admin-tab-section">
                <h3>Bilingual Translation Management</h3>
                <p>Manage English and Arabic text for all plugin elements.</p>

                <div class="orbis-translation-filters" style="margin-bottom: 20px; display: flex; gap: 10px;">
                    <input type="text" id="orbis-translation-search" placeholder="Search strings..." style="flex-grow:1; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>

                <form id="orbis-translations-form">
                    <?php wp_nonce_field( 'orbis_save_translations', 'orbis_translations_nonce' ); ?>
                    <div class="orbis-translation-list" style="max-height: 500px; overflow-y: auto; border: 1px solid #eee; border-radius: 8px;">
                        <table class="wp-list-table widefat fixed striped" style="border:none;">
                            <thead>
                                <tr>
                                    <th style="width:20%;">Key / Context</th>
                                    <th>English (LTR)</th>
                                    <th>Arabic (RTL)</th>
                                </tr>
                            </thead>
                            <tbody id="orbis-translation-table-body">
                                <?php
                                $all_translations = $GLOBALS['orbis_translator']->get_all();
                                foreach ( $all_translations as $key => $data ) : ?>
                                    <tr class="orbis-translation-row" data-key="<?php echo esc_attr($key); ?>">
                                        <td><strong><?php echo esc_html($key); ?></strong><br><small><?php echo esc_html($data['category']); ?></small></td>
                                        <td><textarea name="translations[<?php echo esc_attr($key); ?>][en]" style="width:100%; min-height:60px;"><?php echo esc_textarea($data['en']); ?></textarea></td>
                                        <td><textarea name="translations[<?php echo esc_attr($key); ?>][ar]" dir="rtl" style="width:100%; min-height:60px;"><?php echo esc_textarea($data['ar']); ?></textarea></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="orbis-auth-submit" style="margin-top: 20px;">Save All Translations</button>
                </form>
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
