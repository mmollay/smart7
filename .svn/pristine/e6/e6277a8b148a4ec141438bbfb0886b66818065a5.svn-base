
$(document).ready( function() {

	$('#send_auto').on("change", function() { 
		if ($('#send_auto').is(':checked')) {
			$('.auto_time').show();
		}
		else {
			$('.auto_time').hide();
		}		
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

function load_autosave(update_id,form_id) {
	
	$('.'+form_id).change( function() {
		key = this.id;
		if (key == 'send_auto') return;
		if (key) {
			value = $('#'+this.id).val();
			fu_save_content(update_id,key,value);
			if ($('#text').val() && $('#title').val() && $('#from_id').val()) $('.testmail').show();
			else $('.testmail').hide();
		}
	});
}

function fu_save_content(id,key,value){
	
    $.ajax({
    	url: 'inc/save_nl_elements.php',	
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