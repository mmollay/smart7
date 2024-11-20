<?php
$report_id = $_POST ['update_id'];

require_once ('../mysql.inc');
//Stellt die Verbindung  zur Finder->Webseite her
$query2 = $GLOBALS ['mysqli']->query ( "SELECT * FROM ssi_paneon.report LEFT JOIN ssi_paneon.report2tag ON report.report_id = report2tag.report_id WHERE report.report_id = '$report_id' " );
$array = mysqli_fetch_array ( $query2 );


echo "<a href class='ui icon button' data-tooltip='Add users to your feed'><i class='share alternate icon'></i></a>";
echo set_message ("Problem","red",$array ['problem'] );
echo set_message ("Highlight","green", $array ['highlight'] );
echo set_message ("Brief","blue", $array ['text'] );
echo set_message ("Anwort","grey", "<a href='{$array ['image']}' data-fancybox='' class='ui small left rounded floated image'><img  src=\"{$array ['image']}\"></a>".$array ['answer'] );
//echo set_message ("Jahre","blue", $array ['age']." Jahre" );




function set_message ($title, $color, $text, $class='segment') {
	return "
	<div class='ui $class $color'>
	<div class='ui large $color left ribbon label'>$title</div><br><br>
	$text
	</div>";
}


