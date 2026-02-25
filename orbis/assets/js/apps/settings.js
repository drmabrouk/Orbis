(function($) {
    'use strict';

    window.OrbisSettings = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            const nonce = $('#orbis_account_nonce').val();

            $('#orbis-export-account').on('click', function() {
                if (!confirm('Export data as JSON?')) return;
                $.post(orbis_params.ajax_url, { action: 'orbis_export_data', orbis_account_nonce: nonce }, (response) => {
                    if (response.success) {
                        const blob = new Blob([response.data.data], { type: 'application/json' });
                        const a = document.createElement('a');
                        a.href = window.URL.createObjectURL(blob);
                        a.download = response.data.filename;
                        a.click();
                    }
                });
            });

            $('#orbis-reset-account').on('click', function() {
                if (!confirm('Reset account?')) return;
                $.post(orbis_params.ajax_url, { action: 'orbis_reset_account', orbis_account_nonce: nonce }, () => window.location.reload());
            });

            $('#orbis-delete-account').on('click', function() {
                if (confirm('Permanently delete account?') && prompt('Type DELETE to confirm') === 'DELETE') {
                    $.post(orbis_params.ajax_url, { action: 'orbis_delete_account', orbis_account_nonce: nonce }, () => window.location.href = orbis_params.home_url);
                }
            });
        }
    };

    $(function() {
        if ($('.orbis-profile-editor').length) window.OrbisSettings.init();
    });

})(jQuery);
