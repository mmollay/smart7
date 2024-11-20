$(document).ready(function() {
	
    	$('.ui.search.text').search({
    	    apiSettings: { url: 'inc/search_list.php?q={query}&term=text'  },
    	    minCharacters : 2,
    	    onSelect : function(result,response){ $('#text').val(result['description']); set_values_form(result['km_id']) }
    	});
    
    	$('.ui.search.end_point').search({
    	    apiSettings: { url: 'inc/search_list.php?q={query}&term=end'  },
    	    minCharacters : 2,
    	    onSelect : function(result,response){ $('#end_point').val(result['description']); }
    	});
    	
    	$('.ui.search.start_point').search({
    	    apiSettings: { url: 'inc/search_list.php?q={query}&term=start'  },
    	    minCharacters : 2,
    	    onSelect : function(result,response){ $('#start_point').val(result['description']); }
    	});
    	
	
	$('#button_home').click( function () {
	    	
		var home = $.ssi_ajax({ url : 'ajax/call_home.php' });
		$('#start_point').val(home);
		$('#end_point').focus();
	})

	if (!$('#home').val()) $('#home').click();
	
	//http://jonthornton.github.io/jquery-datepair/
	$('#km_date .time').timepicker({'showDuration': true,'timeFormat': 'H:i'});
	$('#km_date .date').datepicker({'format': 'dd.mm.yyyy','autoclose': true});

	$('#km_date .date, #km_date .time').change( function(){ call_time() });

	if ($('#km_date .date, #km_date .time').val() ){ call_time() };
	
	// initialize datepair
	$('#km_date').datepair();

	//Wenn Datum bereits eingegeben wurde, dann springt der Cursor auf das Feld "end_point"
//	$('#text').change( function(){
//		if ( $('#km_date .time').val() && $('#km_date .date').val()) { $('#end_point').focus(); }
//	})
	
	//ist das Feld "end_point" eingegeben, dann wird auf Route berechnen gesprungen
	$('#end_point').change( function(){
		call_km();
		$('#save_button').focus();
	})

});

function set_values_form(id) {
    $.ajax( {
	url :"inc/call_values.php",
	global :false,
	async :false,
	type :"POST",
	data :( { km_id :  id }),
	dataType :"script"
    })
    
}

//sucht aus der Datenbank bestehende Verbindungen und uebergibt die Km-Zahl
function call_km() {
	$.ajax({
		url: 'inc/call_km.php',
		data: {'start':$('#start_point').val(), 'end':$('#end_point').val() },
		success: function(data){ if (data) { $('#km').val(data);  } },
		dataType: 'text',
		type: "POST"
	});		
}

//Setzt automatisch das Zieldatum ein
function set_target(){
	$.ajax({
		url: 'inc/call_target.php',
		data: {'text':$('#text').val() },
		success: function(data){ 
			if (data)
				
				$('#end_point').val(data).focus();
				call_km();
			},
		dataType: 'text',
		type: "POST"
	});
}

function call_time(){
	$.ajax({
		url: 'inc/call_time.php',
		data: {'from':$('#km_from').val(), 'to':$('#km_to').val(), 'from_time':$('#km_from_time').val(), 'to_time':$('#km_to_time').val() },
		success: function(data){ $('#show_time').html(data) },
		dataType: 'text',
		type: "POST"
	});	
}

function after_form_km(id) {
	
	if (id == 'ok' || id == 'update') {
		table_reload();
		set_timer_button();	
		$('#modal_form').modal('hide');
		$('#ProzessBarBox').message({ type:'success',title:'Info', text: 'Eintrag wurde gespeichert' });
		
	}	
	else if (id == 'new_after'){
		table_reload();
		load_last_insert();
		$('#ProzessBarBox').message({ type:'success',title:'Info', text: 'Eintrag wurde gespeichert' });
		//Call new values for next insert
		var arrayFromPHP = $.ajax( {
			url :"ajax/km_last_insert.php",
			global :false,
			async :false,
			type :"POST",
			data :( { ajax : true, array : true }),
			dataType :"text"
		}).responseText;

		// Umwandeln von Array auf json
		var arrayFromPHP = $.parseJSON(arrayFromPHP);

		// Auslesen der Values aus dem Array
		$('#km_from').val(arrayFromPHP.km_from);
		$('#km_to').val(arrayFromPHP.km_to);
		$('#km_from_time').val(arrayFromPHP.km_from_time);
		$('#km_to_time').val(arrayFromPHP.km_to_time);
		
		$('#km,#text,#commend').val('');
		$('#dropdown_country').dropdown('set selected','at')
		$('#text').focus();
	}
}