<?php
/*
 * Zusatzfunktionen für OEGT
 * martin@ssi.at 04.10.2011
 * UPDATE mm@ssi.at 15.02.2012 - Auswahl der Sektionen nur bei Update
 */

/* configs */
$account_id['membership'] = 62;
$account_id['sections'] = 63;

/* functions */
function call_array($account_id) {
	// Auslesen der Mitgliedertypen aus der Kontenlist
	$query = $GLOBALS['mysqli']->query ( " SELECT * from article_temp where account=$account_id" );
	while ( $array1 = mysqli_fetch_array ( $query ) ) {
		$id = $array1['temp_id'];
		$array[$id] = $array1['art_title'];
	}
	return $array;
}

// Call Title from db
$query_title = $GLOBALS['mysqli']->query ( "SELECT distinct(specialist_species_for) FROM client" );
while ( $fetch_array_title = mysqli_fetch_array ( $query_title ) ) {
	$array_tierarzt[] = $fetch_array_title[0];
}

$array_membership = call_array ( $account_id['membership'] );
$array_sections = call_array ( $account_id['sections'] );

$form1->setField ( 'id_card_no', array ( 'group' => 2 , 'type' => 'input' , 'text' => 'Ausweis-Nr' , 'size' => 30 ) );
$form1->setField ( 'specialist_species_for', array ( 'group' => 2 , 'type' => 'autocompliter' , 'text' => 'Fachtierarzt für' , 'array' => $array_tierarzt , 'size' => 60 ) );
$form1->setField ( 'matrical_nr', array ( 'group' => 2 , 'type' => 'input' , text2 => '(Matrikel-Nr)' , 'size' => 30 , after => student ) );
$form1->setField ( 'hr1_5', array ( 'group' => 2 , 'text' => '<hr>' ) );
$form1->setField ( 'student', array ( 'group' => 2 , 'type' => 'checkbox' , 'title' =>'Student ->' , 'size' => 30 ) );
$form1->setField ( 'hr1_6', array ( 'group' => 2 , 'text' => '<hr>' ) );

$form1->setField ( 'own_practice', array ( 'group' => 2 , 'type' => 'checkbox' , 'text' => ' ' , 'title' =>'selbstständig' ) );
$form1->setField ( 'group_practice', array ( 'group' => 2 , 'type' => 'checkbox' , 'text' => ' ' , 'title' =>'Praxisgemeinschaft' ) );
$form1->setField ( 'employed', array ( 'group' => 2 , 'type' => 'checkbox' , 'text' => ' ' , 'title' =>'angestellt' ) );
$form1->setField ( 'industry', array ( 'group' => 2 , 'type' => 'checkbox' , 'text' => ' ' , 'title' =>'Industrie' ) );
$form1->setField ( 'administration', array ( 'group' => 2 , 'type' => 'checkbox' , 'text' => ' ' , 'title' =>'Verwaltung' ) );
$form1->setField ( 'university', array ( 'group' => 2 , 'type' => 'checkbox' , 'text' => ' ' , 'title' =>'Universität' ) );
$form1->setField ( 'no_exercise', array ( 'group' => 2 , 'type' => 'checkbox' , 'text' => ' ' , 'title' =>'keine Ausübung' ) );
$form1->setField ( 'retirement', array ( 'group' => 2 , 'type' => 'checkbox' , 'text' => ' ' , 'title' =>'Ruhestand' ) );
$form1->setField ( 'hr1_7', array ( 'group' => 2 , 'text' => '<hr>' ) );
$form1->setField ( 'other', array ( 'group' => 2 , 'type' => 'input' , 'text' => 'sonstiges' , 'size' => 50 ) );

// $form1->setField('date_membership_start', array('after'=>membership,text=>'seit',type=>'datepicker',size=>'9'));
// $form1->setField('date_membership_stop', array('after'=>membership,text=>'bis',type=>'datepicker',size=>'9'));
// $form1->setField('membership', array('group'=>2,text=>'Mitgliedschaft',type=>select,'array'=>$array_membership,emptyField=>"--bitte wählen--"));
// $form1->setField('hr1_4', array('group'=>2,text=>'<hr>'));

