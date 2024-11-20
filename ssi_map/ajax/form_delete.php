<?php
include ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

if (! $_POST['delete_id']) {

    if ($_POST['list_id'] == 'tree_remove') {
        // Nur bei Baum
        $arr['ajax'] = array('success' => "$('.modal.ui').modal('hide');  $('#load_map').gmap3({ clear:{ id: '{$_POST['update_id']}' } }); loadMenu(); after_loadMap(); message({ title: 'Entfernen', text:'Baum wurde entfernt'});",'dataType' => "html");
    } else
        // Bei Listen-Löschung
        $arr['ajax'] = array('success' => "$table_reload $('.modal.ui').modal('hide'); table_reload(); message({ title: 'Entfernen', text:'Ein Eintrag wurde entfernt'});",'dataType' => "html");

    $arr['hidden']['list_id'] = $_POST['list_id'];
    $arr['hidden']['delete_id'] = $_POST['update_id'];
    $arr['button']['submit'] = array('value' => 'Löschen','color' => 'red');
    $arr['button']['close'] = array('value' => 'Abbrechen','color' => 'gray','js' => "$('.modal.ui').modal('hide');");
    $output = call_form($arr);
    echo $output['js'];
    echo $output['html'];
    exit();
}

$del_id = $_POST['delete_id'];

switch ($_POST['list_id']) {

    case 'tree_remove':
    case 'map_tree':
        if ($del_id) {
            $GLOBALS['mysqli']->query("UPDATE tree SET trash = 1  where tree_id = '$del_id' Limit 1") or die(mysqli_error($GLOBALS['mysqli']));
        }
        break;
    case 'map_location':
        $GLOBALS['mysqli']->query("DELETE FROM tree_places WHERE place_id = '$del_id' AND !(SELECT COUNT(*) FROM tree WHERE district2 = '$del_id')") or die(mysqli_error($GLOBALS['mysqli']));
        break;

    case 'map_family':
        $GLOBALS['mysqli']->query("
				DELETE tree_family, tree_family_lang FROM tree_family, tree_family_lang
		 		WHERE family_id = family_lang_id
		 		AND family_id = '$del_id'
		 		AND !(SELECT COUNT(*) FROM tree_group_id WHERE tree_group_id = '$del_id')
		 		") or die(mysqli_error($GLOBALS['mysqli']));

        $GLOBALS['mysqli']->query("DELETE FROM tree_family WHERE family_id = '{$_POST['delete_id']}' LIMIT 1") or die(mysqli_error($GLOBALS['mysqli']));
        $GLOBALS['mysqli']->query("DELETE FROM tree_family_lang WHERE family_lang_id = '{$_POST['delete_id']}'") or die(mysqli_error($GLOBALS['mysqli']));
        break;

    case 'map_client':
        $GLOBALS['mysqli']->query("DELETE FROM client WHERE client_id = '{$_POST['delete_id']}' 
			AND (SELECT COUNT(*) FROM bills WHERE bills.client_id = '{$_POST['delete_id']}') = 0	
			AND (SELECT COUNT(*) FROM tree WHERE client_faktura_id = '{$_POST['delete_id']}') = 0
				LIMIT 1 ") or die(mysqli_error($GLOBALS['mysqli']));
        break;
    case 'map_speciesgroup':
        $GLOBALS['mysqli']->query("DELETE FROM tree_group_lang WHERE group_id = '$del_id' AND !(SELECT COUNT(*) FROM tree LEFT JOIN tree_template ON tree.plant_id = tree_template.temp_id WHERE tree_template.group_id = '$del_id' LIMIT 1)") or die(mysqli_error($GLOBALS['mysqli']));
        $GLOBALS['mysqli']->query("DELETE FROM tree_group WHERE tree_group_id = '$del_id' AND !(SELECT COUNT(*) FROM tree LEFT JOIN tree_template ON tree.plant_id = tree_template.temp_id WHERE tree_template.group_id = '$del_id' LIMIT 1)") or die(mysqli_error($GLOBALS['mysqli']));

        // $GLOBALS['mysqli']->query ( "
        // DELETE tree_group, tree_group_lang FROM tree_group, tree_group_lang
        // WHERE group_id = tree_group_id
        // AND group_id = '$del_id'
        // AND !(SELECT COUNT(*) FROM tree LEFT JOIN tree_template ON tree.plant_id = tree_template.temp_id WHERE tree_template.group_id = '$del_id' LIMIT 1)
        // " ) or die ( mysqli_error ( $GLOBALS['mysqli'] ) );
        break;

    case 'map_species':
        $GLOBALS['mysqli']->query("
				DELETE tree_template, tree_template_lang FROM tree_template, tree_template_lang
		 		WHERE tree_template.temp_id = tree_template_lang.temp_id
		 		AND tree_template.temp_id = '$del_id'
		 		AND !(SELECT COUNT(*) FROM tree WHERE plant_id = '$del_id')
		 		") or die(mysqli_error($GLOBALS['mysqli']));
        break;
}