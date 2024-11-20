<?php
if ($_POST ['update_id']) {
	// call groups for the User
	$mysql_tag_query = $GLOBALS ['mysqli']->query ( "SELECT * FROM ssi_paneon.report2tag where report_id = '{$_POST['update_id']}' " ); // and activate='1'
	while ( $mysql_tag_fetch = mysqli_fetch_array ( $mysql_tag_query ) ) {
		$tag_id = $mysql_tag_fetch ['tag_id'];
		$tag_name = $mysql_tag_fetch ['title'];
		$tag_color = $mysql_tag_fetch ['color'];
		$tag_selected_array [] = $tag_id;
	}
}

if ($_SESSION ['explorer_folder'] && is_dir ( "../" . $_SESSION ['explorer_folder'] )) {
	include ('../inc/gallery.inc.php');
	$array_folder = array_reverse ( directoryToArray ( "../" . $_SESSION ['explorer_folder'], true, '' ) );
	// echo $_SESSION['explorer_folder'];
}

$arr ['ajax'] = array ('onLoad' => "call_add_tag('tag_id');",'success' => "if (data == 'ok') { $('.ui.modal').modal('hide'); table_reload('report_list'); } else  { alert('Error: f_report.php'); }	",'dataType' => "html" );
//$arr ['tab'] = array ('tabs' => array (1 => 'Allgemeines',2 => 'Erfolgsbericht',3 => 'Antwort',4 => 'Hightlights' ),'active' => '1' );

$arr ['sql'] = array ('query' => "SELECT * from ssi_paneon.report WHERE report_id = '{$_POST['update_id']}' " );

$arr ['field'] [] = array ('tab' => '1','type' => 'div','class' => 'fields two' ); // 'label'=>'test'

$arr ['field'] ['title'] = array ('tab' => '1','type' => 'input','label' => 'Überschrift','focus' => true );
$arr ['field'] ['category'] = array ('tab' => '1','type' => 'dropdown','label' => 'Kategorie','array' => $array_category );
$arr ['field'] [] = array ('tab' => '1','type' => 'div_close' );
$arr ['field'] ['create_date'] = array ('tab' => '1','type' => 'date','label' => 'Erstelldatum' );
$arr ['field'] [] = array ('tab' => '1','type' => 'div','class' => 'fields two ui message' ); // 'label'=>'test'
$arr ['field'] ['image'] = array ('tab' => '1','type' => 'finder','label' => 'Bild' );
$arr ['field'] ['foto_owner'] = array ('tab' => '1','type' => 'input','label' => 'Fotonachweis' );
$arr ['field'] [] = array ('tab' => '1','type' => 'div_close' );



$arr ['field'] [] = array ('tab' => '1','type' => 'div','class' => 'fields ui message' ); // 'label'=>'test'
$arr ['field'] ['tags'] = array ('tab' => '1','label' => 'Ausgewählte Tags','class' => 'eleven wide search','type' => 'multiselect','array' => call_array_report_tags (),'value' => $tag_selected_array );
$arr ['field'] ['new_tag'] = array ('tab' => '1','type' => 'input','label' => 'Neuen Tag','class' => 'five wide','label_left' => "<i class='icon arrow left'></i> Anlegen",'label_left_class' => 'button orange ui' );
$arr ['field'] [] = array ('tab' => '1','type' => 'div_close' );

$arr ['field'] [] = array ('tab' => '1','type' => 'div','class' => 'ui equal width fields red message' ); // 'label'=>'test'
$arr ['field'] ['problem'] = array ('tab' => '1','type' => 'input','label' => 'Problem','class' => '' );
$arr ['field'] [] = array ('tab' => '1','type' => 'div_close' );


$arr ['field'] ['text'] = array ('tab' => '2','type' => 'ckeditor','label' => 'Erfolgsbericht' );
$arr ['field'] ['answer'] = array ('tab' => '3','type' => 'ckeditor','label' => 'Antwort' );
$arr ['field'] ['highlight'] = array ('tab' => '4','type' => 'textarea','label' => 'Hightlights' );

//$arr['field']['pdf'] = array ( 'tab' => 'sec' , 'label' => 'PDF' , 'type' => 'finder' );
if ($_SESSION ['explorer_folder'])
	$arr ['field'] ['gallery'] = array ('tab' => 'sec','type' => 'dropdown','label' => 'Bildergalerie','array' => $array_folder );

	
$arr ['field'] ['age'] = array ('tab' => '1','type' => 'slider','label' => 'Alter','min' => '1','max' => '100','step' => '1','unit' => 'Jahre' );
$arr ['field'] ['sensible_content'] = array ('tab' => '1','type' => 'checkbox','label' => 'Sensibler Inhalt' );


//$add_js .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"js/form_report.js\"></script>";