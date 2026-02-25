<?php
/**
 * Notifications & Alerts Application
 */
?>
<div class="orbis-app-notifications">
    <div class="orbis-notif-hub">
        <div class="notif-header">
            <h3><?php echo orbis_t('recent_alerts', 'Recent Alerts', 'التنبيهات الأخيرة', 'Notifs'); ?></h3>
            <button class="button"><?php echo orbis_t('mark_all_read', 'Mark All Read', 'تحديد الكل كمقروء', 'Notifs'); ?></button>
        </div>

        <div class="notif-list">
            <?php
            // Mock notifications based on actual user content
            $tasks = get_posts(array('post_type' => 'orbis_task', 'author' => get_current_user_id(), 'posts_per_page' => 3));
            foreach ($tasks as $t) : ?>
                <div class="notif-item unread">
                    <span class="dashicons dashicons-calendar-alt"></span>
                    <div class="notif-content">
                        <p><strong><?php echo orbis_t('task_reminder', 'Task Reminder', 'تذكير بمهمة', 'Notifs'); ?>:</strong> <?php echo esc_html($t->post_title); ?> is due soon.</p>
                        <small>2 hours ago</small>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="notif-item">
                <span class="dashicons dashicons-admin-users"></span>
                <div class="notif-content">
                    <p><?php echo orbis_t('welcome_notif', 'Welcome to Orbis!', 'مرحباً بك في أوربيس!', 'Notifs'); ?> explore your new workspace.</p>
                    <small>1 day ago</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.notif-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.notif-list { display: flex; flex-direction: column; gap: 10px; }
.notif-item { background: #fff; padding: 15px 20px; border-radius: 10px; display: flex; gap: 15px; align-items: center; border: 1px solid #eee; }
.notif-item.unread { border-left: 4px solid var(--orbis-primary); background: #f0f7ff; }
.notif-content p { margin: 0; font-size: 14px; }
.notif-content small { color: #888; font-size: 12px; }
</style>
