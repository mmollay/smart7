$(document).ready(function() {

	$('#button_edit_brocken_emails').button();
	
	// CSS
	$('#import_button,#check_import').button();
	
	// Import Contacts inner Group
	/*
	$('#import_button').click( function(){
		
		$.ajax( {
			url :'ajax/content_import2.php',
			data: ({ 
				group_id: $('#group').val(),
				groups_id: $('#groups').val(),
				setTEXT: $('#setTEXT').val(), 
				setTemplate: $('#setTemplate').val(), 
				setDelimiter: $('#setDelimiter').val(),  
				update: $('#update:checked').val() 
			}),
			async: false,
			type: 'POST',
			beforeSend: function(){ $('#dialog_msg').dialog({width:'300px',height:'200',modal:true}).html('<div align=center style=\"font-size:12px\">Daten werden importiert<br><img src=\"images/load.png\"></div>'); },
			success:    function(data){ 
				$('#dialog_msg').dialog({'title':'Info','modal':true}).html(data); 
			},
		});
	})	
	*/
	
});

function after_upload_attachment(name,size) {
	$('#finish_upload').html("<br>Inhalt von <b>"+name+'</b> wird in die Datenbank &uuml;bertragen...');
	$('#import_file').val(name);
	$("#form_window").submit();
}

function after_page_contact(){
	$('#dialog_msg').dialog({'title':'Info'}).html($('#import_info').val());
	$('#finish_upload').html('');
	//$('#message').message({ status:'info', title: message });
}