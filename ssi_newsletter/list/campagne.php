<?php
// Abrufen der infos von Mailjet
// Wird in weiterer Folge in Zukunft mit cron gemacht
// $sql_query = $GLOBALS['mysqli']->query("SELECT session_id FROM session WHERE user_id = '{$_SESSION['user_id']}' order by session_id desc LIMIT 3");
// while ($array = mysqli_fetch_array ($sql_query)) {
// $session_id = $array['session_id'];
// call_status($session_id);
// }
//

// Kamagne wird auf status = 3 = Senden gesetzt, wenn auto-campagne gestartet werden soll
$GLOBALS['mysqli']->query("UPDATE session SET `release`=1, session.status = '3', datetime_start = NOW()  WHERE send_date < NOW() AND session.status = 2 AND send_auto = 1") or die(mysqli_error($GLOBALS['mysqli']));

// $count_sent = "(SELECT COUNT(*) FROM logfile WHERE logfile.session_id = session.session_id AND (status='ok' OR status='sent' OR status='open' OR status='unsub' OR status='click') )";
// $count_open = "(SELECT COUNT(*) FROM logfile WHERE logfile.session_id = session.session_id AND (status='open' OR status='click'))";
// $count_click = "(SELECT COUNT(*) FROM logfile WHERE logfile.session_id = session.session_id AND (status='click'))";
// $count_bounce = "(SELECT COUNT(*) FROM logfile WHERE logfile.session_id = session.session_id AND (status='bounce' OR status='blocked'))";
// $count_unsub = "(SELECT COUNT(*) FROM logfile WHERE logfile.session_id = session.session_id AND status='unsub')";
// $count_sendet_mail = "(SELECT COUNT('sendet') FROM logfile WHERE logfile.session_id = session.session_id AND sendet = 1)";
// $count_error_mail = "(SELECT COUNT('error') FROM logfile WHERE logfile.session_id = session.session_id AND error = 1)";
// $count_mail = "(SELECT COUNT(*) FROM logfile LEFT JOIN contact ON logfile.client_id = contact.contact_id WHERE logfile.session_id = session.session_id AND contact.activate = 1)";

// $count_unsubscribe_mail = "(SELECT COUNT(DISTINCT(contact_id)) FROM user_logfile WHERE user_logfile.session_id = session.session_id AND status_id = 3 AND contact_id )";

$count_sent = "COUNT(IF(logfile.status='ok' OR logfile.status='sent' OR logfile.status='open' OR logfile.status='unsub' OR logfile.status='click',logfile.status,NULL) )";
$count_open = "COUNT(IF(logfile.status='open' OR logfile.status='click',logfile.status,NULL))";
$count_click = "COUNT(IF(logfile.status='click',logfile.status,NULL))";
$count_bounce = "COUNT(IF(logfile.status='bounce' OR logfile.status='blocked',logfile.status,NULL))";
$count_unsub = "COUNT(IF(logfile.status='unsub',logfile.status,NULL))";
$count_sendet_mail = "COUNT(IF(logfile.sendet = 1,logfile.sendet,NULL))";
$count_error_mail = "COUNT(IF(logfile.error = 1,logfile.error,NULL))";
$count_mail = "COUNT(IF(contact.activate = 1,contact.activate,NULL))";

// BUTTON zum versenden
$sql_send_button = "CONCAT('<button class=\"ui small compact icon button green\" onclick=\"ReleaseNewsletter(',session.session_id,')\">','<i class=\"icon send\"></i> Jetzt versenden</button>')";

$a_generate_send_user = "<a class=\'tooltip\' title=\'Schick an Zugestellte aber noch nicht geöffnte User Mail\' href=# onclick=\"load_content_semantic(\'newsletter\',\'campagne\',\'\',{\'event\':\'sent\',\'session_id\':\'',session.session_id,'\'})\">";
$a_generate_open_user = "<a class=\'tooltip\' title=\'Schick an geöffnete User Mail\' href=# onclick=\"load_content_semantic(\'newsletter\',\'campagne\',\'\',{\'event\':\'open\',\'session_id\':\'',session.session_id,'\'})\">";
$a_generate_click_user = "<a class=\'tooltip\' title=\'Schick an geöffnete User Mail\' href=# onclick=\"load_content_semantic(\'newsletter\',\'campagne\',\'\',{\'event\':\'click\',\'session_id\':\'',session.session_id,'\'})\">";

// IF ($count_unsubscribe_mail,CONCAT('<a onclick=show_unsubscribe(\"',session_id,'\") class=\"label basic red ui mini tooltip\" title=\"Abgemeldete User\">',$count_unsubscribe_mail,'</a>'),'') closed_nl,

