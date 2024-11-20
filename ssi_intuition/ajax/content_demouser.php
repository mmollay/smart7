<?
require_once ('../config.inc.php');
include_once ('../../ssi_smart/smart_form/include_form.php');
include_once ('../functions.inc');

foreach ( $_POST as $key => $value ) {
	$GLOBALS [$key] = $GLOBALS ['mysqli']->real_escape_string ( $value );
}

if (! $_POST ['intuition_user_id'] && ! $_POST ['intuition_session_id']) {
	$arr1 ['ajax'] = array ('dataType' => "html",'success' => "$('#show_diagram').html(data); " );
	$arr1 ['header'] = array ('text' => "<div class='content ui header small'>$title_header</div>",'segment_class' => 'message attached' );
	$arr1 ['form'] = array ('id' => 'choose','width' => '800','class' => 'segment attached','size' => 'small' );
	$arr1 ['field'] [] = array ('type' => 'div','class' => 'two fields' );
	$arr1 ['field'] ['intuition_session_id'] = array ('validate' => true,'label' => 'Session','type' => 'dropdown','placeholder' => 'Session wählen','array_mysql' => 'SELECT session_id,CONCAT (session_id," (xr:",xr,")") title FROM session','onchange' => '$("#choose.ui.form").submit();' );
	$arr1 ['field'] ['intuition_user_id'] = array ('validate' => true,'label' => 'User','type' => 'dropdown','placeholder' => 'User wählen','array_mysql' => 'SELECT user_id,CONCAT(user_id," ",nickname," (Level ",level,")") FROM user','onchange' => '$("#choose.ui.form").submit();' );
	$arr1 ['field'] [] = array ('type' => 'div_close' );
	//$arr1 ['button'] ['submit'] = array ('value' => "<i class='save icon'></i>Anzeigen",'color' => 'blue' );
	$arr_output1 = call_form ( $arr1 );
	echo $arr_output1 ['html'];
	echo $arr_output1 ['js'];
	echo "<br>";
	echo "<div id = 'show_diagram'></div>";
}

