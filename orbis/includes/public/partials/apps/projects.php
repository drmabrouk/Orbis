<?php
/**
 * Projects Application Interface
 */
?>
<div class="orbis-app-projects">
    <div class="orbis-projects-workspace">
        <div class="orbis-project-card">
            <h3>Orbis System V1</h3>
            <div class="orbis-progress-container">
                <div class="orbis-progress-label"><?php echo orbis_t('progress', 'Overall Progress', 'التقدم الإجمالي', 'Projects'); ?>: 75%</div>
                <div class="orbis-progress-bar"><div class="orbis-progress-fill" style="width: 75%;"></div></div>
            </div>
            <div class="orbis-subtasks">
                <h4><?php echo orbis_t('subtasks', 'Sub-tasks', 'المهام الفرعية', 'Projects'); ?></h4>
                <ul>
                    <li><span class="dashicons dashicons-yes-alt" style="color:green;"></span> Core Architecture</li>
                    <li><span class="dashicons dashicons-yes-alt" style="color:green;"></span> Auth System</li>
                    <li><span class="dashicons dashicons-clock"></span> App Launchpad</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.orbis-project-card { background: #fff; padding: 30px; border-radius: 12px; box-shadow: var(--orbis-shadow); border: 1px solid #e2e8f0; }
.orbis-progress-container { margin: 20px 0; }
.orbis-progress-label { font-size: 14px; font-weight: 600; margin-bottom: 8px; }
.orbis-subtasks ul { list-style: none; padding: 0; }
.orbis-subtasks li { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f1f5f9; }
</style>
