
function CallCampagneTimer(id,date) {
	
	if ($('#'+id+'.campagne_countdown').val()) return;
	
	$('#'+id+'.campagne_countdown')
	    .on('update.countdown', function(event) {
	      var format = '%H:%M:%S';
	      if(event.offset.days > 0) {
	        format = '%-d Tag%!d:e; ' + format;
	      }
	      if(event.offset.weeks > 0) {
	        format = '%-w Woche%!w:n; ' + format;
	      }
	      $(this).html(event.strftime(format));
	    })
	    .on('finish.countdown', function(event) {
	      $(this).html('Versendung wird gestartet..');
	      table_reload();
		});
	
	$('#'+id+'.campagne_countdown').countdown(date);
}	 

function show_unsubscribe(ID) {

	$('#modal_unsubscribe_log').modal('show');
	$.ajax( {
		url :"ajax/smartlist_unsubscribe.php",
		//global :false
		data : ({'id':ID}),
		async :false,
		dataType :"text",
		type :"POST",
		beforeSend: function(){
			$('#modal_unsubscribe_log>.content').html("<div class='ui message'><br><div class='ui active inverted dimmer'><br><div class='ui text loader'>Protokoll laden...</div><br><br></div><br><br></div>");
		},
		success: function(data){
			$('#modal_unsubscribe_log>.content').html(data);

		}
	});
}


function ReleaseNewsletter(ID) {
	$('.tooltip').popup('hide all');
	
	$.ajax( {
		url :"inc/set_session_free.php",
		global :false,
		data : ({'id':ID}),
		async :false,
		dataType :"text",
		type :"POST",
		success: function(){
			table_reload();
			$('#modal_send').modal('hide');
			$('.tooltip').popup();
		}
	});
}

function session_logfile(ID) {
	$('#modal_session_log').modal('show');

	$.ajax( {
		url :"ajax/smartlist_session_logfiles.php",
		//global :false
		data : ({'id':ID}),
		async :false,
		dataType :"text",
		type :"POST",
		beforeSend: function(){
			$('#modal_session_log>.content').html("<div class='ui message'><br><div class='ui active inverted dimmer'><br><div class='ui text loader'>Protokoll laden...</div><br><br></div><br><br></div>");
		},
		success: function(data){
			$('#modal_session_log>.content').html(data);

		}
	});
}