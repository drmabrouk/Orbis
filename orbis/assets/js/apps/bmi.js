(function($) {
    'use strict';

    window.OrbisBMI = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            $('#orbis-bmi-form').on('submit', function(e) {
                e.preventDefault();
                const h = parseFloat($('#orbis-bmi-height').val()) / 100;
                const w = parseFloat($('#orbis-bmi-weight').val());
                const bmi = (w / (h * h)).toFixed(1);

                let cat = '', color = '';
                if (bmi < 18.5) { cat = 'Underweight'; color = '#3498db'; }
                else if (bmi < 25) { cat = 'Normal'; color = '#2ecc71'; }
                else if (bmi < 30) { cat = 'Overweight'; color = '#f1c40f'; }
                else { cat = 'Obese'; color = '#e74c3c'; }

                $('#orbis-bmi-val').text(bmi);
                $('#orbis-bmi-category').text(cat).css('color', color);
                $('#orbis-bmi-meter-fill').css({'width': Math.min(bmi * 2, 100) + '%', 'background': color});
                $('#orbis-bmi-result').fadeIn();

                $.post(orbis_params.ajax_url, {
                    action: 'orbis_save_bmi',
                    nonce: orbis_params.nonce,
                    bmi: bmi,
                    category: cat
                });
            });
        }
    };

    $(function() {
        if ($('#orbis-bmi-form').length) window.OrbisBMI.init();
    });

})(jQuery);
