<?php
include_once ('../config.inc.php');
require ('../function.php');

$SetYear = $_SESSION['SetYear'];

if (is_array ( $km_array[$SetYear]['cost_per_day'] )) {
	$array_mysql_km_list_details = "SELECT
car_nr, car_color,vehicle_type,
SUM(if (`return_point` = 0, km, km*2) ) sum_km,

(CASE
WHEN vehicle_type = 'car' then SUM(if (`return_point` = 0, km*{$km_array[$SetYear]['cost_per_km']['car']}, km*2*{$km_array[$SetYear]['cost_per_km']['car']}))
WHEN vehicle_type = 'bike' then SUM(if (`return_point` = 0, km*{$km_array[$SetYear]['cost_per_km']['bike']}, km*2*{$km_array[$SetYear]['cost_per_km']['bike']}))
WHEN vehicle_type = 'motorbike' then SUM(if (`return_point` = 0, km*{$km_array[$SetYear]['cost_per_km']['motorbike']}, km*2*{$km_array[$SetYear]['cost_per_km']['motorbike']}))
END) as sum_km_euro,

SUM(if (HOUR(TIMEDIFF(km_to,km_from)) >= 12, DATEDIFF(km_to,km_from)+1,'')) sum_km_days,
SUM(if (HOUR(TIMEDIFF(km_to,km_from)) >= 12, DATEDIFF(km_to,km_from),'')) sum_km_nights,";
	
	foreach ( $km_array[$SetYear]['cost_per_day'] as $country => $value ) {
		$array_mysql_km_list_details .= "
		SUM(if (HOUR(TIMEDIFF(km_to,km_from)) >= 12 AND country ='$country', (DATEDIFF(km_to,km_from)+1)*{$km_array[$SetYear]['cost_per_day'][$country]},'')) sum_km_days_euro_$country,
		SUM(if (HOUR(TIMEDIFF(km_to,km_from)) >= 12 AND country='$country', DATEDIFF(km_to,km_from)*{$km_array[$SetYear]['cost_per_night'][$country]},'')) sum_km_nights_euro_$country,
		SUM(if (HOUR(TIMEDIFF(km_to,km_from)) >= 12 AND country='$country', DATEDIFF(km_to,km_from)+1,'')) sum_days_$country,
		SUM(if (HOUR(TIMEDIFF(km_to,km_from)) >= 12 AND country='$country', DATEDIFF(km_to,km_from),'')) sum_nights_$country,";
	}
	
	$array_mysql_km_list_details .= "
SUM(if (HOUR(TIMEDIFF(km_to,km_from)) >= 3 AND HOUR(TIMEDIFF(km_to,km_from)) < 12, HOUR(TIMEDIFF(km_to,km_from)),'')) sum_km_hours,
SUM(if (HOUR(TIMEDIFF(km_to,km_from)) >= 3 AND HOUR(TIMEDIFF(km_to,km_from)) < 12, HOUR(TIMEDIFF(km_to,km_from))*{$km_array[$SetYear]['cost_per_hour']['at']},'')) sum_km_hours_euro
from km_list LEFT JOIN km_settings ON km_list.car_id = km_settings.car_id
WHERE km_list.user_id = '{$_SESSION['user_id']}' AND DATE_FORMAT(km_from,'%Y') = '$SetYear'
GROUP by km_list.car_id
";
	
	// echo $array_mysql_km_list_details;
	$query = $GLOBALS['mysqli']->query ( $array_mysql_km_list_details ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
	while ( $array = mysqli_fetch_array ( $query ) ) {
		
		$vehicle_type = $array['vehicle_type'];
		$sum_km_euro = nr_format ( $array['sum_km_euro'] );
		
		$cost_per_km = nr_format ( $km_array[$SetYear]['cost_per_km'][$vehicle_type] );
		
		$array_th['country_split'] = '';
		$array_th['country'] = '';
		$array_td['anzahl'] = '';
		$array_td['sum'] = '';
		$array_td['einheit'] = '';
		$array["sum_days"] = '';
		$array["sum_nights"] = '';
		$sum_km_days_euro = 0;
		$sum_km_nights_euro = 0;
		
		foreach ( $km_array[$_SESSION['SetYear']]['cost_per_day'] as $country => $value ) {
			
			if ($km_array[$SetYear]['cost_per_hour'][$country]) {
				$cost_per_hour = nr_format ( $km_array[$SetYear]['cost_per_hour'][$country] );
				$sum_km_hours_euro = nr_format ( $array['sum_km_hours_euro'] ) . " €";
				$sum_km_hours = $array['sum_km_hours'];
			} else {
				$sum_km_hours = $cost_per_hour = $sum_km_hours_euro = '';
			}
			
			$cost_per_day[$country] = nr_format ( $km_array[$SetYear]['cost_per_day'][$country] ) . " €";
			$cost_per_night[$country] = nr_format ( $km_array[$SetYear]['cost_per_night'][$country] ) . " €";
			
			$km_days_euro[$country] = nr_format ( $array["sum_km_days_euro_$country"] );
			$km_nights_euro[$country] = nr_format ( $array["sum_km_nights_euro_$country"] );
			
			$sum_km_days_euro += $array["sum_km_days_euro_$country"];
			$sum_km_nights_euro += $array["sum_km_nights_euro_$country"];
			
			if ($vehicle_type == 'car') {
				$icon_vehicle_type = "<img src='img/auto-icon.png' height=20>";
			} elseif ($vehicle_type == 'motorbike') {
				$icon_vehicle_type = "<img src='img/motorbike-icon.png' height=20>";
			} elseif ($vehicle_type == 'bike') {
				$icon_vehicle_type = "<img src='img/bike-icon.png' height=20>";
			} elseif ($vehicle_type == 'transport') {
				$icon_vehicle_type = "<img src='img/transport-icon.png' height=20>";
			}
			
			if ($km_days_euro[$country]) {
				$country_flag = preg_replace ( "/_/", " ", $country );
				
				$array_tr['country'] .= "<tr>";
				$array_tr['country'] .= "<td><i class='$country_flag flag tooltip' title='{$km_array_country[$country]}' ></i>" . $km_array_country[$country] . "</td>";
				$array_tr['country'] .= "<td>$sum_km_hours</td>";
				$array_tr['country'] .= "<td>$cost_per_hour</td>";
				$array_tr['country'] .= "<td>$sum_km_hours_euro</td>";
				$array_tr['country'] .= "<td>" . $array["sum_days_$country"] . "</td>";
				$array_tr['country'] .= "<td><div align=right>" . $cost_per_day[$country] . "</div></td>";
				$array_tr['country'] .= "<td><div align=right>" . $km_days_euro[$country] . " €</div></td>";
				$array_tr['country'] .= "<td>" . $array["sum_nights_$country"] . "</td>";
				$array_tr['country'] .= "<td><div align=right>" . $cost_per_night[$country] . "</div></td>";
				$array_tr['country'] .= "<td><div align=right>" . $km_nights_euro[$country] . " €</div></td>";
				$array_tr['country'] .= "</tr>";
				
				$colspan = $colspan + 2;
			}
		}
		
		$colspan = $colspan + 3;
		
		$array['sum_km_total'] = nr_format ( $array['sum_km_euro'] + $sum_km_days_euro + $array['sum_km_hours_euro'] );
		
		$sum_km_days_euro = nr_format ( $sum_km_days_euro );
		$sum_km_nights_euro = nr_format ( $sum_km_nights_euro );
		$sum_km_hours_euro = nr_format ( $array['sum_km_hours_euro'] );
		
		$diaeten_gesamt = ($sum_km_days_euro + $sum_km_nights_euro + $array['sum_km_hours_euro']);
		
		$output .= "<h2 style='color:{$array['car_color']}'>$icon_vehicle_type " . $array['car_nr'] . "</h2>";
		
		$output .= "
			<h4 class=ui header>Diäten $SetYear</h4>
			<table class='ui celled striped table collapsing'>
			<thead>
				<tr>
				<th>Land</th>
				<th colspan=3>Stunden</th>
				<th colspan=3>Tage</th>
				<th colspan=3>Nächte</th>
				</tr>
			</thead>
			<tbody>" . $array_tr['country'] . "</tbody>
			<tfoot>
				<tr>
					<th align=right><b>$diaeten_gesamt €</b></th>
					<th colspan=3><div align=right>$sum_km_hours_euro €</div></th>
					<th colspan=3><div align=right>$sum_km_days_euro €</div></th>
					<th colspan=3><div align=right>$sum_km_nights_euro €</div></th>
				</tr>
			</tfoot>
	</table>
		";
		
		// if ($diaeten_gesamt) {
		// $output .= "<table style='max-width:400px' class='ui celled striped table'>
		// <thead><tr><th colspan=2>Summe</th></tr></thead>
		// <tbody>
		// <tr><td>Diäten Gesamt</td><td>" . nr_format ( $diaeten_gesamt ) . " €</td></tr>
		// <tr><td>Kilometergeld</td><td>" . nr_format ( $sum_km_euro ) . " €</td></tr>
		// </tbody>
		// </table>";
		// }
	}
}

if (! $output)
	$output = "<div class=text_no_content>Keine Einträge im Jahr <b>{$_SESSION['SetYear']}</b> vorhanden</div>";

$output = "<div id='list_km_sum'>$output</div>";

echo $output;
echo "<script>$('.tooltip').popup();</script>";

?>