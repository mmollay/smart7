<?php
// FREE ICONS
// http://www.flaticon.com/categories/business/
include_once (__DIR__ . "/../login/config_main.inc.php");
include_once ('functions.inc');

$module ['ID'] = 'intuiton';
$module ['version'] = '0.2';
$module ['title'] = 'Intuition';
$module ['first_load'] = 'home';

$cfg ['Servers'] ['host'] = 'www.ssi.at';
//$cfg ['Servers'] ['host'] = 'localhost';
$cfg ['Servers'] ['port'] = '3306';
$cfg ['Servers'] ['user'] = 'intubspe';
$cfg ['Servers'] ['password'] = 'CPU&*N@0r98f';
$cfg ['Servers'] ['only_db'] = 'usrdb_intubspe';

if ($_SERVER ['HTTP_HOST'] == 'localhost')
 	$GLOBALS ['mysqli']->select_db ( 'usrdb_intubspe' ) or die ( 'Could not select database intuition' );
 else
	$GLOBALS ['mysqli'] = new mysqli ( $cfg ['Servers'] ['host'], $cfg ['Servers'] ['user'], $cfg ['Servers'] ['password'], $cfg ['Servers'] ['only_db'], $cfg ['Servers'] ['port'] ) or die ( "Could not open connection to server {$cfg_mysql['server']}" );


	
	//$c ['host'] = '81.169.203.18';
	// $c ['host'] = 'server7.ssi.at';
	// $c ['port'] = '3306';
	// $c ['user'] = 'root';
	// $c ['pass'] = 'Jgewl21;';
	// $c ['name'] = 'usrdb_intubspe';
	//$c ['name'] = 'usrdb_intubspe';
	
	//$GLOBALS ['mysqli'] = new mysqli ( $c ['host'] , $c ['user'], $c ['pass'], $c ['name'], $c ['port'] );
	