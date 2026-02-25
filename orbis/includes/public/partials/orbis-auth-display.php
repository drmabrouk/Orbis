<?php
/**
 * Unified Authentication Interface
 */
$lang = $GLOBALS['orbis_translator']->get_current_language();
?>

<div class="orbis-auth-overlay" <?php if ($lang === 'ar') echo 'dir="rtl"'; ?>>
    <div class="orbis-auth-container">

        <!-- Login View -->
        <div id="orbis-auth-login" class="orbis-auth-box active">
            <div class="orbis-auth-header">
                <h2><?php echo orbis_t('login_title', 'Login to Orbis', 'تسجيل الدخول إلى أوربيس', 'Auth'); ?></h2>
            </div>
            <form action="<?php echo esc_url( wp_login_url() ); ?>" method="post">
                <div class="orbis-auth-form-group">
                    <label for="user_login"><?php echo orbis_t('username_email', 'Username or Email', 'اسم المستخدم أو البريد الإلكتروني', 'Auth'); ?></label>
                    <input type="text" name="log" id="user_login" required>
                </div>
                <div class="orbis-auth-form-group">
                    <label for="user_pass"><?php echo orbis_t('password', 'Password', 'كلمة المرور', 'Auth'); ?></label>
                    <input type="password" name="pwd" id="user_pass" required>
                </div>
                <input type="hidden" name="redirect_to" value="<?php echo esc_url( site_url('orbis-dashboard') ); ?>">
                <button type="submit" class="orbis-auth-submit"><?php echo orbis_t('login_btn', 'Login', 'تسجيل الدخول', 'Auth'); ?></button>
            </form>
            <div class="orbis-auth-footer">
                <p><a href="#" class="orbis-switch-auth" data-target="forgot"><?php echo orbis_t('forgot_pass', 'Forgot Password?', 'هل نسيت كلمة المرور؟', 'Auth'); ?></a></p>
                <p><?php echo orbis_t('no_account', "Don't have an account?", 'ليس لديك حساب؟', 'Auth'); ?> <a href="#" class="orbis-switch-auth" data-target="register"><?php echo orbis_t('register_link', 'Register', 'سجل الآن', 'Auth'); ?></a></p>
            </div>
        </div>

        <!-- Register View (Multi-step) -->
        <div id="orbis-auth-register" class="orbis-auth-box">
            <div class="orbis-auth-header">
                <h2><?php echo orbis_t('create_account', 'Create Account', 'إنشاء حساب', 'Auth'); ?></h2>
            </div>
            <div class="orbis-progress-bar"><div class="orbis-progress-fill"></div></div>

            <form id="orbis-registration-form" method="post">
                <?php wp_nonce_field( 'orbis_register_nonce', 'orbis_register_nonce_field' ); ?>

                <!-- Step 1: Account Credentials -->
                <div id="orbis-reg-step-1" class="orbis-reg-step active">
                    <p class="orbis-step-guide"><?php echo orbis_t('reg_step1_guide', 'Step 1: Set up your account access.', 'الخطوة 1: قم بإعداد الوصول إلى حسابك.', 'Auth'); ?></p>
                    <div class="orbis-auth-form-group">
                        <label for="reg_email"><?php echo orbis_t('email_address', 'Email Address', 'البريد الإلكتروني', 'Auth'); ?></label>
                        <input type="email" name="user_email" id="reg_email" required>
                    </div>
                    <div class="orbis-auth-form-group">
                        <label for="reg_pass"><?php echo orbis_t('reg_password', 'Password', 'كلمة المرور', 'Auth'); ?></label>
                        <input type="password" name="user_pass" id="reg_pass" required>
                    </div>
                    <div class="orbis-auth-form-group">
                        <label for="reg_pass_confirm"><?php echo orbis_t('confirm_password', 'Confirm Password', 'تأكيد كلمة المرور', 'Auth'); ?></label>
                        <input type="password" name="user_pass_confirm" id="reg_pass_confirm" required>
                    </div>
                    <button type="button" class="orbis-auth-submit orbis-next-step"><?php echo orbis_t('next_step', 'Next Step', 'الخطوة التالية', 'Auth'); ?></button>
                </div>

                <!-- Step 2: Personal Information -->
                <div id="orbis-reg-step-2" class="orbis-reg-step">
                    <p class="orbis-step-guide"><?php echo orbis_t('reg_step2_guide', 'Step 2: Tell us about yourself.', 'الخطوة 2: أخبرنا عن نفسك.', 'Auth'); ?></p>
                    <div class="orbis-auth-form-group">
                        <label for="first_name"><?php echo orbis_t('first_name', 'First Name', 'الاسم الأول', 'Auth'); ?></label>
                        <input type="text" name="first_name" id="first_name" required>
                    </div>
                    <div class="orbis-auth-form-group">
                        <label for="last_name"><?php echo orbis_t('last_name', 'Last Name', 'اسم العائلة', 'Auth'); ?></label>
                        <input type="text" name="last_name" id="last_name" required>
                    </div>
                    <div class="orbis-auth-form-group">
                        <label for="pref_lang"><?php echo orbis_t('preferred_lang', 'Preferred Language', 'اللغة المفضلة', 'Auth'); ?></label>
                        <select name="pref_lang" id="pref_lang">
                            <option value="en">English</option>
                            <option value="ar">Arabic</option>
                        </select>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <button type="button" class="orbis-auth-submit orbis-prev-step" style="background:#888;"><?php echo orbis_t('back', 'Back', 'رجوع', 'Auth'); ?></button>
                        <button type="button" class="orbis-auth-submit orbis-next-step"><?php echo orbis_t('next_step', 'Next Step', 'الخطوة التالية', 'Auth'); ?></button>
                    </div>
                </div>

                <!-- Step 3: Terms & Agreement -->
                <div id="orbis-reg-step-3" class="orbis-reg-step">
                    <p class="orbis-step-guide"><?php echo orbis_t('reg_step3_guide', 'Step 3: Finalize your registration.', 'الخطوة 3: اللمسات الأخيرة.', 'Auth'); ?></p>
                    <div class="orbis-auth-form-group">
                        <label style="display:flex; align-items: center; gap: 10px; font-weight: normal;">
                            <input type="checkbox" name="terms_agree" id="terms_agree" required style="width: auto;">
                            <?php echo orbis_t('terms_agreement', 'I agree to the Terms & Conditions', 'أوافق على الشروط والأحكام', 'Auth'); ?>
                        </label>
                    </div>
                    <div id="orbis-reg-message"></div>
                    <div style="display:flex; gap:10px;">
                        <button type="button" class="orbis-auth-submit orbis-prev-step" style="background:#888;"><?php echo orbis_t('back', 'Back', 'رجوع', 'Auth'); ?></button>
                        <button type="submit" class="orbis-auth-submit"><?php echo orbis_t('register_now', 'Register Now', 'سجل الآن', 'Auth'); ?></button>
                    </div>
                </div>
            </form>

            <div class="orbis-auth-footer">
                <p><?php echo orbis_t('have_account', 'Already have an account?', 'لديك حساب بالفعل؟', 'Auth'); ?> <a href="#" class="orbis-switch-auth" data-target="login"><?php echo orbis_t('login_link', 'Login', 'تسجيل الدخول', 'Auth'); ?></a></p>
            </div>
        </div>

        <!-- Forgot Password View -->
        <div id="orbis-auth-forgot" class="orbis-auth-box">
            <div class="orbis-auth-header">
                <h2><?php echo orbis_t('reset_pass_title', 'Reset Password', 'إعادة تعيين كلمة المرور', 'Auth'); ?></h2>
            </div>
            <form action="<?php echo esc_url( wp_lostpassword_url() ); ?>" method="post">
                <div class="orbis-auth-form-group">
                    <label for="user_login_lost"><?php echo orbis_t('username_email', 'Username or Email', 'اسم المستخدم أو البريد الإلكتروني', 'Auth'); ?></label>
                    <input type="text" name="user_login" id="user_login_lost" required>
                </div>
                <button type="submit" class="orbis-auth-submit"><?php echo orbis_t('get_new_pass', 'Get New Password', 'احصل على كلمة مرور جديدة', 'Auth'); ?></button>
            </form>
            <div class="orbis-auth-footer">
                <p><a href="#" class="orbis-switch-auth" data-target="login"><?php echo orbis_t('back_login', 'Back to Login', 'العودة لتسجيل الدخول', 'Auth'); ?></a></p>
            </div>
        </div>

    </div>
</div>
