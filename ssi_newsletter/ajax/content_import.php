<?php
require_once ('../config.inc.php');
include ('../../ssi_smart/smart_form/include_form.php');

//$liste = "Bernhard Wouk <bern.iwo@hotmail.com>; Karl KOEPPL <karl.koeppl@rbgk.raiffeisen.at>; gerhard poschinger <gerhard.poschinger@ams.at>; Martins, Victoria <Victoria.Martins@dbschenker.com>; Luschnig, Alexander <Alexander.Luschnig@dbschenker.com>; Fina, Sandra <Sandra.Fina@dbschenker.com>; Kau, Sandro <Sandro.Kau@dbschenker.com>; Daniela Tschernigg <daniela.tschernigg@gmx.at>; Umek, Andrea <andrea.umek@bmf.gv.at>; Christine REICHMANN-HERZELE <christine.reichmann-herzele@rbgk.raiffeisen.at>; KERSCHBAUMER Gerald <Gerald.KERSCHBAUMER@ktn.gv.at>; Mario UNTERWIESER <mario.unterwieser@rbgk.raiffeisen.at>; Maria Salcher (Ifa Unternehmensberatung) <Maria.Salcher@ifa-kaernten.at>; Martina ZUSCHNIG <martina.zuschnig@rbgk.raiffeisen.at>; Alexander Oberressl <A.Oberressl@okzt.at>; Renate GREGORITSCH <renate.gregoritsch@rbgk.raiffeisen.at>; Millonig, Elisabeth <Elisabeth.Millonig@aau.at>; Facciani-Rizzo, Claudia <Claudia.Facciani-Rizzo@bks.at>; yvonne.koller@dbschenker.com; petra.schemitsch@dbschenker.com; Trattnig, Helmut <Helmut.Trattnig@dbschenker.com>; ruth dobernigg <ruth.dobernigg@ams.at>; Thalhammer <apis.thalhammer@aon.at>; Hannesschläger, Dieter <dieter.hannesschlaeger@bmf.gv.at>; Berni Ladinig <tallach111@gmx.at>; Weinold, Carmen <Carmen.Weinold@dbschenker.com>; Marisa Höllmüller <marisa.hoellmueller@jaw-kaernten.at>; maier@gisquadrat.com; leitner@gisquadrat.com; bernhard frank <bernhard.frank@kgkk.at>; Moser Ingrid <I.Moser@lebenshilfe-kaernten.at>; Kanzian, Matthias <Matthias.Kanzian@dbschenker.com>; martina.schwarz@rbgk.raiffeisen.at; stefanie.tauschitz@rbgk.raiffeisen.at; Muhrer Manfred <Manfred.Muhrer@stw.at>; kh.kucher@gmail.com; Stefan KIKO <stefan.kiko@rbgk.raiffeisen.at>; Wimmer Reinhard <Reinhard.Wimmer@stw.at>; stefanie.tauschitz@rbgk.raiffeisen.at; arbeitszentrum@promente-kaernten.at; sunflower@promente-kaernten.at; ap-klagenfurt@promente-kaernten.at; berufstraining@promente-kaernten.at; elisabeth-mgt@A1.net; nicole.achatz@stw.at; ams.klagenfurt@ams.at; michael.herzog@klv.at <michael.herzog@klv.at>; stephanie.huber@wohnbaugruppe.at; juniorgt@gmx.at; pension.hainzl@gmx.at; anja.poluk@aekktn.at; Tschuk Gertrud, Mag.a <g.tschuk@autark.co.at>; Carine SUZUKI <carine.suzuki@rbgk.raiffeisen.at>; Pretis-Pösinger, Cornelia <cornelia.pretis-poesinger@bfg.gv.at>; Gerald GLANTSCHNIG <gerald.glantschnig@rbgk.raiffeisen.at>; Appe, Martin <Martin.Appe@dbschenker.com>; Gronald Markus <Markus.Gronald@stw.at>; Bernhard Wouk <bern.iwo@hotmail.com>; Valentinitsch Thomas <T.Valentinitsch@lebenshilfe-kaernten.at>; Eveline CRNALIC <eveline.crnalic@rbgk.raiffeisen.at>; Kuchinka, Angelika <Angelika.Kuchinka@amsc.com>; HÖSSL Hannes <hannes.hoessl@ktn.gv.at>; judith auner <judith.auner@ams.at>; Sandra Stattmann <sandrastattmann@gmx.at>; manfred.enengel@a1.net; Renate GREGORITSCH <renate.gregoritsch@rbgk.raiffeisen.at>; Christine REICHMANN-HERZELE <christine.reichmann-herzele@rbgk.raiffeisen.at>; KERSCHBAUMER Gerald <Gerald.KERSCHBAUMER@ktn.gv.at>; Mario UNTERWIESER <mario.unterwieser@rbgk.raiffeisen.at>; Maria Salcher (Ifa Unternehmensberatung) <Maria.Salcher@ifa-kaernten.at>; Martina ZUSCHNIG <martina.zuschnig@rbgk.raiffeisen.at>; Alexander Oberressl <A.Oberressl@okzt.at>; Renate GREGORITSCH <renate.gregoritsch@rbgk.raiffeisen.at>; Millonig, Elisabeth <Elisabeth.Millonig@aau.at>; Facciani-Rizzo, Claudia <Claudia.Facciani-Rizzo@bks.at>; yvonne.koller@dbschenker.com; petra.schemitsch@dbschenker.com; Trattnig, Helmut <Helmut.Trattnig@dbschenker.com>; ruth dobernigg <ruth.dobernigg@ams.at>; Thalhammer <apis.thalhammer@aon.at>; Hannesschläger, Dieter <dieter.hannesschlaeger@bmf.gv.at>; Berni Ladinig <tallach111@gmx.at>; Weinold, Carmen <Carmen.Weinold@dbschenker.com>; Marisa Höllmüller <marisa.hoellmueller@jaw-kaernten.at>; maier@gisquadrat.com; leitner@gisquadrat.com; bernhard frank <bernhard.frank@kgkk.at>; Moser Ingrid <I.Moser@lebenshilfe-kaernten.at>; Kanzian, Matthias <Matthias.Kanzian@dbschenker.com>; martina.schwarz@rbgk.raiffeisen.at; stefanie.tauschitz@rbgk.raiffeisen.at; Muhrer Manfred <Manfred.Muhrer@stw.at>; kh.kucher@gmail.com; Stefan KIKO <stefan.kiko@rbgk.raiffeisen.at>; Wimmer Reinhard <Reinhard.Wimmer@stw.at>; stefanie.tauschitz@rbgk.raiffeisen.at; arbeitszentrum@promente-kaernten.at; sunflower@promente-kaernten.at; ap-klagenfurt@promente-kaernten.at; berufstraining@promente-kaernten.at; elisabeth-mgt@A1.net; nicole.achatz@stw.at; ams.klagenfurt@ams.at; michael.herzog@klv.at <michael.herzog@klv.at>; stephanie.huber@wohnbaugruppe.at; juniorgt@gmx.at; pension.hainzl@gmx.at; anja.poluk@aekktn.at; Tschuk Gertrud, Mag.a <g.tschuk@autark.co.at>; Carine SUZUKI <carine.suzuki@rbgk.raiffeisen.at>; Pretis-Pösinger, Cornelia <cornelia.pretis-poesinger@bfg.gv.at>; Gerald GLANTSCHNIG <gerald.glantschnig@rbgk.raiffeisen.at>; Appe, Martin <Martin.Appe@dbschenker.com>; Gronald Markus <Markus.Gronald@stw.at>; Bernhard Wouk <bern.iwo@hotmail.com>; Valentinitsch Thomas <T.Valentinitsch@lebenshilfe-kaernten.at>; Eveline CRNALIC <eveline.crnalic@rbgk.raiffeisen.at>; Kuchinka, Angelika <Angelika.Kuchinka@amsc.com>; HÖSSL Hannes <hannes.hoessl@ktn.gv.at>; judith auner <judith.auner@ams.at>; Sandra Stattmann <sandrastattmann@gmx.at>; manfred.enengel@a1.net; Renate GREGORITSCH <renate.gregoritsch@rbgk.raiffeisen.at>; Anna Wieser <anna.karolina.wieser@gmail.com>; Christine REICHMANN-HERZELE <christine.reichmann-herzele@rbgk.raiffeisen.at>; KERSCHBAUMER Gerald <Gerald.KERSCHBAUMER@ktn.gv.at>; Mario UNTERWIESER <mario.unterwieser@rbgk.raiffeisen.at>; Maria Salcher (Ifa Unternehmensberatung) <Maria.Salcher@ifa-kaernten.at>; Martina ZUSCHNIG <martina.zuschnig@rbgk.raiffeisen.at>; Alexander Oberressl <A.Oberressl@okzt.at>; Renate GREGORITSCH <renate.gregoritsch@rbgk.raiffeisen.at>; Millonig, Elisabeth <Elisabeth.Millonig@aau.at>; Facciani-Rizzo, Claudia <Claudia.Facciani-Rizzo@bks.at>; yvonne.koller@dbschenker.com; petra.schemitsch@dbschenker.com; Trattnig, Helmut <Helmut.Trattnig@dbschenker.com>; ruth dobernigg <ruth.dobernigg@ams.at>; Thalhammer <apis.thalhammer@aon.at>; Hannesschläger, Dieter <dieter.hannesschlaeger@bmf.gv.at>; Berni Ladinig <tallach111@gmx.at>; Weinold, Carmen <Carmen.Weinold@dbschenker.com>; Marisa Höllmüller <marisa.hoellmueller@jaw-kaernten.at>; maier@gisquadrat.com; leitner@gisquadrat.com; bernhard frank <bernhard.frank@kgkk.at>; Moser Ingrid <I.Moser@lebenshilfe-kaernten.at>; Kanzian, Matthias <Matthias.Kanzian@dbschenker.com>; Smolak Martin <Martin.Smolak@stw.at>; martina.schwarz@rbgk.raiffeisen.at; stefanie.tauschitz@rbgk.raiffeisen.at; Muhrer Manfred <Manfred.Muhrer@stw.at>; kh.kucher@gmail.com; Stefan KIKO <stefan.kiko@rbgk.raiffeisen.at>; Wimmer Reinhard <Reinhard.Wimmer@stw.at>; stefanie.tauschitz@rbgk.raiffeisen.at; arbeitszentrum@promente-kaernten.at; sunflower@promente-kaernten.at; ap-klagenfurt@promente-kaernten.at; berufstraining@promente-kaernten.at; elisabeth-mgt@A1.net; nicole.achatz@stw.at; ams.klagenfurt@ams.at; michael.herzog@klv.at <michael.herzog@klv.at>; stephanie.huber@wohnbaugruppe.at; juniorgt@gmx.at; pension.hainzl@gmx.at; anja.poluk@aekktn.at; Tschuk Gertrud, Mag.a <g.tschuk@autark.co.at>; Carine SUZUKI <carine.suzuki@rbgk.raiffeisen.at>; Pretis-Pösinger, Cornelia <cornelia.pretis-poesinger@bfg.gv.at>; Gerald GLANTSCHNIG <gerald.glantschnig@rbgk.raiffeisen.at>; Appe, Martin <Martin.Appe@dbschenker.com>; Gronald Markus <Markus.Gronald@stw.at>; Bernhard Wouk <bern.iwo@hotmail.com>; Valentinitsch Thomas <T.Valentinitsch@lebenshilfe-kaernten.at>; Eveline CRNALIC <eveline.crnalic@rbgk.raiffeisen.at>; Kuchinka, Angelika <Angelika.Kuchinka@amsc.com>; HÖSSL Hannes <hannes.hoessl@ktn.gv.at>; judith auner <judith.auner@ams.at>; Sandra Stattmann <sandrastattmann@gmx.at>; manfred.enengel@a1.net; Renate GREGORITSCH <renate.gregoritsch@rbgk.raiffeisen.at>; Anna Wieser <anna.karolina.wieser@gmail.com>; wolfgang.saiwald@rbgk.raiffeisen.at; Wallner Otto <Otto.Wallner@stw.at>; Moser Monika <Monika.Moser@stw.at>; Barbara Huber-Stopper <barbara.huber-stopper@rbgk.raiffeisen.at>";
//$array_liste=preg_split("/;/",$liste);

