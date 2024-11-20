<?php
$clone = $_GET['clone'];

$arr['ajax'] = array('success' => "after_form_hedging(data)", 'dataType' => "html");
// $arr['tab'] = array('tabs' => array(1 => 'Default', 2 => 'More'), 'active' => '1');

if (!$clone) {
	$arr['sql'] = array('query' => "SELECT * from ssi_trader.hedging_group WHERE group_id  = '{$_POST['update_id']}' ");
} else
	$arr['sql'] = array('query' => "SELECT group_id,CONCAT(title,'_clone') title ,text from ssi_trader.hedging_group WHERE group_id  = '{$_POST['update_id']}'");


$arr['field']['title'] = array('tab' => '1', 'type' => 'input', 'label' => 'Title', 'focus' => true);
$arr['field']['text'] = array('tab' => '1', 'type' => 'textarea', 'label' => 'Description');

$stmt = $GLOBALS['mysqli']->prepare("SELECT lots, entrypoint, takeprofit, info FROM ssi_trader.hedging WHERE group_id = ? AND level = ?");
$update_id = $_POST['update_id'];

for ($i = 1; $i <= 14; $i++) {
	$stmt->bind_param("ii", $update_id, $i);
	$stmt->execute();
	$result = $stmt->get_result();
	$lotsValue = ''; // Default value if no entry is found
	$infoValue = '';
	$entrypointValue = '';
	$takeprofitValue = '';

	if ($row = $result->fetch_assoc()) {
		$lotsValue = $row['lots']; // Value from the database
		$infoValue = $row['info'];
		$entrypointValue = $row['entrypoint'];
		$takeprofitValue = $row['takeprofit'];
	}

	$arr['field'][] = array('type' => 'div', 'class' => 'fields width');
	// $arr['field'][] = array('type' => 'content', 'label' => "Level $i");
	$arr['field']["lots$i"] = array('type' => 'input', 'label' => "$i Lots", 'class' => 'inline', 'value' => $lotsValue);
	$arr['field']["entrypoint$i"] = array('type' => 'input', 'label' => "Entrypoint", 'class' => 'inline', 'value' => $entrypointValue);
	$arr['field']["takeprofit$i"] = array('type' => 'input', 'label' => "Takeprofit", 'class' => 'inline', 'value' => $takeprofitValue);
	//$arr ['field'] ["info$i"] = array ('type' => 'input','label' => "",'placeholder' => 'Comment','value' => $infoValue );
	$arr['field'][] = array('type' => 'div_close');
}

if ($clone) {
	$arr['field']['clone'] = array('type' => 'hidden', 'value' => '1');
}

$stmt->close();

$add_js .= "<script type=\"text/javascript\" src=\"js/form_strategy.js\"></script>";