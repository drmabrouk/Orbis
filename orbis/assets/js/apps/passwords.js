(function($) {
    'use strict';

    window.OrbisPasswords = {
        init: function() {
            this.load();
            this.bindEvents();
        },

        load: function() {
            const $list = $('#orbis-vault-list');
            if (!$list.length) return;

            $.post(orbis_params.ajax_url, {
                action: 'orbis_get_passwords',
                nonce: orbis_params.nonce
            }, (response) => {
                if (response.success) {
                    let html = '';
                    response.data.forEach(entry => {
                        html += `
                            <div class="orbis-vault-card" data-id="${entry.id}">
                                <div class="vault-header">
                                    <span class="dashicons dashicons-admin-links"></span>
                                    <strong>${entry.url || 'No URL'}</strong>
                                </div>
                                <div class="vault-body">
                                    <p>User: <strong>${entry.username}</strong></p>
                                    <div class="vault-password-wrap">
                                        <code class="pass-val">••••••••</code>
                                        <span class="dashicons dashicons-visibility orbis-reveal-pass" data-pass="${entry.password}"></span>
                                    </div>
                                    <p><small>${entry.notes}</small></p>
                                </div>
                                <div class="vault-actions">
                                    <span class="dashicons dashicons-trash orbis-delete-pass"></span>
                                </div>
                            </div>
                        `;
                    });
                    $list.html(html || '<p>Vault is empty.</p>');
                }
            });
        },

        bindEvents: function() {
            const self = this;
            $('#orbis-new-password-btn').on('click', () => $('#orbis-password-modal').fadeIn());

            $(document).on('click', '.orbis-reveal-pass', function() {
                const pass = $(this).data('pass');
                const $code = $(this).prev('.pass-val');
                if ($code.text() === '••••••••') { $code.text(pass); $(this).removeClass('dashicons-visibility').addClass('dashicons-hidden'); }
                else { $code.text('••••••••'); $(this).removeClass('dashicons-hidden').addClass('dashicons-visibility'); }
            });

            $('#orbis-password-form').on('submit', function(e) {
                e.preventDefault();
                $.post(orbis_params.ajax_url, $(this).serialize() + '&action=orbis_save_password&nonce=' + orbis_params.nonce, () => {
                    $('#orbis-password-modal').fadeOut();
                    self.load();
                });
            });

            $(document).on('click', '.orbis-delete-pass', function() {
                if (!confirm('Delete entry?')) return;
                const id = $(this).closest('.orbis-vault-card').data('id');
                $.post(orbis_params.ajax_url, {
                    action: 'orbis_delete_password',
                    pass_id: id,
                    nonce: orbis_params.nonce
                }, () => self.load());
            });
        }
    };

    $(function() {
        if ($('#orbis-vault-list').length) window.OrbisPasswords.init();
    });

})(jQuery);
