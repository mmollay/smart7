<?php
$set_id = $_POST ['id'] ++;
require ("mysql.inc");
$query = $GLOBALS ['mysqli']->query ( " SELECT * from article_temp where account=63" );
while ( $array1 = mysqli_fetch_array ( $query ) ) {
	$id = $array1 ['temp_id'];
	$array [$id] = $array1 ['art_title'];
	$option .= "<option id=$id value=$id>" . $array1 ['art_title'] . "</option>";
}

echo '
		<select id = "section' . $set_id . '" ><option value="">--Bitte wählen</option>' . $option . '</select>
				seit <input id="date_membership_start' . $set_id . '" class="hasDatepicker" type="date" maxlength="" minlength="" size="9" name="date_membership_start" style="" >
						bis <input id="date_membership_start' . $set_id . '" class="hasDatepicker" type="date" maxlength="" minlength="" size="9" name="date_membership_start" style="" ><br>
								';