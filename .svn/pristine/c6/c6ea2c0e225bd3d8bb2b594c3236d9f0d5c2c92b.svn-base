<?
session_start();
//$_SESSION['date_default_timezone_set'] = 'Europe/Berlin';
//date_default_timezone_set ( $_SESSION[date_default_timezone_set] );
// Rechnet die Differnzzeit der beiden Werte aus
$from = $_POST ['from'];
$to = $_POST ['to'];
$from_time = $_POST ['from_time'];
$to_time = $_POST ['to_time'];

$datetime1 = date_create ( "$from $from_time" );
$datetime2 = date_create ( "$to $to_time" );
$interval = date_diff ( $datetime1, $datetime2 );

if ($interval->format ( '%a' ) > 0)
	$zusatz_tag = $interval->format ( '%a Tage, ' );
if ($interval->format ( '%i' ) > 0)
	$zusatz_tag2 = $interval->format ( ' und %i Minuten' );

echo "<span class=call_time>" . $zusatz_tag . $interval->format ( '%h Stunden' ) . $zusatz_tag2 . "</span>";
?>