//Metodo aggiungiAlbum
function aggiungiAlbum(obj){
	var objAddAlbum = jhp_frm(obj);
	
	var flag = [];
	flag['album'] = true;
	flag['anno'] = true;
	flag['idU'] = true;
	
	var nome = objAddAlbum['iAlbum'];
	var annoPubblicazione = objAddAlbum['iAnno'];
	var iCompositore = objAddAlbum['iCompositore'];
	
	//controllo iAlbum
	if (nome == "") {
		flag['album'] = false;
		alert(messaggi.noAlbum);
	}
	else{
		flag['album'] = true;
	}

	//controllo iAnno DA FARE IL CONTROLLO
	if (annoPubblicazione != annoPubblicazione) {
		flag['anno'] = false;
		alert(messaggi.noAnno);
	}
	else{
		flag['anno'] = true;
	}
	
	//controllo iCompositore
	if (iCompositore == "") {
		flag['idU'] = false;
		alert(messaggi.noCompositore);
	}
	else{
		flag['idU'] = true;
	}
	
	//Eseguo l'aggiunta dell'album se tutti e 3 i campi sono true
	if(flag['album'] == true && flag['anno'] == true && flag['idU'] == true ){
		//Salvo i dati nel db
		var result = jhp("jhp/jhp_aggiungiAlbum.php",objAddAlbum);;
		var page = result.value;
		if(result.state){
			alert(result.message);
		}
		else{
			//richiamo home
			window.location.href = page;
		}
	}
	else{
		document.formAddAlbum.submit();
	}
}

/*
	MODIFICA ALBUM
*/
function modAlbum(obj){
	//console.log(obj);
	var objModAlbum = jhp_frm(obj);
	//console.log(objModAlbum['iAlbum']);
	//console.log(objModAlbum['iAnno']);
	//console.log(objModAlbum['idUtente']);
	//console.log('-------------');
	var flag = [];
	flag['album'] = false;
	flag['annoP'] = false;
	flag['idUtente'] = false;

	var album = objModAlbum['iAlbum'];
	var annoP = objModAlbum['iAnno'];
	var idUtente = objModAlbum['idUtente'];

	  //controllo validità campo iAlbum
	  if(album == ""){
		flag['album'] = false;
		alert(messaggi.noAlbum);
		console.log("No ALBUM inserito");
	  }
	  else {
		flag['album'] = true;
	  }  

	  //controllo validità campo annoP
	  if(annoP == ""){
		flag['annoP'] = false;
		alert(messaggi.noAnno);
	  }
	  else {
		flag['annoP'] = true;
	  }

	  //controllo validità campo idUtente
	  if (idUtente == "") {
			flag['idUtente'] = false;
			alert(messaggi.noCompositore);
		}
		else{
			flag['idUtente'] = true;
		}

	  //se tutto ok
	if(flag['album'] == true && flag['annoP'] == true && flag['idUtente'] == true ){
		var result = jhp("jhp/jhp_modAlbum.php",objModAlbum);;
		var page = result.value;
		if(result.state){
			alert(result.message);
		}
		else{
			//richiamo home
			window.location.href = page;
		}
	}
	else{
		document.formModAlbum.submit();
	}
}

function eliminaAlbum(){
	//porto stato di validate a 0
	var result = jhp("jhp/jhp_eliminaAlbum.php");
	var page = result.value;
	if(result.state){
		alert(result.message);
	}
	else{
		//richiamo home
		window.location.href = page;
	}  
}