$fields = "
session.session_id as session_id,
CONCAT (IF(LENGTH(session.title) >= 40, CONCAT(substring(session.title, 1,40), '...'), session.title),IF (size > 0,'<i style=\"float:right\" title=\"Attachment angehängt\" class=\"tooltip icon large attach\"></i>','')) title,
session.status status, counter,
IF ($count_mail = 1 ,logfile.email,$count_mail) email,
IF(LENGTH(tag.title) >= 30, CONCAT(substring(tag.title, 1,30), '...'),tag.title) as tag_name,
(CASE 
WHEN session.status = 1 then CONCAT ('<i class=\"icon large write\"></i><div class=\'label ui small orange basic\'>Vorlage</div>')
WHEN send_auto=0 AND session.status = 2 THEN $sql_send_button
WHEN send_auto=1 AND session.status = 2 THEN CONCAT ('<i class=\"icon large clock orange\"></i><div id=\"',session.session_id,'\" class=\'campagne_countdown ui label grey basic small\'>Timer</div><script>$(document).ready( function() { CallCampagneTimer(\'',session.session_id,'\',\'',send_date,'\'); })</script>')
WHEN session.status = 3 THEN CONCAT('<div class=\"ui progress small indicating progress-status\" id=\"',session.session_id,'\"><div class=\"bar\"><div class=\"progress\"></div></div><div class=\"label\" style=\"font-size:10px;\">..laden</div></div>')
WHEN send_auto=1 AND session.status = 4 THEN CONCAT ('<div class=\"label small ui basic\">',DATE_FORMAT(send_date,'%Y-%m-%d'),'</div> ',DATE_FORMAT(send_date,'%H:%i'))
WHEN send_auto=0 AND session.status = 4 THEN CONCAT ('<div class=\"label small ui basic\">',DATE_FORMAT(datetime_start,'%Y-%m-%d'),'</div> ',DATE_FORMAT(datetime_start,'%H:%i'))
END) as send_date,

(CASE 
WHEN send_auto=0 AND session.status = 2 THEN '--'
WHEN send_auto=0 AND session.status = 3 THEN '--'
WHEN send_auto=0 AND session.status = 4 THEN DATE_FORMAT(datetime_start,'%H:%i')
ELSE DATE_FORMAT(send_date,'%H:%i')
END) as send_time,

modus,`release`, from_name, error_email,from_email,
if (smtp_server != '', smtp_server, 'localhost') smtp_server,
if (size > 0, CONCAT (round(size/1000),' kb'),'-') size,
	
$count_mail total,
IF($count_sent,CONCAT ('$a_generate_send_user<div class=\'ui small grey header\'>',$count_sent,'</div>', ROUND((100/$count_mail)*$count_sent,1),'%'),'</a>') sent,
IF($count_open,CONCAT ('$a_generate_open_user<div class=\'ui small green header\'>',$count_open,'</div>',ROUND((100/$count_mail)*$count_open,1),'%'),'</a>') open,
IF($count_click,CONCAT ('$a_generate_click_user<div class=\'ui small green header\'>',$count_click,'</div>',ROUND((100/$count_mail)*$count_click,1),'%'),'</a>') click,
IF($count_bounce,CONCAT ('<div class=\'ui small orange header\'>',$count_bounce,'</div>',ROUND((100/$count_mail)*$count_bounce,1),'%'),'') bounce,
IF($count_unsub,CONCAT ('<div class=\'ui small blue header\'>',$count_unsub,'</div>',ROUND((100/$count_mail)*$count_unsub,1),'%'),'') unsub,

(CASE
WHEN $count_sendet_mail < $count_mail then CONCAT ('<div class=\"header green small ui\"><span class=\"newsletter-running-send\" id=\"',session.session_id,'\">',$count_sendet_mail,'</span></div>')
ELSE CONCAT ('<div class=\"header green small ui\">',$count_sendet_mail,'</div>')
END) as mail_sendet,
	
(CASE 
WHEN $count_error_mail then CONCAT ('<div onclick=\'session_logfile(',session.session_id,')\' class=\'button basic icon tiny ui\'>',$count_error_mail,' <i class=\'icon red info circle\'></i></div>')				
WHEN `release` <= 2 then ''
WHEN !(SELECT COUNT(checked) from verification WHERE email = session.from_email) then CONCAT('<a href=\'page_list_verification.php\' class=\'verifizieren_title tooltip\' title=\'Bitte Emailadresse verifizieren\'><span class=\'ui-icon ui-icon-alert red\'/></span></a>')
ELSE CONCAT ('<div onclick=\'session_logfile(',session.session_id,')\' class=\'button icon mini ui\'><i class=\'icon info circle\'></i></div>')
END) as fehler";


