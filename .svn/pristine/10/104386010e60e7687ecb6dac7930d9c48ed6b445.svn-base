<?php
$arr ['sql'] = array ('query' => "SELECT * from ssi_company.user2company WHERE user_id = '{$_SESSION['user_id']}'" );

$arr ['header'] = array ('title' => "<i class='icon user circle outline'></i>Fast fertig!",'class' => 'small diverding white','segment_class' => 'attached message' );
$arr ['form'] = array ('id' => 'form_register','width' => '800','align' => 'center','action' => "$add_link" . "ajax/form_userinfo_complite2.php",'class' => 'attached segment','inline' => 'list','keyboardShortcuts' => true );

$array_sex = array ('' => '--Bitte w&auml;hlen--','f' => 'Frau','m' => 'Herr','c' => 'Firma' );

// $arr['field'][] = array ('type'=>'text','value'=>'Bitte auf die RICHTIGKEIT der Daten achten, da diese im Impressum der Seite angeführt werden müssen.<br>Sämtliche angegebenen Daten werden, selbstverständlich nicht an dritte weitergegeben und streng vertraulich behandelt.');

$arr ['field'] [] = array ('class' => 'message ui small info','type' => 'content','text' => 'Bitte Felder vervollständigen und auf die RICHTIGKEIT der Inhalte achten!' );

$arr ['field'] ['gender'] = array ('label' => 'Anrede','type' => 'dropdown','array' => $array_sex,'validate' => true,'focus' => true );
$arr ['field'] [] = array ('type' => 'div','class' => 'two fields' ); // 'label'=>'test'
$arr ['field'] ['firstname'] = array ('label' => 'Vorname','type' => 'input','placeholder' => 'Vorname','validate' => 'Bitte Vornamen eingeben' );
$arr ['field'] ['secondname'] = array ('label' => 'Nachname','type' => 'input','placeholder' => 'Nachname','validate' => 'Bitte Nachnamen eingeben' );
$arr ['field'] [] = array ('type' => 'div_close' );

$arr ['field'] ['street'] = array ('label' => 'Straße','type' => 'input','placeholder' => 'Straße','validate' => true );
$arr ['field'] [] = array ('type' => 'div','class' => 'fields' ); // 'label'=>'test'
$arr ['field'] ['zip'] = array ('label' => 'Plz','type' => 'input','class' => 'four wide','placeholder' => '1020','rules' => array ([ 'type' => 'empty','prompt' => 'PLZ eingeben' ],[ 'type' => 'integer','prompt' => 'Ungültige Eingabe' ] ) );
$arr ['field'] ['city'] = array ('label' => 'Stadt','type' => 'input','placeholder' => 'Stadt','class' => 'six wide','validate' => 'Bitte die Stadt angeben' );
$arr ['field'] ['country'] = array ('label' => 'Land','type' => 'dropdown','class' => 'six wide','value' => 'at','array' => 'country' );
$arr ['field'] [] = array ('type' => 'div_close' );

$arr ['field'] ['confirm_agb'] = array ('label' => "Ich bestätige die AGB gelesen zu haben und stimme diesen zu",
		'label_right' => "<a title='AGB lesen' class='button compact basic tooltip icon ui mini' onclick=\"$('.ui.modal.agb').modal({closable  : false, onApprove : function() { $('#confirm_agb').prop('checked', true); }, onDeny : function() { $('#confirm_agb').prop('checked', false); } }).modal('show')\"><i class='icon external'></i> Hier einsehen</a>",
		'type' => 'checkbox','validate' => 'Bitte den AGB zustimmen','class' => 'message ui' );

$arr ['field'] [] = array ('type' => 'content','text' => '<div id=form_message2></div>' );
$arr ['buttons'] = array ('id' => 'buttons_register','align' => 'center' );
$arr ['button'] ['submit'] = array ('value' => "<i class='icon thumbs up'></i> Abschließen und loslegen",'color' => 'green' );
$output = call_form ( $arr );

// MODAL AGB
$content .= "
<div class='ui modal agb'><div class='header'>AGB's</div><div class='content'>" . call_agb_text () . "</div>
<div class='actions'>
<div class='ui button green approve'>Zustimmen</div>
<div class='ui button deny'>Cancel</div>
</div></div>";

$content .= "<br>" . $output ['html'];
$add_js .= $output ['js'];

// CALL AGB-TEXT
function call_agb_text() {
	$array = call_company_option ( $_SESSION ['smart_company_id'], array ('terms_and_conditions' ) );
	return $array ['terms_and_conditions'];
}