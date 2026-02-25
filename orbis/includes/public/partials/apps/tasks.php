<?php
/**
 * Tasks Application Interface
 */
?>
<div class="orbis-app-tasks">
    <div class="orbis-app-toolbar">
        <button id="orbis-add-task-btn" class="button button-primary"><?php echo orbis_t('add_task', 'Add Task', 'إضافة مهمة', 'Tasks'); ?></button>
        <div class="orbis-task-filters">
            <button class="button active" data-filter="all"><?php echo orbis_t('all', 'All', 'الكل', 'General'); ?></button>
            <button class="button" data-filter="pending"><?php echo orbis_t('pending', 'Pending', 'قيد الانتظار', 'Tasks'); ?></button>
            <button class="button" data-filter="completed"><?php echo orbis_t('completed', 'Completed', 'مكتملة', 'Tasks'); ?></button>
        </div>
    </div>

    <div id="orbis-tasks-list" class="orbis-tasks-list">
        <!-- Tasks loaded via AJAX -->
    </div>

    <!-- Task Modal -->
    <div id="orbis-task-modal" class="orbis-modal" style="display:none;">
        <div class="orbis-modal-content">
            <span class="orbis-close-modal">&times;</span>
            <h3 id="orbis-task-modal-title"><?php echo orbis_t('new_task', 'New Task', 'مهمة جديدة', 'Tasks'); ?></h3>
            <form id="orbis-task-form">
                <input type="hidden" id="orbis-task-id" name="task_id">
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('task_title', 'Task Title', 'عنوان المهمة', 'Tasks'); ?></label>
                    <input type="text" id="orbis-task-title-field" name="task_title" required>
                </div>
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('deadline', 'Deadline', 'الموعد النهائي', 'Tasks'); ?></label>
                    <input type="date" id="orbis-task-deadline-field" name="task_deadline">
                </div>
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('priority', 'Priority', 'الأولوية', 'Tasks'); ?></label>
                    <select id="orbis-task-priority-field" name="task_priority">
                        <option value="low"><?php echo orbis_t('low', 'Low', 'منخفضة', 'Tasks'); ?></option>
                        <option value="medium"><?php echo orbis_t('medium', 'Medium', 'متوسطة', 'Tasks'); ?></option>
                        <option value="high"><?php echo orbis_t('high', 'High', 'عالية', 'Tasks'); ?></option>
                    </select>
                </div>
                <button type="submit" class="orbis-auth-submit"><?php echo orbis_t('save_task', 'Save Task', 'حفظ المهمة', 'Tasks'); ?></button>
            </form>
        </div>
    </div>
</div>

<style>
.orbis-task-item { background: #fff; padding: 20px; border-radius: 12px; margin-bottom: 15px; display: flex; align-items: center; gap: 20px; box-shadow: var(--orbis-shadow); border: 1px solid #edf2f7; transition: 0.2s; }
.orbis-task-item:hover { border-color: var(--orbis-primary); }
.orbis-task-item.completed { opacity: 0.6; }
.orbis-task-item.completed .orbis-task-title { text-decoration: line-through; }
.orbis-task-details { flex-grow: 1; }
.orbis-task-title { font-weight: 600; font-size: 16px; display: block; margin-bottom: 5px; }
.orbis-task-meta { font-size: 12px; color: #718096; display: flex; gap: 15px; }
.priority-badge { font-size: 10px; padding: 2px 8px; border-radius: 20px; font-weight: 700; text-transform: uppercase; }
.priority-high { background: #fee2e2; color: #dc2626; }
.priority-medium { background: #fef3c7; color: #d97706; }
.priority-low { background: #e0f2fe; color: #0284c7; }
</style>
