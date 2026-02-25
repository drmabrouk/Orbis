<?php
/**
 * Provide a public-facing view for the plugin
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Orbis
 * @subpackage Orbis/public/partials
 */
?>

<div class="orbis-dashboard-container">
    <header class="orbis-dashboard-header">
        <h1>Orbis Dashboard</h1>
        <nav class="orbis-dashboard-nav">
            <ul>
                <li><a href="#notes">Notes</a></li>
                <li><a href="#tasks">Tasks</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#calendar">Calendar</a></li>
                <li><a href="#tools">Tools</a></li>
                <li><a href="<?php echo site_url('orbis-profile'); ?>">Profile</a></li>
            </ul>
        </nav>
    </header>

    <main class="orbis-dashboard-main">
        <section id="overview" class="orbis-dashboard-section">
            <h2>Welcome, <?php echo wp_get_current_user()->display_name; ?></h2>
            <p>Your productivity overview for today.</p>
        </section>

        <section id="notes" class="orbis-dashboard-section">
            <h3>Recent Notes</h3>
            <?php
            $notes_query = new WP_Query( array(
                'post_type' => 'orbis_note',
                'posts_per_page' => 5,
                'author' => get_current_user_id()
            ) );

            if ( $notes_query->have_posts() ) :
                echo '<ul>';
                while ( $notes_query->have_posts() ) : $notes_query->the_post();
                    echo '<li>' . get_the_title() . ' - <small>' . get_the_date() . '</small></li>';
                endwhile;
                echo '</ul>';
                wp_reset_postdata();
            else :
                echo '<p>No notes found. Start by creating one!</p>';
            endif;
            ?>
        </section>

        <section id="tasks" class="orbis-dashboard-section">
            <h3>Active Tasks</h3>
            <?php
            $tasks_query = new WP_Query( array(
                'post_type' => 'orbis_task',
                'posts_per_page' => 5,
                'author' => get_current_user_id()
            ) );

            if ( $tasks_query->have_posts() ) :
                echo '<ul>';
                while ( $tasks_query->have_posts() ) : $tasks_query->the_post();
                    $priority = get_post_meta( get_the_ID(), '_orbis_task_priority', true );
                    echo '<li>' . get_the_title() . ' (Priority: ' . esc_html( ucfirst( $priority ) ) . ')</li>';
                endwhile;
                echo '</ul>';
                wp_reset_postdata();
            else :
                echo '<p>No tasks found. Relax or add a new task!</p>';
            endif;
            ?>
        </section>
    </main>

    <footer class="orbis-dashboard-footer">
        <p>&copy; <?php echo date('Y'); ?> Orbis System</p>
    </footer>
</div>
