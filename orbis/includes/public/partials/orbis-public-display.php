<?php
/**
 * Provide a public-facing view for the plugin
 */
$site_title = get_option( 'orbis_site_title', get_bloginfo('name') );
$logo_url = get_option( 'orbis_site_logo', '' );
$footer_text = get_option( 'orbis_footer_text', '&copy; ' . date('Y') . ' Orbis System' );

$apps = array(
    'notes'         => array('label' => orbis_t('app_notes', 'Notes', 'ملاحظات', 'Apps'), 'icon' => 'dashicons-welcome-write-blog', 'color' => '#3498db'),
    'tasks'         => array('label' => orbis_t('app_tasks', 'Tasks', 'مهام', 'Apps'), 'icon' => 'dashicons-list-view', 'color' => '#2ecc71'),
    'projects'      => array('label' => orbis_t('app_projects', 'Projects', 'مشاريع', 'Apps'), 'icon' => 'dashicons-portfolio', 'color' => '#9b59b6'),
    'calendar'      => array('label' => orbis_t('app_calendar', 'Calendar', 'التقويم', 'Apps'), 'icon' => 'dashicons-calendar-alt', 'color' => '#e67e22'),
    'documents'     => array('label' => orbis_t('app_docs', 'Documents', 'المستندات', 'Apps'), 'icon' => 'dashicons-media-document', 'color' => '#1abc9c'),
    'notifications' => array('label' => orbis_t('app_notifs', 'Alerts', 'تنبيهات', 'Apps'), 'icon' => 'dashicons-bell', 'color' => '#f1c40f'),
    'utilities'     => array('label' => orbis_t('app_utils', 'Utilities', 'أدوات المساعدة', 'Apps'), 'icon' => 'dashicons-calculator', 'color' => '#34495e'),
    'forms'         => array('label' => orbis_t('app_forms', 'Forms', 'نماذج', 'Apps'), 'icon' => 'dashicons-feedback', 'color' => '#e74c3c'),
    'clocks'        => array('label' => orbis_t('app_clocks', 'Clocks', 'ساعات', 'Apps'), 'icon' => 'dashicons-clock', 'color' => '#7f8c8d'),
    'settings'      => array('label' => orbis_t('app_settings', 'Settings', 'إعدادات', 'Apps'), 'icon' => 'dashicons-admin-settings', 'color' => '#95a5a6'),
);
?>

<div class="orbis-full-dashboard" <?php if ($GLOBALS['orbis_translator']->get_current_language() === 'ar') echo 'dir="rtl"'; ?>>
    <!-- Full Site Header -->
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
                <a href="<?php echo wp_logout_url( home_url() ); ?>" class="button"><?php echo orbis_t('logout', 'Logout', 'تسجيل الخروج', 'Auth'); ?></a>
            </div>
        </div>
    </header>

    <div class="orbis-dashboard-layout">
        <!-- Sidebar Navigation -->
        <aside class="orbis-master-sidebar">
            <nav class="orbis-sidebar-nav">
                <ul>
                    <li class="active"><a href="#" class="orbis-app-link" data-app="launchpad"><?php echo orbis_t('dash_launchpad', 'App Launchpad', 'مشغل التطبيقات', 'Navigation'); ?></a></li>
                    <?php foreach ($apps as $slug => $app): ?>
                        <li><a href="#" class="orbis-app-link" data-app="<?php echo $slug; ?>"><span class="dashicons <?php echo $app['icon']; ?>"></span> <?php echo $app['label']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </aside>

        <!-- Main Workspace -->
        <main class="orbis-master-content">

            <!-- App Launchpad -->
            <div id="orbis-launchpad" class="orbis-app-view active">
                <section class="orbis-dashboard-section">
                    <h2><?php echo orbis_t('welcome_workspace', 'Welcome to your Orbis Workspace', 'مرحباً بك في مساحة عمل أوربيس الخاصة بك', 'Dashboard'); ?></h2>
                    <p><?php echo orbis_t('workspace_desc', 'Manage your personal and business productivity in one professional environment.', 'قم بإدارة إنتاجيتك الشخصية والمهنية في بيئة احترافية واحدة.', 'Dashboard'); ?></p>
                </section>

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

            <!-- Dynamic App Views -->
            <?php foreach ($apps as $slug => $app): ?>
                <div id="orbis-app-<?php echo $slug; ?>" class="orbis-app-view">
                    <header class="orbis-app-header">
                        <button class="orbis-back-to-launchpad button">&larr; <?php echo orbis_t('back_to_apps', 'Back to Apps', 'العودة للتطبيقات', 'Navigation'); ?></button>
                        <h2><?php echo $app['label']; ?></h2>
                    </header>
                    <div class="orbis-app-content">
                        <?php
                        $app_path = plugin_dir_path(__FILE__) . "apps/{$slug}.php";
                        if (file_exists($app_path)) {
                            include $app_path;
                        } else {
                            echo '<p>' . orbis_t('app_coming_soon', 'This application is coming soon.', 'هذا التطبيق سيتوفر قريباً.', 'Apps') . '</p>';
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </main>
    </div>

    <!-- Full Site Footer -->
    <footer class="orbis-master-footer">
        <div class="orbis-footer-inner">
            <p><?php echo wp_kses_post($footer_text); ?></p>
        </div>
    </footer>
</div>
