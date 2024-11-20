<?php
include ('../config.inc.php');
//include ('../../ssi_smart/smart_form/fu_filelist.php');

include ('../../ssi_smart/smart_form/include_form.php');
$id = $_POST['update_id'];

$arr['sql'] = array ( 'query' => "SELECT * from session where session_id = '$id'" );
$arr['field']['title'] = array ('type'=>'content', 'text'=>"<h3 class='ui header'>{data}</h3>");
$arr['field']['text'] = array('type'=>'html');
$arr['field']['img_url'] = array (
		'type' => 'gallery',
		'file_dir' => "$upload_dir/$id/",
		'file_url' => "$upload_url/$id/" ,
		'accept' => array('png','jpg','jpeg','pdf'),
		'card_class' => 'five' );
$output = call_form ( $arr );

echo $output['html']."<br>";
echo "<br><br><br><div class='ui label bottom attached'><div align=right><div class='button blue ui' onclick='$(\"#modal_view\").modal(\"hide\");'>Schließen</div></div>";
