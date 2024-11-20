//Code - snipsel

// Array - Content auslesen
var arrayFromPHP = $.ajax( {
	url :"read_values_from_mysql.php",
	global :false,
	async :false,
	type :"POST",
	data :( { id :id }),
	dataType :"text"
}).responseText;

// Umwandeln von Array auf json
var arrayFromPHP = $.parseJSON(arrayFromPHP);

// Auslesen der Values aus dem Array
var matchcode = arrayFromPHP.matchcode;
var title     = arrayFromPHP.title;

