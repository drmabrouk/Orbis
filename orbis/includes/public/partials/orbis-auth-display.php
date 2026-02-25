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

            <form action="<?php echo esc_url( wp_registration_url() ); ?>" method="post">
                <!-- Step 1: Account Info -->
                <div id="orbis-reg-step-1" class="orbis-reg-step active">
                    <p class="orbis-step-guide">Step 1: Choose your unique username and provide a valid email.</p>
                    <div class="orbis-auth-form-group">
                        <label for="reg_user">Username</label>
                        <input type="text" name="user_login" id="reg_user" required>
                    </div>
                    <div class="orbis-auth-form-group">
                        <label for="reg_email">Email</label>
                        <input type="email" name="user_email" id="reg_email" required>
                    </div>
                    <button type="button" class="orbis-auth-submit orbis-next-step">Next Step</button>
                </div>

                <!-- Step 2: Personal Details -->
                <div id="orbis-reg-step-2" class="orbis-reg-step">
                    <p class="orbis-step-guide">Step 2: Tell us a bit about yourself to personalize your workspace.</p>
                    <div class="orbis-auth-form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name">
                    </div>
                    <div class="orbis-auth-form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name">
                    </div>
                    <div style="display:flex; gap:10px;">
                        <button type="button" class="orbis-auth-submit orbis-prev-step" style="background:#888;">Back</button>
                        <button type="button" class="orbis-auth-submit orbis-next-step">Next Step</button>
                    </div>
                </div>

                <!-- Step 3: Confirmation -->
                <div id="orbis-reg-step-3" class="orbis-reg-step">
                    <p>Click "Register" to create your personal workspace.</p>
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
