//Metodo aggiungiAlbum
/*function aggiungiAllegato(obj){
	var objAddAllegato = jhp_frm(obj);

	var flag = [];
	//flag['nome'] = true;
	//flag['desc'] = true;
	flag['srcImg'] = true;

	//var nome = objAddAllegato['iNomeAllegato'];
	//var desc = objAddAllegato['iDescrizione'];
	var srcImg = objAddAllegato['imgAllegato'];

	//controllo validità campo idUtente
	if (srcImg == "") {
		flag['srcImg'] = false;
		alert("Non è stata scelta l'immagine");
	}
	else{ 
		flag['srcImg'] = true;
	}

	//se tutto ok
	if(flag['srcImg'] == true){
		var result = jhp("jhp/jhp_aggiungiAllegato.php",objAddAllegato);;
		//alert(result.value['home']);
		if(result.state){
			alert(result.message);
		}
		else{
			//richiamo pagina listaAllegati
			//window.location.href = result.value;
		}
	}
}*/

/*
	MODIFICA ALLEGATO
*/
/*function modAllegato(obj){
  var objModAllegato = jhp_frm(obj);

  var flag = [];
  //flag['nome'] = true;
  //flag['desc'] = true;
  flag['srcImg'] = true;

  //var nome = objModAllegato['iNomeAllegato'];
  //var desc = objModAllegato['iDescrizione'];
  var srcImg = objModAllegato['imgAllegato'];

  //controllo validità campo idUtente
  if (srcImg == "") {
		flag['srcImg'] = false;
		alert("Non è stata scelta l'immagine");
	}
	else{
		flag['srcImg'] = true;
	}

  //se tutto ok
  if(flag['srcImg'] == true){
		var result = jhp("jhp/jhp_modAllegato.php",objModAllegato);;
		//alert(result.value['home']);
		if(result.state){
			alert(result.message);
		}
		else{
			//richiamo pagina listaAllegati
			window.location.href = result.value;
		}
	}
}*/

function displayPreviewImage(file, containerid) {
	if (typeof FileReader !== "undefined") {
		var container = document.getElementById(containerid),
			img = document.createElement("img"),
			reader;
		container.appendChild(img);
		reader = new FileReader();
		reader.onload = (function (theImg) {
			return function (evt) {
				theImg.src = evt.target.result;
			};
		}(img));
		reader.readAsDataURL(file);
	}
}

function eliminaAllegato(){
	//porto stato di validate a 0
	var result = jhp("jhp/jhp_eliminaAllegato.php");
	var page = result.value;
	if(result.state){
		alert(result.message);
	}
	else{
		//richiamo home
		window.location.href = page;
	}
}

function errorHandler(evt) {
	switch(evt.target.error.code) {
	case evt.target.error.NOT_FOUND_ERR:
		alert(messaggi.noFile);
		break;
	case evt.target.error.NOT_READABLE_ERR:
		alert(messaggi.noLeggibile);
		break;
	case evt.target.error.ABORT_ERR:
		break; // noop
	default:
		alert(messaggi.erroreLettura);
	};
}

function updateProgress(evt) {
	// evt is an ProgressEvent.
	if (evt.lengthComputable) {
		var percentLoaded = Math.round((evt.loaded / evt.total) * 100);
		// Increase the progress bar length.
		if (percentLoaded < 100) {
			progress.style.width = percentLoaded + '%';
			progress.textContent = percentLoaded + '%';
		}
	}
}

function handleFileSelect2(evt) {
	// Reset progress indicator on new file selection.
	progress.style.width = '0%';
	progress.textContent = '0%';

	reader = new FileReader();
	reader.onerror = errorHandler;
	reader.onprogress = updateProgress;
	reader.onabort = function(e) {
		alert(messaggi.cancellaLettura);
	};
	reader.onloadstart = function(e) {
		document.getElementById('progress_bar').className = 'loading';
	};
	reader.onload = function(e) {
		// Ensure that the progress bar displays 100% at the end.
		progress.style.width = '100%';
		progress.textContent = '100%';
		setTimeout("document.getElementById('progress_bar').className='';", 2000);
	}
	// Read in the image file as a binary string.
	reader.readAsBinaryString(evt.target.files[0]);
}