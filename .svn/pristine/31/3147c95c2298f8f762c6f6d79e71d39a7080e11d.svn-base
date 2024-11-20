<?php
$report_id = $_GET ['id'];

if ($_GET ['id']) {
	include ('page.php');
	exit ();
} 

$list_id = 'report_list';
include ("../../smart_form/include_list.php");
$array = call_list ( '../../ssi_smart/gadgets/paneon_report/array_report.php', 'mysql.inc' );
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>PANEON - Erfolgsberichte</title>
<link rel="stylesheet" href="/smartform/semantic/dist/semantic.min.css">
<link rel='shortcut icon' href='https://www.paneon.net/explorer/favicon.png' type='image/x-icon'>
<script src="/smartform/jquery/jquery.min.js"></script>
<script src="/smartform/semantic/dist/semantic.min.js"></script>
<script>var smart_form_wp = '/smartform/'</script>
<script src="/smartform/js/smart_list.js"></script>
</head>
<body>
<?php include('header.php');?>
	<div class="ui center aligned container">
		<br>
		<div class="ui container"><?=$array['html']?></div>
	</div>
	<br><?php include('footer.php');?>
	<?=$array['js']?>
</body>
</html>