// echo "<table class='ui table'>";
// foreach($array_liste as $email) {
// 	$array_email = email_split($email);
// 	echo "<tr>";
// 	echo "<td>".$array_email['name']."</td>";
// 	echo "<td>".$array_email['email']."</td>";
// 	echo "</tr>";
// }
// echo "</table>";

if ($user_id == '40') {
	$liste = "
office@ssi.at
martin@ssi.at
";
	$value_update = 1;
}

$label_list .= "<div id='sortable_label'>";
foreach ( $array_import as $key => $text ) {
	$label_list .= "<div class='label basic ui' style='cursor:move' id='$key' >$text</div>";
}
$label_list .= "</div><div id='sortable-9'></div>";

$onload = "call_add_tag('tags');";

$arr ['ajax'] = array ('onLoad' => $onload,'success' => "$('#modal_msg>.content').html(data); $('#modal_msg').modal('show');",'dataType' => "html" );

$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'ui message' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'fields' );
$arr ['field'] ['tags'] = array ('tab' => 'first','type' => 'multiselect','class' => 'wide eleven search','label' => "Tag(s) auswählen",'array' => $array_value_tag,'value' => array ('9' ) );
$arr ['field'] ['tags_add'] = array ('tab' => 'first','type' => 'input','class' => 'wide five','label' => 'Neuen Tag','label_left' => "<i class='icon arrow left'></i> Anlegen",'label_left_class' => 'button orange ui' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );
$arr ['field'] ['tags_remove'] = array ('label' => 'Tag(s) entziehen','label_class' => 'red','tab' => 'action','type' => 'multiselect','array' => call_array_tags () );
$arr ['field'] ['remove_all_tags'] = array ('type' => 'checkbox','label' => "alle Tags entfernen","info" => "" );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );

