
/* Infos for GMap3
 * https://code.google.com/p/jquery-ui-map/wiki/jquery_ui_map_v_3_sample_code
 */

/*******************************************************************************
 * Baum bearbeiten - Formular laden
 ******************************************************************************/
function edit_tree(id,reload_list) {
	$.ajax( {
		url      : "ajax/form_edit.php",
		global   : false,
		type     : "POST",
		data     : ({ update_id : id, list_id : 'form_tree' }),
		dataType : "html",
		success : function(data) {
			$('#tree_dialog>.content').html(data);
			//$('#tree_dialog').modal('setting','autofocus',false).modal('show');  
			$('#tree_dialog').modal({ allowMultiple: true, observeChanges : true, autofocus: false, closable: false }).modal('show');
		}
	})
}


/*******************************************************************************
 * Loeschen eines Baumes
 ******************************************************************************/
function del_tree(id) {
	
	$.ajax( {
		url      : 'inc/del_tree.php',
		global   : false,
		// async : false,
		type     : "POST",
		data     : ({ tree_id : id  }),
		dataType : "html",
		success : function(data) { if (data =='ok'){  $("#load_map").gmap3({ clear:{ id: id } }); loadMenu(); after_loadMap() } }
	});
}

/*******************************************************************************
 * Speichern der Koordinaten
 ******************************************************************************/
function save_tree(tree_id,long){
	
	var content = $.ajax( {
		url      : 'ajax/form_edit2.php',
		global   : false,
		async    : false,
		type     : "POST",
		data     : ({ latitude : long.lat(), longtitude : long.lng(), tree_id : tree_id, list_id : 'form_tree'  }),
		dataType : "html"
	}).responseText;
	return content;
}


/*******************************************************************************
 * Neuen Baum setzen
 ******************************************************************************/
function map_button_new_tree(){	
	// aktuelle Koordianten der map herauslesen und das Zentrum ermitteln
	var map = $("#load_map").gmap3('get');
	var map_bounds = map.getBounds().getCenter();
	
	//Marker muss eine ID bekommen
	var tree_id =  save_tree('new',map_bounds);
	
	$("#load_map").gmap3({ 
		marker:{
        	  values:[{ "id":tree_id, "latLng":map_bounds,"options":{"draggable":true}}],
        	  events:{
        		  dragend: function(marker, event , context){ 
        			  loadMenu();

        			  //Marker muss eine ID bekommen
        			  save_tree(tree_id,marker.getPosition());
        			  marker.setIcon("https://center.ssi.at/ssi_smart/gadgets/map/icons/grey.png");
        			  callInfoWindow(marker, event, context) 
        		  },
        		  click: function(marker, event, context){ 
        	      }
              }
        }
	});
	
}

/*******************************************************************************
 * Karte laden, im Adminmodus zum verschieben der Bäume
 ******************************************************************************/
function laodAdminMap(autofit,bicyclinglayer) {
	
	//Schaltet Lock-Anzeige aus oder ein
	call_set_admin_status();
	
	$('#load_map').gmap3({ clear: {  } });
	// $("#load_map").gmap3('destroy');
	$.ajax( {
		url      : '../ssi_smart/gadgets/map/inc/data_map.php',
		global   : false,
		async    : false,
		type     : "POST",
		dataType : "json",
		data : ({ set_admin: true }),
		success : function(array_map) {
			
			if (array_map == null ) { $('#map-no-results').show('fast').delay(3000).hide('fast'); return; }
			
			$("#load_map").gmap3({
		        marker:{
		        	  values:array_map,
		        	  cluster:{
		        	      radius:20,
		        	      // This style will be used for clusters with more
							// than 0 markers
		        	      0: {
		        	        content: "<div class='cluster cluster-1'>CLUSTER_COUNT</div>",
		        	        width: 30,
		        	        height: 30
		        	      },
		        	  },
		        	  options:{ 
		        		draggable:true,
		        		streetViewControl: false
		        	 },
		        	  events:{
		        		  dragend: function(marker, event, context){ save_tree(context.id,marker.getPosition()) },
		        		  click: function(marker, event, data){ 
		        			  callInfoWindow(marker, event, data); 
		        			  }  
		              }
		        }
			},bicyclinglayer,autofit);			
			
			//after_loadMap();
			
		 }
	});	
}

function move_trees(){
	
	var id = $( ".map_button_set_admin_modus" ).attr('id');
		if (id == 'true') {
			
			if (!Cookies.get('autofit')) Cookies.set('autofit',1, { path: '' });
			
			Cookies.set("set_admin",true, { path:'' });
			//set_admin_cookie(true);
			laodAdminMap(Cookies.get("autofit"),Cookies.get("bicyclinglayer"));
		}
		else {
			Cookies.set("set_admin",false, { path:''});
			//set_admin_cookie(false);
			loadMap(Cookies.get("autofit"),Cookies.get("bicyclinglayer"));
		}
		//setzt Icon
		call_set_admin_status();
}

function set_admin_cookie(set){
	
	$.ajax( {
		url      : "ajax/set_admin_cookie.php",
		global   : false,
		type     : "POST",
		data     : ({ set_admin_cookie : set }),
		dataType : "html"
	});
}

//Icon setzen "bearbeitbar oder nicht" "lock","unlock"
function call_set_admin_status() {
	var id = Cookies.get('set_admin');
	
	if (id == 'true') {
			$('.map_button_set_admin_modus>.icon').removeClass('lock grey');
			$('.map_button_set_admin_modus>.icon').addClass('unlock orange');
			$('.map_button_set_admin_modus').attr("id", "false");
			$('.show_admin_button').show();
		}
		else {
			$('.map_button_set_admin_modus>.icon').removeClass('unlock orange');
			$('.map_button_set_admin_modus>.icon').addClass('lock grey');
			$('.map_button_set_admin_modus').attr("id", "true");
			$('.show_admin_button').hide();
		}	
}