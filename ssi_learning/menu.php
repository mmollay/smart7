<?php
include (__DIR__."/config_learning.php");
include ('../ssi_smart/smart_form/include_form.php');
$success = 'onChange: function(value, text) { $(\'#select_theme.ui.form\').submit(); }';
$arr['form'] = array ( 'id' => 'select_theme' , 'action' => 'ajax/set_value.php' , 'class' => 'small' );
$arr['ajax'] = array ('onLoad' => "check_theme_choose()", 'success' => "check_theme_choose()" , 'dataType' => 'html' ); // location.reload()
$arr['field']['theme_id'] = array ( 'type' => 'dropdown' , 'settings' => $success , 'array' => $array_theme , 'placeholder' => 'Thema wählen' , 'value' => $_SESSION['theme_id'] );
// $arr['field']['group_id'] = array ( 'type' => 'dropdown' , 'settings' => $success , 'array' => $array_group , 'placeholder' => 'Gruppe wählen' , 'value' => $_SESSION['group_id'] );
$output_form = call_form ( $arr );
$setMenu .= $output_form['html'];
$add_js .= $output_form['js'];

$setMenu .= "<div style='position:relative; left:6px;' class='ui vertical fluid tabular menu'>";
// $setMenu .= "<a class='item' id=home><i class='home icon'></i>Home</a>";
// $setMenu .= "<a class='item' id=list_theme><i class='tags icon'></i>Themen</a>";

$setMenu .= "<a class='item' id=list_group style='display:none'><i class='sitemap icon'></i>Gruppen</a>";
$setMenu .= "<a class='item' id=list_question style='display:none'><i class='question icon'></i>Fragen</a>";

if ($_SESSION['group_id']) {
	// $setMenu .= "<hr>";
	// $setMenu .= "<a class='item' id=begin><i class='student icon'></i>Vorbeitung</a>";
	// $setMenu .= "<a class='item' id=open><i class='settings icon'></i>Offen</a>";
	// $setMenu .= "<a class='item' id=focus><i class='mail icon'></i>Fokus</a>";
	// $setMenu .= "<a class='item' id=setting><i class='edit icon'></i>Prüfung</a>";
}

$setMenu .= "<hr>";
// $setMenu .= "<a class='item' id=setting><i class='setting icon'></i>mein Konto</a>";
$setMenu .= "<a class='item tooltip' title='Dieser Button setzt alle beantwortet' onclick='erase_question()' ><i class='erase icon'></i>Zurücksetzen</a>";
$setMenu .= "</div>";
?>