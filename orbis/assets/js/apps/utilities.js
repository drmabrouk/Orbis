(function($) {
    'use strict';

    window.OrbisUtilities = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            $('#orbis-convert-curr').on('click', () => {
                const amount = $('#orbis-curr-amount').val();
                const from = $('#orbis-curr-from').val();
                const to = $('#orbis-curr-to').val();

                // Mock rates
                const rates = { 'USD-SAR': 3.75, 'SAR-USD': 0.27, 'EUR-USD': 1.08, 'USD-EUR': 0.92, 'EUR-SAR': 4.05, 'SAR-EUR': 0.25 };
                const key = `${from}-${to}`;
                const rate = rates[key] || 1;
                const result = (amount * rate).toFixed(2);

                $('#orbis-curr-result').text(`${amount} ${from} = ${result} ${to}`);
            });

            $('#orbis-convert-unit').on('click', () => {
                const val = $('#orbis-unit-val').val();
                const type = $('#orbis-unit-type').val();
                let result = 0;
                let unit = '';

                switch(type) {
                    case 'km-mi': result = val * 0.621371; unit = 'Miles'; break;
                    case 'mi-km': result = val / 0.621371; unit = 'KM'; break;
                    case 'kg-lb': result = val * 2.20462; unit = 'Lbs'; break;
                    case 'lb-kg': result = val / 2.20462; unit = 'Kg'; break;
                }

                $('#orbis-unit-result').text(`${result.toFixed(2)} ${unit}`);
            });
        }
    };

    $(function() {
        if ($('.orbis-app-utilities').length) window.OrbisUtilities.init();
    });

})(jQuery);
