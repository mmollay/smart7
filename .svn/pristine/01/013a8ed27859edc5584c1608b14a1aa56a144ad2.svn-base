/**
 * Zustellung des Codes
 */

$('.button_send_code').click( function(){ 

	//Gruppen auslesen
		var data = $.ajax( {
			data :({ id:     this.id }),
				
			beforeSend: function(){     $('#send_progress').html('<div class="label ui orange">Zustellung erfolgt <i class="notched circle loading icon"></i></div>'); },
			success:    function(data){ 
				if (data == 'ok') { 
					message({'title':'Code wurde zugestellt', text: 'Bitte Postfach einsehen, Verifizierungscode kopieren und hier einfügen!', type:'success'}); $('#code').focus();
		 
				}
				else {
					message({'title':'Zustellung', text: "Zustellung ist fehlgeschlagen<br>" +data , type:'error'}); $('#code').focus();
				} 
			},				
			url :"exec/send_verification.php",
			global :false,
			async :false,
			type :"POST",
			dataType :"text"
		});
})