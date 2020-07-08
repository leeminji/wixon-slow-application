<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta charset="utf-8">
		<title>elFinder 2.1.x source version with PHP connector</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />

		<!-- jQuery and jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" href="/include/lib/elFinder-2.x/css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" href="/include/lib/elFinder-2.x/css/theme.css">

		<!-- elFinder JS (REQUIRED) -->
		<script src="/include/lib/elFinder-2.x/js/elfinder.min.js"></script>
		<script type="text/javascript" charset="utf-8">
			(function($){
				var i18nPath = 'js/i18n',
					start = function(lng) {
						$().ready(function() {
							var elf = $('#elfinder').elfinder({
								// Documentation for client options:
								// https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
								lang : lng,
								//url : '/modules/elfinder_mod/elfinder_init/<?php echo $mid;?>' // connector URL (REQUIRED)
								soundPath: '/include/lib/elFinder-2.x/sounds',
								height: 470,
								url : '/modules/elfinder_mod/elfinder_<?php echo $mid;?>' // connector URL (REQUIRED)
							}).elfinder('instance');
						});
					},
					loct = window.location.search,
					full_lng, locm, lng;

				// detect language
				if (loct && (locm = loct.match(/lang=([a-zA-Z_-]+)/))) {
					full_lng = locm[1];
				} else {
					full_lng = (navigator.browserLanguage || navigator.language || navigator.userLanguage);
				}
				lng = full_lng.substr(0,2);
				if (lng == 'ja') lng = 'jp';
				else if (lng == 'pt') lng = 'pt_BR';
				else if (lng == 'zh') lng = (full_lng.substr(0,5) == 'zh-tw')? 'zh_TW' : 'zh_CN';

				if (lng != 'en') {
					$.ajax({
						url : '/include/lib/elFinder-2.x/'+i18nPath+'/elfinder.'+lng+'.js',
						cache : true,
						dataType : 'script'
					})
					.done(function() {
						start(lng);
					})
					.fail(function() {
						start('en');
					});
				} else {
					start(lng);
				}
			})(jQuery);
		</script>
	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>


