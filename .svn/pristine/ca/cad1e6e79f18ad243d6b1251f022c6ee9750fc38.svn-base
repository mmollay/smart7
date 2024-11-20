
$(document).ready(function() {
	$('#student').click( function(){
		$('#matrical_nr').removeAttr('disabled');
		$('#matrical_nr').focus();
	})
	if ($('#student').attr('checked')){
	}
	else $('#matrical_nr').attr('disabled', 'disabled');
	
	$(".button_add_section").click( function(){
		$.post('oegt/add_section.php', { id:this.id }, function(data){ $("#set_new_section").append(data) });
	})

	
	/*
	$.localise('ui-multiselect', {
		language : 'de',
		path : '../ssi_form2/multiselect/js/locale/'
	});
	$("#sections").css({'height':'150px','width':'300px'})
	$("#sections").multiselect();	
	*/
});
