$(document).ready(function() {
	
	/*Check Email, if is verified or not*/
	$('#from_email,#error_email,#test_email,#replay_email').each(function() { check_verify(this.id); });
	$('#from_email,#error_email,#test_email,#replay_email').change( function() { check_verify(this.id); });

	$('#from_name').focus( function() {
		if ($('#from_name').val() == '') { 
			$('#error_email,#report_email,#test_email,#replay_email').val($('#from_email').val());
		}
	});
	
		
		$('#check_smtp').click( function(){ 

			//Gruppen auslesen
			$.ajax( {			
				beforeSend : function() { 
					$('#check_smtp').addClass('loading');
				},	
				success:    function(data){ 
					if (data == 'ok') { 
						//$("#modal_smtp").html('<div align=center>SMTP-Verbindung ist korrekt!<i class="ui large green icon checkmark"></i></div>'); 
						$('#check_smtp').removeClass('loading');
						$('#check_smtp').addClass('green');
						$('#check_smtp').removeClass('red');
						$('#show_smtp_ok').html('Erfolgreich');
					}
					else {
						//$('#modal_smtp').html("<div align=center>SMTP-Verbindung ist fehlgeschlagen<i class='ui large red icon warning sign'></i></div>"); 
						$('#check_smtp').removeClass('loading');
						$('#check_smtp').addClass('red');
						$('#show_smtp_ok').html('Fehler');
					}
				},				
				url :"exec/test_smtp_server.php",
				global   : false,
				type     : "POST",	
				dataType : "html",
				data :({
					smtp_host:     $('#smtp_server').val(),
					smtp_user:     $('#smtp_user').val(),
					smtp_password: $('#smtp_password').val(),
					smtp_secure:   $('#smtp_secure').val(),
					smtp_port:     $('#smtp_port').val()
				}),
			});
		
	});
	
	
});

function check_verify(id) {
	   var email = $('input[name="'+id+'"]').val();
	   //check is verified or not (in db)
	   $.ajax ({
		   url: 'inc/verification_check.php',
		   global: false,
		   data: ({ email : email}),
		   success: function (data) { $('.verification#'+id).html(data); },
		   type: 'POST',
		   dataType: "text"
	   }); 
}