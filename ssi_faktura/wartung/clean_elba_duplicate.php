<?php
require ("../config.inc.php");
//https://www.mysqltutorial.org/mysql-delete-duplicate-rows/
$sql = $GLOBALS['mysqli']->query ( "
DELETE t1 FROM data_elba t1
INNER JOIN data_elba t2
WHERE
    t1.elba_id < t2.elba_id AND
    t1.timestamp = t2.timestamp AND
	t1.text = t2.text
") or die ( mysqli_error ($GLOBALS['mysqli']) );

echo "Duplicates form data_elba removed";