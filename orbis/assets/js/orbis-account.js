(function($) {
    'use strict';

    $(function() {
        const $msg = $('#orbis-account-message');
        const nonce = $('#orbis_account_nonce').val();

        // Export Data
        $('#orbis-export-account').on('click', function() {
            if (!confirm('This will export all your data as a JSON file. Proceed?')) return;

            $msg.html('<p style="color:blue;">Generating export...</p>');

            $.post(orbis_auth_params.ajax_url, {
                action: 'orbis_export_data',
                orbis_account_nonce: nonce
            }, function(response) {
                if (response.success) {
                    $msg.html('<p style="color:green;">' + response.data.message + '</p>');

                    // Create download link
                    const blob = new Blob([response.data.data], { type: 'application/json' });
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = response.data.filename;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                } else {
                    $msg.html('<p style="color:red;">' + response.data.message + '</p>');
                }
            });
        });

        // Reset Account
        $('#orbis-reset-account').on('click', function() {
            if (!confirm('WARNING: This will delete all your notes, tasks, projects, and custom settings. THIS CANNOT BE UNDONE. Are you absolutely sure?')) return;
            if (!confirm('Please confirm once more: Do you really want to reset your account?')) return;

            $msg.html('<p style="color:blue;">Resetting account...</p>');

            $.post(orbis_auth_params.ajax_url, {
                action: 'orbis_reset_account',
                orbis_account_nonce: nonce
            }, function(response) {
                if (response.success) {
                    $msg.html('<p style="color:green;">' + response.data.message + '</p>');
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    $msg.html('<p style="color:red;">' + response.data.message + '</p>');
                }
            });
        });

        // Delete Account
        $('#orbis-delete-account').on('click', function() {
            if (!confirm('ULTIMATE WARNING: This will PERMANENTLY DELETE your entire account and all associated data. This action is irreversible. Proceed?')) return;
            const confirmation = prompt('To confirm deletion, please type "DELETE" below:');

            if (confirmation !== 'DELETE') {
                alert('Deletion cancelled: Incorrect confirmation string.');
                return;
            }

            $msg.html('<p style="color:blue;">Deleting account...</p>');

            $.post(orbis_auth_params.ajax_url, {
                action: 'orbis_delete_account',
                orbis_account_nonce: nonce
            }, function(response) {
                if (response.success) {
                    alert('Your account has been deleted. You will now be redirected.');
                    window.location.href = orbis_auth_params.home_url;
                } else {
                    $msg.html('<p style="color:red;">' + response.data.message + '</p>');
                }
            });
        });
    });

})(jQuery);
