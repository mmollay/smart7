<?php
include ('f_map_tree.php');

$arr['ajax'] = array (  'success' => "$('.ui.modal').modal('hide'); table_reload('form_tree');  form_tree_save('{$_POST['update_id']}',data); after_loadMap();" , 
		//  'onLoad' => "$('#zip').change(function() { alert('Test'); });",
		 'dataType' => "html" );
