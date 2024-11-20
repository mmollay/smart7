$(document).ready(function() {
	$('.dropdown').dropdown();
});

function call_form_newpage() {
	$('.ui.modal.new_page').modal('observeChanges').modal({
		closable : false, 
		onApprove : function() { $('#form_newpage.ui.form').submit(); return false;  }, 
		onDeny : function() {  $('.ui.modal.new_page').modal('hide'); }
	}).modal('show')
	
	// var ID = this.id;
	$.ajax({
		url : 'ajax/form_newpage.php',
		global : false,
		// async : false,
		type : "POST",
		dataType : "html",
		beforeSend : function() { $(".new_page>.content").html("<br><br><br><br><br><div class='ui active inverted dimmer'><div class='ui text loader'>Bitte warten</div></div><br><br><br><br>"); }, 
		success : function(data) { $(".new_page>.content").html(data); },
	});
}
