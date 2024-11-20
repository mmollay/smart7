<?php
include ('../../login/config_main.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

$name = $_POST['name'];
$folder = $_SESSION['FOLDER_PATH_RELATIVE'];
$image_path_server = "{$_SESSION ['HTTP_SERVER_FOLDER']}/$name";
$image_path = $_SESSION['HTTP_HOST_FOLDER'] . $name;

$strTitle = "Titel";
$strDescription = "Beschreibung";
$strSave = "Speichern";
$strClose = "Schließen";

$query = $GLOBALS['mysqli']->query ( "SELECT * FROM smart_explorer WHERE name='$name' AND folder = '$folder'" );
$array2 = mysqli_fetch_array ( $query );
$finder_id = $array2['finder_id'];
$title = $array2['title'];
$text = $array2['text'];
$link = $array2['link'];
$style = $array2['style'];
$style_align = $array2['style_align'];
$style_width = $array2['style_width'];
$link_intern = $array2['link_intern'];
$target = $array2['target'];

$query = $GLOBALS['mysqli']->query ( "SELECT * FROM smart_langSite INNER JOIN smart_id_site2id_page ON site_id = fk_id where page_id = '{$_SESSION['smart_page_id']}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
while ( $array = mysqli_fetch_array ( $query ) ) {
	$id = $array['site_id'];
	$array_link_intern[$id] = $array['title'];
}

//$image_edit = "<a onclick=\"$('.my-image').croppie('bind')\">Check</a>";

// $image_edit = "<img id='image' src='$image_path'>";
// $image_edit .= "
// <script>
// $('#image').cropper({
//   aspectRatio: 16 / 9,
//   crop: function(event) {
//     console.log(event.detail.x);
//     console.log(event.detail.y);
//     console.log(event.detail.width);
//     console.log(event.detail.height);
//     console.log(event.detail.rotate);
//     console.log(event.detail.scaleX);
//     console.log(event.detail.scaleY);
//   }
// });
// </script>";

$image_edit .= "
<div class='message ui'>
<div id='my-image'></div>
<div align = center>
<button type=button class='ui button blue icon upload-result'><i class='icon save'></i>Speichern</button>
<button type=button class='ui button icon vanilla-result'><i class='icon eye'></i>Vorschau</button>
<button type=button class='ui button icon vanilla-rotate' data-deg='-90'><i class='icon undo'></i></button>
<button type=button class='ui button icon vanilla-rotate' data-deg='90'><i class='icon repeat'></i></button>
</div>
<div class='ui modal' id='modal_show_image'>
<i class='close icon'></i>
<div class='content' align =center><img src='' id='show_image_src'>
</div>
<div class='actions'>
<div class='ui cancel button load'>Schließen</div>
</div>
</div>
</div>
";

$arr['tab'] = array ( 'tabs' => [ "first" => "Stammdaten" , "sec" => "Bildgröße bearbeiten" , "thi" => "Bildausschnitt erzeugen" ] );

// Bildgröße ausgeben Wenn es sich um ein solches handelt
if (exif_imagetype ( $image_path_server )) {
	$size = getimagesize ( $image_path_server );
	$datei_groesse_byte = filesize ( $image_path_server );
	$datei_groesse_kilobyte = ($datei_groesse_byte / 1024);
	$datei_groesse_kilobyte_gerundet = round ( $datei_groesse_kilobyte );
	
	$arr['field'][] = array ( 'tab' => 'sec' , 'class' => 'ui message' , 'type' => 'content' , 'text' => 'Zum Bild verkleinern, Höhe <b>oder</b> Breite angeben, das Bild wird dann in der richtigen Relation erzeugt.' );
	$arr['field'][] = array ( 'tab' => 'sec' , 'type' => 'div' , 'class' => 'fields two' );
	$arr['field']['img_width'] = array ( 'tab' => 'sec' , 'label' => 'Breite' , 'type' => 'input' , 'value' => $size[0] ,  'label_right' => 'px' );
	$arr['field']['img_height'] = array ( 'tab' => 'sec' , 'label' => 'Höhe' , 'type' => 'input' , 'value' => $size[1] ,  'label_right' => 'px' );
	$arr['field'][] = array ( 'tab' => 'sec' , 'type' => 'div_close' );
	$arr['field']['new_image'] = array ( 'tab' => 'sec' , 'label' => 'als neues Bild speichern' , 'type' => 'checkbox' );
}

$pathinfo = pathinfo($image_path);
$extension = $pathinfo['extension'];
$filename = $pathinfo['filename'];

$arr['field'][] = array ( 'tab' => 'thi' , 'type' => 'content' ,  'text' => "$image_edit" );

$arr['form'] = array ( 'tab' => 'first' , 'id' => 'form_name' , 'size' => 'small' , 'action' => 'ajax/pic_details2.php' );
$arr['field'][] = array ( 'tab' => 'first' , 'type' => 'div' , 'class' => 'fields two' );
$arr['field']['name_new'] = array ( 'tab' => 'first' , 'label' => 'Datei-Name' , 'info' => '' , 'value' => $filename , 'placeholder' => $strTitle , 'type' => 'input' ,  'validate' => true, 'label_right' => ".".$extension );
$arr['field']['title'] = array ( 'tab' => 'first' , 'label' => 'Titel' , 'placeholder' => $strTitle , 'type' => 'input' ,  'focus' => true , 'value' => $title , 'info' => 'Titel des Bildes wird je nach Darstellung unterschiedlich aussgegeben.' );
$arr['field'][] = array ( 'tab' => 'first' , 'tab' => 'first' , 'type' => 'div_close' );
$arr['field']['text'] = array ( 'tab' => 'first' , 'placeholder' => $strDescription , 'type' => 'ckeditor' , 'style' => 'height:150px' , 'value' => $text );

$arr['field'][] = array ( 'tab' => 'first' ,  'tab' => 'first' , 'type' => 'div' , 'class' => 'ui message' );
$arr['field'][] = array ( 'tab' => 'first' ,  'tab' => 'first' , 'type' => 'div' , 'class' => 'fields 	two' );
$arr['field']['style_align'] = array ( 'tab' => 'first' , 'label' => "Ausrichtung" , "type" => "select" , 'array' => array ( 'left' => 'links' , 'center' => 'mittig' , 'right' => 'rechts' ) , 'value' => $style_align );
$arr['field']['style_width'] = array ( 'tab' => 'first' , 'label' => "Breite" , "type" => "input" , 'value' => $style_width );
$arr['field'][] = array ( 'tab' => 'first' ,  'type'=>'div_close');
$arr['field']['style'] = array ( 'tab' => 'first' , 'label' => 'Style (css)' , 'placeholder' => 'width:100px;' , 'type' => 'input', 'value' => $style , 'info' => 'Style vom Textfeld für das Bilderkarusel' );
$arr['field'][] = array ( 'tab' => 'first' ,  'type'=>'div_close');

$arr['field'][] = array ( 'tab' => 'first' , 'type' => 'div' , 'class' => 'fields two' );
$arr['field']['link'] = array ( 'tab' => 'first' , 'label' => 'Link' , 'class' => 'ten wide' , 'type' => 'input' , 'placeholder' => 'http://' , 'value' => $link );
$arr['field']['link_intern'] = array ( 'tab' => 'first' , 'label' => 'oder' , 'class' => 'search' , 'type' => 'dropdown' , 'value' => $link_intern , 'array' => $array_link_intern , 'placeholder' => '--Interne Seite wählen--','clear' => true );
$arr['field'][] = array ( 'tab' => 'first' , 'type' => 'div_close' );
$arr['field']['target'] = array ( 'tab' => 'first' , 'label' => 'Link in neuer Seite öffnen',  'type' => 'checkbox' , 'value' => $target );

$arr['button']['submit'] = array ( 'value' => $strSave , 'color' => 'blue' );
$arr['button']['close'] = array ( 'value' => $strClose ,  'js' => "$('#edit_explorer').modal('hide');" );
// $arr['hidden']['update_id'] = $_POST['update_id'];
$arr['hidden']['name'] = $name;
$arr['hidden']['finder_id'] = $finder_id;
$arr['ajax'] = array (  'dataType' => "script" );

$output = call_form ( $arr );

echo $output['html'];
echo $output['js'];
echo "<script>$('.top.menu .item#thi').tab({'onVisible':function(){ call_croppie('$image_path','$name'); }});</script>";

//echo $add_js .= "<script type=\"text/javascript\" src=\"js/form_edit.js\"></script>";