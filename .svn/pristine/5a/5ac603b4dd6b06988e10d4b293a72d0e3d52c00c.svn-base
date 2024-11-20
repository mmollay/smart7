<?php
/*
 * INFO ZUM DYNAMSCHEN HINZUGFÜGEN VON FELDERN
 * Habe dies schon mit add_tag2user.php gemacht.
 * Dabei habe ich mit jquery einfach die Felder in das jeweilige Formular eingebracht:
 * BSP:
 * $('#add_group').append("<div id='row_tag<?=$id?>' class='field row_field inline'><div class='ui toggle checkbox'><input id='tag<?=$id?>' class='form_edit hidden' value='1' name='tag<?=$id?>' tabindex='0' type='checkbox' <?=$checked?>><label id='label_tag<?=$id?>' class='label'><?=$title?></label></div></div>");
 * $('.ui.checkbox').checkbox();
 * Das Formular übernimmt dabei die Parameter und kann wie gewohnt Save-Formlar verarbeitet werden
 */
include ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');
$user_id = $_SESSION ['user_id'];

switch ($_POST ['list_id']) {

	// Formular für Pool
	case 'followup_pool_list' :
		$arr ['ajax'] = array ('onLoad' => $onload,'success' => "
		if (data=='ok') {
			$('.modal.ui').modal('hide'); 
			table_reload('followup_list');
			table_reload('followup_pool_list');
			new PNotify({ title: 'Follow-Up wurde erfolgreich bearbeitet', delay: 3000, type:'success'});
		} else alert(data); ",'dataType' => "html" );
		$arr ['sql'] = array ('query' => "SELECT * from followup_pool where pool_id = '{$_POST['update_id']}' AND user_id = '{$_SESSION['user_id']}' " );
		$arr ['form'] = array ('action' => "ajax/form_followup2.php",'id' => 'pool_edit','inline' => 'list' );
		$arr ['field'] ['matchcode'] = array ('type' => 'input','label' => 'Titel','validate' => true,'focus' => true );

		for($iii = 1; $iii <= 10; $iii ++) {
			$array_count_generate_steps [$iii] = "$iii";
		}

		if (! $_POST ['update_id']) {
			$arr ['field'] ['count_generate_steps'] = array ('type' => 'dropdown','label' => 'Anzahl der automatisch zu generierenden Steps','array' => $array_count_generate_steps );
		}

		//if ($_POST['update_id'])
		//$arr['field']['start_followup_id'] = array ( 'type' => 'dropdown' , 'label' => 'Start-Step der Follow-Up festlegen' , 'array' => call_array_followup ( $_POST['update_id'] ) ,  'validate' => 'Startpunkt wählen' , 'placeholder' => '--Startpunkt wählen--');

		$arr ['field'] ['description'] = array ('tab' => 'mail','type' => 'textarea','label' => 'Beschreibung' );
		$arr ['button'] ['submit'] = array ('value' => "<i class='save icon'></i>Speichern",'color' => 'blue' );
		break;

	// Formular für Mail-step
	case 'followup_list' :

		$onload = "
		call_add_tag('action_add_tag'); 
		call_add_tag('trigger_new_tag');";

		$pool_id = $_SESSION ['filter'] ['followup_list'] ['pool_id'];
		if ($pool_id == 'all' or ! $pool_id) {
			echo "<div class='ui message info'><br>Bitte eine Follow-Up auswählen.<br><br></div>";
			exit ();
		}

		// Followup anlegen fuer Zuweisung Folder
		if (! $_POST ['update_id']) {
			$tag_first = 'first';
			// Löscht Daten welche nicht beschrieben wurden
			// $GLOBALS['mysqli']->query ( "DELETE FROM followup WHERE user_id = '$user_id' AND description='' AND matchcode='' " );

			$GLOBALS ['mysqli']->query ( "INSERT INTO followup SET user_id = '$user_id', pool_id ='$pool_id' " );
			$_POST ['update_id'] = mysqli_insert_id ( $GLOBALS ['mysqli'] );
		} else if ($_POST ['update_id']) {
			$arr ['sql'] = array ('query' => "SELECT * from followup where followup_id = '{$_POST['update_id']}'" );
			$tag_first = 'mail';
		}

		$tag_first = 'first';
		$update_id = $_POST ['update_id'];

		$arr ['form'] = array ('action' => "ajax/form_followup2.php",'id' => 'step_edit','inline' => 'list' );
		$arr ['ajax'] = array ('onLoad' => $onload,'success' => "
		if (data=='ok') { 
			$('.modal.ui').modal('hide'); 
			table_reload('followup_list');
		} 
		else alert(data); ",'dataType' => "html" );

		$arr ['tab'] = array ('class' => "pointing secondary",'content_class' => "basic",
				'tabs' => [ "first" => "Allgemein","trigger" => "<i class='icon handshake'></i>Auslöser","mail" => "<i class='icon mail'></i>Mail","action" => "<i class='icon rocket'></i>Handlung","upload" => "<i class='icon upload'></i>Datei Hochladen" ],'active' => $tag_first );

		/**
		 * *************************************************************
		 * ALLGEMEIN
		 * *************************************************************
		 */
		$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'ui message' );
		// $arr['field']['pool_id'] = array ( 'tab' => 'first' , 'type' => 'dropdown' , 'label' => 'Zuweisung des Pools' , 'array' => call_array_followup_pool () ,  'validate' => 'Bitte Absender auswählen' , 'placeholder' => '--Pool wählen--' ,  'focus' => $focus_from_id ,  'validate' => true );
		$arr ['field'] ['matchcode'] = array ('tab' => 'first','type' => 'input','label' => 'Step Beschreibung','validate' => true,'focus' => true );
		$arr ['field'] ['sorted'] = array ('tab' => 'first','type' => 'input','label' => 'Sortiernummer','info' => 'Dient zur besseren Übersicht in der Listansicht (hat keinen Einfluss auf den Ablauf)','validate' => true );
		$arr ['field'] ['description'] = array ('tab' => 'first','type' => 'textarea','label' => 'Zusatzinfo' );
		$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );

		/**
		 * **************************************************************
		 * TRIGGER
		 * **************************************************************
		 */
		include ('../inc_followup/trigger.php');

		/**
		 * *************************************************************
		 * Mail
		 * *************************************************************
		 */
		include ('../inc_followup/mail.php');

		/**
		 * **************************************************************
		 * ACTION
		 * **************************************************************
		 */
		include ('../inc_followup/action.php');

		$arr ['buttons'] = array ('align' => 'center' );
		if (! $hide_submit_button)
			$arr ['button'] ['submit'] = array ('value' => "<i class='save icon'></i>Speichern",'color' => 'blue' );
		break;
}

$arr ['hidden'] ['pool_id'] = $pool_id;
$arr ['hidden'] ['update_id'] = $_POST ['update_id'];
$arr ['hidden'] ['list_id'] = $_POST ['list_id'];
$arr ['button'] ['close'] = array ('value' => 'Abbrechen','color' => 'gray','js' => "$('.modal.ui').modal('hide'); " );

$output = call_form ( $arr );
echo $output ['html'];
echo "<script type=\"text/javascript\" src=\"js/form_followup.js\"></script>";
echo "<script>$onload_after</script>";
//echo "<script>appendScript('js/form_followup.js'); $onload_after</script>";
// echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"js/form_newsletter.js\"></script>";
echo $output ['js'];