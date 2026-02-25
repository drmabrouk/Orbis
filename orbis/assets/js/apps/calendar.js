(function($) { 'use strict'; $(function() { $(document).on('orbis_app_switched', function(e, app) { if (app === 'calendar') { console.log('calendar initialized'); } }); }); })(jQuery);
