<?php
// modal_funnel_generator   id vom Modalfenster


include ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');
$user_id = $_SESSION['user_id'];

$promo_title_short = $promo_title;

//prüfen ob die Listbuildingunmmer schon vorhanden ist
$listbuilding_number = sprintf ( "%'.04d", 1 ); // '001'; //w

$query = $GLOBALS['mysqli']->query ( "SELECT * FROM {$_SESSION['db_smartkit']}.smart_page WHERE user_id = $user_id order by update_date desc" );

while ( $array = mysqli_fetch_array ( $query ) ) {
	$ii ++;
	$page_id = $array['page_id'];
	$domain = $array['smart_domain'];
	$array_domain[$page_id] = $domain;
}

// Auslesen promo_title and amazon_asin
$query = $GLOBALS['mysqli']->query ( "SELECT a.title promotion_title, a.amazon_asin amazon_asin FROM promotion a LEFT JOIN formular b ON a.promotion_id = b.promotion_id WHERE b.form_id = '{$_POST['update_id']}' " );
$arr['ajax'] = array ( 'success' => "if (data == 'ok') { 
	$('#modal_funnel_generator').modal('hide'); 
		message({'title':'Funnel erzeugt', text: 'Seite bearbeitbar im Smart-Kit', type:'success'});
}" ,  'dataType' => "html" );
$array = mysqli_fetch_array ( $query );

$promotion_title = $array['promotion_title'] . "&nbsp;" . "<div class='ui small label'><i class='icon amazon'></i>" . $array['amazon_asin'] . "</div>";
// $amazon_asin = $array['amazon_asin'];

$arr['form'] = array ( 'action' => "ajax/form_funnelgenerator2.php" , 'id' => 'generate_funnel' , 'inline' => 'list' );

$arr['field']['promo_title'] = array ( 'type' => 'text' , 'label' => "$promotion_title" );
// $arr['field']['amazon_asin'] = array ( 'type' => 'text' , 'label' => $amazon_asin, 'class'=>'ui label' );

$arr['field']['page_id'] = array ( 'type' => 'dropdown' , 'label' => 'Domain wählen' , 'array' => $array_domain ,  'focus' => true ,  'validate' => true );
$arr['field']['funnel_short'] = array ('class_input'=>'check_url', 'type' => 'input' , 'label' => 'Funnel-Kürzel' , 'value' => $promo_title_short ,  'validate' => true );

$arr['field'][] = array ( 'type' => 'div' , 'class' => 'ui message' );
$arr['field']['funnel_lp'] = array ('class_input'=>'check_url', 'type' => 'input' , 'label_left' => "https://<span class='funnel_domain'></span>/funnel/<span class='funnel_short'></span>/" , 'label' => 'Landing-Page URL' , 'value' => "$listbuilding_number-lp" ,  'validate' => true );
$arr['field']['funnel_ff'] = array ('class_input'=>'check_url', 'type' => 'input' , 'label_left' => "https://<span class='funnel_domain'></span>/funnel/<span class='funnel_short'></span>/" , 'label' => 'FastFertig-Page URL' , 'value' => "$listbuilding_number-ff" ,  'validate' => true );
$arr['field']['funnel_gr'] = array ('class_input'=>'check_url', 'type' => 'input' , 'label_left' => "https://<span class='funnel_domain'></span>/funnel/<span class='funnel_short'></span>/" , 'label' => 'Gratulations-Page URL' , 'value' => "$listbuilding_number-gr" ,  'validate' => true );
$arr['field'][] = array ( 'type' => 'div_close' );

$arr['button']['submit'] = array ( 'value' => "<i class='save icon'></i>Funnel-Pages erzeugen" , 'color' => 'blue' );

$arr['hidden']['pool_id'] = $pool_id;
$arr['hidden']['update_id'] = $_POST['update_id'];
$arr['hidden']['list_id'] = $_POST['list_id'];
$arr['button']['close'] = array ( 'value' => 'Abbrechen' , 'color' => 'gray' ,  'js' => "$('.modal.ui').modal('hide'); " );

$output = call_form ( $arr );
echo $output['html'];
echo $output['js'];
echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"js/generate_funnel.js\"></script>";