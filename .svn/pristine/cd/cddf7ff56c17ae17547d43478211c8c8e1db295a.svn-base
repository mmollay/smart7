
$(document).ready( function() {

	$('#trigger_time').on('change', function() { 
		$('.time_settings').hide();
		val = $('#trigger_time').val();
		if (val) { $('.'+val).show(); }
	});

	$('#trigger_modus').on('change', function() { 	
		$('.trigger_settings').hide();
		val = $('#trigger_modus').val();
		if (val) { $('.'+val).show(); }
	});
	
	$('#trigger_mail_id').on('change', function() { 
		$('.mail_status').hide();
		val = $('.form_edit#trigger_mail_id').val();
		if (val) { $('.mail_status').show(); }
	});
	
	$('#from_id').bind('change keyup', function(){
		var id = $('#'+this.id).val();
		$.ajax( {
			url :"inc/verify_check_open.php",
			global :false,
			async :false,
			type :"POST",
			data : {ID:id},
			dataType :"text",
			success: function(data){ 
				if (data != 'ok'  && id != 0) { 
					$('#verify_alert_text').css({'color':'red'}).html('Achtung eine der Adressen in diesem Profil sind noch nicht best&auml;tigt!');
					check_alert ();
				}	
				else {
					$('#verify_alert_text').html('');
				}
			}
		});
	})
});

// Ermöglicht, dass alle Felder in der angegebenen Form automatisch gespeichert
// werden
function load_autosave_followup(update_id,form_id) {
	
	$('.'+form_id).change( function() {
		key = this.id;
		if (key) {
			value = $('#'+this.id).val();
			fu_save_value(update_id,key,value);
			if ($('#text').val() && $('#title').val() && $('#from_id').val()) $('.testmail').show();
			else $('.testmail').hide();
		}
	});
}

//Funktion - schickt update_id zu php-script und speichert den gewünschten Wert
function fu_save_value(id,key,value){
    $.ajax({
    	url: 'inc/save_followup_values.php',	
        type: "POST",
        data: {
            value : value,
            id : id,
            key : key,
        },
        success: function(data){ 
        	if (data == 'ok') { $('#short_info_box').fadeIn().delay('2000').fadeOut( "slow" ); } 
        	else { alert('Fehler beim speichern aufgetreten'); }
        },
        dataType: "html"
    });
}