// Call inserts from DB
if ($_POST['update_id']) {
	$membership_query = $GLOBALS['mysqli']->query ( "SELECT * from membership WHERE client_id = '{$_POST['update_id']}' order by date_membership_start " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	while ( $array_query = mysqli_fetch_array ( $membership_query ) ) {
		$zzz ++;
		$date_membership_start[$zzz] = $array_query['date_membership_start'];
		$date_membership_stop[$zzz] = $array_query['date_membership_stop'];
		$set_membership_id[$zzz] = $array_query['membership_id'];
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
	if ($date_membership_stop[$membership_count] == '0000-00-00')
		$date_membership_stop[$membership_count] = '';
	$form1->setField ( "date_membership_start$membership_count", array ( 'after' => "membership$membership_count" , 'text' => 'seit' , 'type' => 'datepicker' , 'size' => '9' , 'value' => $date_membership_start[$membership_count] ) );
	$form1->setField ( "date_membership_stop$membership_count", array ( 'after' => "membership$membership_count" , text2 => $add_text2 , 'text' => 'bis' , 'type' => 'datepicker' , 'size' => '9' , 'value' => $date_membership_stop[$membership_count] ) );
	$form1->setField ( "membership$membership_count", array ( 'group' => 3 , 'type' => 'dropdown' , 'array' => $array_membership , 'emptyfield' => "--bitte wählen--" , 'value' => $set_membership_id[$membership_count] ) );
}

$form1->setField ( 'hr1_7', array ( 'group' => 3 , 'text' => '<hr>' ) );

if ($_POST['update_id']) {
	// Call inserts from DB
	$section_query = $GLOBALS['mysqli']->query ( "SELECT * from sections WHERE client_id = '{$_POST['update_id']}' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	while ( $array_query = mysqli_fetch_array ( $section_query ) ) {
		$zz ++;
		if ($date_sections_stop[$zz] == '0000-00-00')
			$date_sections_stop[$zz] = '';
		$date_sections_start[$zz] = $array_query['date_sections_start'];
		$date_sections_stop[$zz] = $array_query['date_sections_stop'];
		$set_section_id[$zz] = $array_query['section_id'];
	}
}

// Sections
// Aufbau einer eigenen Datenbank Datum - Ein und Austrittsdatum!
$set_section_count = count ( $array_sections );
for($section_count = 1; $section_count <= $set_section_count; $section_count ++) {
	if ($date_sections_stop[$section_count] == '0000-00-00')
		$date_sections_stop[$section_count] = '';
	$form1->setField ( "date_sections_start$section_count", array ( 'after' => "section$section_count" , 'text' => 'seit' , 'type' => 'datepicker' , 'size' => '9' , 'value' => $date_sections_start[$section_count] ) );
	$form1->setField ( "date_sections_stop$section_count", array ( 'after' => "section$section_count" , 'text' => 'bis' , 'type' => 'datepicker' , 'size' => '9' , 'value' => $date_sections_stop[$section_count] ) );
	$form1->setField ( "section$section_count", array ( 'group' => 3 , 'type' => 'dropdown' , 'array' => $array_sections , 'emptyfield' => "--bitte wählen--" , 'value' => $set_section_id[$section_count] ) );
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
$form1->setField ( 'set_section_count', array ( 'type' => 'hidden' , 'value' => $set_section_count ) );
$form1->setField ( 'set_membership_count', array ( 'type' => 'hidden' , 'value' => $set_membership_count ) );

// add new Sections
// $form1->setField("section_add", array('group'=>2,'text'=>'<div align=center><br> <div id=add_new_section>Weitere Sektion anlegen</div></div>'));

$add_js = "<script type=\"text/javascript\" src=\"oegt/oegt.js\"></script>";

//$form1->setField('sections',               array('group'=>2,type=>multiselect,'array'=>$array_sections));