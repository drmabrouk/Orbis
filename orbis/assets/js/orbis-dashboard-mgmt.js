(function($) {
    'use strict';

    $(function() {

        // Tab Switching for Admin Dashboard
        $('.orbis-admin-sidebar a').on('click', function(e) {
            e.preventDefault();
            const tab = $(this).data('tab');

            $('.orbis-admin-sidebar li').removeClass('active');
            $(this).parent().addClass('active');

            $('.orbis-admin-tab-section').removeClass('active');
            $(`#orbis-tab-${tab}`).addClass('active');
        });

        // Site Settings Saving (AJAX)
        $('#orbis-site-settings-form').on('submit', function(e) {
            e.preventDefault();
            const $msg = $('#orbis-admin-mgmt-msg');
            const data = $(this).serialize() + '&action=orbis_save_site_settings';

            $msg.html('<p style="color:blue;">Saving settings...</p>');

            $.post(orbis_auth_params.ajax_url, data, function(response) {
                if (response.success) {
                    $msg.html('<p style="color:green;">' + response.data.message + '</p>');
                    // Live update title if visible
                    $('.orbis-site-title').text($('input[name="orbis_site_title"]').val());
                } else {
                    $msg.html('<p style="color:red;">' + response.data.message + '</p>');
                }
            });
        });

        // Media Library for Logo
        $('#orbis-select-logo').on('click', function(e) {
            e.preventDefault();
            const frame = wp.media({
                title: 'Select or Upload Site Logo',
                button: { text: 'Use this logo' },
                multiple: false
            });

            frame.on('select', function() {
                const attachment = frame.state().get('selection').first().toJSON();
                $('#orbis_site_logo_val').val(attachment.url);
                $('.orbis-logo-preview').html(`<img src="${attachment.url}" style="max-width: 150px; display: block; margin-bottom: 10px;">`);
                // Live update logo in header
                $('.orbis-site-logo').attr('src', attachment.url);
            });

            frame.open();
        });

        // Live Color Update
        $('input[name="orbis_primary_color"]').on('input', function() {
            const color = $(this).val();
            document.documentElement.style.setProperty('--orbis-primary', color);
            $('.orbis-site-title').css('color', color);
        });
    });

})(jQuery);
