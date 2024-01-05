function changeStatusCheckboxradio(myArray){
	var arr = myArray;
	for (i = 0; i < arr.length; i++) { 
		$( "#brano_"+arr[i] ).prop( "checked", true ).checkboxradio( "refresh" );
	}
}

/*
	GESTIONE SCALETTE
*/
//Metodo aggiungiScaletta
function aggiungiScaletta(obj){
	var objAddScaletta = jhp_frm(obj);
	
	var flag = [];
	flag['nomeScaletta'] = true;
	
	var nomeScaletta = objAddScaletta['iNomeScaletta'];
	
	//controllo nomeScaletta
	if (nomeScaletta == "") {
		flag['nomeScaletta'] = false;
		alert(messaggi.campoScalettaVuoto);
	}
	else{
		flag['nomeScaletta'] = true;
	}
	
	//controllo arrayBrani
	for (var k in objAddScaletta){
		if (k.includes("brano_")) {
			
			if(objAddScaletta[k] == 1){
				flag['arrayBrani'] = true;
				console.log(flag['arrayBrani']);
				break;
			}
			else{
				flag['arrayBrani'] = false;
				console.log(flag['arrayBrani']);
			}
			
		}
	}
	
	if(flag['arrayBrani'] == false){
		alert(messaggi.campoInserireBrano);
	}
	
	if(	flag['nomeScaletta'] == true && flag['arrayBrani'] == true)
	{
		//Salvo i dati nel db
		var result = jhp("jhp/jhp_aggiungiScaletta.php",objAddScaletta);
		var pageA = result.value;
		if(result.state){
			alert(result.message);
		}
		else{
			window.location.href = pageA;
		}
	}
}

//Metodo modScaletta
function modScaletta(obj){
	var objModScaletta = jhp_frm(obj);//obj è codice html
	console.log(objModScaletta);
	
	var flag = [];
	flag['nomeScaletta'] = false;
	flag['arrayBrani'] = false;
	
	var nomeScaletta = objModScaletta['iNomeScaletta'];
	
	//controllo nomeScaletta
	if (nomeScaletta == "") {
		flag['nomeScaletta'] = false;
		alert(messaggi.campoScalettaVuoto);
	}
	else{
		flag['nomeScaletta'] = true;
	}
	
	//controllo arrayBrani
	for (var k in objModScaletta){
		if (k.includes("brano_")) {
			
			if(objModScaletta[k] == 1){
				flag['arrayBrani'] = true;
				console.log(flag['arrayBrani']);
				break;
			}
			else{
				flag['arrayBrani'] = false;
				console.log(flag['arrayBrani']);
			}
			
		}
	}
	
	if(flag['arrayBrani'] == false){
		alert(messaggi.campoInserireBrano);
		window.location.href = "modificaScaletta.php";
	}
	
	if(	flag['nomeScaletta'] == true && flag['arrayBrani'] == true)
	{
		//Salvo i dati nel db
		var result = jhp("jhp/jhp_modScaletta.php",objModScaletta);

		if(result.state){
			alert(result.message);
		}
		else{
			window.location.href = result.value;
		}
	}
	
}

function eliminaScaletta(){
	//porto stato di validate a 0
	var result = jhp("jhp/jhp_eliminaScaletta.php");
	
	if(result.state){
		alert(result.message);
	}
	else{
		//richiamo lista scalette aggiornata
		window.location.href = result.value;
	}
}