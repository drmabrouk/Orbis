<?php
/**
 * Polished Master Dashboard for Orbis
 */
$site_title = get_option( 'orbis_site_title', get_bloginfo('name') );
$logo_url = get_option( 'orbis_site_logo', '' );
$footer_text = get_option( 'orbis_footer_text', '&copy; ' . date('Y') . ' Orbis System' );
$current_lang = $GLOBALS['orbis_translator']->get_current_language();

$apps = array(
    'notes'         => array('label' => orbis_t('app_notes', 'Notes', 'ملاحظات', 'Apps'), 'icon' => 'dashicons-welcome-write-blog', 'color' => '#3498db'),
    'tasks'         => array('label' => orbis_t('app_tasks', 'Tasks', 'مهام', 'Apps'), 'icon' => 'dashicons-list-view', 'color' => '#2ecc71'),
    'projects'      => array('label' => orbis_t('app_projects', 'Projects', 'مشاريع', 'Apps'), 'icon' => 'dashicons-portfolio', 'color' => '#9b59b6'),
    'calendar'      => array('label' => orbis_t('app_calendar', 'Calendar', 'التقويم', 'Apps'), 'icon' => 'dashicons-calendar-alt', 'color' => '#e67e22'),
    'documents'     => array('label' => orbis_t('app_docs', 'Documents', 'المستندات', 'Apps'), 'icon' => 'dashicons-media-document', 'color' => '#1abc9c'),
    'finance'       => array('label' => orbis_t('app_finance', 'Finance', 'المالية', 'Apps'), 'icon' => 'dashicons-chart-bar', 'color' => '#27ae60'),
    'bmi'           => array('label' => orbis_t('app_bmi', 'BMI Calc', 'حاسبة BMI', 'Apps'), 'icon' => 'dashicons-heart', 'color' => '#e74c3c'),
    'passwords'     => array('label' => orbis_t('app_passwords', 'Passwords', 'كلمات المرور', 'Apps'), 'icon' => 'dashicons-lock', 'color' => '#f1c40f'),
    'images'        => array('label' => orbis_t('app_images', 'Image Storage', 'تخزين الصور', 'Apps'), 'icon' => 'dashicons-format-image', 'color' => '#3498db'),
    'forms'         => array('label' => orbis_t('app_forms', 'Forms', 'نماذج', 'Apps'), 'icon' => 'dashicons-feedback', 'color' => '#e67e22'),
    'notifications' => array('label' => orbis_t('app_notifs', 'Alerts', 'تنبيهات', 'Apps'), 'icon' => 'dashicons-bell', 'color' => '#f1c40f'),
    'utilities'     => array('label' => orbis_t('app_utils', 'Utilities', 'أدوات المساعدة', 'Apps'), 'icon' => 'dashicons-calculator', 'color' => '#34495e'),
    'clocks'        => array('label' => orbis_t('app_clocks', 'Clocks', 'ساعات', 'Apps'), 'icon' => 'dashicons-clock', 'color' => '#7f8c8d'),
    'settings'      => array('label' => orbis_t('app_settings', 'Settings', 'إعدادات', 'Apps'), 'icon' => 'dashicons-admin-settings', 'color' => '#95a5a6'),
);
?>

<div class="orbis-full-dashboard <?php echo ($current_lang === 'ar') ? 'rtl' : 'ltr'; ?>" <?php if ($current_lang === 'ar') echo 'dir="rtl"'; ?>>
    <header class="orbis-master-header">
        <div class="orbis-header-inner">
            <div class="orbis-site-brand">
                <?php if ($logo_url): ?>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="Logo" class="orbis-site-logo">
                <?php endif; ?>
                <span class="orbis-site-title"><?php echo esc_html($site_title); ?></span>
            </div>
            <div class="orbis-user-meta">
                <span><?php echo sprintf( orbis_t('hello_user', 'Hello, %s', 'مرحباً، %s', 'Dashboard'), wp_get_current_user()->display_name ); ?></span>
                <a href="<?php echo wp_logout_url( home_url() ); ?>" class="orbis-btn orbis-btn-primary" style="margin-left: 20px;"><?php echo orbis_t('logout', 'Logout', 'تسجيل الخروج', 'Auth'); ?></a>
            </div>
        </div>
    </header>

    <div class="orbis-dashboard-layout">
        <aside class="orbis-master-sidebar">
            <nav class="orbis-sidebar-nav">
                <ul>
                    <li class="active"><a href="#" class="orbis-app-link" data-app="launchpad"><span class="dashicons dashicons-dashboard"></span> <?php echo orbis_t('dash_launchpad', 'Dashboard', 'لوحة التحكم', 'Navigation'); ?></a></li>
                    <?php foreach ($apps as $slug => $app): ?>
                        <li><a href="#" class="orbis-app-link" data-app="<?php echo $slug; ?>"><span class="dashicons <?php echo $app['icon']; ?>"></span> <?php echo $app['label']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </aside>

        <main class="orbis-master-content">
            <div id="orbis-launchpad" class="orbis-app-view active">
                <div class="orbis-welcome-section">
                    <h2 style="font-size: 32px; margin-bottom: 8px;"><?php echo orbis_t('welcome_workspace', 'Welcome back', 'مرحباً بعودتك', 'Dashboard'); ?>, <?php echo wp_get_current_user()->first_name; ?></h2>
                    <p style="color: var(--orbis-text-muted); font-size: 18px;"><?php echo orbis_t('workspace_desc', 'Your unified management environment is ready.', 'بيئة الإدارة الموحدة الخاصة بك جاهزة.', 'Dashboard'); ?></p>
                </div>

                <div class="orbis-app-grid">
                    <?php foreach ($apps as $slug => $app): ?>
                        <div class="orbis-app-tile" data-app="<?php echo $slug; ?>" style="--app-color: <?php echo $app['color']; ?>;">
                            <div class="orbis-app-icon">
                                <span class="dashicons <?php echo $app['icon']; ?>"></span>
                            </div>
                            <div class="orbis-app-label"><?php echo $app['label']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php foreach ($apps as $slug => $app): ?>
                <div id="orbis-app-<?php echo $slug; ?>" class="orbis-app-view">
                    <header class="orbis-app-header">
                        <button class="orbis-back-to-launchpad orbis-btn" style="background: #edf2f7;">&larr; <?php echo orbis_t('back', 'Back', 'رجوع', 'General'); ?></button>
                        <h2 style="font-size: 28px; font-weight: 800;"><?php echo $app['label']; ?></h2>
                    </header>
                    <div class="orbis-app-content">
                        <?php
                        $app_path = plugin_dir_path(__FILE__) . "apps/{$slug}.php";
                        if (file_exists($app_path)) {
                            include $app_path;
                        } else {
                            echo '<div class="orbis-card" style="text-align:center; padding: 100px 0;"><p>' . orbis_t('app_coming_soon', 'This application is being polished.', 'هذا التطبيق قيد التحسين.', 'Apps') . '</p></div>';
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
