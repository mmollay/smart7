
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type='text/javascript' src='../../ssi_smart/smart_form/jquery-ui/js/jquery.min.js'></script>
<script type='text/javascript'>
// Get HTML from page
$(document).ready(function() {
	call_amazon('<?=$_GET['product_id']?>');
});

function call_amazon(product_id) {
	$.ajax( {
		beforeSend : function() { 
			window.parent.$('#wait').html('..Bitte warten');
		},	
		success:    function(data){ 
			if (data == 'error')
				alert('Kein Produkt gefunden');
			else {
				$('#content').html(data);
				window.parent.$('#wait').html('');
				window.parent.$('#amanzon_title').html($('#productTitle').text());
				window.parent.$('#amanzon_text').html($('#feature-bullets').html());
				window.parent.$('#amanzon_price').html($('#priceblock_ourprice').html());
				window.parent.$('#amanzon_alt_images').html($('#altImages').html());
				window.parent.$('#amanzon_pic').attr('src',$('#landingImage').attr('src'));
				
				$('#content').html('');
			}					
		},	
		type :"POST",			
		url :"call_amazon_content.php",
		data :( {  'product_id' : product_id }),
		global   : false,
		//async    : false,
		dataType: 'html',
	});
}
</script>
</head>
<body>
	<div id='content' style='display: none'>content</div>
</body>
</html>