<?php
$arr['mysql'] = array ( 
		'table'=>'amazon_order a',
		'field' => "id, order_id, amazon_promotion_id,timestamp,buyer_name,purchase_date,product_name",
		'order' => 'timestamp desc' , 
		'limit' => 25,  
		//'debug'=> true,
		'group' => 'id',
		'where' => "AND a.user_id = '{$_SESSION['user_id']}' AND amazon_promotion_id != '' " ,
		'like' => 'code,email',
		//'export' => 'order_id,amazon_promotion_id,buyer_name,product_name,purchase_date'
);

$arr['list'] = array ( 'id' => 'amazon_order_list' , 'size' => 'small' , 'class' => 'compact celled striped definition' ); // definition

$arr['filter']['amazon_promotion_id'] = array ( 'type' => 'select', 'array' => call_array_promotion2(), 'placeholder' => '--Promotion--', 'class'=>'',  'table'=>'a' );

//$arr['filter']['promotion_id'] = array ( 'type' => 'select', 'array' => call_array_promotion(), 'placeholder' => '--Promotion--', 'class'=>'',  'table'=>'a' );

$arr['th']['order_id'] = array ( 'title' =>"Order ID" );
$arr['th']['amazon_promotion_id'] = array ( 'title' =>"Nachverfolgungsnummer");
//$arr['th']['email'] = array ( 'title' =>"<i class='user icon'></i>Userzuweisung");
$arr['th']['buyer_name'] = array ( 'title' =>"Käufername");
//$arr['th']['product_name'] = array ( 'title' =>"Produktnamen");
$arr['th']['purchase_date'] = array ( 'title' =>"<i class='clock icon'></i>Datum" , 'align' => 'center' );

//$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
//$arr['tr']['button']['left']['modal_form'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue' , 'popup' => 'Bearbeiten' );
//$arr['tr']['button']['right']['modal_form_delete_code'] = array ( 'title' =>'' , 'icon' => 'trash' , 'popup' => 'Löschen', 'class'=>'' );

//$arr['modal']['modal_form_code'] = array ( 'title' =>'Code bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
//$arr['modal']['modal_form_delete_code'] = array ( 'title' =>'Code entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

//$arr['top']['button']['modal_form_code'] = array ( 'title' =>'Neue Codes eintragen' , 'icon' => 'plus' , 'class' => 'blue circular' );