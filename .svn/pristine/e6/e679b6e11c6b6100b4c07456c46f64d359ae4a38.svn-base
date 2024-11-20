<?php
session_start ();
error_reporting(E_ALL ^  E_NOTICE);
if (! empty ( $_SERVER ['HTTPS'] ))
	$http_host = "https://" . $_SERVER ['HTTP_HOST'] . "/";
else
	$http_host = "http://" . $_SERVER ['HTTP_HOST'] . "/";

if (isset($_GET ['openDir'])) {
	$_SESSION ['openDir'] = $_GET ['openDir'];
} else
	$_SESSION ['openDir'] = '';

if ($_GET ['id']) {
	$_SESSION ['gadget_id'] = $_GET ['id'];
} else
	$_SESSION ['gadget_id'] = '';
	
	
?>
<!DOCTYPE HTML>
<html lang="de">
<head>
<meta charset="utf-8">
<title>SSI-Finder</title>
<link rel='stylesheet' type='text/css' href='../ssi_smart/smart_form/semantic/dist/semantic.min.css'>
<link rel='stylesheet' type='text/css' href='../ssi_smart/smart_form/jquery-ui/jquery-ui.min.css'>
<link rel="stylesheet" href="js/gallery/css/blueimp-gallery.min.css">
<link rel="stylesheet" href="js/contextmenu/dist/font-awesome.min.css">
<link rel="stylesheet" href="js/contextmenu/dist/jquery.contextMenu.css">
<link rel="stylesheet" href="../ssi_smart/smart_form/jquery-upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="js/pnotify/pnotify.custom.min.css">
<link rel="stylesheet" href="js/croppie.css">
<link rel="stylesheet" href="css/style.css">

<!-- <link  href="cropper/cropper.css" rel="stylesheet"> -->
<!-- <script src="cropper/cropper.js"></script> -->
<!-- <script src="cropper/jquery-cropper.js"></script> -->

<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript>
	<link rel="stylesheet"
		href="../ssi_smart/smart_form/jquery-upload/css/jquery.fileupload-noscript.css">
</noscript>
<noscript>
	<link rel="stylesheet"
		href="../ssi_smart/smart_form/jquery-upload/css/jquery.fileupload-ui-noscript.css">
</noscript>
</head>
<body>
	<!-- The file upload form used as target for the file upload widget -->
	<div id="fileupload" method="POST" enctype="multipart/form-data">
		<div class='message ui' id=container_folder style='display: none'></div>

		<div class="block_uploader" style='display: none'>
			<div style='float: left'>
				<a class='ui icon button' href='' title='Inhalt laden'><i class='icon refresh'></i></a>
				<!--  <a class='ui icon button' onclick='reload_finder()' href=# title='Inhalt laden'><i class='icon refresh'></i></a>-->
				<input type="file" name="files[]" id="file" class="inputfile" multiple /> <label
					title='Hier klicken zum hochladen von Dateien' class="button icon ui green" for="file"><i
					class='icon upload'></i> Dateien hochladen</label>
			</div>
			<!--<button type="button" class="button ui delete">Löschen</button> -->
			<!--<input type="checkbox" class="ui checkbox toggle"> -->
			<!--<div style='float: right'><a class='ui icon button' onclick='' href=# title='Fenster Schließen'>Schließen <i class='remove icon'></i></a></div>-->
			<div style='clear: both'></div>

		</div>
		<br>

		<!-- The table listing the files available for upload/download -->

		<div class="ui cards files" id='container_files'></div>
	</div>

	<!-- The blueimp Gallery widget -->
	<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even"
		style='display: none'>
		<div class="slides"></div>
		<h3 class="title"></h3>
		<a class="prev">‹</a> <a class="next">›</a> <a class="close">×</a> <a class="play-pause"></a>
		<ol class="indicator"></ol>
	</div>

	<!-- 	Modal for edit image -->
	<div class='ui large modal' id='edit_explorer'>
		<i class='close icon'></i>
		<div class='content'></div>
	</div>

	<script type='text/javascript' src='../ssi_smart/smart_form/jquery-ui/jquery.min.js'></script>
	<script type='text/javascript' src='../ssi_smart/smart_form/jquery-ui/jquery-ui.min.js'></script>
	<script type='text/javascript' src="../ssi_smart/smart_form/semantic/dist/semantic.min.js"></script>
	<script type='text/javascript' src="js/contextmenu/dist/jquery.contextMenu.min.js"></script>
	<script type='text/javascript' src='js/js.cookie.js'></script>
	<script type='text/javascript' src='js/pnotify/pnotify.custom.min.js'></script>

	<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
	<script src="../ssi_smart/smart_form/jquery-upload/js/vendor/jquery.ui.widget.js"></script>

	<!-- The Templates plugin is included to render the upload/download listings -->
	<script src="../ssi_smart/smart_form/jquery-upload/js/tmpl.min.js"></script>
	<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
	<script src="../ssi_smart/smart_form/jquery-upload/js/load-image.min.js"></script>
	<!-- The Canvas to Blob plugin is included for image resizing functionality -->
	<script src="../ssi_smart/smart_form/jquery-upload/js/canvas-to-blob.min.js"></script>

	<!-- blueimp Gallery script -->
	<script src="js/gallery/js/jquery.blueimp-gallery.min.js"></script>

	<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
	<!-- The Canvas to Blob plugin is included for image resizing functionality -->
	<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>

	<script src="../ssi_smart/smart_form/jquery-upload/js/jquery.iframe-transport.js"></script>
	<!-- The basic File Upload plugin -->
	<script src="../ssi_smart/smart_form/jquery-upload/js/jquery.fileupload.js"></script>
	<!-- The File Upload processing plugin -->
	<script src="../ssi_smart/smart_form/jquery-upload/js/jquery.fileupload-process.js"></script>
	<!-- The File Upload image preview & resize plugin -->
	<script src="../ssi_smart/smart_form/jquery-upload/js/jquery.fileupload-image.js"></script>
	<!-- The File Upload audio preview plugin -->
	<script src="../ssi_smart/smart_form/jquery-upload/js/jquery.fileupload-audio.js"></script>
	<!-- The File Upload video preview plugin -->
	<script src="../ssi_smart/smart_form/jquery-upload/js/jquery.fileupload-video.js"></script>
	<!-- The File Upload validation plugin -->
	<script src="../ssi_smart/smart_form/jquery-upload/js/jquery.fileupload-validate.js"></script>
	<!-- The File Upload user interface plugin -->
	<script src="../ssi_smart/smart_form/jquery-upload/js/jquery.fileupload-ui.js"></script>

	<script type='text/javascript'>var http_host = '<?=$http_host?>';</script>
	<script type='text/javascript'>var gadget_id = '<?=$_SESSION['gadget_id']?>';</script>
	<script src="js/finder_main.js"></script>
