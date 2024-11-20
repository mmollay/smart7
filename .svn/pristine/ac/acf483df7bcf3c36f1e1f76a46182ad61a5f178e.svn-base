/*
 * OEGT mm@ssi.at 
 */

$(document).ready(function() {

		$("#filter_section,#filter_membership,#list_filter").bind('change keyup', function(){
			$.post('inc/call_filter.php', {'list_filter':$('#list_filter').val(),'filter_section':$('#filter_section').val(), 'filter_membership':$('#filter_membership').val(), 'table':'client' });
			
			var oTable = $('#list_list').dataTable();
			oTable.fnClearTable();
		});
 		
		$("#submit").submit( function(){
			$.post('inc/call_search.php', {'list_search':$('#list_search').val(), 'list_filter':$('#list_filter').val(),'filter_section':$('#filter_section').val(), 'filter_membership':$('#filter_membership').val(), 'table':'client' });
			var oTable = $('#list_list').dataTable();
			oTable.fnClearTable();
			$('#count_open_mail').load('ajax/call_count_open_mail.php');
			return false;
		});
		
		$("#list").list({
			folder: "../ssi_form2/jquery_ssi/",
			options: {
				filter : false
			},

			cols: { 
				//code:   { title:"Code" }, 
				client_number: { title:"Kd.Nr", table:'client', width:'90'},
				//activ: { align:'center', title:"Status", table:'client', ruls:"(%activ == 1) style='font-weight:bold; color:green; font-size:18px' text='&#10004;' else text=' ' "},
				activ2: { align:'center', title:"Status"},
				company_1:  { title:"Firma", table:'client'},
				firstname:  { title:"Vorname", table:'client'},
				secondname: { title:"Nachname", table:'client'},
				//firstname:  { title:"Name", table:'client', content: "%firstname% %secondname%"},
				//secondname: { view:'hidden', title:"Nachname", table:'client', width:'100'},
				zip:        { title:"Plz", table:'client', width:'35'},
				city:       { title:"Ort", table:'client'},
				birth:      { view:'hidden'},
				//email    :  { title:"Email", table:'client'},
				//tel      :  { title:"Tel", table:'client'},
				send_date:  { view:'hidden'},
				newsletter: { align:'center', title:"NL", table:'client', ruls:"(%newsletter == 1) style='font-weight:bold; color:green; font-size:18px' text='&#10004;' else text=' ' "},
				post: { align:'center', title:"Post", table:'client', ruls:"(%post == 1) style='font-weight:bold; color:green; font-size:18px' text='&#10004;' else text=' ' "},
				amound_open  :  { title:"Offen",format:"euro",  align:"right", width:'90', field:'SUM(brutto)' , ruls:"(%amound_open > 0.000) style='font-weight:bold; color:red;'" },
				booking_total :  { title:"Verbucht",  table:'bills',  field:'SUM(booking_total)',width:'90', align:"right",format:"euro"},
				brutto   :  { title:"Gesamt",format:"euro",  table:'bills',  align:"right", width:'90', field:'SUM(brutto)'  },
				
				//netto  :  { title:"Offen", width:'80',align:"right",format:"euro",formula:"sum", ruls:"(%netto > 0.000) style='font-weight:bold; color:red;'"},
				//booking_total :  { title:"Verbucht", width:'80', align:"right",format:"euro",formula:"sum"},
				//brutto   :  { title:"Gesamt",format:"euro", align:"right", width:'80',formula:"sum" },
			},
			width: "99%",
			mysql: { 
				config_path: "../../../ssi_faktura/mysql.inc", 
				array: "array_client",
				},
			lang: "de",
			buttons:{ 
				'width': '90',
				/*
				"Beitrag erzeugen": { 
					onSuccess:  function(ID) {  call_generate_bill(ID) },
					icons     : {primary :'ui-icon-circle-plus'}, 
					text      : false,
					filter    : [{ field: 'send_date', value: '0000-00-00', operator: '!=' },{ field: 'activ', value: '1', operator: '!=' }]
				},
				*/
				"Bearbeiten": { 
					onSuccess:  function(ID) {  call_form_client(ID) },
					icons     : {primary :'ui-icon-pencil'}, 
					text      : false
				},
				"Löschen": { 
			 		onDelete : { title:"Feld löschen", text:"Wollen Sie den Datenbanksatz wirklich löschen", beforeSubmit: function() {} } ,
					onSuccess: function(ID) { },
					icons :    {primary :'ui-icon-trash'}, 
					text:      false,
					filter:    [{ field: 'netto', value: '', operator: '!=' }]
				}
			}
		});
	
		/*
		 * Buttonfunktion zum anlegen einer neuen Ausgabe
		 */
	
		$("#add_client").click( function() { 
			call_form_client();
		});	
		
		/*
		$('#generate_bills').easyconfirm({locale: {
			title: 'Abfrage',
			text: 'Wollen Sie tatsächlich Rechnungen erzeugen?',
			button: ['Abbrechen','Erzeugen'],
			closeText: 'fermer'
		}});
		*/
		$('#generate_bills').click( function() {
			call_generate_bill('all');
			$('#count_new_bills_for_user').html('0');
		});
		
		$('#generate_bills_pre').click( function() {
			call_generate_bill('all','pre');
			$('#count_new_bills_for_user_pre').html('0');
		});
		
	}); 

 	/*
 	 * Rechungsgenerator zum erzeugen einer Rechung des jeweiligen Kunden laut Einstellungen in seinem System
 	 */
 	function call_generate_bill(ID,setting) {
 		
 		var content = $.ajax( {
			url      : "oegt/generate_bill.php",
			global   : false,
			async    : false,
			type     : "POST",
			data     : ({ id : ID, setting: setting  }),
			dataType : "html",
			beforeSend : function() { $('#window_progress').dialog({width:'300px',height:'200',modal:true}).html('<div align=center style=\"font-size:12px\"><br><img src=\"images/load.png\"><br>Rechnung(en) in Erzeugung</div>');  },
 			success : function(data) { 
 				//if (!data) $('#window_progress').dialog('close'); 	
 				//else 
 					
 					$('#window_progress').html("<div align=center><br>"+data+"</div>");
 				var oTable = $('#list_list').dataTable();
 				oTable.fnClearTable();
 			}
 		}).responseText;
 	}
 	