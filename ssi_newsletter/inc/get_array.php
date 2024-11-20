<?php
header("Content-Type: application/json; charset=UTF-8");
require_once ('../mysql.inc');
$search = $_GET['search']; // suchfeld
$result = $GLOBALS['mysqli']->query("SELECT contact_id value, if (firstname>'',CONCAT(firstname,' (',email,')'),email) name FROM contact WHERE CONCAT(email, firstname, secondname) LIKE '%$search%' AND user_id = '$user_id' LIMIT 10");
$outp["results"] = $result->fetch_all(MYSQLI_ASSOC);
$outp["success"] = true;
echo json_encode($outp);