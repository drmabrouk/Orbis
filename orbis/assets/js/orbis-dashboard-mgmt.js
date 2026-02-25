(function($) {
    'use strict';

    $(function() {

        // App Switching Logic (SPA-like)
        function switchApp(appSlug) {
            $('.orbis-app-view').removeClass('active');
            $('.orbis-sidebar-nav li').removeClass('active');

            if (appSlug === 'launchpad') {
                $('#orbis-launchpad').addClass('active');
                $('.orbis-sidebar-nav li').first().addClass('active');
            } else {
                $(`#orbis-app-${appSlug}`).addClass('active');
                $(`.orbis-sidebar-nav a[data-app="${appSlug}"]`).parent().addClass('active');
            }

            // Scroll to top of content
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

            $.post(orbis_params.ajax_url, data, function(response) {
                if (response.success) {
                    $msg.html('<p style="color:green;">' + response.data.message + '</p>');
                    // Live update title if visible
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
            const data = $(this).serialize() + '&action=orbis_save_translations';

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
