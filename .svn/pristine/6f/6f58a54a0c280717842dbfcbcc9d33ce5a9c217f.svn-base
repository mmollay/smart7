$(document).ready(function() {

	$('#content_no_data').html("<div class='ui active inverted dimmer'><div class='ui text loader'>Dateiverwaltung wird geladen</div></div>");
	//$('.no_data').hide();	
	// load_fileupload();
	ajax_FolderPath(true)

	$.contextMenu({
		events: {
		//show : function(options){ $('#results_dir').popup('hide all'); }
		},
	    // define which elements trigger this menu
	    selector: ".explorer_folder",
	    // define the elements of the menu
	    items: {
	        edit: {name: "Umbennenen",  icon: "fa-edit", callback: function(key, opt){ id = $(this).attr('id'); ajax_EditDir(id); }},
			move: {name: "Verschieben",  icon: "fa-folder-open-o", callback: function(key, opt){ alert('Funktion noch nicht bereit') }},
			"sep1": "---------",
			rem: {name: "Löschen",  icon: "fa-trash", callback: function(key, opt){ id = $(this).attr('id'); ajax_DelFolder(id); }},
	    }
	    // there's more, have a look at the demos and docs...
	});
	
	
    $( "#draggable" ).draggable();
    
    $( "#droppable, #droppable-inner" ).droppable({
      classes: {
        "ui-droppable-active": "ui-state-active",
        "ui-droppable-hover": "ui-state-hover"
      },
      drop: function( event, ui ) {
        $( this )
          .addClass( "ui-state-highlight" )
          .find( "> p" )
            .html( "Dropped!" );
        return false;
      }
    });
 
    $( "#droppable2, #droppable2-inner" ).droppable({
      greedy: true,
      classes: {
        "ui-droppable-active": "ui-state-active",
        "ui-droppable-hover": "ui-state-hover"
      },
      drop: function( event, ui ) {
        $( this )
          .addClass( "ui-state-highlight" )
          .find( "> p" )
            .html( "Dropped!" );
      }
    });
    
});

