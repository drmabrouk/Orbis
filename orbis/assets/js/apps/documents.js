(function($) { 'use strict'; $(function() { $(document).on('orbis_app_switched', function(e, app) { if (app === 'documents') { console.log('documents initialized'); } }); }); })(jQuery);
