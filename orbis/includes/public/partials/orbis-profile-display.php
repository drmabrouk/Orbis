<?php
/**
 * User Profile Editor
 */
$current_user = wp_get_current_user();
$user_id = $current_user->ID;

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

<div class="orbis-profile-editor">
    <h2>Edit Profile</h2>
    <form id="orbis-profile-form" method="post" enctype="multipart/form-data">
        <?php wp_nonce_field( 'orbis_profile_update', 'orbis_profile_nonce' ); ?>

        <div class="orbis-profile-section">
            <h3>Basic Information</h3>
            <div class="orbis-auth-form-group">
                <label>Profile Picture</label>
                <?php if ( $profile_pic ) : ?>
                    <img src="<?php echo esc_url( $profile_pic ); ?>" style="width:100px; height:100px; border-radius:50%; display:block; margin-bottom:10px;">
                <?php endif; ?>
                <input type="file" name="orbis_profile_pic" accept="image/*">
            </div>
            <div class="orbis-auth-form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $current_user->first_name ); ?>">
            </div>
            <div class="orbis-auth-form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $current_user->last_name ); ?>">
            </div>
            <div class="orbis-auth-form-group">
                <label for="display_name">Username</label>
                <input type="text" value="<?php echo esc_attr( $current_user->user_login ); ?>" disabled>
            </div>
            <div class="orbis-auth-form-group">
                <label for="email">Email Address</label>
                <input type="email" name="user_email" id="email" value="<?php echo esc_attr( $current_user->user_email ); ?>">
            </div>
            <div class="orbis-auth-form-group">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" value="<?php echo esc_attr( $phone ); ?>">
            </div>
        </div>

        <div class="orbis-profile-section">
            <h3>Location & Bio</h3>
            <div class="orbis-auth-form-group">
                <label for="country">Country</label>
                <input type="text" name="country" id="country" value="<?php echo esc_attr( $country ); ?>">
            </div>
            <div class="orbis-auth-form-group">
                <label for="bio">Bio / About Me</label>
                <textarea name="bio" id="bio" rows="4" style="width:100%; border: 1px solid #ddd; border-radius:6px;"><?php echo esc_textarea( $bio ); ?></textarea>
            </div>
        </div>

        <div class="orbis-profile-section">
            <h3>Social Media</h3>
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
            <h3>Notification Preferences</h3>
            <div class="orbis-auth-form-group">
                <label><input type="checkbox" name="notif_email" value="1" <?php checked( $notif_email, '1' ); ?>> Email Notifications</label>
            </div>
            <div class="orbis-auth-form-group">
                <label><input type="checkbox" name="notif_inapp" value="1" <?php checked( $notif_inapp, '1' ); ?>> In-App Notifications</label>
            </div>
        </div>

        <div class="orbis-profile-section">
            <h3>Security</h3>
            <div class="orbis-auth-form-group">
                <label for="new_password">New Password (leave blank to keep current)</label>
                <input type="password" name="new_password" id="new_password">
            </div>
        </div>

        <div id="orbis-profile-message"></div>
        <button type="submit" name="orbis_save_profile" class="orbis-auth-submit">Save Changes</button>
    </form>

    <div class="orbis-profile-section" style="margin-top: 50px; border-top: 2px solid #ff4d4d; padding-top: 20px;">
        <h3 style="color: #ff4d4d;">Account Management</h3>
        <p>Warning: Some of these actions are irreversible. We recommend backing up your data first.</p>

        <div class="orbis-account-actions" style="display: flex; gap: 15px; flex-wrap: wrap;">
            <button id="orbis-export-account" class="orbis-auth-submit" style="background: #4caf50; width: auto;">Backup & Export Data</button>
            <button id="orbis-reset-account" class="orbis-auth-submit" style="background: #ff9800; width: auto;">Reset Account Settings</button>
            <button id="orbis-delete-account" class="orbis-auth-submit" style="background: #f44336; width: auto;">Delete Account Permanently</button>
        </div>
        <div id="orbis-account-message" style="margin-top: 15px;"></div>
        <?php wp_nonce_field( 'orbis_account_action', 'orbis_account_nonce' ); ?>
    </div>
</div>

<style>
.orbis-profile-section { margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
.orbis-profile-section h3 { margin-top: 0; color: #007cba; }
</style>
