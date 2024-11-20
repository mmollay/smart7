<?php
for($ii = - 1; $ii <= 1; $ii ++) {
	$add_mysql_sum .= " SUM(if(b.tip = '$ii' AND b.level=1, 1, 0))  AS `tip_1$ii` ,";
}

for($ii = - 2; $ii <= 2; $ii ++) {
	$add_mysql_sum .= " SUM(if(b.tip = '$ii' AND b.level=2, 1, 0))  AS `tip_2$ii` ,";
}

for($ii = - 3; $ii <= 3; $ii ++) {
	$add_mysql_sum .= " SUM(if(b.tip = '$ii' AND b.level=3, 1, 0)) AS `tip_3$ii` ,";
}

$arr ['mysql'] = array ('table' => 'session a 
		LEFT JOIN user2session b ON a.session_id = b.session_id
','field' => "
	a.session_id session_id, lock_session,
	x1,x2,x3,x4,x5,x6,x7,x8,x9,x10,x11,x12,x13,xr,	
	$add_mysql_sum
	DATE_FORMAT(a.timestamp,'%Y-%m-%d') timestamp , 
	(SELECT count('user_id') FROM user2session WHERE user2session.session_id = a.session_id ) `count_user` 

",'order' => 'a.session_id desc','limit' => 25,'group' => 'a.session_id','like' => '' );

$arr ['list'] = array ('id' => 'session','width' => '1100px','size' => 'small','class' => 'compact celled striped definition','serial' => false );

$arr ['tr_top'] = array ('style' => 'background-color:#EEE;',"align" => 'center' );
$arr ['th_top'] [] = array ('title' => "",'colspan' => '3' );
$arr ['th_top'] [] = array ('title' => "Eingabewerte",'colspan' => '13' );
$arr ['th_top'] [] = array ('title' => "",'colspan' => '1' );
$arr ['th_top'] [] = array ('title' => "Endwert",'colspan' => '1' );
$arr ['th_top'] [] = array ('title' => "User",'colspan' => '1' );
$arr ['th_top'] [] = array ('title' => "Level 1",'colspan' => '3' );
$arr ['th_top'] [] = array ('title' => "Level 2",'colspan' => '5' );
$arr ['th_top'] [] = array ('title' => "Level 3",'colspan' => '7' );

$arr ['tr_bottom'] = array ('style' => 'background-color:green; color:white; padding:1px;',"align" => 'center' );
$arr ['th_bottom'] [] = array ('title' => "",'colspan' => '33' );

$arr ['th'] ['session_id'] = array ('title' => "ID" );
$arr ['th'] ['timestamp'] = array ('title' => "<i class='clock icon'></i>Datum",'align' => 'center' );

//$arr ['th'] ['title'] = array ('title' => "Titel","align" => 'center' );

for($i = 2; $i <= 14; $i ++) {
	$ii = $i -1;
	$arr ['th'] [$i] = array ('title' => "X$ii","align" => 'center' );
}

$arr ['th'] ['lock_session'] = array ('replace' => array ('default' => '','1' => "<i class='icon lock'></i>",'0' => "<i class='icon grey unlock'></i>" ) );
$arr ['th'] ['xr'] = array ('title' => "Xr","align" => 'center','class' => 'red' );
$arr ['th'] ['count_user'] = array ('title' => "User","align" => 'center' );

for($ii = - 1; $ii <= 1; $ii ++) {
	$arr ['th'] ["tip_1$ii"] = array ('title' => "$ii",'class' => 'active',"align" => 'center' );
}

for($ii = - 2; $ii <= 2; $ii ++) {
	$arr ['th'] ["tip_2$ii"] = array ('title' => "$ii",'class' => '',"align" => 'center' );
}

for($ii = - 3; $ii <= 3; $ii ++) {
	$arr ['th'] ["tip_3$ii"] = array ('title' => "$ii",'class' => 'active',"align" => 'center' );
}
$arr ['top'] ['buttons'] = array ('align' => 'left' );

$arr ['top'] ['button'] ['modal_form'] = array ('title' => 'Anlegen','icon' => 'plus','class' => 'blue circular','align' => 'left' );

$arr ['tr'] = array ('style' => 'background-color:#EEE;',"align" => 'center' );
$arr ['tr'] ['buttons'] ['left'] = array ('class' => 'tiny' );
$arr ['tr'] ['button'] ['left'] ['modal_form'] = array ('title' => '','icon' => 'edit','class' => 'blue','popup' => 'Bearbeiten' );
//$arr ['tr'] ['button'] ['left'] ['modal_form'] = array ('title' => '','icon' => 'edit','class' => 'blue','popup' => 'Bearbeiten','filter' => array ([ 'field' => 'lock_session','operator' => '==','value' => '0' ] ) );
$arr ['tr'] ['button'] ['left'] ['modal_form_delete'] = array ('title' => '','icon' => 'trash','popup' => 'Löschen','class' => '' );

$arr ['modal'] ['modal_form'] = array ('title' => 'Bearbeiten','class' => '','url' => 'form_edit.php' );
$arr ['modal'] ['modal_form_delete'] = array ('title' => 'Entfernen','class' => 'small','url' => 'form_delete.php' );
