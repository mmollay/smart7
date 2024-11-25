<?


$img_select = "(SELECT option_value FROM ssi_company.comp_options WHERE company_id = a.company_id AND option_name = 'img_logo' )";

$arr['mysql'] = array ( 
		'field' => "company_id,
		(SELECT option_value FROM ssi_company.comp_options WHERE company_id = a.company_id AND option_name = 'title' ) title,
		(SELECT option_value FROM ssi_company.comp_options WHERE company_id = a.company_id AND option_name = 'db_smartkit' ) db_smartkit,
		(SELECT option_value FROM ssi_company.comp_options WHERE company_id = a.company_id AND option_name = 'db_newsletter' ) db_newsletter,
		(SELECT option_value FROM ssi_company.comp_options WHERE company_id = a.company_id AND option_name = 'center_domain' ) center_domain,
		(SELECT option_value FROM ssi_company.comp_options WHERE company_id = a.company_id AND option_name = 'superuser_id' ) superuser_id,
		(SELECT option_value FROM ssi_company.comp_options WHERE company_id = a.company_id AND option_name = 'service_offline' ) service_offline,
		matchcode, if ($img_select != '',CONCAT('<img height=\'40\' target=\'_blank\' src=\'/company/',company_id,'/',$img_select,'\'>'),'') img_logo", 
		'table' => "ssi_company.tbl_company a" , 
		'order' => 'company_id' , 
		'limit' => 10 , 
		'where' => "" , 
		'group' => 'company_id',
		'like' => 'matchcode, title'
);

$arr['list'] = array ( 'id' => 'company_list' , 'width' => '1000px' , 'align' => '' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['th']['company_id'] = array ( 'title' =>"ID" );
$arr['th']['title'] = array ( 'title' =>"Titel" );
//$arr['th']['matchcode'] = array ( 'title' =>"Matchcode" );
$arr['th']['service_offline'] = array ( 'title' =>"Service", 'replace' => array('1'=>'<div class="label ui small red">Offline</div>','default'=>'<div class="label small ui green">Online</div>') );
$arr['th']['img_logo'] = array ( 'title' =>"Logo" );
$arr['th']['center_domain'] = array ( 'title' =>"Domain" );
$arr['th']['db_smartkit'] = array ( 'title' =>"SmartKit DB" );
$arr['th']['db_newsletter'] = array ( 'title' =>"Newsletter DB" );
$arr['th']['superuser_id'] = array ( 'title' =>"Superuser ID" );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny');
$arr['tr']['button']['left']['modal_form_comp'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );

$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny');
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );

$arr['top']['button']['modal_form_comp'] = array ( 'title' =>'Neue Firma anlegen' , 'icon' => 'plus' , 'class' => 'blue' );

$arr['modal']['modal_form_comp'] = array ( 'title' =>'Firma bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Firma entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );