<?php
/*
 * Zusatzfunktionen für OEGT
 * martin@ssi.at 04.10.2011
 * UPDATE mm@ssi.at 15.02.2012 - Auswahl der Sektionen nur bei Update
 */

/* configs */
$account_id ['membership'] = 62;
$account_id ['sections'] = 63;

// /* functions */
function call_array2($account_id) {
	// Auslesen der Mitgliedertypen aus der Kontenlist
	$query = $GLOBALS ['mysqli']->query ( " SELECT * from article_temp where account=$account_id" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	while ( $array1 = mysqli_fetch_array ( $query ) ) {
		$id = $array1 ['temp_id'];
		$array [$id] = $array1 ['art_title'];
	}
	return $array;
}

$array_membership = call_array2 ( $account_id ['membership'] );
$array_sections = call_array2 ( $account_id ['sections'] );

// Call Title from db
$query_title = $GLOBALS ['mysqli']->query ( "SELECT distinct(specialist_species_for) FROM client" );
while ( $fetch_array_title = mysqli_fetch_array ( $query_title ) ) {
	$array_tierarzt [] = $fetch_array_title [0];
}

$arr ['field'] ['id_card_no'] = array ('tab' => '2','type' => 'input','label' => 'Ausweis-Nr' );
$arr ['field'] ['specialist_species_for'] = array ('tab' => '2','type' => 'dropdown','label' => 'Fachtierarzt für','array' => $array_tierarzt );

$arr ['field'] [] = array ('tab' => '2','type' => 'div','class' => 'inline fields' );
$arr ['field'] ['student'] = array ('tab' => '2','type' => 'checkbox','label' => 'Student ->' );
$arr ['field'] ['matrical_nr'] = array ('tab' => '2','type' => 'input','label_right' => '(Matrikel-Nr)' );
$arr ['field'] [] = array ('tab' => '2','type' => 'div_close' );

$arr ['field'] ['own_practice'] = array ('tab' => '2','type' => 'checkbox','label' => 'selbstständig' );
$arr ['field'] ['group_practice'] = array ('tab' => '2','type' => 'checkbox','label' => 'Praxisgemeinschaft' );
$arr ['field'] ['employed'] = array ('tab' => '2','type' => 'checkbox','label' => 'angestellt' );
$arr ['field'] ['industry'] = array ('tab' => '2','type' => 'checkbox','label' => 'Industrie' );
$arr ['field'] ['administration'] = array ('tab' => '2','type' => 'checkbox','label' => 'Verwaltung' );
$arr ['field'] ['university'] = array ('tab' => '2','type' => 'checkbox','label' => 'Universität' );
$arr ['field'] ['no_exercise'] = array ('tab' => '2','type' => 'checkbox','label' => 'keine Ausübung' );
$arr ['field'] ['retirement'] = array ('tab' => '2','type' => 'checkbox','label' => 'Ruhestand' );
$arr ['field'] ['other'] = array ('tab' => '2','type' => 'input','label' => 'sonstiges' );

$arr ['field'] [] = array ('tab' => '3','type' => 'line','text' => 'MITGLIEDER' );

// Call inserts from DB
if ($_POST ['update_id']) {
	$membership_query = $GLOBALS ['mysqli']->query ( "SELECT * from membership WHERE client_id = '{$_POST['update_id']}' order by date_membership_start " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	while ( $array_query = mysqli_fetch_array ( $membership_query ) ) {

		$zzz ++;
		$date_membership_start [$zzz] = $array_query ['date_membership_start'];
		$date_membership_stop [$zzz] = $array_query ['date_membership_stop'];
		$set_membership_id [$zzz] = $array_query ['membership_id'];
	}
}

// Sections
// Aufbau einer eigenen Datenbank Datum - Ein und Austrittsdatum!
$set_membership_count = count ( $array_membership );
for($membership_count = 1; $membership_count <= 4; $membership_count ++) {
	if ($membership_count == 1) {
		$add_text2 = '(Bsp.: 2013-12-12)';
	} else
		$add_text2 = '';
	if ($date_membership_stop [$membership_count] == '0000-00-00')
		$date_membership_stop [$membership_count] = '';

	$arr ['field'] [] = array ('tab' => '3','type' => 'div','class' => 'three fields' );
	$arr ['field'] ["membership$membership_count"] = array ('tab' => '3','class' => 'eight wide','type' => 'dropdown','array' => $array_membership,'value' => $set_membership_id [$membership_count], 'clear'=>true );
	$arr ['field'] ["date_membership_start$membership_count"] = array ('tab' => '3','type' => 'date','label_left' => 'seit','value' => $date_membership_start [$membership_count] );
	$arr ['field'] ["date_membership_stop$membership_count"] = array ('tab' => '3','type' => 'date','label_left' => 'bis','value' => $date_membership_stop [$membership_count] );
	$arr ['field'] [] = array ('tab' => '3','type' => 'div_close' );
	// $form1->setField ( "date_membership_start$membership_count", array ( 'after' => "membership$membership_count" , 'text' => 'seit' , 'type' => 'datepicker' , 'size' => '9' , 'value' => $date_membership_start[$membership_count] ) );
	// $form1->setField ( "date_membership_stop$membership_count", array ( 'after' => "membership$membership_count" , text2 => $add_text2 , 'text' => 'bis' , 'type' => 'datepicker' , 'size' => '9' , 'value' => $date_membership_stop[$membership_count] ) );
	// $form1->setField ( "membership$membership_count", array ( 'group' => 3 , 'type' => 'dropdown' , 'array' => $array_membership , 'emptyfield' => "--bitte wählen--" , 'value' => $set_membership_id[$membership_count] ) );
}

$arr ['field'] [] = array ('tab' => '3','type' => 'line','text' => 'SEKTIONEN' );

if ($_POST ['update_id']) {
	// Call inserts from DB
	$section_query = $GLOBALS ['mysqli']->query ( "SELECT * from sections WHERE client_id = '{$_POST['update_id']}' " ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	while ( $array_query = mysqli_fetch_array ( $section_query ) ) {
		$zz ++;
		if ($date_sections_stop [$zz] == '0000-00-00')
			$date_sections_stop [$zz] = '';
		$date_sections_start [$zz] = $array_query ['date_sections_start'];
		$date_sections_stop [$zz] = $array_query ['date_sections_stop'];
		$set_section_id [$zz] = $array_query ['section_id'];
	}
}

// Sections
// Aufbau einer eigenen Datenbank Datum - Ein und Austrittsdatum!
$set_section_count = count ( $array_sections );
//$set_section_count = 8;

for($section_count = 1; $section_count <= $set_section_count; $section_count ++) {
	if ($date_sections_stop [$section_count] == '0000-00-00')
		$date_sections_stop [$section_count] = '';

	$arr ['field'] [] = array ('tab' => '3','type' => 'div','class' => 'three fields' );
	$arr ['field'] ["section$section_count"] = array ('tab' => '3','class' => 'eight wide','type' => 'dropdown','array' => $array_sections,'value' => $set_section_id [$section_count], 'clear'=>true );
	$arr ['field'] ["date_sections_start$section_count"] = array ('tab' => '3','type' => 'date','label_left' => 'seit','value' => $date_sections_start [$section_count] );
	$arr ['field'] ["date_sections_stop$section_count"] = array ('tab' => '3','type' => 'date','label_left' => 'bis','value' => $date_sections_stop [$section_count] );
	$arr ['field'] [] = array ('tab' => '3','type' => 'div_close' );

	// $form1->setField ( "section$section_count", array ( 'group' => 3 , 'type' => 'dropdown' , 'array' => $array_sections , 'emptyfield' => "--bitte wählen--" , 'value' => $set_section_id[$section_count] ) );
	// $form1->setField ( "date_sections_start$section_count", array ( 'after' => "section$section_count" , 'text' => 'seit' , 'type' => 'datepicker' , 'size' => '9' , 'value' => $date_sections_start[$section_count] ) );
	// $form1->setField ( "date_sections_stop$section_count", array ( 'after' => "section$section_count" , 'text' => 'bis' , 'type' => 'datepicker' , 'size' => '9' , 'value' => $date_sections_stop[$section_count] ) );
}

/*
 * if (!$first) {
 * $section_count = 1;
 * $form1->setField("date_sections_start$section_count", array('after'=>"section$section_count",text=>'seit',type=>'datepicker',size=>'9',value=>$date_sections_start[$section_count]));
 * $form1->setField("date_sections_stop$section_count", array('after'=>"section$section_count",text=>'bis',type=>'datepicker',size=>'9',value=>$date_sections_stop[$section_count]));
 * $form1->setField("section$section_count", array('group'=>2,text=>"Sektion",type=>select,'array'=>$array_sections,emptyField=>"--bitte wählen--", value=>$set_section_id[$section_count]) );
 * }
 *
 * $form1->setField("add_section_button", array('group'=>2,text=>"<div id='set_new_section'></div><div class=button_add_section id='$first' >Sektion anlegen</div>") );
 */

// Übertragen der COUNT Section zum speichern in der Db notwendig
$arr ['hidden'] ['set_section_count'] = $set_section_count;
$arr ['hidden'] ['set_membership_count'] = $set_membership_count;
// $form1->setField ( 'set_section_count', array ( 'type' => 'hidden' , 'value' => $set_section_count ) );
// $form1->setField ( 'set_membership_count', array ( 'type' => 'hidden' , 'value' => $set_membership_count ) );

// add new Sections
// $form1->setField("section_add", array('group'=>2,'text'=>'<div align=center><br> <div id=add_new_section>Weitere Sektion anlegen</div></div>'));

$add_js = "<script type=\"text/javascript\" src=\"oegt/oegt.js\"></script>";

//$form1->setField('sections',               array('group'=>2,type=>multiselect,'array'=>$array_sections));