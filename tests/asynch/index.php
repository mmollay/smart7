<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Smart-Form: Demos</title>
<link rel="stylesheet" href="../../ssi_smart/smart_form/semantic/dist/semantic.min.css">
</head>
<body>
	<br>
	<div class="request"></div>

	<script src="../../ssi_smart/smart_form/jquery/jquery.min.js"></script>
	<script src="../../ssi_smart/smart_form/semantic/dist/semantic.min.js"></script>
	<script>
	var responseLen = 0;
	$.ajax({
	    url: "request.php", 
	    type: "POST",
	    xhr: function(){
	        var xhr = $.ajaxSettings.xhr();
	        xhr.onprogress = function(e){
	            text = e.currentTarget.responseText.substr(responseLen); 
	            responseLen = e.currentTarget.responseText.length;
	            $('.request').append(text);
	        };
	        return xhr;
	    }
	 });
	</script>
</body>
</html>