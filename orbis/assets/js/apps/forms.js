(function($) {
    'use strict';

    window.OrbisForms = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            $('.orbis-preview-form').on('click', function() {
                const id = $(this).data('id');
                const title = $(this).data('title');
                $('#orbis-preview-form-id').val(id);
                $('#orbis-form-preview-title').text(title);
                $('#orbis-form-preview-modal').fadeIn();
            });

            $('#orbis-public-form-submit').on('submit', function(e) {
                e.preventDefault();
                const $msg = $('#orbis-form-submit-msg');
                $msg.html('<p style="color:blue;">Submitting...</p>');

                const data = $(this).serialize() + '&action=orbis_submit_form&nonce=' + orbis_params.nonce;
                $.post(orbis_params.ajax_url, data, (response) => {
                    if (response.success) {
                        $msg.html('<p style="color:green;">' + response.data.message + '</p>');
                        setTimeout(() => $('.orbis-modal').fadeOut(), 2000);
                    }
                });
            });
        }
    };

    $(function() {
        if ($('.orbis-app-forms').length) window.OrbisForms.init();
    });

})(jQuery);
