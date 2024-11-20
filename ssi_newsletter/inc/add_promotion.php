<?php
require_once ('../mysql.inc');
$value = $_POST['value'];

// Check ob Name bereits vorhanden sind
$query = $GLOBALS['mysqli']->query ( "SELECT * FROM `promotion` WHERE title = '$value' AND user_id = '{$_SESSION['user_id']}' " );
$check = mysqli_num_rows ( $query );

if ($check) {
	echo "message({ title: 'Promotion anlegen', text:'Name $value bereits vorhanden!<br>Bitte anderen Promotion-Namen wählen.', type:'error', delay:5000});";
} else {
	
	$GLOBALS['mysqli']->query ( "INSERT INTO `promotion` SET user_id = '{$_SESSION['user_id']}', type= 'basic', title = '$value' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	$id = mysqli_insert_id ($GLOBALS['mysqli']);
	echo "
$('#dropdown_promotion_id').find('.menu').append('<div class=\"item\" data-value=\"$id\">$value</div>');
$('#dropdown_promotion_id').dropdown('refresh');
$('#dropdown_promotion_id').dropdown('set selected', $id );
$('#new_promotion').val('');
";
}