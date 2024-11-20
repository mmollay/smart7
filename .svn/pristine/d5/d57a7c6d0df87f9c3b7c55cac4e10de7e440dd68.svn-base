$(document).ready(function() {
	
	//load_content_set_menu_semantic('learning','home');
	//load_content_semantic('learning','home')
	
	$('.choose').dropdown( { action: function(text, value) { 
		//Themen ID wird wird gesetzt (Session)
		//$.post('inc/choose_theme.php', { theme_id : value } );
		//Seite wird neu geladen 
		$.ajax( {
			url      : 'inc/choose_select.php',
			global   : false,
			type     : "POST",
			data     : ({ value : value, id : this.id  }),
			dataType : "html",
			success : function() { location.reload(); }
		});
	} 
	});
});

function check_theme_choose() {
	if ( $('#theme_id').val() ) { 
		$('#list_group,#list_question').show(); 
		load_content_set_menu_semantic('learning','home');
	} 
	else { 
		load_content_semantic('learning','home'); 
	}
}

function call_block(id) {
	//block setzen
	$.ajax( {
		url      : 'inc/choose_select.php',
		global   : false,
		type     : "POST",
		data     : ({ value : id , id : 'block'  }),
		dataType : "html",
		success : function() { load_content_set_menu_semantic('learning'); }
	});
}

function erase_question(){
	//block setzen
	$.ajax( {
		url      : 'inc/erase_question.php',
		global   : false,
		type     : "POST",
		//data     : ({ value : id , id : 'block'  }),
		dataType : "html",
		success : function(data) { if (data == 'ok') alert('Fragen wurden zurückgesetzt'); }
	});
}