<?
//$cfg ['Servers'] ['host'] = 'www.intuition-works.org';
$cfg ['Servers'] ['host'] = '85.158.181.25';
$cfg ['Servers'] ['host'] = 'www.ssi.at';
//$cfg ['Servers'] ['host'] = 'localhost';
$cfg ['Servers'] ['port'] = '3306';
$cfg ['Servers'] ['user'] = 'intubspe';
$cfg ['Servers'] ['password'] = 'CPU&*N@0r98f';

// $cfg ['Servers'] ['user'] = 'root';
// $cfg ['Servers'] ['password'] = 'Jgewl21;';

$cfg ['Servers'] ['only_db'] = 'usrdb_intubspe';
$conn = new mysqli ( $cfg ['Servers'] ['host'], $cfg ['Servers'] ['user'], $cfg ['Servers'] ['password'], $cfg ['Servers'] ['only_db'], $cfg ['Servers'] ['port'] ) or die ( "Could not open connection to server {$cfg_mysql['server']}" );

//Check connection
if ($conn->connect_error) {
	die ( "Connection failed: " . $conn->connect_error );
}
echo "Connected successfully";





exit;

$c ['host'] = '81.169.203.18';
//$c ['host'] = 'localhost';
//$c ['host'] = 'server6.ssi.at';
$c ['port'] = '3306';
$c ['user'] = 'root';
$c ['pass'] = 'Jgewl21;';
$c ['name'] = 'usrdb_intubspe';
//$c ['name'] = 'usrdb_intubspe';

$conn = new mysqli ( $c ['host'], $c ['user'], $c ['pass'] );

// Check connection
if ($conn->connect_error) {
	die ( "Connection failed: " . $conn->connect_error );
}
echo "Connected successfully";

?>