$arr['mysql'] = array(
	'table' => 'session 
		LEFT JOIN tag ON tag.tag_id = session.tag_id
		LEFT JOIN logfile ON logfile.session_id = session.session_id
		LEFT JOIN contact ON logfile.client_id = contact.contact_id
		',
	'field' => $fields,
	'order' => 'session.session_id desc',
	'limit' => 20,
	'where' => "AND session.user_id  = '{$_SESSION['user_id']}' AND remove_nl = 0",
	'group' => 'session.session_id',
	'like' => 'session.title'
);


// $arr['list']['auto_reload'] = array ( 'label'=>'Automatisches aktualisieren', 'checked'=>TRUE, 'loader'=>FALSE);
$arr['list'] = array('id' => 'newsletter_list', 'width' => '1300px', 'size' => 'small', 'class' => 'compact celled striped definition', 'loading_time' => true); // definition

//$arr['list']['auto_reload'] = array('label' => 'Automatisches aktualisieren', 'loader' => FALSE);

//$arr['list']['serial'] = true;

$array_filter = array('session.status<=2 AND session.followup_id=0' => 'Nicht versendeten Mails', 'session.status>=3 AND session.followup_id=0' => 'Manuell versendete Mails', 'session.followup_id>0' => 'Automatisch erzeugte Mails');

$arr['filter']['filter'] = array('type' => 'dropdown', 'class' => 'tertiary grey basic', 'array' => $array_filter, 'default_value' => 'session.followup_id=0', 'placeholder' => '--Standardansicht--', 'query' => "{value}");

if ($_SESSION['develop_mode'])
	$arr['th']['session_id'] = array('title' => "ID");

// $arr['th']['datetime_start'] = array ( 'title' =>"<i class='clock icon'></i>Datum" , 'align' => 'center' );

// $arr ['th'] ['status'] = array ('title' => "Status" );
// $arr ['th'] ['release'] = array ('title' => "Release" );
$arr['th']['send_date'] = array('title' => "<i class='calendar icon'></i>Sendedatum", 'align' => ''); // , colspan => array ( [ 'field' => 'status' , 'value' => 3, 'operator' => '==' ], col => 2 ) );
$arr['th']['from_email'] = array('title' => "Absender");
$arr['th']['email'] = array('title' => "Empfänger");
$arr['th']['title'] = array('title' => "Bezeichnung");
$arr['th']['size'] = array('title' => "Datei");
// $arr['th']['tag_name'] = array ( 'title' =>"Gruppe" );
// $arr ['th'] ['total'] = array ('tooltip' => 'Gesamt','title' => "<i class='mail icon tooltip'></i>",'align' => 'center','replace' => array ('default' => '<div class=\'ui small header\'>{value}</div>','0' => '' ) );
// $arr['th']['gesamt'] = array ( 'title' =>"&nbsp;&nbsp;<i class='mail icon'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 'align' =>'right');
// $arr['th']['send_time'] = array ( 'title' =>"<i class='clock icon'></i>Zeit" , 'align' => 'center' );
// $arr['th']['label_status'] = array ( 'title' =>"<i class='users icon'></i>User" );
// $arr['th']['mail_sendet'] = array ( 'title' =>"&nbsp;&nbsp;<i class='user icon'></i>&nbsp;&nbsp;&nbsp;", 'align' =>'center');
// $arr['th']['sent'] = array ( 'tooltip' => 'Zugestellt' , 'title' =>"<i class='icon grey check sign'></i>" , 'align' => 'center' , 'replace' => array ( 'default' => '<div class=\'ui small grey header\'>{value}</div>' , '0' => '' ) );
$arr['th']['sent'] = array('tooltip' => 'Zugestellt', 'title' => "<i class='icon grey check sign'></i>", 'align' => 'center');
// $arr['th']['sent']
$arr['th']['open'] = array('class' => 'selectable', 'tooltip' => 'Geöffent', 'title' => "<i class='icon green unhide sign'></i>", 'align' => 'center');
$arr['th']['click'] = array('class' => 'selectable', 'tooltip' => 'Geklickt', 'title' => "<i class='icon green mouse pointer'></i>", 'align' => 'center');
$arr['th']['bounce'] = array('tooltip' => 'Unzustellbar oder geblockt', 'title' => "<i class='icon orange remove sign'></i>", 'align' => 'center');
$arr['th']['unsub'] = array('tooltip' => 'Abgemeldet', 'title' => "<i class='icon blue remove user'></i>", 'align' => 'center');

// $arr['th']['closed_nl'] = array (tooltip=>'Abgemeldete User', 'title' =>"<i class='icon remove user'></i>" , 'align' => 'center' );

