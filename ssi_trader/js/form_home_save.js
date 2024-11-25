$(document).ready(function () {
	
	function loadStocksData() {
		$.ajax({
			url: 'inc/stock_list.php', // Passe diesen Pfad an deinen tatsächlichen Pfad an
			type: 'GET',
			success: function (data) {
				$('#stocksDataContainer').html(data);
			},
			error: function (err) {
				console.error('Fehler beim Laden der Daten:', err);
			}
		});
	}

	var conn = new WebSocket('ws://server7.ssi.at:8080');
        conn.onopen = function(e) {
            console.log("Verbindung hergestellt!");
        };

        conn.onmessage = function(e) {
            var $daxValue = $('#daxValue');
            $daxValue.text(e.data);

            // Blink-Effekt hinzufügen, um die Aktualisierung hervorzuheben
            $daxValue.css('color', 'red');
            setTimeout(function() {
                $daxValue.css('color', ''); // Farbe zurücksetzen
            }, 500); // Dauer des Effekts in Millisekunden
        };

	// Lade die Daten beim ersten Mal
	loadStocksData();
	loadEmaForm();

	// Setze das Neuladen der Daten jede Minute fort
	setInterval(loadStocksData, 60000);
});

function post_ema(strategyValue) {
	$.ajax({
		url: 'ajax/post.php', // Die URL, an die die Anfrage gesendet wird
		type: 'POST', // Die Art der Anfrage
		data: { 'strategy_value': strategyValue }, // Die Daten, die gesendet werden sollen
		success: function (data) {
			// Aufruf der after_post_ema Funktion mit der Serverantwort
			after_post_ema(data);
			loadEmaForm();
		},
		error: function (xhr, status, error) {
			// Im Fehlerfall, erstelle ein JSON-Objekt mit einer Fehlermeldung und rufe after_post_ema auf
			after_post_ema(JSON.stringify({ error: 'Ein Fehler ist aufgetreten: ' + error }));
		}
	});
}


function loadEmaForm() {
	$.ajax({
		url: 'inc/ema_form.php',
		type: 'GET',
		success: function (data) {
			$('#formEmaContainer').html(data);
			
		},
		error: function (err) {
			console.error('Fehler beim Laden der Daten:', err);
		}
	});
}

function submit_hedging(id) {
	if (id = 'ok') {
		$('#message').toast({ class: 'info', title: 'Demo: Send Strategy', position: 'top center' });
	}
	else {
		$('#message').toast({
			class: 'red',
			title: id,
			position: 'top center'
		});
	}
}

function after_post_ema(json) {
	// Überprüfe, ob json gültig ist
	if (!json) {
		// Wenn kein json vorhanden ist, zeige eine Fehlermeldung an
		$('#message').toast({
			class: 'red',
			title: 'Keine Daten erhalten',
			position: 'top center'
		});
		return; // Beende die Funktion frühzeitig
	}

	try {
		// Versuche, json aufzulösen
		json = JSON.parse(json);
	} catch (e) {
		// Wenn json nicht aufgelöst werden kann, zeige eine Fehlermeldung an
		$('#message').toast({
			class: 'red',
			title: json,
			position: 'top center'
		});
		return; // Beende die Funktion frühzeitig
	}

	// Wenn json ein Fehler enthält, zeige die Fehlermeldung an
	if (json.error) {
		$('#message').toast({
			class: 'red',
			title: json.error,
			position: 'top center'
		});
	} else {
		// Sonst zeige die Nachricht aus json an
		$('#message').toast({
			class: 'info',
			title: json.message,
			position: 'top center'
		});
	}
}

function after_post_request(json) {
	json = JSON.parse(json);
	//Alles json in console.log anzeigen
	console.log(json);

	//json.message show in toast
	if (json.message) {

		$('#message').toast({
			class: 'info',
			title: json.message,
			position: 'top center'
		});
	}
	else if (json.error) {
		$('#message').toast({
			class: 'red',
			title: json.error,
			position: 'top center'
		});
	}
	else if (!json) {
		$('#message').toast({
			class: 'red',
			title: 'Keine Daten erhalten',
			position: 'top center'
		});
	}

	if (json.buy_sell) {
		$('#dropdown_buy_sell_stop').dropdown('set selected', json.buy_sell);
		$('#price_trade').val(json.price);

		if (json.buy_sell === 'buy') {
			var neuerPreis = parseFloat(json.price) + 5; // Füge 5 zum Preis hinzu
			//wenn kein json.price ist dann toast "Kein Preis erhalten"
			if (!json.price) {
				$('#message').toast({
					class: 'red',
					title: 'Kein Preis erhalten',
					position: 'top center'
				});
				return;
			}

			$('#price').val(neuerPreis); // Setze den neuen Preis
			$('#dropdown_buy_sell_stop').dropdown('set selected', 'buyStop');
		} else if (json.buy_sell === 'sell') {
			var neuerPreis = parseFloat(json.price) - 5; // Subtrahiere 5 vom Preis
			$('#price').val(neuerPreis); // Setze den neuen Preis
			$('#dropdown_buy_sell_stop').dropdown('set selected', 'sellStop');
		}
	}

}	
