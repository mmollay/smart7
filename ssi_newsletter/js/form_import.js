/*******************************************************************************
 * Laden der Basiseinstellung fuer die Contact_site - anlegen, loeschen,
 * bearbeiten von Usern und Gruppen martin@ssi.at am 14.08.2011
 ******************************************************************************/

$.fn.enterKey = function (fnc) {
    return this.each(function () {
        $(this).keypress(function (ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                fnc.call(this, ev);
            }
        })
    })
}

$(document).ready( function() {
    
    	$( "#sortable_label" ).sortable({
    	    update: function(event, ui) {
                var productOrder = $(this).sortable('toArray').toString();
                
                $.ajax ({
 		   url: 'inc/sortable_templates.php',
 		   global: false,
 		   data: ({ data : productOrder}),
 		   type: 'POST',
 		   dataType: "text",
 		  success:    function(data){
 		     $("#sortable-9").text (data);      
 		  }
                }); 
            }
    	});
    
	if ($('#dropdown_import_type').dropdown('get value') == 'basic') {
		$('#row_setDelimiter,#row_info_list').show();
		$('#row_info_format').hide();
	}
	else {
		$('#row_setDelimiter,#row_info_list').hide();
		$('#row_info_format').show();
	}
	
	$('#import_type').change( function() {
		if ($('#dropdown_import_type').dropdown('get value') == 'basic') {
			$('#row_setDelimiter,#row_info_list').show();
			$('#row_info_format').hide();

		}
		else {
			$('#row_setDelimiter,#row_info_list').hide();
			$('#row_info_format').show();
		}
		$('#setTEXT').focus();
	});
	
});