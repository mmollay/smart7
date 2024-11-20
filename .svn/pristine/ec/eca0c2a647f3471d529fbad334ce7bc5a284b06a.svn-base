<?php
require_once ('../config.inc.php');
$value = $_POST['value'];
//$tag_id = $_POST['tag_id'];

// Check ob Name bereits vorhanden sind
$query = $GLOBALS['mysqli']->query ( "SELECT * FROM paneon.tag WHERE title = '$value' AND user_id = '{$_SESSION['user_id']}' " );
$check = mysqli_num_rows ( $query );

//Entfernt wieder das Loading-Zeichen
echo "$('#label_left_new_tag').removeClass('loading');";

if ($check) {
	echo "message({ title: 'Tag anlegen', text:'Name $value bereits vorhanden!<br>Bitte anderen Tag-Namen wählen.', type:'error', delay:5000});";
} else {
	
	$GLOBALS['mysqli']->query ( "INSERT INTO paneon.tag SET title = '$value' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$id = mysqli_insert_id ($GLOBALS['mysqli']);
	
	echo "add_val_dropdown('tags','$id','$value'); $('#new_tag').val(''); ";

// echo "
// $('#dropdown_tags').find('.menu').append('<div class=\"item\" data-value=\"$id\">$value</div>');
// $('#dropdown_tags').dropdown('refresh');
// $('#dropdown_tags').dropdown('set selected', $id );
// ";
}