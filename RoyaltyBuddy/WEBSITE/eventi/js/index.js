/*
	GESTIONE EVENTI
*/
//Metodo aggiungiEvento
function aggiungiEvento(obj){
	var objAddEvento = jhp_frm(obj);
	
	var flag = [];
	flag['nomeEvento'] = true;
	flag['dataEvento'] = true;
	flag['nomeLuogo'] = true;
	flag['tipoLuogo'] = true;
	flag['indirizzo'] = true;
	flag['citta'] = true;
	flag['stato'] = true;

	var nomeEvento = objAddEvento['iEvento'];
	var dataEvento = objAddEvento['iDataEvento'];
	var oraEvento = objAddEvento['iOra'];
	var splitAP = oraEvento.split(":");
	objAddEvento['iOra'] = (splitAP[0]*3600)+(splitAP[1]*60);
	var nomeLuogo = objAddEvento['iNomeLuogo'];
	var tipoLuogo = objAddEvento['iTipoLuogo'];
	var indirizzo = objAddEvento['iIndirizzo'];
	var citta = objAddEvento['iCitta'];
	var stato = objAddEvento['iStato'];

	//controllo nomeEvento
	if (nomeEvento == "") {
		flag['nomeEvento'] = false;
		alert(messaggi.campoEventoVuoto);
	}
	else{
		flag['nomeEvento'] = true;
	}
	
	//controllo dataEvento ---> CONTROLLO DA FARE
	if (dataEvento != dataEvento) {
		flag['dataEvento'] = false;
		alert(messaggi.campoDataVuoto);
	}
	else{
		flag['dataEvento'] = true;
	}
	
	//controllo nomeLuogo
	if (nomeLuogo == "") {
		flag['nomeLuogo'] = false;
		alert(messaggi.campoLuogoVuoto);
	}
	else{
		flag['nomeLuogo'] = true;
	}
	
	//controllo tipoLuogo
	if (tipoLuogo == "") {
		flag['tipoLuogo'] = false;
		alert(messaggi.campoTLuogoVuoto);
	}
	else{
		flag['tipoLuogo'] = true;
	}
	
	//controllo indirizzo
	if (indirizzo == "") {
		flag['indirizzo'] = false;
		alert(messaggi.campoIndirizzoVuoto);
	}
	else{
		flag['indirizzo'] = true;
	}
	
	//controllo citta 
	if (citta == "") {
		flag['citta'] = false;
		alert(messaggi.campoCittaVuoto);
	}
	else{
		flag['citta'] = true;
	}
	
	//controllo stato
	if (stato == "") {
		flag['stato'] = false;
		alert(messaggi.campoStatoVuoto);
	}
	else{
		flag['stato'] = true;
	}
	
	if(	flag['nomeEvento'] == true && flag['dataEvento'] == true && 
		flag['nomeLuogo'] == true && flag['tipoLuogo'] == true && 
		flag['indirizzo'] == true && flag['citta'] == true &&
		flag['stato'] == true )
	{
		//Salvo i dati nel db
		var result = jhp("jhp/jhp_aggiungiEvento.php",objAddEvento);
		var page = result.value;
		if(result.state){
			alert(result.message);
		}
		else{
			//richiamo home
			window.location.href = page;
		}
	}	
}

//Metodo modificaEvento
function modificaEvento(obj){
	var objAddEvento = jhp_frm(obj);
	
	var flag = [];
	flag['nomeEvento'] = true;
	flag['dataEvento'] = true;
	flag['nomeLuogo'] = true;
	flag['tipoLuogo'] = true;
	flag['indirizzo'] = true;
	flag['citta'] = true;
	flag['stato'] = true;

	var nomeEvento = objAddEvento['iEvento'];
	var dataEvento = objAddEvento['iDataEvento'];
	var nomeLuogo = objAddEvento['iNomeLuogo'];
	var tipoLuogo = objAddEvento['iTipoLuogo'];
	var indirizzo = objAddEvento['iIndirizzo'];
	var citta = objAddEvento['iCitta'];
	var stato = objAddEvento['iStato'];

	//controllo nomeEvento
	if (nomeEvento == "") {
		flag['nomeEvento'] = false;
		alert(messaggi.campoEventoVuoto);
	}
	else{
		flag['nomeEvento'] = true;
	}
	
	//controllo dataEvento ---> CONTROLLO DA FARE
	if (dataEvento != dataEvento) {
		flag['dataEvento'] = false;
		alert(messaggi.campoDataVuoto);
	}
	else{
		flag['dataEvento'] = true;
	}
	
	//controllo nomeLuogo
	if (nomeLuogo == "") {
		flag['nomeLuogo'] = false;
		alert(messaggi.campoLuogoVuoto);
	}
	else{
		flag['nomeLuogo'] = true;
	}
	
	//controllo tipoLuogo
	if (tipoLuogo == "") {
		flag['tipoLuogo'] = false;
		alert(messaggi.campoTLuogoVuoto);
	}
	else{
		flag['tipoLuogo'] = true;
	}
	
	//controllo indirizzo
	if (indirizzo == "") {
		flag['indirizzo'] = false;
		alert(messaggi.campoIndirizzoVuoto);
	}
	else{
		flag['indirizzo'] = true;
	}
	
	//controllo citta 
	if (citta == "") {
		flag['citta'] = false;
		alert(messaggi.campoCittaVuoto);
	}
	else{
		flag['citta'] = true;
	}
	
	//controllo stato
	if (stato == "") {
		flag['stato'] = false;
		alert(messaggi.campoStatoVuoto);
	}
	else{
		flag['stato'] = true;
	}
	
	if(	flag['nomeEvento'] == true && flag['dataEvento'] == true && 
		flag['nomeLuogo'] == true && flag['tipoLuogo'] == true && 
		flag['indirizzo'] == true && flag['citta'] == true &&
		flag['stato'] == true )
	{
		//Salvo i dati nel db
		var result = jhp("jhp/jhp_modEvento.php",objAddEvento);
		var page = result.value;
		if(result.state){
			alert(result.message);
		}
		else{
			//richiamo home
			window.location.href = page;
		}
	}	
}

function eliminaAccount(){
	//porto stato di validate a 0
	var result = jhp("jhp/jhp_eliminaEvento.php");
	var page = result.value;
		if(result.state){
			alert(result.message);
		}
		else{
			//richiamo home
			window.location.href = page;
		}
}
