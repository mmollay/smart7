<?php
session_start ();
error_reporting(E_ALL ^  E_NOTICE);
$_SESSION['admin_modus'] = 1;
$_SESSION['ssi_map_admin_modus'] = 1;
// echo "<style type='text/css'>@import '../ssi_smart/gadgets/map/font.css';</style>\n";
// echo "<div class='segment ui' id='load_map' style='height:600px'></div>";
// echo "\n<script>appendScript('../ssi_smart/gadgets/map/js/gmap3.min.js');</script>";
// // echo "\n<script>appendScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyAgoO9CQxiF6tddu1WIKqB5vrONEHsoLTM&region=AT');</script>";
// echo "\n<script> var set_path = '../ssi_smart/'; </script>";
// echo "\n<script>appendScript('../ssi_smart/gadgets/map/js/functions.js');</script>";
// echo "\n<script src='../ssi_smart/gadgets/map/js/include.js'></script>";
// echo "\n<script src='js/map.js'></script>";
if (! $height)
	$height = 600;

// Defaultmässig wird Wien gewählt
if ($_SESSION['user_id'] == '1287')
	$destination = '1020';
else
	$destination = $_SESSION["map_filter"]['map_zip'];

if (! $_SESSION["map_filter"]['autofit'])
	$_SESSION["map_filter"]['autofit'] = 1;

if ($destination && ! $_SESSION["map_filter"]['map_zip']) {
	$_SESSION["map_filter"]['map_zip'] = $destination;
}

$add_path_js .= "\n<script> var set_path = '../ssi_smart/'; </script>";
$add_path_js .= "\n<script>appendScript('../ssi_smart/gadgets/map/js/gmap3.min.js');</script>";
$add_path_js .= "\n<script>appendScript('../ssi_smart/gadgets/map/js/jquery.fullscreen.min.js');</script>";
$add_path_js .= "\n<script>appendScript('js/functions.js');</script>";
$add_path_js .= "\n<script>appendScript('../ssi_smart/gadgets/map/js/functions.js');</script>";
$add_path_js .= "\n<script>var destination = '$destination'; call_set_admin_status();</script>";
$add_path_js .= "\n<script src='../ssi_smart/gadgets/map/js/include.js'></script>";
$add_path_js .= "\n<script src='js/map.js'></script>";

$add_css2 .= "<style type='text/css'>@import '../ssi_smart/gadgets/map/font.css';</style>\n";

$button_output_edit .= "<div class='item map_button_set_admin_modus tooltip' title='Bearbeitungsmodus Ein/Aus schalten' type=button onclick=move_trees() id=true><i class='grey lock icon'></i></div>";
$button_output_edit .= "<div class='item show_admin_button tooltip' title='Hier klicken um Baum zu setzen' onclick=map_button_new_tree()><i class='icons'><i class='green icon tree'></i><i class='top right corner add icon'></i></i></div>";

$add_icon_eye_client = "<i class='icon eye slash outline grey tooltip' title = 'wir öffentlich nicht angezeigt' ></i>";

// $button_output .= "<a class='item active' data-tab='first'><i class='map icon'></i><div class='tablet'>Fruitmap </div><div class='computer'>&nbsp;<span class='style_treenumber' id='count_trees'></span></div></a>";
// $button_output .= "<a class='item' data-tab='second' onclick=loadList('client')>$add_icon_eye_client<i class='users icon'></i><div class='tablet'>Baumpaten</div></a>";
$div_output .= "<div class='ui basic segment tab load_segment' data-tab='second' id=load_client></div>";

$add_icon_eye_sorts = "<i class='icon eye slash outline grey tooltip' title = 'wir öffentlich nicht angezeigt' ></i>";

$output .= "<div id='map_container' class='container'>";

// $output .= "
// <div class='ui top attached menu small pointing'>
// <a class='item icon toggle_sidemap'><i id='map_filter_icon' class='icon grey ui content'></i></a>
// <div class='item' ><div style='width:100px' class='ui transparent icon input'><input placeholder='Suchen' class='prompt search_input' type='text'><i class='search link icon'></i></div></div>
// $button_output
// <div class='right menu'>
// $button_output_edit

// <a class='item icon' id='toggle'><i class='icon expand arrows alternate'></i></a></div>
// </div>
// </div>";

$output .= "
	<div id=content_menu>
		<div class='ui top attached menu pointing'>
			<a class='item icon toggle_sidemap'><i id='map_filter_icon' class='icon grey ui content'></i></a>
			<div class='ui item' style='width:180px'><div class='ui transparent icon input'><input class='prompt search_input' placeholder='Suchen' type='text'><i class='search link icon'></i></div></div>
			$button_output_edit
			$button_output
			<div class='right menu'><a class='item icon' id='fullsrceen_toggle'><i class='icon expand arrows alternate'></i></a></div>
		</div>";

$output .= "
	<div class='ui bottom attached segment pushable' id='map_sidebar_segment'>
			<div id='map_sidebar' class='ui labeled left sidebar segment'><div id='menu_filter'></div></div>
			<div class='pusher' >
				<div id='map-no-results' style='display:none; position:absolute; right:0px; z-index:10000;' align=center><div class='ui label red'>Keine Suchergenisse vorhanden</div></div>
				<div class='ui bottom attached tab active load_segment' style='height:600px;' data-tab='first' id='load_map'></div>
				$div_output
			</div>
		</div>
	</div>
</div>
";

$output .= "<div class='ui modal' id ='modal_ordertree' ><i class='close icon'></i><div class='header'>Baumpatenschaft beantragen</div><div class='content'></div></div>";

$output .= "<div id=div_map_dialog></div>";
$output .= "<div id=div_map2></div>";
$output .= "<div id=dialog_list></div>";
$output .= "<div id=div_map><div class='ui modal' id ='tree_dialog' ><i class='close icon'></i><div class='header'>Baum bearbeiten</div><div class='content'></div></div>";
$output .= "<div id=tree_dialog2></div>";
$output .= "</div>";

echo $add_css2;
echo $add_path_js;
echo $output;