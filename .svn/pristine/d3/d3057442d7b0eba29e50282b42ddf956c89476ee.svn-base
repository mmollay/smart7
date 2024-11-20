
$(document).ready( function() {
	
	check_url_name();

	$('#page_id').change( function() {
		var domain = $('#dropdown_page_id').dropdown('get text');
		$('.funnel_domain').html(domain);	
	});
	
});

var xhr = null;
//Prüft nach ob Name bereits existiert und wandelt URL um (keine Sonder und Leerzeichen
function check_url_name(){
	
	$('.check_url').keyup( function() {
				
		if( xhr != null ) {
	        xhr.abort();
	        xhr = null;
		}
		
		if( this.value.length < 2 ) return;
		xhr = $.ajax( {
			url      : '../ssi_newsletter/inc/call_url_name.php',
			data     : ({ url:this.value ,name : this.id , page_id : $('#page_id').val()}),
			type     : 'POST',
			dataType : 'script'
		});
	});
}


var delay = (function(){
	  var timer = 0;
	  return function(callback, ms){
	    clearTimeout (timer);
	    timer = setTimeout(callback, ms);
	  };
})();