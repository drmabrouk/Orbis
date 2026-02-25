<?php
/**
 * Provide a public-facing view for the plugin
 */
$site_title = get_option( 'orbis_site_title', get_bloginfo('name') );
$logo_url = get_option( 'orbis_site_logo', '' );
$footer_text = get_option( 'orbis_footer_text', '&copy; ' . date('Y') . ' Orbis System' );
?>

<div class="orbis-full-dashboard">
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
                <span>Hello, <?php echo wp_get_current_user()->display_name; ?></span>
                <a href="<?php echo wp_logout_url( home_url() ); ?>" class="button">Logout</a>
            </div>
        </div>
    </header>

    <div class="orbis-dashboard-layout">
        <!-- Sidebar Navigation -->
        <aside class="orbis-master-sidebar">
            <nav class="orbis-sidebar-nav">
                <ul>
                    <li><a href="#overview">Dashboard Overview</a></li>
                    <li><a href="#notes">My Notes</a></li>
                    <li><a href="#tasks">Task Manager</a></li>
                    <li><a href="#projects">Project Tracking</a></li>
                    <li><a href="#calendar">Calendar</a></li>
                    <li><a href="#tools">Productivity Tools</a></li>
                    <li><a href="<?php echo site_url('orbis-profile'); ?>">Account Settings</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Workspace -->
        <main class="orbis-master-content">
            <section id="overview" class="orbis-dashboard-section">
                <h2>Welcome to your Orbis Workspace</h2>
                <p>Manage your personal and business productivity in one professional environment.</p>
            </section>

            <div class="orbis-dashboard-grid">
                <section id="notes" class="orbis-dashboard-section card">
                    <h3>Recent Notes</h3>
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
                        echo '<p>No notes found.</p>';
                    endif;
                    ?>
                </section>

                <section id="tasks" class="orbis-dashboard-section card">
                    <h3>Active Tasks</h3>
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
                        echo '<p>No tasks found.</p>';
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
