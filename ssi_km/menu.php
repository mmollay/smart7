<?
// include('function.php'); //Modulspezifische Funktionen laden
include ("config.inc.php"); // Configs laden
include ('ajax/call_carselect.php'); // $select_car uebergeben

$chooseYearSelect[$_SESSION['SetYear']] = 'selected';
$select_year_new .= "<select class='ui fluid dropdown' id=change_year>";
for($year = date ( 'Y' ); $year >= 2012; $year --) {
	$select_year_new .= "<option value='$year' {$chooseYearSelect[$year]} >$year</option>";
}
$select_year_new .= "</select>";

$setMenu .= "<div align=center>$select_year_new</div><br><br>";
$setMenu .= "<div class=car_nr_title>Kennzeichen</div>";
$setMenu .= "<div class=call_carselect align=center>$select_car</div>";
$setMenu .= "<div align=center><div class='icon' id='icon_car_select'></div></div><br>";

$setMenu .= "<div style='position:relative; left:6px;' class='ui vertical fluid tabular menu'>";
$setMenu .= "<a class='item' id='details'> <i class='icon building'></i>Übersicht</a>";
$setMenu .= "<a class='item' id='kmlist'> <i class='icon database'></i>Km-Liste</a>";
$setMenu .= "<a class='item' id='carlist'> <i class='icon lightning'></i>Fahrzeuge</a>";
$setMenu .= "</div>";

$setMenu .= "<br><br><hr><div align=Center><a href='$link_bmf' target='new'>[BMF-Kilometergeld PDF]</a></div>";
?>