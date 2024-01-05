function aggiungiProgramma(obj){
  	var objAddProgrammi = jhp_frm(obj);

	var flag = [];
  	flag['idEvento'] = true;
  	flag['idScaletta'] = true;
  	//flag['idUtente'] = true;

    var evento = objAddProgrammi['iEvento'];
    var scaletta = objAddProgrammi['iScaletta'];
    //var utente = objAddProgrammi['idUtente'];

    //controllo Evento
    if(evento == ""){
      flag['idEvento'] = false;
      alert(messaggi.campoEventoVuoto);
    }
    else {
      flag['idEvento'] = true;
    }

    //controllo Scaletta
    if(scaletta == ""){
      flag['idScaletta'] = false;
      alert(messaggi.campoScalettaVuoto);
    }
    else {
      flag['idScaletta'] = true;
    }

    if(	flag['idEvento'] == true && flag['idScaletta'] == true )
  	{
  		//Salvo i dati nel db
  		var result = jhp("jhp/jhp_aggiungiProgramma.php",objAddProgrammi);
		var pageA = result.value;
		if(result.state){
			alert(result.message);
		}
		else{
			//richiamo home
			window.location.href = pageA;
		}
  	}
}

/*
	MODIFICA PROGRAMMA
*/
function modProgramma(obj){
  var objModProgrammi = jhp_frm(obj);

  var flag = [];
  flag['idEvento'] = true;
  flag['idScaletta'] = true;
  //flag['idUtente'] = true;

  var evento = objModProgrammi['iEvento'];
  var scaletta = objModProgrammi['iScaletta'];
  //var utente = objModProgrammi['idUtente'];

  //controllo Evento
  if(evento == ""){
    flag['idEvento'] = false;
    alert(messaggi.campoEventoVuoto);
  }
  else {
    flag['idEvento'] = true;
  }

  //controllo Scaletta
  if(scaletta == ""){
    flag['idScaletta'] = false;
    alert(messaggi.campoScalettaVuoto);
  }
  else {
    flag['idScaletta'] = true;
  }

  if(	flag['idEvento'] == true && flag['idScaletta'] == true )
  {
    //Salvo i dati nel db
    var result = jhp("jhp/jhp_modProgramma.php",objModProgrammi);
		var pageM = result.value;
		if(result.state){
			alert(result.message);
		}
		else{
			//richiamo home
			window.location.href = pageM;
		}
  }
}

function eliminaProgramma(){
	//porto stato di validate a 0
	var result = jhp("jhp/jhp_eliminaProgramma.php");
	var pageE = result.value;
	if(result.state){
		alert(result.message);
	}
	else{
		//richiamo home
		window.location.href = pageE;
	}
}

