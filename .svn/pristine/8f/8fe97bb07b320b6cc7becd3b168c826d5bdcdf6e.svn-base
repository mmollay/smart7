<?php
include_once ('config.inc.php');

$new = "<label class='ui label red mini'>New</label>";
$setMenu = '';
if ($_SESSION['faktura_company_id']) {
	$setMenu .= "<div class='ui vertical fluid pointing small menu menu_faktura' style='background-color:#FCFFF5'>";
	$setMenu .= "<a class='green item' id=list_earnings><i class='green euro icon'></i>Einnahmen</a>";
	$setMenu .= "<a class='item' id=list_offered><i class='handshake icon'></i>Anbote</a>";
	$setMenu .= "<a class='item' id=list_account_in><i class='tag icon'></i>Konten</a>";
	$setMenu .= "<a class='item' id=list_accountgroups_in><i class='tags icon'></i>Konten-Gruppen</a>";
	$setMenu .= "</div>";

	if ($show_menu['finance_output']) {
		$setMenu .= "<div class='ui vertical fluid pointing small menu menu_faktura' style='background-color:#FFF6F6'>";
		$setMenu .= "<a class='item' id=list_issues><i class='red pie chart icon'></i>Ausgaben</a>";
		$setMenu .= "<a class='item' id=list_account_out><i class='tag icon'></i>Konten</a>";
		$setMenu .= "<a class='item' id=list_accountgroups_out><i class='tags icon'></i>Konten-Gruppen</a>";
		$setMenu .= "<a class='item' id=issue_import><i class='upload icon'></i>Ausgabe Import</a>";
		$setMenu .= "</div>";

		$setMenu .= "<div class='ui vertical fluid pointing small menu menu_faktura' style='background-color:#F8FFFF'>";
		$setMenu .= "<a class='item' id=list_elba><i class='list icon'></i>Elba - Liste</a>";
		$setMenu .= "<a class='item' id=automator><i class='robot icon'></i>Automator</a>";
		$setMenu .= "<a class='item' id=list_automator><i class='clipboard list icon'></i>Automator-Liste</a>";
		$setMenu .= "<a class='item' id=elba_import><i class='upload icon'></i>Elba - Import</a>";
		$setMenu .= "</div>";
	}
}

$setMenu .= "<div class='ui vertical fluid pointing small menu menu_faktura'>";
// $setMenu .= "<a class='item' id=options><i class='setting icon'></i>Einstellungen</a>";

if ($show_menu['finance_output']) {
	$setMenu .= "<a class='item' id=finance><i class='university icon'></i>Finanzübersicht</a>";
	$setMenu .= "<a class='item' id=finance2><i class='university icon'></i>Finanz (neu)</a>";

	$setMenu .= "<a class='item' id=chart><i class='chart bar icon'></i>Charts</a>";
}

if ($oegt_modus) {
	$setMenu .= "<a class='item' id=list_clientoegt><i class='users icon'></i>Mitglieder</a>";
	$setMenu .= "<a class='item' id=import><i class='upload icon'></i>Mitglieder - Import</a>";
} else {
	$setMenu .= "<a class='item' id=list_client><i class='users icon'></i>Kontakte</a>";
	$setMenu .= "<a class='item' id=import><i class='upload icon'></i>Kontake - Import</a>";
}

$setMenu .= "<a class='item' id=list_article><i class='block layout icon'></i>Artikel</a>";
$setMenu .= "<a class='item' id=list_group><i class='cubes icon'></i>Gruppen</a>";

$setMenu .= "</div>";
