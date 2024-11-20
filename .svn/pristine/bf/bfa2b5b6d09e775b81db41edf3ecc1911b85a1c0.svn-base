<?php
// Zugangsdaten fuer die Datenbank
require_once ('../mysql.inc');
$query = $GLOBALS ['mysqli']->query ( "SELECT * from options WHERE user_id = '{$_SESSION['user_id']}'" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
echo mysqli_num_rows ( $query );
?>