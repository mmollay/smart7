<?php
function select_set_public_page() {
	$ii = 0;
	// Auslesen der Page_id und der Start ID
	$query1 = $GLOBALS ['mysqli']->query ( "SELECT page_id, smart_domain FROM smart_page WHERE set_public = 1
						ORDER by set_public_timestamp desc,smart_domain" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	while ( $array1 = mysqli_fetch_array ( $query1 ) ) {
		$ii ++;
		$array_page_id = $array1 ['page_id'];
		$domain = $array1 ['domain'];
		$multi_user = $array1 ['multi_user'];

		if ($array_page_id == $page_id)
			$select = "selected";
		else
			$select = '';
		$option .= "<option value='$array_page_id' $select >$domain</option>";
	}

	if ($ii) {
		if ($ii == 1)
			$text_seite = "Seite";
		else
			$text_seite = "Seiten";
		return "
		<br><br>$ii zu prüfende $text_seite
		<FORM NAME=\"form\" class=form_select_domain style='display:inline' ACTION=\"../ssi_smart/index.php\" METHOD=\"POST\">
		<input type=hidden name=load_new_page value=1>
		<select  name=page_select  onChange=\"document.form.submit()\">
		<option value=''>--Webseite wählen--</option> $option</select>
		</FORM>";
	}
}
?>