if ($_POST ['intuition_user_id'] && $_POST ['intuition_session_id']) {

	//Speichern
	if (isset ( $tip )) {
		//Auslesen Level
		$sql = "SELECT * from usrdb_intubspe.user WHERE user_id = '$intuition_user_id' ";
		$query = $GLOBALS ['mysqli']->query ( $sql ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		$array = mysqli_fetch_array ( $query );
		$level = $array ['level'];

		$GLOBALS ['mysqli']->query ( "
		REPLACE INTO usrdb_intubspe.user2session SET
		session_id = '$intuition_session_id',
		user_id = '$intuition_user_id',
		level = '$level',
		tip = '$tip'  
		" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );

		#Wenn xr bereits gewählt wurde wird UPDATE für user2session gemacht
		$sql = "SELECT xr from usrdb_intubspe.session WHERE session_id = '$intuition_session_id' ";
		$query = $GLOBALS ['mysqli']->query ( $sql ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
		$array = mysqli_fetch_array ( $query );
		$xr = $array ['xr'];

		set_session_finish($session_id, $xr);
		
		
	}

	$intuition_user_id = $_POST ['intuition_user_id'];
	$intuition_session_id = $_POST ['intuition_session_id'];

	//Auslesen Level
	$sql = "SELECT * from usrdb_intubspe.user WHERE user_id = '$intuition_user_id'  ";
	$query = $GLOBALS ['mysqli']->query ( $sql ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$array = mysqli_fetch_array ( $query );
	$level = $array ['level'];
	$nickname = $array ['nickname'];

	//Auslesen Level
	$sql = "SELECT c.session_id session_id,tip, id, success, xr 
			FROM user2session a 
			LEFT JOIN user b  ON a.user_id = b.user_id
			LEFT JOIN session c  ON a.session_id = c.session_id  
				WHERE (b.user_id = '$intuition_user_id' AND  a.session_id = '$intuition_session_id') ";

	$query = $GLOBALS ['mysqli']->query ( $sql ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$array = mysqli_fetch_array ( $query );

	//print_r ( $array );

	$user2session_id = $array ['id'];
	$tip = $array ['tip'];
	$xr = $array ['xr'];

	$success = $array ['success'];

	$text_level = "<div class='ui orange label'>Level $level</div>";

	$title_header = "<i class='user circle outline icon'></i> $nickname";

	$data_kurve = json_encode ( get_x_values ( $intuition_session_id ) );
	$lable_array = json_encode ( range ( 1, 12 ) );

	$array_radio_level1 = array ('1' => "<i class='icon arrow up'></i> 1 Sprung",'0' => "<i class='icon equals'></i> Gerade",'-1' => "<i class='icon arrow down'></i> 1 Sprünge" );
	$array_radio_level2 = array ('2' => "<i class='icon arrow up'></i> 2 Sprünge",'1' => "<i class='icon arrow up'></i> 1 Sprung",'0' => "<i class='icon equals'></i> Gerade",'-1' => "<i class='icon arrow down'></i> 1 Sprünge",'-2' => "<i class='icon arrow down'></i> 2 Sprünge" );
	$array_radio_level3 = array ('3' => "<i class='icon arrow up'></i> 3 Sprünge",'2' => "<i class='icon arrow up'></i> 2 Sprünge",'1' => "<i class='icon arrow up'></i> 1 Sprung",'0' => "<i class='icon equals'></i> Gerade",'-1' => "<i class='icon arrow down'></i> 1 Sprung",
			'-2' => "<i class='icon arrow down'></i> 2 Sprünge",'-3' => "<i class='icon arrow down'></i> 3 Sprünge" );

	$array_radio = ${"array_radio_level$level"};

	$arr ['sql'] = array ('query' => "SELECT * from usrdb_intubspe.user WHERE user_id = '$intuition_user_id'" );

	$arr ['ajax'] = array ('dataType' => "html",'success' => "
	if (data=='lock') 
	{ alert('Session locked');} 
	else 
	$('#show_diagram').html(data); 
	" );
	$arr ['header'] = array ('text' => "<div class='content ui header small'>$title_header</div>",'segment_class' => 'message attached' );
	$arr ['form'] = array ('id' => 'submit_tipp','width' => '800','class' => 'segment attached','size' => 'small' );
	$arr ['field'] ['intuition_user_id'] = array ('type' => 'hidden','value' => $intuition_user_id );
	$arr ['field'] ['intuition_session_id'] = array ('type' => 'hidden','value' => $intuition_session_id );

	$arr ['field'] [] = array ('type' => 'div','class' => 'fields' );
	$arr ['field'] [] = array ('class' => 'ten wide field','type' => 'content','text' => "<div class='column' ><canvas id='chart_quartal' ></canvas></div>" );
	$arr ['field'] [] = array ('class' => 'two wide field','type' => 'content','text' => "<img src='img/canvas.png' style='position:relative; right:30px; top:60px; width:70px;'>" );
	$arr ['field'] [] = array ('class' => 'ui message','type' => 'div' );

	//if (! $user2session_id) {
	$arr ['field'] ["tip"] = array ('class' => '','type' => 'radio','class_radio_text' => 'green','class_radio' => ' large','grouped' => true,'array' => $array_radio );
	$arr ['field'] [] = array ('type' => 'content','text' => "<br>" );
	$arr ['field'] ['submit'] = array ('type' => 'button','value' => ' Tipp abgeben','icon' => 'send','color' => 'green','onclick' => "$('#submit_tipp.ui.form').submit();" );
	// 	} else {
	// 		foreach ( $array_radio as $key => $value ) {
	// 			$check_icon = "";

	// 			if ($key == $xr && $xr != 0)
	// 				$check_icon = "<i class='icon check green'></i>";

	// 			elseif ($key == $tip && $tip != $xr && $xr != 0)
	// 				$check_icon = "<i class='icon red times'></i>";
	// 			elseif ($key == $tip)
	// 				$check_icon = "<i class='icon check '></i>";

	// 			$arr ['field'] [] = array ('type' => 'content','text' => "$value $check_icon" );
	// 		}
	// 	}

	$arr ['field'] [] = array ('type' => 'div_close' );
	$arr ['field'] [] = array ('type' => 'div_close' );

	$arr_output = call_form ( $arr );

	echo $arr_output ['html'];
	echo $arr_output ['js'];
	echo "
<script>new Chart(document.getElementById('chart_quartal'), { 
	type: 'line',
	options: { 
		legend: { display: false }, 
		scales: { xAxes: [{ display: false }], yAxes: [{ display: false }], }
	},
    data: { labels: $lable_array, datasets: [{fill: true, borderColor: 'green', data: $data_kurve }] },
});</script>";
}

//Werte von Session holen
function get_x_values($session_id) {
	$sql = "SELECT * FROM usrdb_intubspe.session WHERE session_id = '$session_id' ";

	$query = $GLOBALS ['mysqli']->query ( $sql ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$array = mysqli_fetch_array ( $query );
	for($i = 1; $i <= 12; $i ++) {
		$array_kurve [$i] = $array [$i];
	}
	return array_values ( $array_kurve );
}