// $arr ['th'] ['fehler'] = array ('tooltip' => '','title' => "<i class='icon info sign'></i>",'align' => 'center' );

$arr['tr']['buttons']['left'] = array('class' => 'small');
$arr['tr']['button']['left']['modal_form_newsletter'] = array('title' => '', 'icon' => 'edit', 'class' => 'blue', 'popup' => 'Bearbeiten', 'filter' => array(['field' => 'status', 'value' => '2', 'operator' => '<=']));
$arr['tr']['button']['left']['modal_form_clone'] = array('title' => '', 'onclick' => "load_content_semantic('newsletter','campagne',{id})", 'icon' => 'clone', 'class' => '', 'popup' => 'Clonen', 'filter' => array(['field' => 'status', 'value' => '2', 'operator' => '>=']));
$arr['tr']['button']['left']['modal_view'] = array('title' => '', 'icon' => 'unhide', 'class' => '', 'popup' => 'Mail ansehen', 'filter' => array(['field' => 'status', 'value' => '1', 'operator' => '>=']));
$arr['tr']['button']['left']['modal_testmail'] = array('title' => '', 'onclick' => "SmartSendTestMail('{id}');", 'icon' => 'mail', 'icon_corner' => 'arrow right', 'popup' => 'Testmail schicken', 'filter' => array(['field' => 'status', 'value' => '2', 'operator' => '==']));

$arr['tr']['buttons']['right'] = array('class' => 'small basic');
// $arr['tr']['button']['right']['modal_send'] = array ( 'title' =>'' , 'onclick' =>"ReleaseNewsletter('{id}'); " , 'icon' => 'send green' , 'class' => 'green' , 'popup' => 'Newsletter absenden' , 'filter' => array ( [ 'field' => 'status' , 'value' => '2' , 'operator' => '==' ] ) );
$arr['tr']['button']['right']['modal_log'] = array('title' => '', 'icon' => 'server', 'class' => '', 'popup' => 'Logfiles einsehen', 'filter' => array(['field' => 'status', 'value' => 2, 'operator' => '>']));
$arr['tr']['button']['right']['modal_form_delete'] = array('title' => '', 'icon' => 'trash', 'class' => 'red', 'popup' => 'Mistkübel'); // , 'filter' => array ( [ 'field' => 'status' , 'value' => '3' , 'operator' => '<' ])

$arr['modal']['modal_form_newsletter'] = array('title' => 'Aussendung bearbeiten', 'class' => '', 'url' => 'form_edit.php');
$arr['modal']['modal_form_newsletter']['button']['submit'] = array('title' => 'Aussendung speichern', 'color' => 'blue', 'form_id' => 'form_edit', 'icon' => 'save'); // form_id = > ID formular
$arr['modal']['modal_form_newsletter']['button']['cancel'] = array('title' => 'Schließen', 'color' => 'grey', 'icon' => 'close', 'onclick' => "$('#modal_form_newsletter').modal('hide'); ");
//$arr ['modal'] ['modal_form_newsletter'] ['button'] ['testmail'] = array ('title' => "<i class='mail icon'></i>Testmail schicken",'onclick' => "fu_save_content('{$_POST['update_id']}','text',CKEDITOR.instances['text'].getData()); SmartSendTestMail('{$_POST['update_id']}')",'color' => 'grey' );

$arr['modal']['modal_log'] = array('title' => 'Logdateien anzeigen', 'class' => '', 'url' => 'smartlist_logfiles.php');
$arr['modal']['modal_form_delete'] = array('title' => 'Aussendung in den Papierkorb verschieben', 'class' => 'small', 'url' => 'form_delete.php');
$arr['modal']['modal_view'] = array('title' => 'Mail ansehen', 'class' => '', 'url' => 'view_newsletter.php');
// $arr['modal']['modal_testmail'] = array ( 'title' =>'Testmail versenden' , 'class' => 'small');
$arr['modal']['modal_session_log'] = array('title' => 'Sendeprotokoll', 'class' => 'small');
$arr['modal']['modal_unsubscribe_log'] = array('title' => 'Abgemeldete User', 'class' => 'small');

$arr['top']['button']['modal_form_newsletter_direct'] = array('title' => 'Neuen Aussendung anlegen', 'icon' => 'plus', 'class' => 'blue', 'onclick' => "load_content_semantic('newsletter','campagne')");

$arr['checkbox']['button']['modal_form_delete'] = array('title' => 'Delete', 'icon' => 'delete', 'class' => 'red mini');

// $arr['js'][] = array ( src => 'js/list_newsletter.js'); //wurde in die Main verlegt
$arr['js'] = "<script>appendScript('js/form_newsletter.js');</script>";
//if ($('script[src="http://xxx.co.uk/xxx/script.js"]').length > 0) { }