<!-- 	<script src="../ssi_smart/admin/js/functions_smart.js"></script> -->

	<script src="../ssi_smart/smart_form/ckeditor/ckeditor.js"></script>
	<script src="../ssi_smart/smart_form/ckeditor/adapters/jquery.js"></script>

	<script src="js/croppie.js"></script>



	<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
	<!--[if (gte IE 8)&(lt IE 10)]>
	<script src="jquery-upload/js/cors/jquery.xdr-transport.js"></script>
	<![endif]-->

	<!-- The template to display files available for upload -->
	<script id="template-upload" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
	<div class="card template-upload fade">   
	 	<div class='content'><div align=center><div class="preview"></div><br>{%=file.name%}</div>
		<div class='extra'>
		{% if (!i && !o.options.autoUpload) { %}<button class="button ui start" disabled>Start</button>{% } %}
        {% if (!i) { %}<button class="button ui cancel">Abbrechen</button>{% } %}
		</div>
	</div>
	{% } %}
	</script>
	<!-- The template to display files available for download -->
	<script id="template-download" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) {   rnd_id = i+'-'+Math.floor((Math.random() * 100000000000000) + 1);  %}
	
		<div style="width:180px;" class="card  card_draggable template-download fade"  >
		<?
		if ($_GET ['gadget'] and $_GET ['gadget'] != 'undefined') {
			echo "{% if (file.thumbnailUrl) { %}<a style='display:flex; text-align:center; height:140px; overflow:hidden' class='tooltip' style='cursor:pointer' title=\"{%=file.name%}\" onclick=\"SaveFilePhoto('{$_GET['id']}','{$_GET['gadget']}','{%=file.url%}')\" ><img id='img_thumb{%=rnd_id%}' style='max-height:150px; height:auto; width:auto; margin:auto;' src=\"{%=file.thumbnailUrl%}\"></a>{% } %}";
		} else if ($_GET ['id']) {
			echo "{% if (file.thumbnailUrl) { %}<a style='display:flex; text-align:center; height:140px; overflow:hidden' class='tooltip' style='cursor:pointer' title=\"{%=file.name%}\" onclick=\"OpenFileSmart('{$_GET['id']}','{%=file.url%}')\" ><img id='img_thumb{%=rnd_id%}' style='max-height:150px; height:auto; width:auto; margin:auto;' src=\"{%=file.thumbnailUrl%}\"></a>{% } %}";
		} else if ($_GET ['CKEditor']) {
			echo "{% if (file.thumbnailUrl) { %}<a style='display:flex; text-align:center; height:140px; overflow:hidden' class='tooltip' style='cursor:pointer' title=\"{%=file.name%}\" onclick=\"OpenFile('{%=file.url%}')\" ><img id='img_thumb{%=rnd_id%}' style='max-height:150px; height:auto; width:auto; margin:auto;' src=\"{%=file.thumbnailUrl%}\"></a>{% } %}";
		} else {
			// echo "{% if (file.thumbnailUrl) { %}<a style='text-align:center; height:140px; width:100%; overflow:hidden' class='image tooltip' href=\"{%=file.url%}\" data-html=\"<div align=center><img style='max-height:140px; height:auto; width:auto; max-width:190px;' src='{%=file.thumbnailUrl%}'><br>{%=file.name%}<br>{%=o.formatFileSize(file.size)%}</div>\" download=\"{%=file.name%}\" data-gallery><div align=center><img style='max-height:140px; height:auto; width:auto; max-width:190px;' src=\"{%=file.thumbnailUrl%}\"></div></a>{% } %}";
			echo "{% if (file.thumbnailUrl) { %}";
			echo "<a style='display:flex; text-align:center; height:140px; overflow:hidden' class='tooltip' id='img_link{%=rnd_id%}' href=\"{%=file.url%}\" data-html=\"{%=file.name%}<br>Dateigröße:{%=o.formatFileSize(file.size)%}\" download=\"{%=file.name%}\" data-gallery><img id='img_thumb{%=rnd_id%}' style='max-height:150px; height:auto; width:auto; margin:auto;' src=\"{%=file.thumbnailUrl%}\"></a>";
			echo "{% } %}";
		}
		?>
		{% if (file.error) { %}<div class='content'><div align=center><i class='icon warning big red sign'></i></div><br>{%=file.name%}<br>{%=file.error%}</div>{% } %}
		{% if (!file.thumbnailUrl && !file.error){ %} {%=call_format_icon(file.name,rnd_id)%} <a class='content tooltip' href='{%=file.url%}' target='new' title="{%=file.name%}"><div align=center><br><div id='data_icon{%=rnd_id%}'></div></div></a> {% } %}
		{% if (!file.error) { %}
			<?
			echo "<div class='ui bottom attached mini buttons' >";
			echo "<a class='ui button icon delete' title='Datei löschen' data-type='{%=file.deleteType%}' data-url='{%=file.deleteUrl%}'{% if (file.deleteWithCredentials) { %} data-xhr-fields='{withCredentials:true}'{% } %}><i class='trash icon'></i></a>";
			echo "{% if (file.thumbnailUrl) { %}";
			echo "<a class='ui button icon' title='Rotation nach rechts' onclick=\"rotateImg('{%=file.name%}','right','{%=rnd_id%}')\"><i class='undo icon'></i></a>";
			echo "<a class='ui button icon' title='Rotation nach links' onclick=\"rotateImg('{%=file.name%}','left','{%=rnd_id%}')\"><i class='redo icon'></i></a>";
			echo "{% } %}";

			// echo "<a href='#' class='ui basic compact button mini icon move_file' id={%=rnd_id%} title='Verschieben'><i class='arrows alternate icon'></i></a>";
			echo "<a href='#' class='ui button icon blue' title='Datei bearbeiten' onclick=\"callDescribePicForm('{%=file.name%}')\"><i class='write icon'></i></a>";

			if ($_GET ['gadget'] == 'photo') {
				echo "<a title='Datei verlinken' class='ui button icon tooltip' onclick=\"SaveFilePhoto('{$_GET['id']}','{$_GET['gadget']}','{%=file.url%}')\" ><i class='icon linkify'></i></a>";
			} else if ($_GET ['gadget'] and $_GET ['gadget'] != undefined) {} else if ($_GET ['id']) {
				echo "<a title='Datei verlinken' class='ui button icon tooltip' onclick=\"OpenFileSmart('{$_GET['id']}','{%=file.url%}')\"><i class='ui icon linkify'></i></a>";
			} else if ($_GET ['CKEditor']) {
				echo "<a title='Datei verlinken' class='ui button icon tooltip' onclick=\"OpenFile('{%=file.url%}')\"><i class='ui icon linkify'></i></a>";
			}
			?>
		{% } %}
		
		</div>
		</div>
	{% } %}
	</script>

	<div id=content_no_data></div>
	<div class=dialog></div>
</body>
</html>