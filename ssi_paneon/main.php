<?php
//Notwendig damit - bei einem Reload alle JS-Elemente geladen werden (ssi_form2/)
unset ( $_SESSION ['set_js'] );

echo "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//DE\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"de\" xml:lang=\"de\">
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<title>SSI - Faktura</title>
<head>
$style_contnet
<script type=\"text/javascript\" src=\"../ssi_form2/js/jquery.select/js/jquery.selectric.min.js\"></script>
<link rel='stylesheet' type='text/css' href='../ssi_form2/js/jquery.select/selectric.css' />
<link rel=stylesheet type='text/css' href='../css/center.css'>
<link rel=stylesheet type='text/css' href='../css/css.css'>
<link rel=stylesheet type='text/css' href='css/main.css'>
<link rel=stylesheet type='text/css' href='css/font.css'>
</head>
<body>
<button id=faktur_resize_button>Menü anzeigen</button>
<button id=faktur_resize_button_hide>Menü verstecken</button>
$main_menu
<table border=0 class='main' cellpadding=0 cellspacing=0>
<tr>
<td valign=top class=td_menu_left><div id=faktura_menu>$menu</div></td>
<td valign=top class=td_menu_right><br><br><div class='set_content'>$content</div></td>
</tr>
</table>
</body>
</html>";
?>