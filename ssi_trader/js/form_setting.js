/*
 * Call Password 
 */
$(document).ready(function() {
	
});


function after_form_setting(id) {

	if (id == 'ok') {
		$('#message').message({ status: 'info', title: 'The setting has been saved!' });
		$('#modal_form').modal('hide');
		table_reload();
	} else {
		$('#message').message({
			status: 'error', title: 'System Error:' + id
		});
	}

}