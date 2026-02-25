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
            $(`#orbis-reg-step-${step} input[required]`).each(function() {
                if (!$(this).val()) {
                    $(this).css('border-color', 'red');
                    if (!$(this).next('.orbis-error-msg').length) {
                        $(this).after('<span class="orbis-error-msg" style="color:red; font-size:12px;">This field is required.</span>');
                    }
                    valid = false;
                } else {
                    $(this).css('border-color', '#ddd');
                    $(this).next('.orbis-error-msg').remove();
                }
            });
            return valid;
        }

        // Real-time validation
        $('.orbis-auth-container input').on('input', function() {
            if ($(this).val()) {
                $(this).css('border-color', '#ddd');
                $(this).next('.orbis-error-msg').remove();
            }
        });
    });

})(jQuery);
