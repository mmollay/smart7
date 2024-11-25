<?php
include ('../config.inc.php');

// Zugangsdaten fuer die Datenbank
foreach ($_POST as $key => $value) {
    $GLOBALS[$key] = $GLOBALS['mysqli']->real_escape_string($value);
}

switch ($_POST['list_id']) {
    case 'form_tree':
    case 'map_tree':

        if ($search_sponsor)
            $search_sponsor = 1;
        else 
            $search_sponsor = 0;
        
        if (! $client_id)
            $client_id = 0;
        if (! $client_faktura_id)
            $client_faktura_id = 0;
        if (! $baum_pate)
            $baum_pate = 0;
        if (! $plant_id)
            $plant_id = 0;
        if (! $order_date)
            $order_date = '0000-00-00';
        if (! $tree_rm_date)
            $tree_rm_date = '0000-00-00';
        if (! $district2)
            $district2 = 0;

        if ($tree_id == 'new') {

            $distict2 = $_SESSION["map_filter"]['map_places'] ?? 0;
            $zip = isset($_SESSION["map_filter"]['map_zip']) ?? 0;

            $sql = "INSERT INTO tree SET
                search_sponsor = $search_sponsor,
    			baum_pate  = $baum_pate,
    			plant_id = $plant_id,
    			client_id = $client_id,
                trash = 0,
    			client_faktura_id = $client_faktura_id,
    			tree_panel = '',
    			order_date = '$order_date',
    			remark   = '',
    			tree_rm_date = '$tree_rm_date',
    			tree_rm_reason = '$tree_rm_reason',
    			plant_date  = NOW(),
    			latitude = '$latitude',
    			longtitude = '$longtitude',
    			zip = $zip,
    			district2 = $distict2,
    			article_faktura_id = $article_faktura_id
            ";

            // Neuen Baum setzen
            $GLOBALS['mysqli']->query($sql) or die(mysqli_error($GLOBALS['mysqli'])); // Artikel ID von der Faktura fuer das jeweilige Produkt

            // Wird gespeichert, damit neugesetzter Baum gleich bearbeitet werden kann (siehe /temp/window.php)
            $_SESSION['tree_insert_id'] = mysqli_insert_id($GLOBALS['mysqli']);
        } elseif ($tree_id) {
            // UPDATE Koordinaten
            $GLOBALS['mysqli']->query("
            UPDATE tree SET
			latitude = '$latitude',
			longtitude = '$longtitude'
			WHERE tree_id = '$tree_id'
			") or die(mysqli_error($GLOBALS['mysqli']));
        } elseif ($update_id) {

            $sql = "
			UPDATE tree SET
			search_sponsor = $search_sponsor,
			baum_pate  = $baum_pate,
			plant_id = $plant_id,
			client_id = $client_id,
			client_faktura_id = $client_faktura_id,
			tree_panel = '$tree_panel',
			latitude = '$latitude',
			longtitude = '$longtitude',
			plant_date  = '$plant_date',
			order_date = '$order_date',
			district2 = $district2,
			zip = $zip,
			remark   = '$remark',
			tree_rm_date = '$tree_rm_date',
			tree_rm_reason = '$tree_rm_reason'
			WHERE tree_id = '$update_id'
            ";

            // Save and UPDATE new Tree
            $GLOBALS['mysqli']->query($sql) or die(mysqli_error($GLOBALS['mysqli']));
        }

        if ($tree_id == 'new') {
            echo $_SESSION['tree_insert_id'];
        } else
            echo "ok";

        break;

    case 'map_location':
        if ($update_id) {
            $GLOBALS['mysqli']->query("UPDATE tree_places SET name = '$name', zip = '$zip' WHERE place_id = '$update_id' ") or die(mysqli_error($GLOBALS['mysqli']));
        } else {
            $GLOBALS['mysqli']->query("INSERT INTO tree_places SET name = '$name' , zip = '$zip' ") or die(mysqli_error($GLOBALS['mysqli']));
        }
        echo "ok";
        break;

    case 'map_species':

        $GLOBALS['mysqli']->query("REPLACE INTO tree_template SET
			temp_id = '$update_id',
			group_id = '$group_id',
			latin = '$latin',
			ripe_for_picking = '$ripe_for_picking',
			mature_pleasure = '$mature_pleasure',
			taste_id = '$taste_id',
			chooseable = '$chooseable'
			") or die(mysqli_error($GLOBALS['mysqli']));
        $temp_id = mysqli_insert_id($GLOBALS['mysqli']);

        $GLOBALS['mysqli']->query("REPLACE INTO tree_template_lang SET
			temp_id = $temp_id,
			lang = 'de',
			fruit_type = '$fruit_type',
			fruit_type2 = '$fruit_type2',
			worth_knowing = '$worth_knowing',
			wiki = '$wiki'
			") or die(mysqli_error($GLOBALS['mysqli']));
        break;

    case 'map_speciesgroup':

        if (! $family_id)
            $family_id = 0;
        if ($update_id) {
            $GLOBALS['mysqli']->query("UPDATE tree_group SET 
            color = '$color', 
            family_id = $family_id, 
            tree_group_id = $update_id, 
            matchcode = '$matchcode' 
                WHERE tree_group_id = $update_id  ") or die(mysqli_error($GLOBALS['mysqli']));

            $GLOBALS['mysqli']->query("
            UPDATE tree_group_lang SET 
            title = '$title_de', description = '$description_de' 
                WHERE group_id = '$update_id' AND lang='de'  
            ") or die(mysqli_error($GLOBALS['mysqli']));

            $GLOBALS['mysqli']->query("
            UPDATE tree_group_lang SET
            title = '$title_en', description = '$description_en'
                WHERE group_id = '$update_id' AND lang='en'
            ") or die(mysqli_error($GLOBALS['mysqli']));
        } else {
            $GLOBALS['mysqli']->query("INSERT INTO tree_group SET color = '$color', family_id = '$family_id',  matchcode = '$matchcode' ") or die(mysqli_error($GLOBALS['mysqli']));
            $group_id = mysqli_insert_id($GLOBALS['mysqli']);
            $GLOBALS['mysqli']->query("INSERT INTO tree_group_lang SET lang='de', title = '$title_de', description = '$description_de', group_id = '$group_id' ") or die(mysqli_error($GLOBALS['mysqli']));
            $GLOBALS['mysqli']->query("INSERT INTO tree_group_lang SET lang='en', title = '$title_en', description = '$description_en', group_id = '$group_id' ") or die(mysqli_error($GLOBALS['mysqli']));
        }
        echo "ok";
        break;

    case 'map_taste':
        if ($update_id) {
            $GLOBALS['mysqli']->query("REPLACE INTO tree_taste SET taste_id = '$update_id', matchcode = '$matchcode' ") or die(mysqli_error($GLOBALS['mysqli']));
            $GLOBALS['mysqli']->query("REPLACE INTO tree_taste_lang SET lang='de', title = '$title_de', description = '$description_de', taste_id = '$update_id' ") or die(mysqli_error($GLOBALS['mysqli']));
            $GLOBALS['mysqli']->query("REPLACE INTO tree_taste_lang SET lang='en', title = '$title_en', description = '$description_en', taste_id = '$update_id' ") or die(mysqli_error($GLOBALS['mysqli']));
        } else {
            $GLOBALS['mysqli']->query("INSERT INTO tree_taste SET  taste_id = '$update_id', matchcode = '$matchcode' ") or die(mysqli_error($GLOBALS['mysqli']));
            $taste_id = mysqli_insert_id($GLOBALS['mysqli']);
            $GLOBALS['mysqli']->query("INSERT INTO tree_taste_lang SET lang='de', title = '$title_de', description = '$description_de', taste_id = '$taste_id' ") or die(mysqli_error($GLOBALS['mysqli']));
            $GLOBALS['mysqli']->query("INSERT INTO tree_taste_lang SET lang='en', title = '$title_en', description = '$description_en', taste_id = '$taste_id' ") or die(mysqli_error($GLOBALS['mysqli']));
        }
        echo "ok";
        break;

    case 'map_family':

        if ($update_id) {
            $GLOBALS['mysqli']->query("UPDATE tree_family_lang SET name = '$name' , description = '$description' WHERE family_lang_id = $update_id AND lang='de' ") or die(mysqli_error($GLOBALS['mysqli']));
        } else {
            $GLOBALS['mysqli']->query("INSERT INTO tree_family SET user_id = '$user_id' ") or die(mysqli_error($GLOBALS['mysqli']));
            $family_id = mysqli_insert_id($GLOBALS['mysqli']);
            $GLOBALS['mysqli']->query("INSERT INTO tree_family_lang SET name = '$name' , description = '$description', lang='de', family_lang_id = $family_id");
        }
        break;
    case 'map_client':

        if ($update_id) {

            if (! isset($newsletter))
                $newsletter = 0;
            $GLOBALS['mysqli']->query("UPDATE client SET
			company_1 = '$company_1',
			company_2 = '$company_2',
			firstname = '$firstname',
			secondname = '$secondname',
			web   = '$web',
			email = '$email',
			user_id = '$user_id',
			map_user_id = '$user_id',
			tel  = '$tel',
			`desc` = '$desc',
			gender = '$gender',
			commend = '$commend',
			zip = '$zip',
			city = '$city',
			street = '$street',
			newsletter = '$newsletter',
			logo   = '$logo' 
            WHERE client_id = $update_id
            ") or die(mysqli_error($GLOBALS['mysqli']));
        } else {

            // Client -Number (eindeutig) wird ausgelesen +1
            $query = $GLOBALS['mysqli']->query("SELECT MAX(client_number) FROM client");
            $array = mysqli_fetch_array($query);
            $client_number = $array[0] + 1;

            // map_user_id = '$user_id',

            // comapny_id = 30 also Obstadtkonto (wird aber zukünftig für andere Gmeinden angepasst
            $GLOBALS['mysqli']->query("INSERT INTO client SET
			user_id = '$user_id',
			client_number = '$client_number',
			reg_date = now(),
			map_page_id = '{$_SESSION ['smart_page_id']}',
			map_user_id = '{$_SESSION['user_id']}',
			company_1 = '$company_1',
			company_2 = '$company_2',
			firstname = '$firstname',
			secondname = '$secondname',
			web   = '$web',
			email = '$email',
			tel  = '$tel',
			`desc` = '$desc',
			gender = '$gender',
			commend = '$commend',
			zip = '$zip',
			city = '$city',
			street = '$street',
			logo   = '$logo' ") or die(mysqli_error($GLOBALS['mysqli']));
            echo "ok user_id = $user_id";
        }
}
