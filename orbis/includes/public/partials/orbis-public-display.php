<?php
/**
 * Provide a public-facing view for the plugin
 */
$site_title = get_option( 'orbis_site_title', get_bloginfo('name') );
$logo_url = get_option( 'orbis_site_logo', '' );
$footer_text = get_option( 'orbis_footer_text', '&copy; ' . date('Y') . ' Orbis System' );
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
                    <li><a href="#overview"><?php echo orbis_t('dash_overview', 'Dashboard Overview', 'نظرة عامة على لوحة التحكم', 'Navigation'); ?></a></li>
                    <li><a href="#notes"><?php echo orbis_t('my_notes', 'My Notes', 'ملاحظاتي', 'Navigation'); ?></a></li>
                    <li><a href="#tasks"><?php echo orbis_t('task_manager', 'Task Manager', 'مدير المهام', 'Navigation'); ?></a></li>
                    <li><a href="#projects"><?php echo orbis_t('project_tracking', 'Project Tracking', 'تتبع المشاريع', 'Navigation'); ?></a></li>
                    <li><a href="#calendar"><?php echo orbis_t('calendar', 'Calendar', 'التقويم', 'Navigation'); ?></a></li>
                    <li><a href="#tools"><?php echo orbis_t('productivity_tools', 'Productivity Tools', 'أدوات الإنتاجية', 'Navigation'); ?></a></li>
                    <li><a href="<?php echo site_url('orbis-profile'); ?>"><?php echo orbis_t('account_settings', 'Account Settings', 'إعدادات الحساب', 'Navigation'); ?></a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Workspace -->
        <main class="orbis-master-content">
            <section id="overview" class="orbis-dashboard-section">
                <h2><?php echo orbis_t('welcome_workspace', 'Welcome to your Orbis Workspace', 'مرحباً بك في مساحة عمل أوربيس الخاصة بك', 'Dashboard'); ?></h2>
                <p><?php echo orbis_t('workspace_desc', 'Manage your personal and business productivity in one professional environment.', 'قم بإدارة إنتاجيتك الشخصية والمهنية في بيئة احترافية واحدة.', 'Dashboard'); ?></p>
            </section>

            <div class="orbis-dashboard-grid">
                <section id="notes" class="orbis-dashboard-section card">
                    <h3><?php echo orbis_t('recent_notes', 'Recent Notes', 'الملاحظات الأخيرة', 'Modules'); ?></h3>
                    <?php
                    $notes_query = new WP_Query( array(
                        'post_type' => 'orbis_note',
                        'posts_per_page' => 3,
                        'author' => get_current_user_id()
                    ) );
                    if ( $notes_query->have_posts() ) :
                        echo '<ul>';
                        while ( $notes_query->have_posts() ) : $notes_query->the_post();
                            echo '<li>' . get_the_title() . '</li>';
                        endwhile;
                        echo '</ul>';
                        wp_reset_postdata();
                    else :
                        echo '<p>' . orbis_t('no_notes', 'No notes found.', 'لم يتم العثور على ملاحظات.', 'Modules') . '</p>';
                    endif;
                    ?>
                </section>

                <section id="tasks" class="orbis-dashboard-section card">
                    <h3><?php echo orbis_t('active_tasks', 'Active Tasks', 'المهام النشطة', 'Modules'); ?></h3>
                    <?php
                    $tasks_query = new WP_Query( array(
                        'post_type' => 'orbis_task',
                        'posts_per_page' => 3,
                        'author' => get_current_user_id()
                    ) );
                    if ( $tasks_query->have_posts() ) :
                        echo '<ul>';
                        while ( $tasks_query->have_posts() ) : $tasks_query->the_post();
                            echo '<li>' . get_the_title() . '</li>';
                        endwhile;
                        echo '</ul>';
                        wp_reset_postdata();
                    else :
                        echo '<p>' . orbis_t('no_tasks', 'No tasks found.', 'لم يتم العثور على مهام.', 'Modules') . '</p>';
                    endif;
                    ?>
                </section>
            </div>
        </main>
    </div>

    <!-- Full Site Footer -->
    <footer class="orbis-master-footer">
        <div class="orbis-footer-inner">
            <p><?php echo wp_kses_post($footer_text); ?></p>
        </div>
    </footer>
</div>
