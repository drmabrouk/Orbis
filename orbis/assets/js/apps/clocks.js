(function($) {
    'use strict';

    window.OrbisClocks = {
        init: function() {
            this.updateClocks();
            setInterval(() => this.updateClocks(), 1000);
        },

        updateClocks: function() {
            $('.orbis-clock-card').each(function() {
                const tz = $(this).data('timezone');
                const now = new Date();

                try {
                    const timeStr = now.toLocaleTimeString('en-US', { timeZone: tz, hour12: false });
                    const dateStr = now.toLocaleDateString('en-US', { timeZone: tz, year: 'numeric', month: 'short', day: 'numeric' });

                    $(this).find('.orbis-clock-time').text(timeStr);
                    $(this).find('.orbis-clock-date').text(dateStr);
                } catch (e) {
                    console.error("Invalid timezone:", tz);
                }
            });
        }
    };

    $(function() {
        if ($('.orbis-app-clocks').length) window.OrbisClocks.init();
    });

})(jQuery);
