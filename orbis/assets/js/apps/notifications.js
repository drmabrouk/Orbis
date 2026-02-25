(function($) { 'use strict'; $(function() { $(document).on('orbis_app_switched', function(e, app) { if (app === 'notifications') { console.log('notifications initialized'); } }); }); })(jQuery);
