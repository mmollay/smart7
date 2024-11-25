
/********************************************
 * Marker wird nach Speicherung der Daten 
 * entfernt und ein neuer Marker wird gesetzt
 ********************************************/
$('#zip').change(function() { 
	    $.ajax({
	    	'type' : "POST",
	        'async': false,
	        'global': false,
	        'data': ({ zip:$('#zip').val() }),
	        'url': 'ajax/get_places.php',
	        'dataType': "json",
	        'success': function (data) {
		        	emtpy_val_dropdown('district2');
		     	    $.each(data, function(index, option) {
		     	    		add_val_dropdown('district2',option.value,option.text);
		         	});
		        }
	    }); 
});

$('#client_faktura_id').change( function (){
	$('#search_sponsor').prop( "checked", false );
})

function form_tree_save(id,data) {
	
	if ( data == 'ok') {
		 
		//$('#tree_dialog').dialog('close');
		$('#tree_dialog').modal('close');
		var marker = $("#load_map").gmap3({ get: { id: id } });	
		loadMenu();	
	
		//Alten Baum loeschen
		$("#load_map").gmap3({ clear:{ id: id } });
		
		//Neuen Baum erzeugen
		$("#load_map").gmap3({ 
			marker:{
	        	  values:[{ "latLng":marker.getPosition(), id:id, data:callDataWindow(id),"options":{"draggable":true, Icon:"http://www.obststadt.at/explorer/icons/apple.png" }}],
	        	  events:{
	        		  dragend: function(marker, event){ save_tree('',marker.getPosition()); },
	        		  click:   function(marker, event, context){ callInfoWindow(marker, event, context) }
	              }
	        }
		});	
	}
}


//Ersetzt select options 
(function($, window) {
	  $.fn.replaceOptions = function(options) {
	    var self, $option;

	    this.empty();
	    self = this;

	    $.each(options, function(index, option) {
	    		var $menu =  $("#district2").find('.menu');
	    		$menu.append('<div class="item" data-value="'+option.value+'">'+option.text+'</div>');
	    	
	    		//$option = $("<option></option>").attr("value", option.value).text(option.text);
	    		//self.append($option);
	    });
	  };
	})(jQuery, window);
