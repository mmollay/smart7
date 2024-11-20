$(document).ready(function() {
	load_content_set_menu_semantic('service','hacker');
	
	setInterval(function() {
		//aktive Prozesse laufen
		if ($('#apache-clients').length ) {
				$.ajax( {
					url :"inc/apache_count_clients.php",
					global :false,
					type :"POST",
					dataType :"html",
					success : function(data) { $('#apache-clients').html(data); }
				})
			}
		}, 3000);
});
