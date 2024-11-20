//if (!destination) var destination = '';

$(document).ready(function() {	
	//call_filter_map('map_zip',destination);
	$(window).resize(function() {
	    $('#load_map').height($(window).height() - 140);
	});

	$(window).trigger('resize');
	
});