$arr ['field'] [] = array ('tab' => 'first','type' => 'div','class' => 'fields' );
$arr ['field'] [] = array ('id' => 'import_type','type' => 'dropdown','label' => 'Import-Type','class' => 'six wide','array' => array ('basic' => 'Als Liste','mail_format' => "Email-Format" ),'value' => 'basic' );
$arr ['field'] [] = array ('id' => 'setDelimiter','type' => 'input','label' => 'Trennzeichen','label_right' => '(Bsp.: tab=Tablulator, #, ...)','class' => 'six wide','value' => 'tab' );
$arr ['field'] [] = array ('tab' => 'first','type' => 'div_close' );

/**
 * ******************************************************************
 * Format-Info1!!
 * ******************************************************************
 */
$arr ['field'] ['info_format'] = array ('type' => 'content','class' => 'ui message info',
		'text' => "Dieses Format wird bei Emailprogammen gerne eingesetzt: (Als Trennzeichen <div class='label mini basic ui'>;</div> oder <div class='label mini basic ui'>,</div> verwenden)<br><div class='label basic ui'>Name1 &lt;name1@domain.at&gt;</div>,<div class='label basic ui'>Name2 &lt;name2@domain.at&gt;</div>,<div class='label basic ui'>Name3 &lt;name3@domain.at&gt;</div>,<div class='label basic ui'>...</div>" );
