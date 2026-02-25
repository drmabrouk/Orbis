<?php
/**
 * Password Manager Application Interface
 */
?>
<div class="orbis-app-passwords">
    <div class="orbis-app-toolbar">
        <button id="orbis-new-password-btn" class="button button-primary"><?php echo orbis_t('new_entry', 'New Entry', 'إدخال جديد', 'Passwords'); ?></button>
        <input type="text" id="orbis-password-search" placeholder="<?php echo orbis_t('search_vault', 'Search vault...', 'بحث في الخزنة...', 'Passwords'); ?>" class="orbis-search-input">
    </div>

    <div class="orbis-vault-container">
        <div id="orbis-vault-list" class="orbis-vault-grid">
            <!-- Loaded via AJAX -->
            <p><?php echo orbis_t('loading_vault', 'Accessing secure vault...', 'جارٍ الدخول إلى الخزنة الآمنة...', 'Passwords'); ?></p>
        </div>
    </div>

    <!-- Password Modal -->
    <div id="orbis-password-modal" class="orbis-modal" style="display:none;">
        <div class="orbis-modal-content">
            <span class="orbis-close-modal">&times;</span>
            <h3 id="orbis-password-modal-title"><?php echo orbis_t('entry_details', 'Entry Details', 'تفاصيل الإدخال', 'Passwords'); ?></h3>
            <form id="orbis-password-form">
                <input type="hidden" id="orbis-pass-id" name="pass_id">
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('website_url', 'Website URL', 'رابط الموقع', 'Passwords'); ?></label>
                    <input type="url" name="pass_url" id="orbis-pass-url-field" placeholder="https://example.com">
                </div>
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('username', 'Username', 'اسم المستخدم', 'Auth'); ?></label>
                    <input type="text" name="pass_user" id="orbis-pass-user-field" required>
                </div>
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('password', 'Password', 'كلمة المرور', 'Auth'); ?></label>
                    <input type="password" name="pass_val" id="orbis-pass-val-field" required>
                </div>
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('notes', 'Notes', 'ملاحظات', 'General'); ?></label>
                    <textarea name="pass_notes" id="orbis-pass-notes-field"></textarea>
                </div>
                <button type="submit" class="orbis-auth-submit"><?php echo orbis_t('save_to_vault', 'Save to Vault', 'حفظ في الخزنة', 'Passwords'); ?></button>
            </form>
        </div>
    </div>
</div>
