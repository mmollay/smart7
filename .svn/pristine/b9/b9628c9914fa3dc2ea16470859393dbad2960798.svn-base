var str_button_stop = 'STOP';
var str_button_start = 'START';

$(document).ready(function() {
	
	load_content_set_menu_semantic('kmlist','kmlist');
	
		$('#change_car').dropdown();
		$('#change_year').dropdown();
		
		//$('#icon_car_select').css({'background-color':$.ssi_ajax({ url : 'ajax/call_color.php' }) })
		
		//Jahr waehlen
		$('#change_year').bind('change keyup',function(){ 
			//session = year speichern
			$.ajax( {
				url      : 'inc/change_session.php',
				global   : false,
				data :({'year': $('#change_year').val()}),
				type     : 'POST',
				dataType : 'html',
				success  : function(data) {
							
				}
			});
			
			
			//Uebersicht neu laden
			reload_survey();
			//Tabelle neu laden
			table_reload();
		})
		
		//Ladefunction bei Select CAR
		laod_change_select_car();
			
		//Icon laden
		load_icon();
		
		//$("#button_settings").button();
		$("#button_settings").click( function() { 
			call_form_settings();
		});	
}); 
 	
	//Neuladen des �bersicht
 	function load_last_insert(){
		$.ajax( {
			url      : 'ajax/km_last_insert.php',
			global   : false,
			data :({'ajax':true}),
			type     : 'POST',
			dataType : 'html',
			success  : function(data) { $('#div_last_km_insert').html(data); }
		});
 	}

 	function reload_survey(){
		$.ajax( {
			url      : 'ajax/km_sum.php',
			global   : false,
			data :({'ajax':true}),
			type     : 'POST',
			dataType : 'html',
			success  : function(data) { $('#list_km_sum').html(data); }
		});
 	}
 	
 	//Farbe fuer Auto laden
 	function load_carselect() {
 		//var data  = $.ssi_ajax({ url : 'ajax/call_carselect.php', data :({'ajax':true}) });
 		$.ajax( {
			url      : 'ajax/call_carselect.php',
			global   : false,
			data :({'ajax':true}),
			type     : 'POST',
			dataType : 'html',
			success  : function(data) { $('.call_carselect').html(data); }
		});
 	}
 	
 	function load_icon(){
 		//Settings abrufen
		$.ajax( {
			url      : 'ajax/call_setting.php',
			global   : false,
			data :({'car_id': $('#change_car').val()}),
			type     : 'POST',
			dataType : 'html',
			success  : function(data) {
				array = $.parseJSON(data); 	
		 		var icon      = array['vehicle_type'];
		 		$('#icon_car_select').attr('class','icon_'+icon+' icon');
			}
		});
 	}
 	
 	function laod_change_select_car() {	
		//Jahr waehlen
		$('#change_car').bind('change keyup',function(){ 
			
			//session = year speichern
			
			$.ajax( {
				url      : 'inc/change_session.php',
				global   : false,
				data :({'car_id': $('#change_car').val()}),
				type     : 'POST',
				dataType : 'html',
				success  : function(data) {
				}
			});
			
			//Uebersicht neu laden
			reload_survey();
			
			//Icon laden und andere Settings wie Color
			load_icon();
			
			table_reload();
			
			//change color
			//$('#change_car').css({'background-color':$.ssi_ajax({ url : 'ajax/call_color.php' }) })
			
			//$('#icon_car_select').css({'background-color':$.ssi_ajax({ url : 'ajax/call_color.php' }) })
			
						
			//Timerbutton falls auf der Seite vorhanden "setzen"
			if ($(".start_stop_button").length) {
				set_timer_button();
			}
		})
	}