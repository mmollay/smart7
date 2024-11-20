<?
if ($_POST['update_id'])
	$_SESSION['logfile_session_id'] = $_POST['update_id'];

$session_id = $_SESSION['logfile_session_id'];

// abgemeldete User abgleichen
function sync_unsub_logfile($session_id) {
	$query = $GLOBALS['mysqli']->query ( "SELECT DISTINCT(contact.contact_id) client_id FROM user_logfile LEFT JOIN contact ON user_logfile.contact_id = contact.contact_id WHERE session_id = '$session_id' AND status_id = 3 AND contact_id" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	while ( $array = mysqli_fetch_array ( $query ) ) {
		$client_id = $array['client_id'];
		
		if ($client_id)
			// echo $client_id;
			// echo "UPDATE logfile SET status='unsub' WHERE client_id = '$client_id' AND session_id = '$session_id'<br>";
			$GLOBALS['mysqli']->query ( "UPDATE logfile SET status='unsub' WHERE client_id = '$client_id' AND session_id = '$session_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	}
}

// sync_unsub_logfile ( $session_id );

$arr['mysql'] = array ( 'field' => "id,email,timestamp,MessageID, CONCAT (firstname,' ',secondname) name, status" , 
		'table' => "logfile" , 
		'order' => 'timestamp desc' , 
		//'debug' => true , 
		'limit' => 100 , 
		'group' => 'id' , 
		'where' => "AND session_id  = '$session_id'" , 
		'like' => 'email, firstname, secondname' );

// call_status ( $session_id );
$set_status['queued'] = array ( 'query' => 'status = "queued"' , 'color' => 'white' , 'title' => 'Verschickt' , 'count_query' => "COUNT(IF((status='queued') ,1,null))" );
$set_status['sent'] = array ( 'query' => '(status = "sent" OR status = "open" or status = "click" or status = "unsub")' , 'color' => '' , 'title' => 'Zugestellt' , 'count_query' => "COUNT(case when status = 'sent' OR status = 'open' or status ='click' or status ='unsub' then 1 else null end)" );
$set_status['open'] = array ( 'query' => '(status = "open" or status ="click")' , 'color' => 'olive' , 'title' => 'Geöffnet' , 'count_query' => "COUNT(case when status = 'open' or status ='click' then 1 else null end)" );
$set_status['click'] = array ( 'query' => 'status = "click"' , 'color' => 'green' , 'title' => 'Angeklickt' , 'count_query' => "COUNT(case when status ='click' then 1 else null end)" );
$set_status['blocked'] = array ( 'query' => 'status = "blocked"' , 'color' => 'black' , 'title' => 'Geblockt' , 'count_query' => "COUNT(IF(status='blocked',1,null))" );
$set_status['bounce'] = array ( 'query' => 'status = "bounce"' , 'color' => 'orange' , 'title' => 'Unzustellbar' , 'count_query' => "COUNT(IF(status='bounce',1,null))" );
$set_status['spam'] = array ( 'query' => 'status = "spam"' , 'color' => 'red' , 'title' => 'Spam' , 'count_query' => "COUNT(IF(status='spam',1,null))" );
$set_status['unsub'] = array ( 'query' => 'status = "unsub"' , 'color' => 'blue' , 'title' => 'Abgemeldet' , 'count_query' => "COUNT(IF(status='unsub',1,null))" );

// $set_status['AND (status = "queued")'] = array ( 'color' => 'white' , 'title' => 'Verschickt' , 'query_count' => "COUNT(IF((status='queued') ,1,null))" );
// $set_status['AND (status = "sent" OR status = "open" or status = "click" or status = "unsub")'] = array ( 'color' => '' , 'title' => 'Zugestellt' , 'query_count' => "COUNT(case when status = 'sent' OR status = 'open' or status ='click' or status ='unsub' then 1 else null end)" );
// $set_status['AND (status = "open" or status ="click")'] = array ( 'color' => 'olive' , 'title' => 'Geöffnet' , 'query_count' => "COUNT(case when status = 'open' or status ='click' then 1 else null end)" );
// $set_status['AND status = "click" '] = array ( 'color' => 'green' , 'title' => 'Angeklickt' , 'query_count' => "COUNT(case when status ='click' then 1 else null end)" );
// $set_status['AND (status = "blocked")'] = array ( 'color' => 'black' , 'title' => 'Geblockt' , 'query_count' => "COUNT(IF(status='blocked',1,null))" );
// $set_status['AND (status = "bounce")'] = array ( 'color' => 'orange' , 'title' => 'Unzustellbar' , 'query_count' => "COUNT(IF(status='bounce',1,null))" );
// $set_status['AND (status = "spam")'] = array ( 'color' => 'red' , 'title' => 'Spam' , 'query_count' => "COUNT(IF(status='spam',1,null))" );
// $set_status['AND (status = "unsub")'] = array ( 'color' => 'blue' , 'title' => 'Abgemeldet' , 'query_count' => "COUNT(IF(status='unsub',1,null))" );

foreach ( $set_status as $status => $value ) {
	$count_query = $value['count_query'];
	// echo $count_query."<br>";
	if ($count_sql)
		$count_sql .= ',';
	$count_sql .= " CONCAT ($count_query,' (', ROUND((100/COUNT(*))*$count_query,1),'%)') $status";
}

// Gesamtzahl ermitteln
$query = $GLOBALS['mysqli']->query ( "SELECT $count_sql FROM logfile WHERE session_id = '$session_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
$array_total = mysqli_fetch_array ( $query );

foreach ( $set_status as $status => $array22 ) {
	$count = $array_total[$status];
	$title = $set_status[$status]['title'];
	$color = $set_status[$status]['color'];
	$query = $set_status[$status]['query'];
	if ($count != '0 (0.0%)') {
		$show_labels .= "<label class='label $color ui'>$title $count</label>";
		$array_filter_status[$query] = "<div class='header small $color ui'>$title</div> $count";
		//$array_filter_status[$query] = $title;
		$array_status[$status] = "<div class='label ui mini $color'>$title</div>";
	}
}
$array_status[''] = "ok";

// $array_status = array ( 'sent' => 'Zugestellt' , 'queued' => 'Verschickt' , 'open' => 'Geöffnet' , 'clicked' => 'Angeklickt' , 'blocked' => 'Geblockt' , 'bounce' => 'Unzustellbar' , 'spam' => 'Spam' );

// $arr['content']['top'] = "<div class='ui message'>" . show_status ( $session_id ) . call_landingpages ( $session_id ) . "</div>";
// $arr['content']['top'] = "<div class='ui message'>" . call_landingpages ( $session_id ) . "</div>";
$arr['list'] = array ( 'id' => 'logfile_list' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition
$arr['list']['auto_reload'] = array ( 'label' => 'Automatisches aktualisieren' , 'loader' => FALSE );

// $arr['filter']['status'] = array ( 'type' => 'dropdown' , 'array' => $array_status , 'placeholder' => '--Status--' , 'class' => '' );

if (is_array ( $array_filter_status )) {
	//$arr['filter']['status'] = array ( 'type' => 'button' , 'array' => $array_filter_status , 'class' => 'basic icon' , 'query' => "{value}"  );
	$arr['filter']['status'] = array ( 'type' => 'dropdown' , 'array' => $array_filter_status , 'class' => 'mini basic icon'  , 'query' => "{value}" );
}

// $arr['th']['id'] = array ( 'title' =>"ID" );
$arr['th']['timestamp'] = array ( 'title' =>"Datum" );
$arr['th']['name'] = array ( 'title' =>"Name" );
$arr['th']['email'] = array ( 'title' =>"Email" );
$arr['th']['status'] = array ( 'title' =>"Letzt-Status" , 'replace' => $array_status );
function call_landingpages($session_id) {
	
	// Gesamtzahl ermitteln
	$query = $GLOBALS['mysqli']->query ( "SELECT count(*) FROM logfile WHERE session_id = '$session_id' " );
	$array_total = mysqli_fetch_array ( $query );
	$total = $array_total[0];
	
	$query = $GLOBALS['mysqli']->query ( "
	SELECT  link, Count(DISTINCT contact_id) count
		FROM landingpage a 
			LEFT JOIN contact_id2landingpage_id b ON a.landingpage_id = b.landingpage_id  
			WHERE session_id  = '$session_id' 
			GROUP by a.landingpage_id" ) or die ( mysqli_error ($GLOBALS['mysqli']) );
	while ( $array = mysqli_fetch_array ( $query ) ) {
		$link = $array['link'];
		$count = $array['count'];
		$percent = round ( (100 / $total) * $count ) . "%";
		$landingpage_id = $array['landingpage_id'];
		
		// <td>$landingpage_id</td>
		$output .= "<tr><td>$link</td><td>$count ($percent)</td></tr></label>";
	}
	if ($output)
		return "
	<table class='ui small very basic celled table'>
	<thead><tr><th>Link</th><th>Besucht</th></tr></thead>
	<tbody>$output</tbody>
	</table>";
}

// Ausgabe der Felder
// function show_status($session_id) {
	
// 	// call_status ( $session_id );
// 	$set_status['queued'] = array ( 'color' => 'white' , 'title' => 'Verschickt' );
// 	$set_status['sent'] = array ( 'color' => '' , 'title' => 'Zugestellt' );
// 	$set_status['open'] = array ( 'color' => 'olive' , 'title' => 'Geöffnet' );
// 	$set_status['clicked'] = array ( 'color' => 'green' , 'title' => 'Angeklickt' );
// 	$set_status['click'] = array ( 'color' => 'green' , 'title' => 'Angeklickt' );
// 	$set_status['blocked'] = array ( 'color' => 'black' , 'title' => 'Geblockt' );
// 	$set_status['bounce'] = array ( 'color' => 'orange' , 'title' => 'Unzustellbar' );
// 	$set_status['spam'] = array ( 'color' => 'red' , 'title' => 'Spam' );
// 	$set_status['unsub'] = array ( 'color' => 'red' , 'title' => 'Abgemeldet' );
	
// 	foreach ( $set_status as $status => $array_status ) {
// 		$set_count = "COUNT(IF(status='$status',1,null))";
// 		if ($count_sql)
// 			$count_sql .= ',';
// 		$count_sql .= " CONCAT ($set_count,' (', ROUND((100/COUNT(*))*$set_count),'%)') $status";
// 	}
	
// 	// Gesamtzahl ermitteln
// 	$query = $GLOBALS['mysqli']->query ( "SELECT $count_sql FROM logfile WHERE session_id = '$session_id' " ) or die ( mysqli_error ($GLOBALS['mysqli']) );
// 	$array_total = mysqli_fetch_array ( $query );
	
// 	foreach ( $set_status as $status => $array_status ) {
// 		$count = $array_total[$status];
// 		$title = $set_status[$status]['title'];
// 		$color = $set_status[$status]['color'];
// 		if ($count != '0 (0%)')
// 			$show_labels .= "<label class='label $color ui'>$title $count</label>";
// 	}
	
// 	$show_labels .= "<div style='float:right' class='ui icon small button' onclick=\"table_reload('logfile_list')\"><i class='icon refresh'></i></div><div style='clear:both'></div>";
// 	return "$show_labels";
// }