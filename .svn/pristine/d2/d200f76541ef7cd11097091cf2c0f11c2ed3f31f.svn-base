<?php
// http://www.getorgchart.com/

function call_date($user_id,$sql,$js_parameter2) {
	
	$GLOBALS['mysqli']->query ( "SET NAMES 'utf8'" );
	$res = $GLOBALS['mysqli']->query ( $sql );
	while ( $array = mysqli_fetch_array ( $res ) ) {
		$tree[$array['id']] = array ( 
				'id' => $array['id'] , 
				'parent_id' => $array['parent_id'] , 
				'name' => $array['name'] , 
				'email' => $array['email'] , 
				'zip' => $array['zip'] , 
				'title' =>$array['title'] 
		);
	}

	/*
	 * Ruft die Struktur auf wenn ein anderer ParentID - User verwendet wird
	 */
	function formatTree($tree, $parent) {
		// GLOBAL $tree2;
		GLOBAL $json;
		if (! $json and $parent) {
			$json .= "\n{ id: " . $tree[$parent]['id'] . ", pid: null, name: '" . $tree[$parent]['name'] . "', title: '" . $tree[$parent]['title'] . "', phone: '" . $tree[$parent]['phone'] . "' , image: '', mail:'" . $tree[$parent]['email'] . "', postcode: '" . $tree[$parent]['zip'] . "',img: 'https://cdn.balkan.app/shared/empty-img-none.svg' },";
		}

		foreach ( $tree as $i => $item ) {
			if ($item['parent_id'] == $parent) {
				// $tree2[$item['id']] = $item;
				// $json .= "\n{ id: ".$item['id'].", parentId: ".$item['parent_id'].", Name: '".$item['Name']."'},";
				$json .= "\n{ id: " . $item['id'] . ", pid: " . $item['parent_id'] . ", name: '" . $item['name'] . "', title: '" . $item['title'] . "', phone: '" . $item['phone'] . "' , image: '', mail:'" . $item['email'] . "', postcode: '" . $item['zip'] . "',img: 'https://cdn.balkan.app/shared/empty-img-none.svg' },";

				formatTree ( $tree, $item['id'] );
			}
		}

		// return $tree;
		return $json;
	}

	$json = formatTree ( $tree, $user_id );
	
	
	$content = "
	<style type='text/css'>
	.center_content { padding-left:10px; padding-top:60px; ;}
	#people {width: 100%;height: 100%; }
	</style>";
	
	$content.="
	<script>
        var chart = new OrgChart(document.getElementById('people'), {
			template: 'isla',
			enableSearch: false,
            mouseScrool: OrgChart.action.none,
            nodeBinding: { 
			field_0: 'name', 
			field_1 : 'title',
			
			},
			slinks: [
                {from: 4, to: 0, label: 'text'}, 
                {from: 4, to: 5, template: 'blue', label: '4 reports to 3' },
                {from: 2, to: 6, template: 'yellow', label: 'lorem ipsum' },
            ],   
			nodes:[ $json ],
        });
    </script>
";
	
	//img_0: 'img'
	
	return "$content<div style='width:100%; height:700px;' id='people'>";
}