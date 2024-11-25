<?
// Superuser
if (! in_array ($_SESSION['user_id'], $array_superuser_id )) {
	$where = " AND map_user_id='$map_user_id'";
}

$arr['mysql'] = array ( 'field' => "
		client.client_id client_id, user_id, if (client.company_1 = '',CONCAT (client.firstname,' ',client.secondname),client.company_1) company_1, 
		 COUNT(tree.client_faktura_id) tree_count, client.web, client.client_id client_id , client.client_number, client.tel,
        client.email" ,
		'table' => "
            client 
			LEFT JOIN tree ON client.client_id = tree.client_faktura_id
			
		" ,
		'order' => 'tree_count desc' ,
		'group' => 'client.client_id' ,
		'where' => $where . $add_mysql ,
		'limit' => 30 ,
		'like' => 'client.company_1,client.firstname,client.secondname,client.web,client.email' );

$arr['list'] = array ( 'id' => 'map_client' , 'width' => '100%' , 'size' => 'small' , 'class' => 'compact celled striped definition unstackable' ); // definition
$arr['list']['serial'] = false;

$arr ['mysql']['export'] = 'firstname,secondname,tel,email';

$arr['order'] = array ( 'default' => 'client_number desc' , 'array' => array ( 'client_number desc' => 'Kundennummer absteigend sortieren' , 'client_number' => 'Kundennummer aufsteigend sortieren' , 'tree_count desc' => 'Anzahl Bäume' ) );
// $arr['th']['client_id'] = array ( 'title' =>"ID" );
//$arr['th']['user_id'] = array ( 'title' =>"User_ID" );
//$arr['th']['client_number'] = array ( 'title' =>"Kd.Nr" );
$arr['th']['company_1'] = array ( 'title' =>"<i class='user icon'></i>Baumpate" );
$arr['th']['email'] = array ( 'title' =>"<i class='browser icon'></i>Email" );
$arr['th']['tel'] = array ( 'title' =>"<i class='browser icon'></i>Telefon" );
$arr['th']['tree_count'] = array ( 'title' =>"Bäume" , 'align' => 'center' );
//$arr['th']['faktura_count'] = array ( 'title' =>"Kunde" , 'align' => 'center' );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form_client'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );

$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_form_delete'] = array ( 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' , 'filter' => array ( [ 'field' => 'faktura_count' , 'operator' => '==' , 'value' => '0' ] , [ 'field' => 'tree_count' , 'operator' => '==' , 'value' => '0' , 'link' => 'and' ] ) );

$arr['modal']['modal_form_client'] = array ( 'title' =>'Baumpaten bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Client entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

$arr['top']['button']['modal_form_client'] = array ( 'title' =>'Neue Baumpaten anlegen' , 'icon' => 'plus' , 'class' => 'blue' );