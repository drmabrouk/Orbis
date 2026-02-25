(function($) {
    'use strict';

    window.OrbisImages = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            $('#orbis-upload-image-btn').on('click', function(e) {
                e.preventDefault();
                const frame = wp.media({
                    title: 'Upload or Select Images',
                    button: { text: 'Add to Orbis Storage' },
                    multiple: true
                });

                frame.on('select', function() {
                    const selections = frame.state().get('selection');
                    selections.map(attachment => {
                        const data = attachment.toJSON();
                        $('#orbis-gallery-grid').prepend(`<div class="orbis-image-tile"><img src="${data.sizes.thumbnail ? data.sizes.thumbnail.url : data.url}"></div>`);
                    });
                });

                frame.open();
            });
        }
    };

    $(function() {
        if ($('#orbis-upload-image-btn').length) window.OrbisImages.init();
    });

})(jQuery);
