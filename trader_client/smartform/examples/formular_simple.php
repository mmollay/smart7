<?
include_once ("../include_form.php");

$arr['form'] = array('id' => 'form', 'action' => 'ajax/handler.php', 'class' => 'segment attached', 'width' => '800', 'align' => 'center', 'keyboardShortcuts' => true, 'inline' => 'list');
$arr['ajax'] = array('success' => "$('#show_data').html(data);", 'dataType' => 'html', "confirmation" => true);
$arr['field']['date'] = array('type' => 'calendar', 'label' => 'Date', 'value' => date("Y-m-d"), 'clearable' => true);

$arr['ajax']['confirmation'] = array('text' => array('content' => 'Please confirm'));

$arr['field'][] = array('type' => 'line', 'text' => 'more');


//Method 1 for grid
$arr['field']['firstname'] = array('grid' => 'first', 'type' => 'input', 'label' => 'Firstname', 'placeholder' => 'Firstname', 'validate' => true, 'focus' => true, 'clearable' => true);
$arr['field']['secondname'] = array('grid' => 'second', 'type' => 'input', 'label' => 'Secondname', 'placeholder' => 'Secondname', 'clearable' => true);
$arr['field']['more'] = array('grid' => 'more', 'type' => 'input', 'label' => 'More');
$arr['field']['grid'] = array('type' => 'grid', 'class' => '', 'column' => ["first" => '4', "second" => "4", "more" => "8"]);

$arr['field']['drop'] = array('type' => 'multiselect', 'label' => 'Drop', 'search' => true, 'clearable' => true, 'array' => array('wood' => 'Wood', 'water' => 'Water', 'wild' => 'Wild'), 'value' => array('wood', 'water'));

$arr['field']['drop_single'] = array('type' => 'dropdown', 'label' => 'Drop (single)', 'search' => true, 'clearable' => true, 'array' => array('wood' => 'Wood', 'water' => 'Water', 'wild' => 'Wild'), 'value' => array('wood', 'water'));


//Method 2 for grid (fields next to next)
$arr['field'][] = array('type' => 'div', 'class' => 'equal fields');
$arr['field']['image'] = array('label' => 'URL 1', 'type' => 'finder', 'flyout' => array('title' => 'Finder'), 'wide' => 'eight');
$arr['field']['image2'] = array('label' => 'URL 2', 'type' => 'finder', 'flyout' => array('title' => 'Finder'), 'wide' => 'eight');
$arr['field'][] = array('type' => 'div_close');

$arr['field'][] = array('type' => 'content', 'text' => '<div id=form_message></div>');
$arr['hidden']['id'] = '10';

$arr['buttons'] = array('align' => 'center', 'class' => 'fluid');
$arr['button']['submit'] = array('value' => 'Submit', 'color' => 'green');
$arr['button'][] = array('type' => 'or', 'value' => 'or');
$arr['button']['cancel'] = array('value' => 'Cancel', 'class' => 'clear', 'color' => 'red', 'js' => "alert('close');");
// $arr ['field'] ['submit'] = array ('type' => 'button','value' => 'Submit','class' => 'submit','align' => 'center' );

$output_form = call_form($arr);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'>
	<title>Formular - Small</title>
	<link rel="stylesheet" href="../semantic/dist/semantic.min.css">
</head>

<body>

	<?= $output_form['flyout'] ?>
	<div class="pusher">
		<div class="ui main text container">
			<br> <br> <a href='../index.php'>
				< Back</a> <br> <br>
					<?= $output_form['html'] ?>
					<div id='show_data'></div>
		</div>
	</div>

	<script src="../jquery/jquery.min.js"></script>
	<script src="../semantic/dist/semantic.min.js"></script>
	<script src="../js/smart_form.js"></script>
	<?= $output_form['js'] ?>
</body>

</html>