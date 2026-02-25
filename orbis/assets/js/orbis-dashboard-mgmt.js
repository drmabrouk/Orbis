(function($) {
    'use strict';

    $(function() {

        // App Switching Logic (SPA-like)
        function switchApp(appSlug) {
            const $target = (appSlug === 'launchpad') ? $('#orbis-launchpad') : $(`#orbis-app-${appSlug}`);

            $('.orbis-app-view').fadeOut(200, function() {
                $('.orbis-app-view').removeClass('active');
                $('.orbis-sidebar-nav li').removeClass('active');

                if (appSlug === 'launchpad') {
                    $('#orbis-launchpad').fadeIn(300).addClass('active');
                    $('.orbis-sidebar-nav li').first().addClass('active');
                } else {
                    $target.fadeIn(300).addClass('active');
                    $(`.orbis-sidebar-nav a[data-app="${appSlug}"]`).parent().addClass('active');

                    // Show loading state if needed
                    $target.find('.orbis-app-content').append('<div class="orbis-loading-overlay"><div class="orbis-spinner"></div></div>');

                    // Global notification for apps to init
                    $(document).trigger('orbis_app_switched', [appSlug]);

                    setTimeout(() => $target.find('.orbis-loading-overlay').fadeOut(), 400);
                }
            });

            $('.orbis-master-content').animate({ scrollTop: 0 }, 'fast');
        }

        // Click on Tile
        $('.orbis-app-tile').on('click', function() {
            const app = $(this).data('app');
            switchApp(app);
        });

        // Click on Sidebar Link
        $('.orbis-app-link').on('click', function(e) {
            e.preventDefault();
            const app = $(this).data('app');
            switchApp(app);
        });

        // Back to Launchpad button
        $('.orbis-back-to-launchpad').on('click', function() {
            switchApp('launchpad');
        });

        // Site Settings Saving (AJAX)
        $('#orbis-site-settings-form').on('submit', function(e) {
            e.preventDefault();
            const $msg = $('#orbis-admin-mgmt-msg');
            const data = $(this).serialize() + '&action=orbis_save_site_settings&nonce=' + orbis_params.nonce;

            $msg.html('<p style="color:blue;">Saving settings...</p>');

            $.post(orbis_params.ajax_url, data, function(response) {
                if (response.success) {
                    $msg.html('<p style="color:green;">' + response.data.message + '</p>');
                    $('.orbis-site-title').text($('input[name="orbis_site_title"]').val());
                } else {
                    $msg.html('<p style="color:red;">' + response.data.message + '</p>');
                }
            });
        });

        // Translation Saving (AJAX)
        $('#orbis-translations-form').on('submit', function(e) {
            e.preventDefault();
            const $msg = $('#orbis-admin-mgmt-msg');
            const data = $(this).serialize() + '&action=orbis_save_translations&nonce=' + orbis_params.nonce;

            $msg.html('<p style="color:blue;">Saving translations...</p>');

            $.post(orbis_params.ajax_url, data, function(response) {
                if (response.success) {
                    $msg.html('<p style="color:green;">' + response.data.message + '</p>');
                } else {
                    $msg.html('<p style="color:red;">' + response.data.message + '</p>');
                }
            });
        });

        // Translation Search
        $('#orbis-translation-search').on('keyup', function() {
            const val = $(this).val().toLowerCase();
            $('.orbis-translation-row').each(function() {
                const text = $(this).text().toLowerCase();
                $(this).toggle(text.indexOf(val) > -1);
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
