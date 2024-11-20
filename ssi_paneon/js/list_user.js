$(document).ready(function() {
	
	$("#submit").submit( function(){
		$.post('inc/call_search.php', {'list_search':$('#list_search').val(), 'table':'user' });
		var oTable = $('#list_list').dataTable();
		oTable.fnClearTable();
		return false;
	});

	$('#list').list({
		folder: '../ssi_form2/jquery_ssi/',
		DisplayLength: 50,
		onLoad: function(){ $('.link').css({'font-size':'10px','width':'170px'}).button();},

		cols: { 
			client_id:     { title:'BeraterID', width:'40px'},
			name:          { title:'Name', width:'200px'},
			//InitiatorID:   { title:'IniatorID'},
			Auszahlg:    { title:'Auszahlung', format:'euro', width:'50px',align:'right', aaSorting:'desc'	},
			EiUmsatz:      { title:'EiUmsatz', format:'euro', width:'50px', align:'right'},
			counter_Initiator: { title:'Initiator (Counter)', width:'40px'},
			counter_ActiveVorg: { title:'ActiveVorg (Counter)', width:'40px'},
			IpUmsatz:      { title:'IpUmsatz', format:'euro', align:'right'},
			KuUmsatz:      { title:'KuUmsatz', format:'euro', align:'right'}
			//Anrede:      { title:'Anrede'},

			
			
			//Email:         { title:'Email'},
			//update_time:   { title:'Seit'},
		},
		width: '100%',
		mysql: { 
			config_path: "../../../paneon/mysql.inc",
			array      : "array_user", 
		},
		lang: 'de',
	});

});