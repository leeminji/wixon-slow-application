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
		<script src="/include/lib/elFinder-2.x/js/elfinder.full.js"></script>
		<script type="text/javascript" charset="utf-8">
		
		elFinder.prototype.commands.custom = function() {
			this.getstate = function() {
				return 0;
			};
			
			this.exec = function(hashes) {
				var files   = this.files(hashes);
				if (! files.length) {
					files   = this.files([ this.fm.cwd().hash ]);
				}
				var self    = this;
				var	fm      = this.fm;
				var	cnt     = files.length;

				if (!cnt) {
					return $.Deferred().reject();
				}

				if (cnt == 1) {
					file  = files[0];	
					var view  = fm.mime2class(file.mime);	
					var path = fm.escape(fm.path(file.hash, true));
					var win = window.open("/MsOneDrive/drives?drive_id=99116f6714f2c07b&path="+path, "win", "width=500,height=600");
					win.focus();
				}
			};
		};

		var i18nPath = 'js/i18n';
		var elfinder_start = function(lng) {
			$(document).ready(function() {
				var elf = $('#elfinder').elfinder({
					// Documentation for client options:
					// https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
					lang : lng,
					soundPath: '/include/lib/elFinder-2.x/sounds',
					height: 470,
					url : '/modules/elfinder_mod/elfinder_<?php echo $mid;?>', // connector URL (REQUIRED)
					commands : [
						'custom', 'open', 'reload','home','up','back','forward','getfile','download','mkdir', 'mkfile', 'upload','edit','search','info'
					],
					contextmenu : {
						// navbarfolder menu
						navbar : ['open', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'info'],
						// current directory menu
						cwd    : ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'sort', '|', 'info'],
						// current directory file menu
						files  : ['getfile', '|', 'custom', 'quicklook', '|', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'edit', 'rename', 'resize', '|', 'archive', 'extract', '|', 'info']									
					}
				}).elfinder('instance');
			});
		};

		var loct = window.location.search;
		var full_lng;
		var locm;
		var lng;

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
				elfinder_start(lng);
			})
			.fail(function() {
				elfinder_start('en');
			});
		} else {
			elfinder_start(lng);
		}
		</script>
	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>


