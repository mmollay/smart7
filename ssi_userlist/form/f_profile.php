<?php 
$arr ['form'] = array ('action' => "ajax/form_edit2.php",'id' => 'form_edit_profile','size' => 'small' );
$arr ['sql'] = array ('query' => "SELECT * from smart_user_right WHERE right_id = '{$_POST['update_id']}'" );

$arr ['field'] ['title'] = array ('label' => 'Titel','placeholder' => 'Profilbezeichnung','type' => 'input','required' => true,'focus' => true,'class' => 'ten wide field' );
$arr ['field'] ['max_number_sites'] = array ('label' => 'Maximale Anzahl','type' => 'input','label_right' => 'Seiten','class' => 'six wide field' );

$arr ['field'] [] = array ('type' => 'header','text' => 'Text und Inhalt','size' => '3','class' => 'dividing' );
$arr ['field'] [] = array ('type' => 'div','class' => 'three fields' );
$arr ['field'] ['right_edit_text'] = array ("type" => "checkbox",'label' => 'Text editieren' );
$arr ['field'] ['right_edit_allsites'] = array ("type" => "checkbox",'label' => 'Alle Seiten bearbeiten' );
$arr ['field'] ['right_div_sort'] = array ("type" => "checkbox",'label' => 'Textfelder verschieben' );
$arr ['field'] [] = array ('type' => 'div_close' );

$arr ['field'] [] = array ('type' => 'div','class' => 'three fields' );
$arr ['field'] ['right_edit_foot'] = array ("type" => "checkbox",'label' => 'Fusszeile-Text bearbeiten' );
$arr ['field'] ['right_edit_layer'] = array ("type" => "checkbox",'label' => 'Layer anlegen und bearbeiten ' );
$arr ['field'] ['right_edit_head'] = array ("type" => "checkbox",'label' => 'Kopfzeile-Text bearbeiten' );
$arr ['field'] [] = array ('type' => 'div_close' );

$arr ['field'] ['right_div_remove'] = array ("type" => "checkbox",'label' => 'Textfelder löschen' );

$arr ['field'] [] = array ('type' => 'header','text' => 'Menü & Style','size' => '3','class' => 'dividing' );
$arr ['field'] [] = array ('type' => 'div','class' => 'three fields' );
$arr ['field'] ['right_edit_menu'] = array ("type" => "checkbox",'label' => 'Menü bearbeiten' );
$arr ['field'] ['right_edit_layout_menu'] = array ("type" => "checkbox",'label' => 'Menü-Layout bearbeiten','class' => "field" );
$arr ['field'] ['right_edit_profile'] = array ("type" => "checkbox",'label' => 'Layout editieren','class' => "field" );
$arr ['field'] [] = array ('type' => 'div_close' );

$arr ['field'] ['right_edit_profile_head'] = array ("type" => "checkbox",'label' => 'Kopfzeilen-Style editieren' );

$arr ['field'] [] = array ('type' => 'header','text' => 'Allgemein','size' => '3','class' => 'dividing' );

$arr ['field'] [] = array ('type' => 'div','class' => 'three fields' );
$arr ['field'] ['right_set_public_page'] = array ("type" => "checkbox",'label' => 'Webseite veröffentlichen' );
$arr ['field'] ['right_edit_modules'] = array ("type" => "checkbox",'label' => 'Module verwendbar machen' );
$arr ['field'] ['right_edit_templates'] = array ("type" => "checkbox",'label' => 'Vorlagen erzeugen einbinden' );
$arr ['field'] [] = array ('type' => 'div_close' );
$arr ['field'] [] = array ('type' => 'div','class' => 'three fields' );
$arr ['field'] ['right_edit_site_options'] = array ("type" => "checkbox",'label' => 'Seiten-Optionen' );
$arr ['field'] ['right_edit_main_options'] = array ("type" => "checkbox",'label' => 'Page-Optionen' );
$arr ['field'] ['right_analytics'] = array ("type" => "checkbox",'label' => 'Analytics einbinden' );
$arr ['field'] [] = array ('type' => 'div_close' );
$arr ['field'] ['right_use_module_dynamic'] = array ("type" => "checkbox",'label' => 'Erzeugen dynamische Elemente(Iframe)' );
$arr ['field'] [] = array ('type' => 'header','text' => '','size' => '3','class' => 'dividing' );
