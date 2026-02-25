<?php
/**
 * Polished Frontend Admin Dashboard for Orbis
 */
$site_title = get_option( 'orbis_site_title', get_bloginfo('name') );
$site_desc  = get_option( 'orbis_site_description', get_bloginfo('description') );
$contact_email = get_option( 'orbis_contact_email', '' );
$primary_color = get_option( 'orbis_primary_color', '#007cba' );
$logo_url = get_option( 'orbis_site_logo', '' );
$current_lang = $GLOBALS['orbis_translator']->get_current_language();
?>

<div class="orbis-full-dashboard orbis-admin-dash <?php echo ($current_lang === 'ar') ? 'rtl' : 'ltr'; ?>" <?php if ($current_lang === 'ar') echo 'dir="rtl"'; ?>>
    <header class="orbis-master-header">
        <div class="orbis-header-inner">
            <div class="orbis-site-brand">
                <?php if ($logo_url): ?>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="Logo" class="orbis-site-logo">
                <?php endif; ?>
                <span class="orbis-site-title"><?php echo orbis_t('admin_dash', 'System Management', 'إدارة النظام', 'Admin'); ?></span>
            </div>
            <div class="orbis-user-meta">
                <span class="orbis-badge" style="background: #e53e3e; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;"><?php echo orbis_t('admin_mode', 'ADMINISTRATOR', 'مسؤول', 'Admin'); ?></span>
                <a href="<?php echo site_url('orbis-dashboard'); ?>" class="orbis-btn" style="background: #edf2f7; margin-left: 20px;"><?php echo orbis_t('view_site', 'Exit Admin', 'خروج من الإدارة', 'Admin'); ?></a>
            </div>
        </div>
    </header>

    <div class="orbis-dashboard-layout">
        <aside class="orbis-master-sidebar">
            <nav class="orbis-sidebar-nav">
                <ul>
                    <li class="active"><a href="#general" data-tab="general"><span class="dashicons dashicons-admin-settings"></span> <?php echo orbis_t('general_settings', 'General Settings', 'الإعدادات العامة', 'Admin'); ?></a></li>
                    <li><a href="#structure" data-tab="structure"><span class="dashicons dashicons-layout"></span> <?php echo orbis_t('structure_mgmt', 'Structure', 'الهيكل', 'Admin'); ?></a></li>
                    <li><a href="#appearance" data-tab="appearance"><span class="dashicons dashicons-art"></span> <?php echo orbis_t('appearance', 'Appearance', 'المظهر', 'Admin'); ?></a></li>
                    <li><a href="#translations" data-tab="translations"><span class="dashicons dashicons-translation"></span> <?php echo orbis_t('translations', 'Translations', 'الترجمات', 'Admin'); ?></a></li>
                    <li><a href="#plugin" data-tab="plugin"><span class="dashicons dashicons-admin-plugins"></span> <?php echo orbis_t('plugin_features', 'Features', 'المميزات', 'Admin'); ?></a></li>
                </ul>
            </nav>
        </aside>

        <main class="orbis-master-content">
            <div class="orbis-admin-main-card orbis-card">

                <!-- General Tab -->
                <section id="orbis-tab-general" class="orbis-admin-tab-section active">
                    <h3 style="margin-top:0; font-size: 24px; font-weight: 800; border-bottom: 2px solid var(--orbis-border); padding-bottom: 15px; margin-bottom: 25px;"><?php echo orbis_t('site_info', 'Site Information', 'معلومات الموقع', 'Admin'); ?></h3>
                    <form id="orbis-site-settings-form">
                        <?php wp_nonce_field( 'orbis_save_settings', 'orbis_settings_nonce' ); ?>
                        <div class="orbis-auth-form-group">
                            <label><?php echo orbis_t('site_title_label', 'Site Title', 'عنوان الموقع', 'Admin'); ?></label>
                            <input type="text" name="orbis_site_title" value="<?php echo esc_attr($site_title); ?>">
                        </div>
                        <div class="orbis-auth-form-group">
                            <label><?php echo orbis_t('site_desc_label', 'Description', 'الوصف', 'Admin'); ?></label>
                            <textarea name="orbis_site_description" rows="3"><?php echo esc_textarea($site_desc); ?></textarea>
                        </div>
                        <div class="orbis-auth-form-group">
                            <label><?php echo orbis_t('contact_email_label', 'Contact Email', 'بريد التواصل', 'Admin'); ?></label>
                            <input type="email" name="orbis_contact_email" value="<?php echo esc_attr($contact_email); ?>">
                        </div>
                        <div class="orbis-auth-form-group">
                            <label><?php echo orbis_t('site_logo_label', 'Site Logo', 'شعار الموقع', 'Admin'); ?></label>
                            <div class="orbis-logo-preview">
                                <?php if ($logo_url): ?>
                                    <img src="<?php echo esc_url($logo_url); ?>" style="max-width: 200px; display: block; border: 1px solid #eee; padding: 5px; border-radius: 8px; margin-bottom: 15px;">
                                <?php endif; ?>
                            </div>
                            <button type="button" class="orbis-btn" style="background: #edf2f7;" id="orbis-select-logo"><?php echo orbis_t('choose_logo', 'Update Logo', 'تحديث الشعار', 'Admin'); ?></button>
                            <input type="hidden" name="orbis_site_logo" id="orbis_site_logo_val" value="<?php echo esc_attr($logo_url); ?>">
                        </div>
                        <button type="submit" class="orbis-auth-submit" style="max-width: 250px;"><?php echo orbis_t('save_site_changes', 'Apply System Changes', 'تطبيق تغييرات النظام', 'Admin'); ?></button>
                    </form>
                </section>

                <!-- Translations Tab -->
                <section id="orbis-tab-translations" class="orbis-admin-tab-section">
                    <h3 style="margin-top:0; font-size: 24px; font-weight: 800; border-bottom: 2px solid var(--orbis-border); padding-bottom: 15px; margin-bottom: 25px;"><?php echo orbis_t('translation_mgmt', 'System Translations', 'ترجمات النظام', 'Admin'); ?></h3>
                    <div class="orbis-translation-filters" style="margin-bottom: 25px;">
                        <input type="text" id="orbis-translation-search" placeholder="<?php echo orbis_t('search_strings', 'Search translatable strings...', 'بحث عن نصوص قابلة للترجمة...', 'Admin'); ?>" style="width:100%; padding:14px; border:1px solid var(--orbis-border); border-radius:10px;">
                    </div>

                    <form id="orbis-translations-form">
                        <?php wp_nonce_field( 'orbis_save_translations', 'orbis_translations_nonce' ); ?>
                        <div class="orbis-translation-list" style="max-height: 600px; overflow-y: auto; border: 1px solid var(--orbis-border); border-radius: 12px; background: #fcfcfc;">
                            <table class="wp-list-table widefat fixed striped" style="border:none;">
                                <thead style="background: #f8fafc;">
                                    <tr>
                                        <th style="width:25%; padding: 15px;"><?php echo orbis_t('key', 'Key', 'المفتاح', 'Admin'); ?></th>
                                        <th style="padding: 15px;"><?php echo orbis_t('english_ver', 'English', 'الإنجليزية', 'Admin'); ?></th>
                                        <th style="padding: 15px;"><?php echo orbis_t('arabic_ver', 'Arabic', 'العربية', 'Admin'); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="orbis-translation-table-body">
                                    <?php
                                    $all_translations = $GLOBALS['orbis_translator']->get_all();
                                    foreach ( $all_translations as $key => $data ) : ?>
                                        <tr class="orbis-translation-row" data-key="<?php echo esc_attr($key); ?>">
                                            <td style="padding: 15px;"><strong><?php echo esc_html($key); ?></strong><br><small style="color:#aaa;"><?php echo esc_html($data['category']); ?></small></td>
                                            <td style="padding: 15px;"><textarea name="translations[<?php echo esc_attr($key); ?>][en]" style="width:100%; min-height:80px; border-radius:8px; border-color:#eee;"><?php echo esc_textarea($data['en']); ?></textarea></td>
                                            <td style="padding: 15px;"><textarea name="translations[<?php echo esc_attr($key); ?>][ar]" dir="rtl" style="width:100%; min-height:80px; border-radius:8px; border-color:#eee; font-family: 'Inter', sans-serif;"><?php echo esc_textarea($data['ar']); ?></textarea></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="orbis-auth-submit" style="margin-top: 30px; max-width: 250px;"><?php echo orbis_t('save_translations_btn', 'Sync Translations', 'مزامنة الترجمات', 'Admin'); ?></button>
                    </form>
                </section>

                <!-- Structure & Appearance Placeholders -->
                <section id="orbis-tab-structure" class="orbis-admin-tab-section">
                    <h3 style="margin-top:0; font-size: 24px; font-weight: 800;"><?php echo orbis_t('layout_structure', 'Layout & Structure', 'التصميم والهيكل', 'Admin'); ?></h3>
                    <p style="color: #666;"><?php echo orbis_t('layout_desc', 'Advanced drag-and-drop structural management is currently in preview mode.', 'إدارة الهيكل المتقدمة بالسحب والإفلات قيد وضع المعاينة حالياً.', 'Admin'); ?></p>
                </section>

                <section id="orbis-tab-appearance" class="orbis-admin-tab-section">
                    <h3 style="margin-top:0; font-size: 24px; font-weight: 800;"><?php echo orbis_t('visual_identity', 'Visual Identity', 'الهوية البصرية', 'Admin'); ?></h3>
                    <div class="orbis-auth-form-group">
                        <label><?php echo orbis_t('primary_color', 'Brand Primary Color', 'لون العلامة التجارية الأساسي', 'Admin'); ?></label>
                        <input type="color" name="orbis_primary_color" value="<?php echo esc_attr($primary_color); ?>">
                    </div>
                </section>

                <div id="orbis-admin-mgmt-msg" style="margin-top: 20px;"></div>
            </div>
        </main>
    </div>
</div>
