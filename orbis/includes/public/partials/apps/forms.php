<?php
/**
 * Forms Application Interface
 */
?>
<div class="orbis-app-forms">
    <div class="orbis-app-toolbar">
        <button id="orbis-create-form-btn" class="button button-primary"><?php echo orbis_t('create_form', 'Create New Form', 'إنشاء نموذج جديد', 'Forms'); ?></button>
    </div>

    <div class="orbis-forms-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        <?php
        $forms = get_posts( array(
            'post_type' => 'orbis_form',
            'author'    => get_current_user_id(),
            'posts_per_page' => -1
        ) );

        if ( $forms ) :
            foreach ( $forms as $f ) :
                $responses = get_posts(array(
                    'post_type' => 'orbis_response',
                    'meta_key' => '_orbis_parent_form',
                    'meta_value' => $f->ID,
                    'posts_per_page' => -1
                ));
                ?>
                <div class="orbis-form-card" style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: var(--orbis-shadow); border: 1px solid #eee;">
                    <h4 style="margin-top:0;"><?php echo esc_html($f->post_title); ?></h4>
                    <div class="form-meta" style="font-size: 13px; color: #666; margin: 15px 0;">
                        <span><span class="dashicons dashicons-email-alt"></span> <?php echo count($responses); ?> <?php echo orbis_t('responses', 'Responses', 'الردود', 'Forms'); ?></span>
                    </div>
                    <div class="form-actions" style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button class="button small"><?php echo orbis_t('view_responses', 'View Responses', 'عرض الردود', 'Forms'); ?></button>
                        <button class="button small orbis-preview-form" data-id="<?php echo $f->ID; ?>" data-title="<?php echo esc_attr($f->post_title); ?>"><?php echo orbis_t('preview', 'Preview', 'معاينة', 'General'); ?></button>
                        <button class="button small" style="color:red;"><?php echo orbis_t('delete', 'Delete', 'حذف', 'General'); ?></button>
                    </div>
                </div>
                <?php
            endforeach;
        else :
            echo '<p>' . orbis_t('no_forms', 'No forms created yet.', 'لم يتم إنشاء نماذج بعد.', 'Forms') . '</p>';
        endif;
        ?>
    </div>

    <!-- Form Preview/Submission Modal -->
    <div id="orbis-form-preview-modal" class="orbis-modal" style="display:none;">
        <div class="orbis-modal-content">
            <span class="orbis-close-modal">&times;</span>
            <h3 id="orbis-form-preview-title"></h3>
            <form id="orbis-public-form-submit">
                <input type="hidden" name="form_id" id="orbis-preview-form-id">
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('name', 'Full Name', 'الاسم الكامل', 'General'); ?></label>
                    <input type="text" name="form_data[name]" required>
                </div>
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('email', 'Email Address', 'البريد الإلكتروني', 'Auth'); ?></label>
                    <input type="email" name="form_data[email]" required>
                </div>
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('message', 'Message / Feedback', 'الرسالة / الملاحظات', 'General'); ?></label>
                    <textarea name="form_data[message]" required></textarea>
                </div>
                <button type="submit" class="orbis-auth-submit"><?php echo orbis_t('submit_response', 'Submit Response', 'إرسال الرد', 'Forms'); ?></button>
                <div id="orbis-form-submit-msg" style="margin-top:15px;"></div>
            </form>
        </div>
    </div>
</div>
