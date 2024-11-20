<?php
session_start ();

if ($_GET ['share_id']) {
	$input = "https://erfolgsberichte.paneon.cc/page.php?id={$_GET ['share_id']}";
} else
	$input = $_SESSION ['page_link'] ['report_list'];

echo "Link herauskopieren:<br>";
echo "<div class='ui fluid icon input focus'><input value='$input' onFocus='this.select()'></div>";
echo "<br><div class='ui label'>ctrl + c</div> =  Copy";
?>