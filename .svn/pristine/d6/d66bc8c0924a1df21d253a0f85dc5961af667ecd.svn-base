<?php

// Kickstart the framework
$f3 = require ('lib/base.php');

$f3->set ( 'DEBUG', 1 );
if (( float ) PCRE_VERSION < 7.9)
	trigger_error ( 'PCRE version is out of date' );

// Load configuration
$f3->config ( 'config.ini' );

$f3->route ( 'GET /', function ($f3) {
	$f3->set ( 'content', 'test.htm' );
	echo View::instance ()->render ( 'layout.htm' );
} );

$f3->route ( 'GET /@shortname/@site', function ($f3) {
	$shortname = $f3->get ( "PARAMS.shortname" );
	$site = $f3->get ( "PARAMS.site" );
	
	$f3->set ( 'content', 'test.htm' );
	
	//echo View::instance ()->render ($site);
	echo View::instance ()->render ( 'layout.htm' );
} );

class Cool{
	public function hello() {
		die ('das ist cool');
	}
}


$f3->run ();
