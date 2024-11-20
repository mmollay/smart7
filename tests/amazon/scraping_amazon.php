<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type='text/javascript' src='../../ssi_smart/smart_form/jquery-ui/js/jquery.min.js'></script>
<script type='text/javascript'>
$(document).ready(function() {	
});

function call_iframe_amazon(product_id) {
	$('#amanzon_title,#amanzon_text,#amanzon_price').html('');
	$('#amanzon_pic').attr('src','');
	$('#iframe_amazon').attr('src','iframe.php?product_id='+product_id);
}
</script>

</head>
<body>
<input type='text' id='input_product_id' value='B00AW9HDQ8'><button onclick="call_iframe_amazon($('#input_product_id').val())">Erzeugen</button> oder <button button onclick="call_iframe_amazon('B00U7GC2NU')">Meditation-Kissen</button><hr>

 <iframe id='iframe_amazon' src="" style='display: none'></iframe>
 <div id='wait'></div>
<div id='amanzon_title'></div>
<div id='amanzon_text'></div>
<div id='amanzon_price'></div>
<img id='amanzon_pic'>
<div id='amanzon_alt_images'></div>
</body>
</html>