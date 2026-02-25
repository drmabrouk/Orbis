(function($) {
    'use strict';

    $(function() {
        const $container = $('.orbis-auth-container');
        if (!$container.length) return;

        // Switch between views
        $('.orbis-switch-auth').on('click', function(e) {
            e.preventDefault();
            const target = $(this).data('target');
            $('.orbis-auth-box').removeClass('active');
            $(`#orbis-auth-${target}`).addClass('active');
        });

        // Multi-step registration
        let currentStep = 1;
        const totalSteps = 3;

        $('.orbis-next-step').on('click', function() {
            if (validateStep(currentStep)) {
                $(`#orbis-reg-step-${currentStep}`).removeClass('active');
                currentStep++;
                $(`#orbis-reg-step-${currentStep}`).addClass('active');
                updateProgress();
            }
        });

        $('.orbis-prev-step').on('click', function() {
            $(`#orbis-reg-step-${currentStep}`).removeClass('active');
            currentStep--;
            $(`#orbis-reg-step-${currentStep}`).addClass('active');
            updateProgress();
        });

        function updateProgress() {
            const percentage = (currentStep / totalSteps) * 100;
            $('.orbis-progress-fill').css('width', percentage + '%');
        }

        function validateStep(step) {
            let valid = true;
            $(`#orbis-reg-step-${step} input[required], #orbis-reg-step-${step} select[required]`).each(function() {
                if (!$(this).val() || ($(this).attr('type') === 'checkbox' && !$(this).is(':checked'))) {
                    $(this).css('border-color', 'red');
                    if (!$(this).next('.orbis-error-msg').length) {
                        $(this).after('<span class="orbis-error-msg" style="color:red; font-size:12px; display:block;">This field is required.</span>');
                    }
                    valid = false;
                } else {
                    $(this).css('border-color', '#ddd');
                    $(this).next('.orbis-error-msg').remove();
                }
            });

            // Password match validation in Step 1
            if (step === 1) {
                const pass = $('#reg_pass').val();
                const confirm = $('#reg_pass_confirm').val();
                if (pass && confirm && pass !== confirm) {
                    $('#reg_pass_confirm').css('border-color', 'red');
                    if (!$('#reg_pass_confirm').next('.orbis-error-msg').length) {
                        $('#reg_pass_confirm').after('<span class="orbis-error-msg" style="color:red; font-size:12px; display:block;">Passwords do not match.</span>');
                    }
                    valid = false;
                }
            }

            return valid;
        }

        // Real-time validation
        $('.orbis-auth-container input').on('input change', function() {
            if ($(this).val() || ($(this).attr('type') === 'checkbox' && $(this).is(':checked'))) {
                $(this).css('border-color', '#ddd');
                $(this).next('.orbis-error-msg').remove();
            }
        });

        // AJAX Registration
        $('#orbis-registration-form').on('submit', function(e) {
            e.preventDefault();
            if (!validateStep(3)) return;

            const $form = $(this);
            const $msg = $('#orbis-reg-message');
            const data = $form.serialize() + '&action=orbis_register_user';

            $msg.html('<p style="color:blue;">Registering...</p>');

            $.post(orbis_params.ajax_url, data, function(response) {
                if (response.success) {
                    $msg.html('<p style="color:green;">' + response.data.message + '</p>');
                    setTimeout(function() {
                        window.location.href = orbis_params.dashboard_url;
                    }, 2000);
                } else {
                    $msg.html('<p style="color:red;">' + response.data.message + '</p>');
                }
            });
        });
    });

})(jQuery);
