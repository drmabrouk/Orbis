<?php
/**
 * Tasks Application Interface
 */
?>
<div class="orbis-app-tasks">
    <div class="orbis-app-toolbar">
        <button class="button button-primary"><?php echo orbis_t('add_task', 'Add Task', 'إضافة مهمة', 'Tasks'); ?></button>
    </div>

    <div class="orbis-tasks-list">
        <div class="orbis-task-item">
            <input type="checkbox">
            <div class="orbis-task-details">
                <span class="orbis-task-title"><?php echo orbis_t('finish_design', 'Finish UI Design', 'إنهاء تصميم الواجهة', 'Tasks'); ?></span>
                <span class="priority high"><?php echo orbis_t('high_priority', 'High', 'عالية', 'Tasks'); ?></span>
            </div>
            <div class="orbis-task-meta">Feb 28</div>
        </div>
        <div class="orbis-task-item">
            <input type="checkbox">
            <div class="orbis-task-details">
                <span class="orbis-task-title"><?php echo orbis_t('api_integration', 'API Integration', 'تكامل API', 'Tasks'); ?></span>
                <span class="priority medium"><?php echo orbis_t('med_priority', 'Medium', 'متوسطة', 'Tasks'); ?></span>
            </div>
            <div class="orbis-task-meta">Mar 05</div>
        </div>
    </div>
</div>

<style>
.orbis-task-item { background: #fff; padding: 15px 20px; border-radius: 8px; margin-bottom: 10px; display: flex; align-items: center; gap: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
.orbis-task-details { flex-grow: 1; display: flex; align-items: center; gap: 15px; }
.priority { font-size: 11px; text-transform: uppercase; padding: 2px 6px; border-radius: 4px; font-weight: 700; }
.priority.high { background: #fee2e2; color: #dc2626; }
.priority.medium { background: #fef3c7; color: #d97706; }
</style>
