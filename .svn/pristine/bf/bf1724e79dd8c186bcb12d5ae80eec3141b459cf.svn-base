<?php

// Anzeigen von News im Dashboard
function call_news_content($element, $buttontext, $load) {
	if (! $buttontext)
		$buttontext = 1;
	$content = "<a class='ui green mini icon button tooltip' id =call_information  title='Neue Nachricht' ><i class='icon alarm'></i> $buttontext</a>";
	$content .= "<div class='ui modal information'>
		<i class='close icon'></i>
		<div class='header' id='modal_header'></div>
		<div class='content' id='modal_content'></div>
		<div class='actions'><div class='close ui button' onclick=\"$('.modal.information').modal('hide');\" >Schließen</div></div>
	</div>";

	if ($load == 'autoload') {
		$GLOBALS ['smart_add_js'] .= "call_information('$element'); ";
	}

	// Aufruf von information via AJAX
	$GLOBALS ['smart_add_js'] .= "		
	$('#call_information').click( function(){
		call_information('$element');
	});
	
	function call_information(element) {
		$.ajax( {
			url :'../information/call_information.php',
			global   : false,
			data : {element: element },
			type     : 'POST',
			dataType: 'JSON',
			success:    function(data){ 
				$('#modal_content').html(data['text']); 
				$('#modal_header').html(data['title']);
				$('.ui.modal.information').modal('show');
			}
		});	
	}";

	return $content;
}

// Check ob User verifziert wurde
function call_verification_content($user_id) {
	$query = $GLOBALS ['mysqli']->query ( "SELECT fbid,user_name, user_checked,login_count FROM ssi_company.user2company WHERE user_id = '$user_id'" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
	$array = mysqli_fetch_array ( $query );
	$user_checked = $array ['user_checked'];
	$fbid = $array ['fbid'];
	$login_count = $array ['login_count'];

	$email = $array ['user_name'];

	$user_name = "<div data-tooltip='ID: $user_id' data-position='bottom right' data-variation='small'> $email</div>";

	$info_send_verification = 'Verifizierung wird versendet';
	$info_fished_sendet_verification = 'Email wurde versendet. Bitte bestätigen!';
	$info_error_sendet_verification = 'Fehler beim versenden';

	
	$info_field = '';
	
	// Wenn User bereits bestätigt hat oder Facebookuser ist
	if ($fbid or $user_checked) { // Wird gesetzt ind

		// Wenn User noch nicht bestätigt hat

		// Ruft beim ersten mal info automatisch auf
		// if ($login_count < 3)
		// $info_field = call_news_content ( 'welcome_info', 'Erster Schritt', true );
		// elseif ($login_count < 4) {
		// $info_field = call_news_content ( 'welcome_info', 'Erster Schritt', false );
		// }

		$sign = "<i class='icon large green check circle tooltip' data-variation='small' title='User ist verifiziert'></i>";
	} else {
		$sign = "<i class='icon large warning red sign tooltip' data-variation='small' title='User noch nicht verifiziert'></i>";
	}

	$content = "
		<div class='small ui modal send'>
		<div class='content' id=modal_window></div>
		<div class='actions'><div class='ui button' onclick=\"$('.modal.send').modal('hide');\">Schließen</div></div>
		</div>";

	// Aufruf des Versende-Popup
	// Eingebunden direkt im der Class -> login ssiPlattform
	$GLOBALS ['smart_add_js'] = "
	$('#send_verification').click( function(){
	$.ajax( {
	beforeSend : function() {
	$('#modal_window').html('<div class=\"ui active inverted dimmer\"><div class=\"ui text loader\">$info_send_verification</div></div>');
	$('.small.ui.modal.send').modal('show');
},
success:    function(data){
if (data == 'ok') {
$('#modal_window').html('<div align=center>$info_fished_sendet_verification<i class=\"ui large green icon checkmark\"></i></div>');
}
else $('#modal_window').html('<div align=center>$info_error_sendet_verification<i class=\"ui large red icon warning sign\"></i></div>');
},
url :'../information/send_verification.php',
global   : false,
type     : 'POST',
dataType : 'html'
});
});
";

	return $info_field . $content . $sign . "&nbsp; $user_name";
}