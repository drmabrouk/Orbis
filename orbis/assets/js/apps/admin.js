(function($) { 'use strict'; $(function() { $(document).on('orbis_app_switched', function(e, app) { if (app === 'admin') { console.log('admin initialized'); } }); }); })(jQuery);
