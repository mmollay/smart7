$(document).ready( function() {
	
//	$('.menu_structure.menu .item').tab({
//	apiSettings: {
//	    url: 'ajax/{tab}'
//	  }
//	}).tab('change tab', 'content_list_campagne.php');
//	
	
//	$('.menu_structure .item').tab({
//		alwaysRefresh: true,
//	    cache: false,
//	    auto: true,
//	    path    : 'ajax/',    
//	  }).tab('change tab', 'content_list_campagne.php')
//	
	
	load_content_set_menu_semantic('newsletter','start');
	check_profile();
	check_alert(); 
	
	//$('.menu .item') .tab();

	setInterval(function() {
		//Wenn Modal offen ist oder aktive Prozesse laufen
		if ( !$('.ui.modal').is(':visible') && $('.progress-status').length ) {
			
			$('.progress-status'). each (function() {				
				
				var xhr = null;
				
				session_id = this.id;
				
				if( xhr != null ) {
			        xhr.abort();
			        xhr = null;
				}
				
				xhr =  $.ajax( {
					url :"inc/call_active_count.php",
					data : { session_id : session_id},
					global :false,
					type :"POST",
					dataType :"script",
				})
				
			})
		}
	}, 5000);
	
	
	//$('#progress_space').progress( { text: { active  : "{value} von {total} Mails", success : '{total} alle Mail verbraucht!' } });
	$('#progress_space').progress();
	
})

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


	//Prueft ob eine Email noch nicht verifiziert wurde und zeigt den Alert an direct bei der Menueleiste
	function check_alert () {
		$.ajax( {
			url :"inc/verify_check_open.php",
			global :false,
			async :false,
			type :"POST",
			dataType :"text",
			success: function(data){ 
				if (data != 0) { 
					$('#verify_alert').addClass('red');
				}	
				else {
					$('#verify_alert').removeClass('red');
				}
			}
		});
	}


	//Prueft ob Profil angelegt wurde
	function check_profile() {
		$.ajax( {
			url :"inc/profile_exist_check.php",
			global :false,
			async :false,
			type :"POST",
			dataType :"text",
			success: function(data){ 
				if (data == 0) { 
					$('.show_content_with_profil').hide();
					$('.show_button_for_add_profil').css({'visibility':'visible'});
				}
				else {
					$('.show_content_with_profil').show();
					$('.show_button_for_add_profil').css({'visibility':'hidden'});
				}
			}
		});
	}
	

	function verify_success(data){
		if ( data  == 'error') {
			$('#message').message({ status:'error', title: 'Falscher Code, Verifizierung fehlgeschlagen'  });
		}
		else {
			$('#message').message({ status:'info', title: 'Emailadresse wurde verifiziert!'  });
			$('#modal_form_verification').modal('hide'); 
			
			table_reload(); 
			check_alert();
		}
	}

	function reset_error_mails(id) {
		$.ajax( {
			url :"inc/reset_error.php",
			global :false,
			async :false,
			type :"POST",
			data : {id:id},
			dataType :"text",
			success: function(data){ 
				if (data == 'ok') { 
					$('#modal_session_log').modal('hide'); 
					table_reload('newsletter_list');
				}
				else {
					if (id) alert('Keine Aktion für Session ID:'+id );
					else alert('Keine ID vorhanden');
				}
			}
		});

	}
	

	function SendMailManuel() {
		$.ajax( {
			url :"exec/SendNewsletter.inc.php",
			async :false,
			dataType :"text",
			type :"POST",
//			beforeSend: function(){
//			    $('body').toast({message: 'Manuelle Versendung..',position : 'top center'});
//			},
			success: function(data){
			    $('body').toast({message: data,position : 'top center'});

			}			
		})
	}
	
	
	function SmartSendTestMail(ID) {

		$.ajax( {
			url :"exec/send_testmail.inc.php",
			//global :false
			data : ({'id':ID}),
			async :false,
			dataType :"script",
			type :"POST",
			beforeSend: function(){
				$('#modal_testmail').modal({allowMultiple: true, observeChanges : true }).modal('show');
				$('.tooltip').popup('hide all');
				$('#modal_testmail>.content').html("<div class='ui message'><br><div class='ui active inverted dimmer'><br><div class='ui text loader'>Versendung erfolgt...</div><br><br></div><br><br></div>");
			},
			success: function(data){
				$('.tooltip').popup();

			}
	})
	}
	
	
	function set_placeholder(textfield_id,placeholder) {
		CKEDITOR.instances[ textfield_id ].insertText("{%"+placeholder+"%}");
		return false;
	}


	//dropdown_id = tagauswahl
	//add_id = inputfeld für die Eingabe des Tagnamens
	//example : call_add_tag('action_add_tag');
	function call_add_tag(dropdown_id, add_id = false ) {
	    
	    if (!add_id)
	    	var add_id = dropdown_id+'_add';
	    
		$('#label_left_'+add_id).popup({'content':'Neuen Tag anlegen'});
		
		$('#new_tag').enterKey(function () {
			$('#label_left_'+add_id).click();
			
		})
			
		$('#label_left_'+add_id).click( function() {
			if (!$('#'+add_id).val()) {
				$('#'+add_id).focus();
			}
			
			var value =  $('#'+add_id).val();
			if (value) { $.ajax({ url : 'inc/add_tag.php', beforeSend: function(){ ; $('#label_left_'+add_id).addClass('loading');  }, data : ({ tag_id : dropdown_id, value: value, add_id : add_id }), global: false, type : 'POST', dataType : 'script' }) }
		})
	}
	
	

function nl_trashback(ID) {
	$.ajax({ url : 'inc/nl_trashback.php', data : ({ id : ID }), global: false, type : 'POST'});
	table_reload();
}
	