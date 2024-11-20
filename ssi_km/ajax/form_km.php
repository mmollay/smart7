<?php
include_once ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

// Laden von Werten direkt aus der Datenbank
if ($_POST['update_id']) {
    $sql = "SELECT km,country,
	DATE_FORMAT(km_from, '%d.%m.%Y') km_from,
	DATE_FORMAT(km_from, '%H:%i') km_from_time,
	DATE_FORMAT(km_to, '%d.%m.%Y') km_to,
	DATE_FORMAT(km_to, '%H:%i') km_to_time,
	text, return_point, start_point, end_point, commend, session_open
	from km_list WHERE km_id = '{$_POST['update_id']}'";

    $arr['sql'] = array(
        'query' => $sql
    );

    $query = $GLOBALS['mysqli']->query($sql);
    $array = mysqli_fetch_array($query);
    if ($array['session_open']) {

        $km_to = date('d.m.Y');
        $km_to_time = date('H:i');
        // $set_focus = true;
    }
} else {
    // Defaultwerte auslesen und letzten Eintrag ausgeben

    $km_return = 1;
    $country = $default_country;
    echo "<div id=div_last_km_insert>";
    include ('km_last_insert.php');
    echo "</div><br>";
}

// $array_autocomplete = array ( 'source' => 'inc/auto_point.php?get=text' );

$arr['ajax'] = array(
    'dataType' => "html",'success' => "after_form_km(data)"
);

$arr['form'] = array(
    'action' => "ajax/form_km2.php",'id' => 'form_km','size' => 'small'
);
// $arr['field']['text'] = array(
// 'type' => 'autocomplete',
// 'placeholder' => 'Beschreibung',
// 'validate' => TRUE,
// 'source' => 'inc/auto_point.php?get=text',
// 'focus' => true,
// 'select' => "set_target()"
// );

$arr['field']['text'] = array(
    'type' => 'input','placeholder' => 'Beschreibung','label' => 'Beschreibung','validate' => true,'search' => true,'focus' => true
);

$arr['field']['km_date'] = array(
    'type' => 'div','class' => 'inline fields ui message'
);

$arr['field']['km_from'] = array(
    'value' => $km_from,'type' => 'input','class_input' => 'date start'
);

$arr['field']['km_from_time'] = array(
    'value' => $km_from_time,'type' => 'input','class_input' => 'time start'
);

$arr['field']['km_to_time'] = array(
    'value' => $km_to_time,'type' => 'input','value_default' => $km_to_time,'label' => 'bis','class_input' => 'time end'
);

$arr['field']['km_to'] = array(
    'value' => $km_to,'value_default' => $km_to,'type' => 'input','class_input' => 'date end','label_right_id' => "show_time",'label_right_class' => 'orange','label_right' => 'Zeitangabe'
);

$arr['field'][] = array(
    'type' => 'div_close'
);

$arr['field'][] = array(
    'type' => 'div','class' => 'fields'
);
$arr['field']['country'] = array(
    'type' => 'dropdown','label' => "Reiseland",'array' => $km_array_country,'value' => $country
);

$arr['field']['start_point'] = array(
    'type' => 'input','label' => 'Start Ort','label_right' => '<i class="icon home"></i>','label_right_class' => 'icon button','label_right_id' => 'button_home','validate' => TRUE
);

$arr['field']['end_point'] = array(
    'type' => 'input','label' => 'Ziel Ort','validate' => TRUE,'search' => true
);

$arr['field']['return_point'] = array(
    'value' => $km_return,'type' => 'checkbox','label' => 'wieder zurück','label_text' => ''
);
$arr['field']['km'] = array(
    'type' => 'input','label' => 'Kilometerstand','label_text' => ' ','label_right' => "<i class='icon refresh'></i>",'label_right_class' => 'icon blue button','label_right_tooltip' => 'Kilometer berrechnen','label_right_click' => 'calcRoute()','label_right_id' => 'button_calcRoute','validate' => TRUE
);
$arr['field'][] = array(
    'type' => 'div_close'
);

// $arr['field']['commend'] = array ( 'type' => 'input' , 'label' => 'Kommentar');

if (! $_POST['update_id']) {
    $arr['field']['new_data'] = array(
        'type' => 'checkbox','label' => 'nach Speichern neuen Datensatz anlegen'
    );
}

$arr['field']['map'] = array(
    'type' => 'content','class' => 'ui segment','text' => '<div id="map_canvas" style="height:300px; overflow: hidden;"></div>'
);

$arr['hidden']['km_id'] = $_POST['update_id'];

$arr['button']['submit'] = array(
    'value' => 'Speichern','color' => 'green','icon' => 'save'
);
$arr['button']['close'] = array(
    'value' => 'Abbrechen','js' => "$('#modal_form').modal('hide');"
);
$output = call_form($arr);

echo $output['html'];
echo $output['js'];
echo "<link rel='stylesheet' type='text/css' href='css/bootstrap-datepicker.css' />";
echo "<link rel='stylesheet' type='text/css' href='css/jquery.timepicker.css' />";
echo "<link rel='stylesheet' type='text/css' href='css/km.css' />";
echo "<script type='text/javascript' src='js/bootstrap-datepicker.js'></script>";
echo "<script type='text/javascript' src='js/jquery.timepicker.js'></script>";
echo "<script type='text/javascript' src='js/datepair.js'></script>";
echo "<script type='text/javascript' src='js/jquery.datepair.js'></script>";
echo "<script type=\"text/javascript\" src=\"js/form_km.js\"></script>";

if ($load_map == true) {
    echo "<style type='text/css'>
			#map_canvas { height: 100%;}
			.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
			.ui-timepicker-div dl { text-align: left; }
			.ui-timepicker-div dl dt { float: left; clear:left; padding: 0 0 0 5px; }
			.ui-timepicker-div dl dd { margin: 0 10px 10px 40%; }
			.ui-timepicker-div td { font-size: 90%; }
			.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
			
			.ui-timepicker-rtl{ direction: rtl; }
			.ui-timepicker-rtl dl { text-align: right; padding: 0 5px 0 0; }
			.ui-timepicker-rtl dl dt{ float: right; clear: right; }
			.ui-timepicker-rtl dl dd { margin: 0 40% 10px 10px; }
		</style>
			
		<script type='text/javascript'>
				var directionDisplay;
				var directionsService = new google.maps.DirectionsService();
				var map;
			
			function initialize() {
				directionsDisplay = new google.maps.DirectionsRenderer();
				var melbourne = new google.maps.LatLng(47.7989349, 16.2162823);
				var myOptions = {
					zoom:12,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: melbourne
				}
			
				map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
				directionsDisplay.setMap(map);
			}
			
			function calcRoute() {
				var start = document.getElementById('start_point').value;
				var end = document.getElementById('end_point').value;
				var distanceInput = document.getElementById('km');
			
				var request = {
				origin:start,
				destination:end,
				travelMode: google.maps.DirectionsTravelMode.DRIVING
			};
			
			directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
					distanceInput.value = response.routes[0].legs[0].distance.value / 1000;
				}
			});
		}
		initialize()
		</script>";
}
