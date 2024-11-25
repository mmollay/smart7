<?

//Gattung/Art

$arr['mysql'] = array ( 'field' => 'tree_group_id, tree_group_lang.title,  name family_name, COUNT(tree_id) count,
     CONCAT("<div class=\' ui fluid centered ",color," label\'><img height=\'50px\' src=\'../ssi_smart/gadgets/map/icons/",tree_group.matchcode,".png\'></img></div>") matchcode,color
     ',
		'table' => 'tree_group
			LEFT JOIN tree_group_lang  ON tree_group_lang.group_id = tree_group.tree_group_id  AND tree_group_lang.lang = "de"
			LEFT JOIN tree_family_lang ON tree_family_lang.family_lang_id = tree_group.family_id
			LEFT JOIN (tree,tree_template) ON tree.plant_id = tree_template.temp_id AND tree_template.group_id = tree_group.tree_group_id  ',	
		'order' => 'count desc' ,
		'group' => 'tree_group.tree_group_id' ,
		'like' => 'tree_group_lang.title' ,
		'limit' => '40' );

$arr['order'] = array ( 'default' => 'title desc' , 'array' => array (
	'count desc' => 'Anzahl der Bäume absteigend sortieren' ,
    'count' => 'Anzahl der Bäume aufsteigend sortieren' ,
	'title' => 'Titel aufsteigend sortieren' ,
    'title desc' => 'Titel absteigend sortieren' ,
    'tree_group_id' => 'nach ID' ) );


$arr['list'] = array ('serial'=>false, 'id' => 'map_speciesgroup' , 'width' => '800px' , 'size' => 'small' , 'class' => 'compact celled striped definition unstackable' ); // definition

//$arr['th']['tree_group_id'] = array ( 'title' =>"ID" );
$arr['th']['title'] = array ( 'title' =>"Titel" );
$arr['th']['family_name'] = array ( 'title' =>"Familie" );
$arr['th']['matchcode'] = array ( 'title' =>"Grafik", 'align'=>'center' );
$arr['th']['count'] = array ( 'title' =>"Anzahl der Bäume" );

$arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['left']['modal_form_group'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );

$arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
$arr['tr']['button']['right']['modal_form_delete'] = array ('filter' => array ( [ 'field' => 'count' , 'operator' => '==' , 'value' => '0' ]) , 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );

$arr['top']['button']['modal_form_group'] = array ( 'title' =>'Neue Sortengruppe anlegen' , 'icon' => 'plus' , 'class' => 'blue' );
$arr['modal']['modal_form_group'] = array ( 'title' =>'Sortengruppe bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
$arr['modal']['modal_form_delete'] = array ( 'title' =>'Sortengruppe entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );

// $arr['mysql'] = array ( 'field' => 'tree_group_lang.group_id group_id,count(tree_id) count, tree_group,tree_group_lang.title, family_id, tree_family_lang.name family_name' ,
// 		'table' => 'tree_group_lang LEFT JOIN (client,tree_template,tree_template_lang,tree)
// 			ON client.client_id = tree.client_faktura_id
// 			AND tree_template_lang.temp_id = tree_template.temp_id
// 			AND tree_group_lang.matchcode = tree_template.tree_group
// 			AND tree.plant_id = tree_template.temp_id
// 			AND tree_group_lang.lang = "de" 
// 			LEFT JOIN tree_group ON tree_group_lang.group_id = tree_group.tree_group_id 
// 			LEFT JOIN tree_family_lang ON tree_family_lang.family_lang_id = tree_group.family_id'
// 		,
// 		'order' => 'count desc' ,
// 		'group' => 'tree_group_lang.group_id' ,
// 		'like' => 'tree_group_lang.title' ,
// 		'limit' => '20' );

// $arr['list'] = array ( 'id' => 'map_speciesgroup' , 'width' => '100%' , 'size' => 'small' , 'class' => 'compact celled striped definition unstackable' ); // definition

// $arr['th']['group_id'] = array ( 'title' =>"Titel" );
// $arr['th']['title'] = array ( 'title' =>"Titel" );
// $arr['th']['count'] = array ( 'title' =>"Anzahl der Bäume" );
// $arr['th']['family_name'] = array ( 'title' =>"Familie" );
// //$arr['th']['matchcode'] = array ( 'title' =>"Machcode" );

// $arr['tr']['buttons']['left'] = array ( 'class' => 'tiny' );
// $arr['tr']['button']['left']['modal_form_group'] = array ( 'title' =>'' , 'icon' => 'edit' , 'class' => 'blue mini' , 'popup' => 'Bearbeiten' );

// $arr['tr']['buttons']['right'] = array ( 'class' => 'tiny' );
// $arr['tr']['button']['right']['modal_form_delete'] = array ('filter' => array ( [ 'field' => 'count' , 'operator' => '==' , 'value' => '0' ]) , 'title' =>'' , 'icon' => 'trash' , 'class' => 'mini' , 'popup' => 'Löschen' );

// $arr['top']['button']['modal_form_group'] = array ( 'title' =>'Neue Sortengruppe anlegen' , 'icon' => 'plus' , 'class' => 'blue' );
// $arr['modal']['modal_form_group'] = array ( 'title' =>'Sortengruppe bearbeiten' , 'class' => '' , 'url' => 'form_edit.php' );
// $arr['modal']['modal_form_delete'] = array ( 'title' =>'Sortengruppe entfernen' , 'class' => 'small' , 'url' => 'form_delete.php' );