$arr ['field'] ['info_list'] = array ('type' => 'content','class' => 'ui message info','text' => "<b>Importreihenfolge der Felder</b>(<i class='crosshairs icon'></i>Durch Verschieben definierbar)<br><br>$label_list" );
$arr ['field'] ['setTEXT'] = array ('type' => 'textarea','label' => 'Templates','rows' => '15','validate' => true,'value' => $liste );
$arr ['field'] ['update'] = array ('type' => 'toggle','label' => "bestehende Kontakte überschreiben","info" => "Status Aktiv/Inaktiv sowie Tag-zuweisungen bleiben erhalten",'value' => $value_update );

$arr ['header'] = array ('text' => "<div class='content ui header small orange'><i class='icons'><i class='icon database'></i><i class='corner add icon'></i></i> Kontakte importieren</div>",'segment_class' => 'message attached' );
$arr ['form'] = array ('action' => "ajax/content_import2.php",'id' => 'form_edit','width' => '800','class' => 'segment attached','size' => 'small' );

$arr ['button'] ['submit'] = array ('value' => ' Kontakte importieren','icon' => 'upload','color' => 'green big fluid' );
$arr_output = call_form ( $arr );

$content = $arr_output ['html'];
$content .= "<div id=dialog_msg></div>";
$content .= $arr_output ['js'];

$content .= "
<div class='ui small modal' id='modal_msg'>
	<div class='header'>Info</div>
	<div class='content'><p></p><p></p><p></p></div>
	<div class='actions'>
		<div class='ui cancel button' >Schließen</div>
	</div>
</div>";

$content .= "<script type=\"text/javascript\" src=\"js/form_import.js\"></script>";

// $output = "<div class='ui top attached tabular menu'>";
// $output .= "<div class='active item' data-tab='tab-name'>Test</div>";
// $output .= "</div>";
// $output .= "<div class='ui bottom attached active tab segment'>$content</div>";

echo $content;

// function call_tab(titlel,text) {
// $output = "<div class='ui tabular menu><div class='item' data-tab='tab-name'>$title</div>";
// $output = "<div class='ui tab' data-tab='tab-name'>$text</div>";
// $output .= "</div>";
// return;
// }

?>