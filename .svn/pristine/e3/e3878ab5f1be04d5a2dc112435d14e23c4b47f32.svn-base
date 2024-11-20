function after_submit(data) {
	
	if ( data  == 'email_exists') {
		$('#message').message({ status:'error', title: 'Email existiert bereits'  });
	}
	else if ( data  == 'blacklist') {
		$('#message').message({ status:'error', title: 'Eine Black-List Email kann nicht angelegt werden!'  });
	}
	else {
		$('#message').message({ status:'info', title: 'Eintrag wurde erfolgreich gespeichert!'  });
		//Reload List
		$('#modal_form_black').modal('hide'); 
		table_reload(); 
	}
}