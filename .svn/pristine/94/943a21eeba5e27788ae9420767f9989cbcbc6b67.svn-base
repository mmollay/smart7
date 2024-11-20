$(document).ready(function() {
	load_content_set_menu_semantic('paneon','start');
	open_modal_test();
});

function call_add_tag(tag_id) {
	
	$('#label_left_new_tag').popup({'content':'Neuen Tag anlegen'});
	
	$('#new_tag').enterKey(function () {
		$('#label_left_new_tag').click();
	})
		
	$('#label_left_new_tag').click( function() {
		if (!$('#new_tag').val()) {
			$('#new_tag').focus();
		}
		
		var value =  $('#new_tag').val();
		if (value) { $.ajax({ url : 'inc/add_tag.php', beforeSend: function(){ ; $('#label_left_new_tag').addClass('loading');  }, data : ({ tag_id : tag_id, value: value }), global: false, type : 'POST', dataType : 'script' }) }
	})
}

function resizeIframe(obj){ 
    obj.style.height = 0;
    obj.style.height = $( document ).height() - 90 + 'px';
}


function fu_open_finder(add_src) {

	$('#show_explorer>.content').html("<iframe src='../ssi_finder/index.php"+add_src+"' frameBorder='0' scrolling='auto' width=100% height=100% onload='resizeIframe(this)'></iframe>");							
	$('#show_explorer').modal({ allowMultiple: true });
	$('#show_explorer').modal('show');
}


function open_modal_test(){
    $('#testtest').modal('show');
}

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


