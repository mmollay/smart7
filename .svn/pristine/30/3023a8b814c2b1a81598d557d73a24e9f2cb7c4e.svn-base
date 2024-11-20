<?php
//....
//Connect to db

//Auslesen
$sql = "SELECT title, text FROM templates WHERE template_id = '$template_id'";
$query = $GLOBALS['mysqli']->query($sql) or die (mysqli_error($sql));
$array = mysqli_fetch_array($query);

echo json_encode($array);
?>