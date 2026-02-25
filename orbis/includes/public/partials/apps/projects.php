<?php
/**
 * Projects App Partial
 */
$projects = get_posts(array(
    'post_type' => 'orbis_project',
    'author' => get_current_user_id(),
    'posts_per_page' => -1
));
?>
<div class="orbis-app-projects">
    <div class="orbis-app-header">
        <h2><?php echo orbis_t('Projects Management'); ?></h2>
        <button class="orbis-btn orbis-btn-primary" id="orbis-new-project-btn">+ <?php echo orbis_t('New Project'); ?></button>
    </div>

    <div class="orbis-projects-grid">
        <?php if (empty($projects)): ?>
            <p><?php echo orbis_t('No projects found. Create your first project to get started!'); ?></p>
        <?php else: ?>
            <?php foreach ($projects as $project):
                $status = get_post_meta($project->ID, '_orbis_project_status', true) ?: 'Active';
                $progress = get_post_meta($project->ID, '_orbis_project_progress', true) ?: 0;
            ?>
                <div class="orbis-project-card">
                    <h3><?php echo esc_html($project->post_title); ?></h3>
                    <p><?php echo wp_trim_words($project->post_content, 15); ?></p>
                    <div class="orbis-project-meta">
                        <span class="orbis-badge"><?php echo esc_html($status); ?></span>
                        <div class="orbis-progress-bar">
                            <div class="orbis-progress-fill" style="width: <?php echo esc_attr($progress); ?>%"></div>
                        </div>
                        <span class="orbis-progress-text"><?php echo esc_html($progress); ?>%</span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Simple Modal for New Project (Implementation Placeholder) -->
<div id="orbis-project-modal" class="orbis-modal" style="display:none;">
    <div class="orbis-modal-content">
        <span class="orbis-close">&times;</span>
        <h3><?php echo orbis_t('Create New Project'); ?></h3>
        <p><?php echo orbis_t('Project management details and sub-task assignments are currently under development.'); ?></p>
    </div>
</div>
