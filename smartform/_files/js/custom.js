
// Funktion zum Aktualisieren der src-Attribute von <img> und href-Attribute von <a> mit bestimmten Klassen
function updateImageSources() {
    // Aktualisiere <img> Elemente
    var imgElements = document.querySelectorAll('.pswp__img');
    updateAttribute(imgElements, 'src');

    // Aktualisiere <a> Elemente
    var aElements = document.querySelectorAll('.files-a-img');
    updateAttribute(aElements, 'href');
}

// Hilfsfunktion zum Aktualisieren eines Attributs (src oder href) für eine NodeList von Elementen
function updateAttribute(elements, attribute) {
    for (var i = 0; i < elements.length; i++) {
        var element = elements[i];
        var value = element[attribute];

        // Entferne bestehende Zeitstempel aus der URL
        var valueWithoutTimestamp = value.split('?')[0];

        // Füge einen neuen Zeitstempel hinzu
        var timestamp = new Date().getTime();
        element[attribute] = valueWithoutTimestamp + '?timestamp=' + timestamp;
    }
}


// Hilfsfunktion zum Aktualisieren der src-Attribute und Tauschen von Breite und Höhe im Style-Attribut
function updateImagesSrc(images, encodedBasename) {

	for (var i = 0; i < images.length; i++) {
		// Überprüfen, ob das Bild existiert und eine src-Eigenschaft hat
		if (images[i] && images[i].src && images[i].src.includes(encodedBasename)) {
			var oldSrc = images[i].src.split('?')[0]; // Aufteilen der URL am '?' und Beibehalten des ersten Teils
			var timestamp = new Date().getTime(); // Generieren eines Zeitstempels
			images[i].src = oldSrc + '?timestamp=' + timestamp; // Hinzufügen des Zeitstempels zum src-Attribut
		}
	}
}


// Funktion zum Entfernen aller Elemente mit der Klasse 'pswp__img--placeholder'
function removePlaceholderImages() {
	var placeholderImages = document.querySelectorAll('.pswp__img');
	placeholderImages.forEach(function(image) {
		image.remove(); // Entfernt das Element aus dem DOM
	});
}

// Event-Listener-Funktion, die auf den Button-Klick reagiert
function onPopupButtonClick(event) {
	// Überprüfe, ob das geklickte Element die richtige Klasse und das Datenattribut hat
	if (event.target.classList.contains('dropdown-item') && event.target.getAttribute('data-action') === 'popup') {
		//removePlaceholderImages();
		setTimeout(function() {
			updateImageSources();
		 	//window.location.reload(true);
		}, 300);
	}
}

// Füge dem gesamten Dokument einen Event Listener für das Klick-Event hinzu
document.addEventListener('click', onPopupButtonClick);


//Übergibt den Link des Images
function sendUrl(item) {
	if (window.parent.$) {
		console.log(item);
		var url = item.url_path;
		var id = window.parent.$('#hiddenVariable').val();
		window.top.$("#" + id).val(url).focus();
		window.parent.$('#flyout_finder').flyout('hide');
	}
}


// Function to rotate an image
function rotate(item, direction) {
	var url = item.url_path; // The URL path of the image
	var basename = item.basename; // The base name of the image file

	// Creating an AJAX request
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "_files/plugins/image_rotate.php", true); // Replace '_files/plugins/image_rotate.php' with the path to your PHP script
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.onreadystatechange = function() {
		if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
			// Here you can process the server's response, e.g., update the image
			//location.reload();
			updateImageSourceIfFilenameFound(basename);
			updateImageSources();
		}
	};
	// Sending the data to the PHP script, including the direction
	xhr.send("url=" + encodeURIComponent(url) + "&direction=" + encodeURIComponent(direction));
}

// Funktion, um zu prüfen, ob die Popup-Klasse vorhanden ist
function isPopupOpen() {
    return document.documentElement.classList.contains('popup-open');
}


