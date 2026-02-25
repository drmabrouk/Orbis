<?php
/**
 * Polished Master Dashboard for Orbis
 * iPhone-inspired Workspace Interface
 */
$site_title = get_option( 'orbis_site_title', 'Orbis Workspace' );
$logo_url = get_option( 'orbis_site_logo', '' );
$footer_text = get_option( 'orbis_footer_text', '&copy; ' . date('Y') . ' Orbis Enterprise' );
$current_lang = $GLOBALS['orbis_translator']->get_current_language();

$apps = array(
    'notes'         => array('label' => orbis_t('app_notes', 'Notes', 'ملاحظات', 'Apps'), 'icon' => 'fa-solid fa-note-sticky', 'color' => '#3b82f6'), // Blue
    'tasks'         => array('label' => orbis_t('app_tasks', 'Tasks', 'مهام', 'Apps'), 'icon' => 'fa-solid fa-list-check', 'color' => '#10b981'), // Green
    'projects'      => array('label' => orbis_t('app_projects', 'Projects', 'مشاريع', 'Apps'), 'icon' => 'fa-solid fa-diagram-project', 'color' => '#8b5cf6'), // Purple
    'calendar'      => array('label' => orbis_t('app_calendar', 'Calendar', 'التقويم', 'Apps'), 'icon' => 'fa-solid fa-calendar-days', 'color' => '#f59e0b'), // Amber
    'documents'     => array('label' => orbis_t('app_docs', 'Files', 'الملفات', 'Apps'), 'icon' => 'fa-solid fa-file-pdf', 'color' => '#ef4444'), // Red
    'finance'       => array('label' => orbis_t('app_finance', 'Finance', 'المالية', 'Apps'), 'icon' => 'fa-solid fa-wallet', 'color' => '#059669'), // Emerald
    'bmi'           => array('label' => orbis_t('app_bmi', 'Health', 'الصحة', 'Apps'), 'icon' => 'fa-solid fa-heart-pulse', 'color' => '#ec4899'), // Pink
    'passwords'     => array('label' => orbis_t('app_passwords', 'Vault', 'الخزنة', 'Apps'), 'icon' => 'fa-solid fa-vault', 'color' => '#64748b'), // Slate
    'images'        => array('label' => orbis_t('app_images', 'Photos', 'الصور', 'Apps'), 'icon' => 'fa-solid fa-image', 'color' => '#0ea5e9'), // Sky
    'forms'         => array('label' => orbis_t('app_forms', 'Forms', 'نماذج', 'Apps'), 'icon' => 'fa-solid fa-file-signature', 'color' => '#f97316'), // Orange
    'notifications' => array('label' => orbis_t('app_notifs', 'Alerts', 'تنبيهات', 'Apps'), 'icon' => 'fa-solid fa-bell', 'color' => '#fbbf24'), // Yellow
    'utilities'     => array('label' => orbis_t('app_utils', 'Tools', 'الأدوات', 'Apps'), 'icon' => 'fa-solid fa-screwdriver-wrench', 'color' => '#475569'), // Slate Dark
    'clocks'        => array('label' => orbis_t('app_clocks', 'Clocks', 'ساعات', 'Apps'), 'icon' => 'fa-solid fa-clock', 'color' => '#6366f1'), // Indigo
    'settings'      => array('label' => orbis_t('app_settings', 'Settings', 'إعدادات', 'Apps'), 'icon' => 'fa-solid fa-gear', 'color' => '#94a3b8'), // Gray
);
?>

<div class="orbis-full-dashboard orbis-user-dash <?php echo ($current_lang === 'ar') ? 'rtl' : 'ltr'; ?>" <?php if ($current_lang === 'ar') echo 'dir="rtl"'; ?>>
    <header class="orbis-master-header">
        <div class="orbis-header-inner">
            <div class="orbis-site-brand">
                <?php if ($logo_url): ?>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="Logo" class="orbis-site-logo">
                <?php endif; ?>
                <span class="orbis-site-title"><?php echo esc_html($site_title); ?></span>
            </div>
            <div class="orbis-user-meta">
                <span class="orbis-user-name"><?php echo wp_get_current_user()->display_name; ?></span>
                <div class="orbis-header-actions">
                    <?php if (current_user_can('manage_options')): ?>
                        <a href="<?php echo site_url('orbis-admin-dashboard'); ?>" class="orbis-btn-icon" title="<?php echo orbis_t('admin', 'Admin', 'الإدارة', 'Dashboard'); ?>"><i class="fa-solid fa-user-shield"></i></a>
                    <?php endif; ?>
                    <a href="<?php echo wp_logout_url( home_url() ); ?>" class="orbis-btn-icon" title="<?php echo orbis_t('logout', 'Logout', 'خروج', 'Dashboard'); ?>"><i class="fa-solid fa-right-from-bracket"></i></a>
                </div>
            </div>
        </div>
    </header>

    <div class="orbis-dashboard-layout no-sidebar">
        <main class="orbis-master-content">
            <!-- App Launchpad -->
            <div id="orbis-launchpad" class="orbis-app-view active">
                <div class="orbis-welcome-hero">
                    <h1><?php echo orbis_t('welcome_back', 'Welcome back', 'مرحباً بعودتك', 'Dashboard'); ?>, <?php echo wp_get_current_user()->first_name; ?></h1>
                    <p><?php echo date('l, F j, Y'); ?></p>
                </div>

                <div class="orbis-iphone-grid">
                    <?php foreach ($apps as $slug => $app): ?>
                        <div class="orbis-app-tile" data-app="<?php echo $slug; ?>" style="--app-color: <?php echo $app['color']; ?>;">
                            <div class="orbis-app-icon-wrapper">
                                <div class="orbis-app-icon">
                                    <i class="<?php echo $app['icon']; ?>"></i>
                                </div>
                            </div>
                            <div class="orbis-app-label"><?php echo $app['label']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- App Container Views -->
            <?php foreach ($apps as $slug => $app): ?>
                <div id="orbis-app-<?php echo $slug; ?>" class="orbis-app-view">
                    <div class="orbis-app-toolbar">
                        <div class="orbis-toolbar-left">
                            <button class="orbis-back-to-launchpad orbis-btn-secondary">
                                <i class="fa-solid fa-chevron-left"></i> <?php echo orbis_t('back', 'Back', 'رجوع', 'General'); ?>
                            </button>
                        </div>
                        <div class="orbis-toolbar-center">
                            <h2 class="orbis-app-title"><?php echo $app['label']; ?></h2>
                        </div>
                        <div class="orbis-toolbar-right">
                            <i class="<?php echo $app['icon']; ?>" style="color: <?php echo $app['color']; ?>; font-size: 20px;"></i>
                        </div>
                    </div>

                    <div class="orbis-app-container">
                        <?php
                        $app_path = plugin_dir_path(__FILE__) . "apps/{$slug}.php";
                        if (file_exists($app_path)) {
                            include $app_path;
                        } else {
                            echo '<div class="orbis-card orbis-empty-state"><i class="fa-solid fa-hammer"></i><p>' . orbis_t('app_polishing', 'Application polishing in progress...', 'جاري تحسين التطبيق...', 'Apps') . '</p></div>';
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </main>
    </div>

    <footer class="orbis-master-footer">
        <p><?php echo wp_kses_post($footer_text); ?></p>
    </footer>
</div>
