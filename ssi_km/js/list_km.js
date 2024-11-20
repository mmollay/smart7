$(document).ready(function() {
	
	var d = $.ssi_ajax({ url : 'inc/timer_check.php' });	
	if (d) $('#timer').tinyTimer({  from: d, format: '%d %h:%m:%s'});

	set_timer_button();

	$('.start_stop_button').click( function(){
		
		if ($(".start_stop_button").attr('id') == 'stopped') {
			$.ssi_ajax({ url : 'inc/timer_start.php', data :({}) });
			table_reload();
			set_timer_button()
		}
		else {
			var timer_sessionID = $.ssi_ajax({ url : 'inc/timer_session.php', data :({'field':'km_id'}) });
			
			//Modal aufrufen
			call_semantic_form(timer_sessionID,'modal_form','../ssi_km/ajax/form_km.php','km_list','');
			
		}
	});
			
}); 
 	
 	function set_timer_button(d) {
	
		//Timer fuer Aufzeichnung
 		if (!d) var d = $.ssi_ajax({ url : 'inc/timer_check.php'});
		if ( d ) {
			$(".start_stop_button_text").html(str_button_stop);
			$(".start_stop_button").attr('id','started').addClass('red');
			//$('#timer').tinyTimer({  from: d, format: '%d %h:%m:%s'});
			$('#timer').show();
			
			if (!$('#timer').data('tinyTimer')) $('#timer').tinyTimer({  from: d, format: '%d %h:%m:%s'})
			var tt = $('#timer').data('tinyTimer');
			tt.start();
			tt.resetFrom(d);
		}
		else {
			
			$(".start_stop_button_text").html(str_button_start);
			$(".start_stop_button").attr('id','stopped').removeClass('red');
			var tt = $('#timer').data('tinyTimer');
			//tt.pause();
			$('#timer').hide();
			
		}
	}