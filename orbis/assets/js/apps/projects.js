(function($) { 'use strict'; $(function() { $(document).on('orbis_app_switched', function(e, app) { if (app === 'projects') { console.log('projects initialized'); } }); }); })(jQuery);
