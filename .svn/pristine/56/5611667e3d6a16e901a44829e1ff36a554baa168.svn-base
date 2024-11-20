$(document).ready(function() {
	
	//check is in system allready logged in
	setInterval(function() { 
		$.ajax({url: "../login/inc/login_check.php", data: ({modul: modul}), type : "POST", success: function(result){
		    if (result == 'exit')
		    	$(location).attr('href','../ssi_dashboard/index.php?logout=true');
		  }});
	}, 10000);
	
	
		  
	
	//$(".hideLoader").css({'display':'block'});
	
	//$('.cookie.nag').nag('clear');
	
	//Zeigt Cookie-aktivieren wenn nicht aktiv
	//$('.cookie.nag').nag({ key:'accepts-cookies', value:true }); 
	
	$('#button_logout').click( function(){ $(location).attr('href','../ssi_dashboard/index.php?logout=true'); })
	$('.radio_modul').click (function(){ var value = $('#'+this.id).attr('value'); $(location).attr('href', '../'+value+'/'); })
	
	//$('.tooltip').popup({'position':"bottom center",'variation':'inverted'});
	$('.tooltip').popup();
	
	$('.tooltip-right').popup({ position: 'right center'});
	$('.tooltip-top').popup({ position: 'top center'});
	/*
	 * Button for resize Menu on the left side
	 */
	$('#resize_button').hide();
	//$('#resize_button_hide').button( { icons : { primary :'ui-icon-arrowstop-1-w'}, text: false }).css('font-size','10px');
	
	if (Cookies.get('hide_menu') == true) {
		$('.center_left').hide();
		$('.right_content').css({'padding-left':'0px'})
		$('#resize_button').show();
		$('#resize_button_hide').hide();
	}
	
	$('#resize_button_hide').click( function() {
		$('.center_left').hide("float", '', 2000, function() {   }); 
		$('.right_content').css({'padding-left':'0px'})
		$('#resize_button_hide').hide();
		$('#resize_button').show();
		Cookies.set('hide_menu', true, { expires: 7, path: '' });
	});
	
	$('#resize_button').click( function() {
		$('.center_left').show("float", '', 2000, function() {   }); 
		$('.right_content').css({'padding-left':'190px'})
		$('#resize_button_hide').show();
		$('#resize_button').hide();
		Cookies.set('hide_menu', false, { expires: 7, path: '' });
	});
	
});


function load_content_set_menu_semantic(modul,default_content_id) {
	
	//Speichert die aktuelle Seite bei einem Reload
	if (Cookies.get(modul+"content_id")) var content_id = Cookies.get(modul+"content_id");
	else var content_id = default_content_id;
	
	load_content_semantic(modul,content_id)
	
	//aufrufen einer weiteren Seite
	//Fuer Menu link  
	//Fuer Menu top
	$(".center_left > .menu > .item, .center_top > .item").click( function(){
		var content_id = this.id;
		
		//Wenn Link direkt aufgerufen werden soll (Bsp.: Logo vom Menu)
		if (content_id){ load_content_semantic(modul,content_id); }
	})
}

//clone_id wird für Newletter clone eingesetzt
function load_content_semantic(modul,content_id,clone_id,data) { 

	//return false;
	var container_id = "container_"+content_id;
	
	//Wenn Seite noch nicht geladen ist wird der Content neu gesetzt
	if ($('#'+container_id).length) set_ajax = 1;
	else set_ajax = 0;
	
	var data = $.extend({'ajax': set_ajax, 'clone_id' : clone_id }, data);
	
	$.ajax( {
		url      : 'ajax/content_'+content_id+'.php',
		global   : false,
//		async    : false,
		type     : "POST",
		data     : data,
		dataType : "html",
		beforeSend : function() {
			$('.tooltip').popup('hide all');
			$('.ui.modal').remove(); //löscht alle Modalfenster im Hintergrund 
			$('.load_content').html('<br><br><br><br><br><br><br><div class="ui centered inline active blue elastic loader"></div>');
		},
		error: function(){
			$('.load_content').html('<div class="message ui error"><br>Seite wurde nicht gefunden<br><br></div>');
		},
		success  : function(data) { 
			//$('.container_loading').html('');
			$('.load_content').html(data);
		},
	});
	
	Cookies.set(modul+"content_id", content_id, { expires: 7, path: '' });
	$('.item').attr('class','item');
	$('#'+content_id).attr('class','item active marked');
	
}

function startTour() {
	var tour = introJs()
	tour.setOption('tooltipPosition', 'auto');
	tour.setOption('positionPrecedence', ['left', 'right', 'bottom', 'top'])
	tour.start()
}

//PRÜFT OB SCRIPT BEREITS GELADEN IST
function appendScript(filepath) {
    if ($('head script[src="' + filepath + '"]').length > 0)
        return;

    var ele = document.createElement('script');
    ele.setAttribute("type", "text/javascript");
    ele.setAttribute("src", filepath);
    $('head').append(ele);
}


function close_finder() {
    $('#show_explorer_content').html('');
    $('#show_explorer').modal('hide');
}
