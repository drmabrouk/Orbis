<?php
/**
 * Unified Authentication Interface
 */
?>

<div class="orbis-auth-overlay">
    <div class="orbis-auth-container">

        <!-- Login View -->
        <div id="orbis-auth-login" class="orbis-auth-box active">
            <div class="orbis-auth-header">
                <h2>Login to Orbis</h2>
            </div>
            <form action="<?php echo esc_url( wp_login_url() ); ?>" method="post">
                <div class="orbis-auth-form-group">
                    <label for="user_login">Username or Email</label>
                    <input type="text" name="log" id="user_login" required>
                </div>
                <div class="orbis-auth-form-group">
                    <label for="user_pass">Password</label>
                    <input type="password" name="pwd" id="user_pass" required>
                </div>
                <input type="hidden" name="redirect_to" value="<?php echo esc_url( site_url('orbis-dashboard') ); ?>">
                <button type="submit" class="orbis-auth-submit">Login</button>
            </form>
            <div class="orbis-auth-footer">
                <p><a href="#" class="orbis-switch-auth" data-target="forgot">Forgot Password?</a></p>
                <p>Don't have an account? <a href="#" class="orbis-switch-auth" data-target="register">Register</a></p>
            </div>
        </div>

        <!-- Register View (Multi-step) -->
        <div id="orbis-auth-register" class="orbis-auth-box">
            <div class="orbis-auth-header">
                <h2>Create Account</h2>
            </div>
            <div class="orbis-progress-bar"><div class="orbis-progress-fill"></div></div>

            <form id="orbis-registration-form" method="post">
                <?php wp_nonce_field( 'orbis_register_nonce', 'orbis_register_nonce_field' ); ?>

                <!-- Step 1: Account Credentials -->
                <div id="orbis-reg-step-1" class="orbis-reg-step active">
                    <p class="orbis-step-guide">Step 1: Set up your account access.</p>
                    <div class="orbis-auth-form-group">
                        <label for="reg_email">Email Address</label>
                        <input type="email" name="user_email" id="reg_email" required>
                    </div>
                    <div class="orbis-auth-form-group">
                        <label for="reg_pass">Password</label>
                        <input type="password" name="user_pass" id="reg_pass" required>
                    </div>
                    <div class="orbis-auth-form-group">
                        <label for="reg_pass_confirm">Confirm Password</label>
                        <input type="password" name="user_pass_confirm" id="reg_pass_confirm" required>
                    </div>
                    <button type="button" class="orbis-auth-submit orbis-next-step">Next Step</button>
                </div>

                <!-- Step 2: Personal Information -->
                <div id="orbis-reg-step-2" class="orbis-reg-step">
                    <p class="orbis-step-guide">Step 2: Tell us about yourself.</p>
                    <div class="orbis-auth-form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" required>
                    </div>
                    <div class="orbis-auth-form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" required>
                    </div>
                    <div class="orbis-auth-form-group">
                        <label for="pref_lang">Preferred Language</label>
                        <select name="pref_lang" id="pref_lang">
                            <option value="en">English</option>
                            <option value="ar">Arabic</option>
                        </select>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <button type="button" class="orbis-auth-submit orbis-prev-step" style="background:#888;">Back</button>
                        <button type="button" class="orbis-auth-submit orbis-next-step">Next Step</button>
                    </div>
                </div>

                <!-- Step 3: Terms & Agreement -->
                <div id="orbis-reg-step-3" class="orbis-reg-step">
                    <p class="orbis-step-guide">Step 3: Finalize your registration.</p>
                    <div class="orbis-auth-form-group">
                        <label style="display:flex; align-items: center; gap: 10px; font-weight: normal;">
                            <input type="checkbox" name="terms_agree" id="terms_agree" required style="width: auto;">
                            I agree to the Terms & Conditions
                        </label>
                    </div>
                    <div id="orbis-reg-message"></div>
                    <div style="display:flex; gap:10px;">
                        <button type="button" class="orbis-auth-submit orbis-prev-step" style="background:#888;">Back</button>
                        <button type="submit" class="orbis-auth-submit">Register Now</button>
                    </div>
                </div>
            </form>

            <div class="orbis-auth-footer">
                <p>Already have an account? <a href="#" class="orbis-switch-auth" data-target="login">Login</a></p>
            </div>
        </div>

        <!-- Forgot Password View -->
        <div id="orbis-auth-forgot" class="orbis-auth-box">
            <div class="orbis-auth-header">
                <h2>Reset Password</h2>
            </div>
            <form action="<?php echo esc_url( wp_lostpassword_url() ); ?>" method="post">
                <div class="orbis-auth-form-group">
                    <label for="user_login_lost">Username or Email</label>
                    <input type="text" name="user_login" id="user_login_lost" required>
                </div>
                <button type="submit" class="orbis-auth-submit">Get New Password</button>
            </form>
            <div class="orbis-auth-footer">
                <p><a href="#" class="orbis-switch-auth" data-target="login">Back to Login</a></p>
            </div>
        </div>

    </div>
</div>