function load_fileupload() {
	'use strict';
	// Initialize the jQuery File Upload widget:
	$('#fileupload').fileupload({
			// Uncomment the following to send cross-domain cookies:
			// xhrFields: {withCredentials: true},
			url : 'server/php/',
			dataType : 'json',
			sequentialUploads : true,
			disableImageResize : /Android(?!.*Chrome)|Opera/.test(window.navigator && navigator.userAgent),
			imageMaxWidth : 1800,
			imageMaxHeight : 1200,
			//acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf|ico|ppt)$/i,
			// imageCrop: true, // Force cropped images

			// filesContainer: 'file',
			autoUpload : true,
			
			start: function (e) {
				check_file_container()
				if (e.isDefaultPrevented()) {
                    return false;
                }
				progress_load();
				check_file_container();
			},
			stop: function (e) {
				if (e.isDefaultPrevented()) {
					return false;
				}
				PNotify.removeAll();
				new PNotify({ title: 'Upload abgeschlossen', icon:'fa fa-check', type:'success'});
				check_file_container();
				ajax_FolderPath(true);
				
				//Reload Element after upload
				if (gadget_id) {
					window.parent.reload_element (gadget_id);
				}
			},
			progressall: function (e, data) {
				if (e.isDefaultPrevented()) { return false; }
		        var progress = parseInt(data.loaded / data.total * 100, 10);
		        $('#progress_upload').progress({ percent: progress, text     : { active: '{percent}%' } });
		    }
	});


	// Enable iframe cross-domain access via redirect option:
	$('#fileupload').fileupload('option', 'redirect', window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s'));

	
	$('#fileupload').bind('fileuploaddestroyed', function(e, data) { check_file_container(); });
	
	$.ajax({
		// Uncomment the following to send cross-domain cookies:
		// xhrFields: {withCredentials: true},
		url : $('#fileupload').fileupload('option', 'url'),
		dataType : 'json',
		context : $('#fileupload')[0]
	}).always(function() {
	}).done(function(result) {
		$(this).fileupload('option', 'done').call(this, $.Event('done'), {result : result});
		$('.button,.tooltip').popup();
		check_file_container();
	});
}


//Rotation durchführen
function  rotateImg(name, direction, id) {
	
	$.ajax( {
		url      : "ajax/image_rotate.php",
		global   : false,
		async    : false,
		type     : 'POST',
		dataType : 'script',
		data     : { name: name, id: id, direction: direction  }
	});
}

function close_finder() {
    window.parent.$('#show_explorer').modal('hide');
}

function reload_finder() {
	ajax_FolderPath(true);
}


//Erzeugt einen Bild welches zu berarbeiten ist 
function call_croppie(image_path,name) {
	
	if ( $( ".croppie-container" ).length ) {
		return;
	}

	var vEl = document.getElementById('my-image'),
	vanilla = new Croppie(vEl, {
	enableResize: true,
	viewport: { width: 200, height: 200 },
	boundary: { width: 500, height: 300 },
	//showZoomer: false,
    enableOrientation: true
	});
	vanilla.bind({
	    url: image_path,
	    //orientation: 4,
	    zoom: 0
	});
	vEl.addEventListener('update', function (ev) {
		console.log('vanilla update', ev);
	});
	
	document.querySelector('.vanilla-result').addEventListener('click', function (ev) {
		vanilla.result({
			type: 'blob'
		}).then(function (blob) {
			//alert(window.URL.createObjectURL(blob));
			$('#show_image_src').attr('src',window.URL.createObjectURL(blob));
			$('#modal_show_image').modal({  allowMultiple: true,	 });
			$('#modal_show_image').modal('show');
		});
	});
	
	
	document.querySelector('.upload-result').addEventListener('click', function (ev) {
		vanilla.result({
			type: 'canvas',
		}).then(function (resp) {
			$.ajax( {
				url      : "ajax/save_crop.php",
				//url      : http_host + "explorer/ajax/save_crop.php",
				global   : false,
				async    : false,
				type     : 'POST',
				dataType : 'html',
				data     : { 'imagebase64':resp  },
				success  : function(data) { ajax_FolderPath(true); $('#edit_explorer').modal('hide'); }
			});
		});
	});
	
	$('.vanilla-rotate').on('click', function(ev) {
		vanilla.rotate(parseInt($(this).data('deg')));
	});
	
	
	
	//this.alreadyCalled=true;
}

/*******************************************************************************
 * Ruft Editierfenster zum bearbeiten des Bildes auf
 ******************************************************************************/
function callDescribePicForm(name,path){
		//var width = 700;
		//var height = 500;
		//,position:[posX, posY]}
		//var posX = $(this).offset().left - $(document).scrollLeft() - width + $(this).outerWidth();
		//var posY = $(this).offset().top - $(document).scrollTop() + $(this).outerHeight();
	   //$(".dialog").dialog({title:name,width:width, height:height}).load(http_host + 'explorer/ajax/pic_details1.php',{ name: name });
	   
		$.ajax( {
			url      : "ajax/pic_details1.php",
			//url      : http_host + "explorer/ajax/pic_details1.php",
			global   : false,
			async    : false,
			type     : 'POST',
			dataType : 'html',
			data     : { name: name },
			success  : function(data) {
				$('#edit_explorer>.content').html(data);
				//$('#edit_explorer').modal('can fit');
				$('#edit_explorer').modal({ allowMultiple: true, observeChanges : true, closable: false });
				$('#edit_explorer').modal({ onHide: function(){ this.alreadyCalled=false; } });
				$('#edit_explorer').modal('setting', 'transition', 'vertical flip').modal('show');		
			}	
		});
}

function getUrlParam(paramName) {
	var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i');
	var match = window.location.search.match(reParam);
	return (match && match.length > 1) ? match[1] : '';
}

// uebergabe in das Formular
function OpenFileSmart(ID, fileUrl) {
	//$('#' + ID, window.parent.document).val(fileUrl);
	//$('#' + ID, window.parent.document).focus();
	window.top.$("#"+ID).val(fileUrl).focus();
	close_finder();
}

function OpenFile(fileUrl) {
	var funcNum = getUrlParam('CKEditorFuncNum');
	window.top.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
	window.top.close();
}

/*********************************************************************
 * 
 * @param ID ...Textfeld ID
 * @param gadget ....Gadget (photo)
 * @param fileUrl ... Der Link zum Foto
 ********************************************************************/
function SaveFilePhoto(ID, gadget, fileUrl) {
	//Daten werden im ueber form_gadget2.php gespeicher
	$.ajax({
		url : '../ssi_smart/admin/ajax/form_gadget_autosave.php',
		//url : http_host + 'ssi_smart/admin/ajax/form_gadget2.php',
		type : 'POST',
		data : ({
			'gadget' : gadget,
			'update_id' : ID,
			'id' : 'explorer',
			'value' : fileUrl,
		}),
		dataType : 'html',
		//Es wird das Feld erzeugt und via ajax ausgetauscht
		success : function(data) {
			
			//window.parent.$('#dialog_explorer').dialog('close'); //Explorer Fenster wird geschlossen von Iframe aus
			window.parent.$('#sort_'+ID).replaceWith(data);
			window.parent.SetNewTextfield ();
			window.parent.$('#modul_finder').flyout('toggle');
			//window.parent.$('#show_explorer').modal('toggle');
			window.parent.$('#save_icon_gadget').stop(true,true).show().fadeOut(2000);
		}, 
	});
}

//Ruft das Icon auf wenn es sich um Kein Bild handelt
function call_format_icon(name,i) {
	$.post('ajax/call_icon.php', {
	//$.post(http_host + 'explorer/ajax/call_icon.php', {
		name : name
	}, function(data) {
		$('#data_icon'+i).html(data);
	});
}


/*******************************************************************************
 * Remove dir
 ******************************************************************************/
function ajax_DelFolder(name) {
	// if(confirm("Ordner wirklich entfernen?")) {
	// Zugriff auf php zum entfernen des Bildes aus dem Verzeichnis inkl.
	// Ausgabe von der Meldung
	$.post('ajax/delete_dir.php', {
	//$.post(http_host + 'explorer/ajax/delete_dir.php', {
		name : name
	}, function(data) {
		new PNotify({ title: 'Ordner löschen', text: data, icon:'fa fa-trash'});
	});

	// Voranstellen von "\" damit id Zugriff funktioniert
	var name = "#" + name.replace(/\./g, "\\.");

	// Entfernen des Bildes
	$(name).fadeOut(500, function() {
		$(name).remove();
	});
	// }
}

/*******************************************************************************
 * Erzeugt Input fuer die Eingabe der einer neuen Folders
 ******************************************************************************/
function ajax_EditDir(id) {
	check_file_container();
	if (!id) { set_id = 'AddDirId'; id=''; }
	else set_id = id;
	$("#"+set_id).html("<div class='ui input' style='padding-top:3px;'><input type='text' value='"+id+"' name='dir_name' id='dir_name' onchange=\"ajax_EditDir2(getElementById('dir_name').value,'"+set_id+"');return false;\"/></div>");
	$("#dir_name").focus();
}


/*******************************************************************************
 * Add a Dir
 ******************************************************************************/
function ajax_EditDir2(name,old) {
	
	$.ajax({
	url : 'ajax/save_dir.php',
	type : 'POST',
	data : { name : name, old : old },
	dataType : 'script'
	});
}

/*******************************************************************************
 * Neuen Path laden bei klick auf Ordner
 ******************************************************************************/
function ajax_FolderPath(load_files,folder_path = '') {
	//if (!folder_path) folder_path = '/';
	
	// Set cookie for remember the path after reload
	Cookies.set("folder_path", folder_path, { expires: 7, path: '' });
	// leoscht files
	
	$('#container_files').html('');
	
	$.ajax({
		url : 'inc/load_folder.php',
		type : 'POST',
		data : ({
			folder_path : folder_path,
		}),
//		beforeSend: function(){
//			$('#content_no_data').html("<div class='ui active inverted dimmer'><div class='ui text loader'>Dateiverwaltung wird geladen</div></div>");
//		},
		success : function(data) {
			$('.block_uploader, #container_folder').show();	
			$('#container_folder').html(data);
			
			// und ladet fileupload neu
			if (load_files) load_fileupload();
			$('.ui.finder.accordion').accordion();
		}
	});
}

function progress_load() {
	// Make a loader.
	var loader = new PNotify({
	    title: "Hochladeprozess",
	    text: '<div class="ui small progress" id="progress_upload"><div class="bar"></div><div class="label"></div></div>',
	    //icon: 'fa fa-moon-o fa-spin',
	    icon: 'fa fa-cog fa-spin',
	    hide: false,
	    buttons: {
	        closer: false,
	        sticker: false
	    },
	    history: {
	        history: false
	    }
	});
}

//Prüft ob der Filecontrainer leer ist und gibt gegebenfalls Meldung aus
function check_file_container(){
	if ($('.template-download').length) { 
		$('#content_no_data').hide();
	}
	else {
		$('#content_no_data').show();
		$('#content_no_data').html("<div class=no_data>Noch keine Dateien in diesem Folder vorhanden<br><br><a data-tooltip='Dateien hochladen' href=# onclick=\"$('.inputfile').click()\"><i class='icon upload circular big'></i></a></div>");
	}
}