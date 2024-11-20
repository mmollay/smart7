<?php
/*
 * page_contact_manuel.php - Userliste verwenden
*
* @author Martin Mollay
* @last-changed 2014-03-20 MM
*
*/

//Addons fuer diese Seite

session_start();
require_once ('../config.inc.php');
require_once ("../../ssi_form2/ssiForm.inc.php");

if (!$array['delimiter']) {
	$array['delimiter'] = "tab";
}

$css_array = array(
		'form'     => 'style_form1',
		'field1'         => 'style_field1',
		'field2'         => 'style_field2',
		'text2'          => 'style_text2',
		'error'          => 'style_error',
		'input'          => 'style_input'
);

$ArrayTemplate = array(
		TurnOverID,
		BetreuerID,
		Betreuer,
		BetrLevel,
		BetrAst,
		InitiatorID,
		Initiator,
		InitLevel,
		ActiveVorgID,
		ActiveVorg,
		ActiveVorgLevel,
		InactVorgID,
		InactVorg,
		InactVorgLevel,
		VorgStatus,
		FaPart,
		Level,
		Ast,
		Anrede,
		Titel,
		Name,
		Strasse,
		PLZ,
		Ort,
		Land,
		ID,
			
		AbrechnNrID,
		ProvPLan,
		EiPunkte,
		KuPunkte,
		PlPunkte,
		SrPunkte,
		IpPunkte,
		Rabatt,
		DifProv,
		BalProv,
		InProv,
		Auszahlg,
		GuthabenNeu,
		GuthabenAlt,
		AuszahlgAb,
		ProvisionInfo,
		EiUmsatz,
		KuUmsatz,
		PlUmsatz,
		SRumsatz,
		IPumsatz,
		IkUmsatz,
		IkPunkte,

		IBAN,
		BIC,
		BankdatenOK,
		Email,
		Tel,
		VatNumber
);

//$ArrayTemplate = array(client_id,email,firstname,secondname,sex,title);
foreach($ArrayTemplate as $value) {
	$setTemplateArray .= $value.",";
}

if (!is_dir($user_folder)) exec("mkdir $user_folder");
if (!is_dir($upload_folder)) { exec("mkdir $upload_folder"); }

$form1 = new ssiForm("form_window","ajax/content_import2.php","import_info");

//addone - js after send

$form1->setConfig("beforeSubmit", "$('#dialog_msg').dialog({width:'300px',height:'200',modal:true}).html('<div align=center style=\"font-size:12px\"><br><img src=\"images/load.png\"><br>Daten werden importiert...</div>'); ");
$form1->setConfig("success","after_page_contact();");
$form1->setClassArray($css_array);
$form1->setConfig("URI","../ssi_form2");
$form1->setConfig("load_jquery_ui",FALSE);
$form1->setConfig("load_jquery_plugins",FALSE);

$form1->setVar('array_title',array(
		1=>'Upload',
		2=>'Manuell'
));

$form1->setGroup("type=>tabs##options=>selected: 0##title=>array_title");

$form1->setField('hr2','group=>1##text=><br>');
$form1->setField('uploader',"
		group=>1
		##text2=><br><div id=finish_upload></div>
		##type=>upload
		##folder=>$upload_folder
		##buttonText=>Datei hochladen
		##queueID=>finish_upload
		##sizeLimit=>15728640
		##fileTypes=>*.csv;
		##onComplete=>after_upload_attachment(fileObj.name,fileObj.size); "
);
$form1->setField('import_file',array('type'=>'hidden')); //wird nach dem Upload auf das hidden-feld übertragen und das Form gestartet
$form1->setField('hr2','group=>1##text=><br>');

$form1->setField('setTemplate', "type=>hidden##value=>$setTemplateArray");
$form1->setField('setDelimiter',"group=>2##text=>Delimiter##text2=>(Bsp.: tab, #, ...)##type=>input##size=>2##check=>TRUE##value=>{$array['delimiter']}");
$form1->setField('setTEXT',      array(group=>2,type=>textarea,rows=>14,width=>'100%',value=>$array['contactlist']));
$form1->setField('hr1','group=>2##text=><br>');
$form1->setField('import_button', array(group=>2,type=>submit, value=>'Kontakte Importieren', 'align' =>'center'));
$form1->setField('hr2','group=>2##text=><br>');

$setContent .= $form1->getHtml();
$setJS       = $form1->getJs();
$setJS      .= "<script type=\"text/javascript\" charset=\"utf-8\" src=\"js/form_import.js\"></script>";

echo $setJS;
echo $setContent;
echo "<div id=dialog_msg></div>";
?>