// Funktion zum Ändern des src-Attributs von img-Elementen, wenn ein bestimmter Dateiname gefunden wird
function updateImageSourceIfFilenameFound(basename) {
	var encodedBasename = encodeURIComponent(basename); // Kodieren des Basenamens

	// Behandlung der Bilder im 'files-container'
	var container = document.getElementById('files-container');
	var images = container.getElementsByTagName('img');
	for (var i = 0; i < images.length; i++) {
		if (images[i].src.includes(encodedBasename)) {
			var oldSrc = images[i].src.split('&')[0]; // Aufteilen der URL am '&' und Beibehalten des ersten Teils
			var randomValue = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15); // Generieren eines neuen zufälligen Werts
			var sizeParameter = images[i].src.match(/resize=\d+/); // Extrahieren des Größenparameters, falls vorhanden

			var newSrcValue = oldSrc; // Erstellen des neuen src-Werts
			if (sizeParameter) {
				newSrcValue += '&' + sizeParameter[0];
			}
			newSrcValue += '&' + randomValue;

			images[i].src = newSrcValue; // Ändern des src-Attributs des img-Elements
		}
	}

	// Aktualisieren der Bilder mit der Klasse 'pswp__img'
	var pswpImages = document.getElementsByClassName('pswp__img');
	updateImagesSrc(pswpImages, encodedBasename);
	
	if (isPopupOpen()) {
		location.reload();
	}
}




