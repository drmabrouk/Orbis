<?php
/**
 * User Profile Editor
 */
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$lang = $GLOBALS['orbis_translator']->get_current_language();

// Fetch meta
$phone = get_user_meta( $user_id, 'orbis_phone', true );
$bio = get_user_meta( $user_id, 'description', true );
$country = get_user_meta( $user_id, 'orbis_country', true );
$timezone = get_user_meta( $user_id, 'orbis_timezone', true );
$social_fb = get_user_meta( $user_id, 'orbis_social_fb', true );
$social_tw = get_user_meta( $user_id, 'orbis_social_tw', true );
$notif_email = get_user_meta( $user_id, 'orbis_notif_email', true );
$notif_inapp = get_user_meta( $user_id, 'orbis_notif_inapp', true );
$profile_pic = get_user_meta( $user_id, 'orbis_profile_pic', true );
?>

<div class="orbis-profile-editor" <?php if ($lang === 'ar') echo 'dir="rtl"'; ?>>
    <h2><?php echo orbis_t('edit_profile', 'Edit Profile', 'تعديل الملف الشخصي', 'Profile'); ?></h2>
    <form id="orbis-profile-form" method="post" enctype="multipart/form-data">
        <?php wp_nonce_field( 'orbis_profile_update', 'orbis_profile_nonce' ); ?>

        <div class="orbis-profile-section">
            <h3><?php echo orbis_t('basic_info', 'Basic Information', 'معلومات أساسية', 'Profile'); ?></h3>
            <div class="orbis-auth-form-group">
                <label><?php echo orbis_t('profile_pic', 'Profile Picture', 'الصورة الشخصية', 'Profile'); ?></label>
                <?php if ( $profile_pic ) : ?>
                    <img src="<?php echo esc_url( $profile_pic ); ?>" style="width:100px; height:100px; border-radius:50%; display:block; margin-bottom:10px;">
                <?php endif; ?>
                <input type="file" name="orbis_profile_pic" accept="image/*">
            </div>
            <div class="orbis-auth-form-group">
                <label for="first_name"><?php echo orbis_t('first_name', 'First Name', 'الاسم الأول', 'Auth'); ?></label>
                <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $current_user->first_name ); ?>">
            </div>
            <div class="orbis-auth-form-group">
                <label for="last_name"><?php echo orbis_t('last_name', 'Last Name', 'اسم العائلة', 'Auth'); ?></label>
                <input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $current_user->last_name ); ?>">
            </div>
            <div class="orbis-auth-form-group">
                <label for="display_name"><?php echo orbis_t('username', 'Username', 'اسم المستخدم', 'Auth'); ?></label>
                <input type="text" value="<?php echo esc_attr( $current_user->user_login ); ?>" disabled>
            </div>
            <div class="orbis-auth-form-group">
                <label for="email"><?php echo orbis_t('email_address', 'Email Address', 'البريد الإلكتروني', 'Auth'); ?></label>
                <input type="email" name="user_email" id="email" value="<?php echo esc_attr( $current_user->user_email ); ?>">
            </div>
            <div class="orbis-auth-form-group">
                <label for="phone"><?php echo orbis_t('phone_number', 'Phone Number', 'رقم الهاتف', 'Profile'); ?></label>
                <input type="text" name="phone" id="phone" value="<?php echo esc_attr( $phone ); ?>">
            </div>
        </div>

        <div class="orbis-profile-section">
            <h3><?php echo orbis_t('location_bio', 'Location & Bio', 'الموقع والسيرة الذاتية', 'Profile'); ?></h3>
            <div class="orbis-auth-form-group">
                <label for="country"><?php echo orbis_t('country', 'Country', 'البلد', 'Profile'); ?></label>
                <input type="text" name="country" id="country" value="<?php echo esc_attr( $country ); ?>">
            </div>
            <div class="orbis-auth-form-group">
                <label for="bio"><?php echo orbis_t('bio', 'Bio / About Me', 'نبذة عني', 'Profile'); ?></label>
                <textarea name="bio" id="bio" rows="4" style="width:100%; border: 1px solid #ddd; border-radius:6px;"><?php echo esc_textarea( $bio ); ?></textarea>
            </div>
        </div>

        <div class="orbis-profile-section">
            <h3><?php echo orbis_t('social_media', 'Social Media', 'وسائل التواصل الاجتماعي', 'Profile'); ?></h3>
            <div class="orbis-auth-form-group">
                <label for="social_fb">Facebook URL</label>
                <input type="url" name="social_fb" id="social_fb" value="<?php echo esc_url( $social_fb ); ?>">
            </div>
            <div class="orbis-auth-form-group">
                <label for="social_tw">Twitter URL</label>
                <input type="url" name="social_tw" id="social_tw" value="<?php echo esc_url( $social_tw ); ?>">
            </div>
        </div>

        <div class="orbis-profile-section">
            <h3><?php echo orbis_t('notif_prefs', 'Notification Preferences', 'تفضيلات الإشعارات', 'Profile'); ?></h3>
            <div class="orbis-auth-form-group">
                <label><input type="checkbox" name="notif_email" value="1" <?php checked( $notif_email, '1' ); ?>> <?php echo orbis_t('email_notifs', 'Email Notifications', 'إشعارات البريد الإلكتروني', 'Profile'); ?></label>
            </div>
            <div class="orbis-auth-form-group">
                <label><input type="checkbox" name="notif_inapp" value="1" <?php checked( $notif_inapp, '1' ); ?>> <?php echo orbis_t('inapp_notifs', 'In-App Notifications', 'إشعارات داخل التطبيق', 'Profile'); ?></label>
            </div>
        </div>

        <div class="orbis-profile-section">
            <h3><?php echo orbis_t('security', 'Security', 'الأمان', 'Profile'); ?></h3>
            <div class="orbis-auth-form-group">
                <label for="new_password"><?php echo orbis_t('new_password', 'New Password (leave blank to keep current)', 'كلمة مرور جديدة (اتركها فارغة للاحتفاظ بالحالية)', 'Profile'); ?></label>
                <input type="password" name="new_password" id="new_password">
            </div>
        </div>

        <div id="orbis-profile-message"></div>
        <button type="submit" name="orbis_save_profile" class="orbis-auth-submit"><?php echo orbis_t('save_changes', 'Save Changes', 'حفظ التغييرات', 'Profile'); ?></button>
    </form>

    <div class="orbis-profile-section" style="margin-top: 50px; border-top: 2px solid #ff4d4d; padding-top: 20px;">
        <h3 style="color: #ff4d4d;"><?php echo orbis_t('account_mgmt', 'Account Management', 'إدارة الحساب', 'Profile'); ?></h3>
        <p><?php echo orbis_t('mgmt_warning', 'Warning: Some of these actions are irreversible. We recommend backing up your data first.', 'تحذير: بعض هذه الإجراءات لا يمكن التراجع عنها. نوصي بنسخ بياناتك احتياطياً أولاً.', 'Profile'); ?></p>

        <div class="orbis-account-actions" style="display: flex; gap: 15px; flex-wrap: wrap;">
            <button id="orbis-export-account" class="orbis-auth-submit" style="background: #4caf50; width: auto;"><?php echo orbis_t('backup_export', 'Backup & Export Data', 'النسخ الاحتياطي وتصدير البيانات', 'Profile'); ?></button>
            <button id="orbis-reset-account" class="orbis-auth-submit" style="background: #ff9800; width: auto;"><?php echo orbis_t('reset_account', 'Reset Account Settings', 'إعادة تعيين إعدادات الحساب', 'Profile'); ?></button>
            <button id="orbis-delete-account" class="orbis-auth-submit" style="background: #f44336; width: auto;"><?php echo orbis_t('delete_account_btn', 'Delete Account Permanently', 'حذف الحساب نهائياً', 'Profile'); ?></button>
        </div>
        <div id="orbis-account-message" style="margin-top: 15px;"></div>
        <?php wp_nonce_field( 'orbis_account_action', 'orbis_account_nonce' ); ?>
    </div>
</div>

<style>
.orbis-profile-section { margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
.orbis-profile-section h3 { margin-top: 0; color: #007cba; }
</style>
