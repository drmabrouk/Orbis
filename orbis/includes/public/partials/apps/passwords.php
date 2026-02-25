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

<style>
.orbis-vault-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
.orbis-vault-card { background: #fff; border-radius: 12px; padding: 20px; box-shadow: var(--orbis-shadow); border: 1px solid #eee; }
.vault-header { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; }
.vault-body p { margin: 5px 0; font-size: 14px; }
.vault-password-wrap { display: flex; align-items: center; gap: 10px; background: #f8fafc; padding: 5px 10px; border-radius: 6px; }
.vault-password-wrap code { flex-grow: 1; overflow: hidden; text-overflow: ellipsis; }
.vault-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px; }
.vault-actions .dashicons { cursor: pointer; color: #888; }
.vault-actions .dashicons:hover { color: var(--orbis-primary); }
</style>
