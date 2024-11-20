/********************************************************************************************
 * Laden der Basiseinstellung fuer die Contact_site
 * - anlegen, loeschen, bearbeiten von Usern und Gruppen
 * martin@ssi.at am 25.10.2010
 ********************************************************************************************/

function after_newsletter_submit(data) {
	
	if ( data  == 'email_exists') {
		$('#message').message({ status:'error', title: 'Email existiert bereits'  });
	}
	else if ( data  == 'blacklist') {
		$('#message').message({ status:'error', title: 'Eine Black-List Email kann nicht angelegt werden!'  });
	}
	else {
		$('#message').message({ status:'success', title: 'Eintrag wurde erfolgreich gespeichert!'  });
		//Reload List
		$('#modal_form_contact').modal('hide'); 
		//$('#modal_form_contact').modal('hide');
		table_reload('contact_list');
	}
}

//Erzeugt ein Feld unter macht diese auf der Seite sichtbar - über append wird das Feld für den Wert übertragen
function generate_tag_toggles(values,contact_id) {
	$.ajax({
		url : "inc/add_tag2user.php",
		data : ({ values: values, contact_id : contact_id }),
		global: false,
		type : "POST",
		dataType : "script"
	})
}