_c.config = {
	// custom context menu (dropdown) options
	contextmenu: {

		rotate_right: {
			text: 'rotate right',
			// icon name, or include custom icon <path d="..."> value from https://pictogrammers.com/library/mdi/
			icon: 'M16.89,15.5L18.31,16.89C19.21,15.73 19.76,14.39 19.93,13H17.91C17.77,13.87 17.43,14.72 16.89,15.5M13,17.9V19.92C14.39,19.75 15.74,19.21 16.9,18.31L15.46,16.87C14.71,17.41 13.87,17.76 13,17.9M19.93,11C19.76,9.61 19.21,8.27 18.31,7.11L16.89,8.53C17.43,9.28 17.77,10.13 17.91,11M15.55,5.55L11,1V4.07C7.06,4.56 4,7.92 4,12C4,16.08 7.05,19.44 11,19.93V17.91C8.16,17.43 6,14.97 6,12C6,9.03 8.16,6.57 11,6.09V10L15.55,5.55Z',
			condition: (item) => item.browser_image,
			// href: (item) => { return item.url_path; },
			action: (item) => rotate(item, 'right'),
			//action: (item) => _h.popup(null, null, null, item.url_path),
			// class: 'mybutton'
		},
		rotate_left: {
			text: 'rotate left',
			icon: 'M13,4.07V1L8.45,5.55L13,10V6.09C15.84,6.57 18,9.03 18,12C18,14.97 15.84,17.43 13,17.91V19.93C16.95,19.44 20,16.08 20,12C20,7.92 16.95,4.56 13,4.07M7.1,18.32C8.26,19.22 9.61,19.76 11,19.93V17.9C10.13,17.75 9.29,17.41 8.54,16.87L7.1,18.32M6.09,13H4.07C4.24,14.39 4.79,15.73 5.69,16.89L7.1,15.47C6.58,14.72 6.23,13.88 6.09,13M7.11,8.53L5.7,7.11C4.8,8.27 4.24,9.61 4.07,11H6.09C6.23,10.13 6.58,9.28 7.11,8.53Z',
			condition: (item) => item.browser_image,
			// href: (item) => { return item.url_path; },
			action: (item) => rotate(item, 'left'),
			// class: 'mybutton'
		},
	},


	// download_dir options
	download_dir: {
		javascript: true, // Use the Javascript downloads API to download zip files
		current_dir_only: true, // Only assign download dir button to current directory
		use_filter: true, // If there is a search filter, only filtered files will be downloaded
	},

	// embed Youtube/Vimeo by linking with .url files
	/*
	[InternetShortcut]
	URL=https://www.youtube.com/watch?v=8jT9ygmMvMg
	*/
	embed: {
		enabled: true, // entirely disable embed, .url files will work like normal clickable links
		youtube: true, // enable Youtube embed
		vimeo: true, // enable Vimeo embed
		preview: true, // load preview images from embed source into layout
		modal: true, // display video in Files modal on click
		params: 'autoplay=1&modestbranding=1', // add optional url parameters to the embedded video
	},

	// favicon
	// Add your own encoded inline favicon or false to disable / SVG https://yoksel.github.io/url-encoder/
	favicon: "<link rel=\"icon\" href=\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%2337474F' d='M20,18H4V8H20M20,6H12L10,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V8C22,6.89 21.1,6 20,6Z' /%3E%3C/svg%3E\" type=\"image/svg+xml\" />",

	// history_scroll / attempts to restore scroll position on browser history navigation
	history_scroll: true,

	// custom language options
	lang: {
		// assign language menu in topbar / true = all / false = no menu (default)
		menu: ['de', 'en', 'es'], // Portuguese, English, Chinese
		// override or create new languages
		langs: {
			de: {
				logout: 'déconnexion',
			},
			no: {
				date: 'dato',
				flag: 'yes',
			},
		},
	},

	// load_svg_max_filesize 100kb / because complex SVG vector files will slow down rendering in browser
	load_svg_max_filesize: 100000,

	// panorama options
	panorama: {
		// function to detect panorama equirectangular source file
		is_pano: (item) => {
			var d = item.dimensions;
			// >=2048px && ratio 2:1 with 1% pixel margin
			return d[0] >= 2048 && Math.abs(d[0] / d[1] - 2) < 0.01;
		},
	},

	// popup options
	popup: {
		captionEl: true, // show popup caption
		caption_hide: true, // Auto-hide popup caption on mouse inactivity
		caption_style: 'block', // caption style: block, box, subtitles, gradient, topbar, none
		caption_align: 'center-left', // caption align: left, center-left, center, right
		click: 'prev_next', // popup click: prev_next, next, zoom
		zoomEl: false, // show zoom button
		playEl: false, // show slideshow play button
		transition: 'glide', // slideshow transition: none, slide, glide, fade, zoom, pop, elastic
		play_transition: null, // assign transition for slideshow (same as above). Inherits main transition by default
		bgOpacity: .95, // background opacity
		play_interval: 5000, // slideshow play interval
		loop: true, // loop slideshow
		video_autoplay_clicked: true, // autoplay videos when clicked from layout
		video_autoplay: false, // autoplay all videos
		transitions: { // custom transitions Object
			mytransition: function(dir) {
				return {
					translateX: [10 * dir, 0],
					opacity: [.1, 1],
					duration: 1000,
					easing: 'easeOutQuart'
				}
			},
		},
	},

	// theme config
	theme: {
		themes: ['contrast', 'light', 'dark'], // array of available themes for button switch
		default: 'contrast', // default theme when no theme is previously selected
		button: true, // allow button to switch themes
		auto: true, // allow prefers-color-scheme:dark
	},

	// custom page <title> function / below is default
	title: (path, name, error, count) => {
		return (name || '/') + (error ? '' : ' [' + count + ']');
	},

	// uppy uploader interface options
	uppy: {
		note: 'Upload images only, maximum %upload_max_filesize%',
		locale: '', // https://github.com/transloadit/uppy/tree/main/packages/%40uppy/locales/src
		DropTarget: false,
		Webcam: false, // https://uppy.io/docs/webcam/
		ImageEditor: { // https://uppy.io/docs/image-editor/
			quality: 0.8,
			cropperOptions: {},
			actions: {},
		},
		// https://uppy.io/docs/compressor/
		Compressor: {

			// options specific to watermarking images on upload
			watermark: {
				text: '©Alibaba Photo', // overlay text here, if you don't want to assign per-upload
				position: 'bottom-right', // default overlay alignment
				interface: false, // disable overlay options from uploader, in which case options from here will always apply
				scale: .33, // scale the overlay relative to the image width in fraction of 1 / .33 = 33%
				margin: .03, // overlay margin from the image edges when using all positions except 'center' in fraction of 1 / .03 = 3%
				font: '10px Futura', // assign a font, which must be available on the device that renders the overlay
				fillStyle: 'white', // text fill color / only applies for text
				shadowColor: 'rgba(0,0,0,.25)', // shadow color
				shadowBlur: 10, // shadow blur
				globalAlpha: .5, // overlay alpha transparency value
				image_src: './path/image.png', // assign an image src from a different location
				font_src: 'https://fonts.bunny.net/righteous/files/righteous-latin-400-normal.woff2', // assign a font source from a web url
			},
		},
	},
}


// Bedingung für das Hinzufügen des 'link'-Teils
if (window.parent.document.querySelector('#hiddenVariable')) {
	_c.config.contextmenu.link = {
		text: 'Verlinken',
		icon: 'link',
		action: (item) => sendUrl(item)
	};
}

// Funktion, um alle Eigenschaften des 'item'-Objekts anzuzeigen
function showItemProperties(item) {
	// Erstelle einen leeren String, um die Eigenschaften zu sammeln
	let properties = '';

	// Durchlaufe alle Eigenschaften des Objekts
	for (let key in item) {
		if (item.hasOwnProperty(key)) {
			// Füge jede Eigenschaft und ihren Wert zum String hinzu
			properties += key + ': ' + item[key] + '\n';
		}
	}
	alert(properties);
}
