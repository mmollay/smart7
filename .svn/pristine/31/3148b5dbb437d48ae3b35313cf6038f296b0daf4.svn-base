<?php
include ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

$arr ['form'] = array ('action' => "ajax/form_edit2.php",'id' => 'form_edit','inline' => 'list' );

switch ($_POST ['list_id']) {
    case 'faq_list' :
        include ('../form/f_faq.php');
        break;
	case 'report_list' :
		include ('../form/f_report.php');
		break;
	case 'tag_list' :
		include ('../form/f_tag.php');
		break;
	case 'contact_list' :
		include ('../../ssi_newsletter/form/f_contact.php');
		break;
}

// $arr['hidden']['update_id'] = $_POST['update_id'];
$arr ['hidden'] ['list_id'] = $_POST ['list_id'];

// if (! $hide_submit_button)
// 	$arr ['button'] ['submit'] = array ('value' => "<i class='save icon'></i>Speichern",'color' => 'blue' );
// $arr ['button'] ['close'] = array ('value' => 'Abbrechen','color' => 'gray','js' => "$('.modal.ui').modal('hide'); " );
$output = call_form ( $arr );

//echo "<div id='show_explorer' class='fullscreen ui modal'><div class='header'>Dateiverwaltung</div><div class='content' id=show_explorer_content></div></div>";


// echo '
// <div id="show_explorer" class="ui fullscreen modal">
// <i class="close icon"></i>
// <div class="header red">Dateiverwaltung</div>
// <div class="content" id=show_explorer_content>
// <p></p>
// </div>
// </div>';

// <div class="actions">
// <div class="ui cancel button">Cancel</div>
// </div>


echo $output ['html'];
echo $output ['js'];
echo $add_js;