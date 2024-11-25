<?
include ('../../login/config_main.inc.php');
include_once ('../../ssi_smart/admin/function.inc.php');
include_once ("../../ssi_smart/smart_form/include_form.php");
include ("webnail_generator.php");

// baut aus Vor und Nachname die Domain zusammen
$query = $GLOBALS['mysqli']->query ( "SELECT * FROM ssi_company.user2company WHERE user_id = '{$_SESSION['user_id']}' " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
$array = mysqli_fetch_array ( $query );
$firstname = $array['firstname'];
$secondname = $array['secondname'];

$domain = seo_permalink ( "$firstname $secondname" );
$domain = strtolower ( $domain );

$array_company_domain_list = explode ( "\n", $array_company['smart_domains'] );
foreach ( $array_company_domain_list as $key => $value ) {
    $value = trim($value);
	if (! $first_domain) {
		$first_domain = trim($value);
	}
	$company_domain_list[$value] = $value;
}

$array['form'] = array ( 'id' => 'form_newpage' , 'action' => 'ajax/form_newpage2.php' , 'size' => '' , 'class' => '' );
$array['field'][] = array ( 'type' => 'div' , 'class' => 'fields inline' );
$array['field']['subdomain'] = array ( 'label' => 'Domain' , 'type' => 'input' , 'value' => $domain ,  'focus' => true ,  'validate' => true , 'placeholder' => 'subdomain' , 'class' => 'field inline' );
$array['field']['domain'] = array ('clear'=>false, 'type' => 'dropdown' , 'class' => '' , 'array' => $company_domain_list , 'placeholder' => '' ,  'validate' => true , 'value' => $first_domain );
$array['field'][] = array ( 'type' => 'div_close' );
// $array['field'][] = array ( 'type' => 'content' ,  'text' => "<div id='form_message'></div>" );
$array['field'][] = array ( 'type' => 'header' , 'text' => 'Vorlage wählen' , 'class' => 'center aligned block grey' );
if ($template_array) {
	$array['field']['template'] = array ( 'default_select' => 'true', 'type' => 'radio' , 'array' => $template_array ,  'validate' => true , 'overflow' => 'auto' );
} else
	$array['field'][] = array ( 'type' => 'header' , 'text' => '<br><br><br>keine Vorlagen vorhanden<br><br>' , 'class' => 'center grey aligned' );

// $array['buttons'] = array ('align'=>'center');
// $array['button']['submit'] = array ( 'value' => 'Webseite erzeugen', 'color' => 'green', 'icon' => 'plus icon');
// $array['button']['close'] = array ( 'value' => 'Abbrechen' , 'color' => 'gray' ,  'js' => "$('#edit_field, #option_global, #option_site, #modal_form').modal('hide');" );

$output = call_form ( $array );
echo $output['html'] . $output['js'];