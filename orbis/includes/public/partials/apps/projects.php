<?php
/**
 * Projects Application Interface
 */
?>
<div class="orbis-app-projects">
    <div class="orbis-app-toolbar">
        <button class="button button-primary"><?php echo orbis_t('new_project', 'New Project', 'مشروع جديد', 'Projects'); ?></button>
    </div>

    <div class="orbis-projects-grid">
        <?php
        $projects = get_posts( array(
            'post_type' => 'orbis_project',
            'author'    => get_current_user_id(),
            'posts_per_page' => -1
        ) );

        if ( $projects ) :
            foreach ( $projects as $p ) :
                $progress = get_post_meta( $p->ID, '_orbis_project_progress', true ) ?: 0;
                ?>
                <div class="orbis-project-card">
                    <div class="project-header">
                        <h4><?php echo esc_html($p->post_title); ?></h4>
                        <span class="status-dot active"></span>
                    </div>
                    <p><?php echo wp_trim_words( $p->post_content, 15 ); ?></p>

                    <div class="orbis-progress-container">
                        <div class="orbis-progress-label"><?php echo orbis_t('progress', 'Progress', 'التقدم', 'Projects'); ?>: <?php echo $progress; ?>%</div>
                        <div class="orbis-progress-bar"><div class="orbis-progress-fill" style="width: <?php echo $progress; ?>%;"></div></div>
                    </div>

                    <div class="project-footer">
                        <span><span class="dashicons dashicons-calendar-alt"></span> Mar 15</span>
                        <div class="project-actions">
                            <span class="dashicons dashicons-edit"></span>
                            <span class="dashicons dashicons-trash"></span>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
        else :
            echo '<p>' . orbis_t('no_projects', 'No projects active. Create one to start tracking!', 'لا توجد مشاريع نشطة. أنشئ واحداً لبدء التتبع!', 'Projects') . '</p>';
        endif;
        ?>
    </div>
</div>

<style>
.orbis-projects-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; margin-top: 20px; }
.project-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
.project-header h4 { margin: 0; font-size: 20px; }
.status-dot { width: 10px; height: 10px; background: #2ecc71; border-radius: 50%; }
.project-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; color: #718096; font-size: 13px; }
.project-actions { display: flex; gap: 10px; }
.project-actions .dashicons { cursor: pointer; }
.project-actions .dashicons:hover { color: var(--orbis-primary); }
</style>
