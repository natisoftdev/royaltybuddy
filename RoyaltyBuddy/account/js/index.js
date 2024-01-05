/*
	Registrazione di un nuovo utente
	Parametri d'ingresso: form
*/
function registrazione2(obj) {
	var flag = [];
	flag['nome'] = false;
	flag['cognome'] = false;
	flag['dataNascita'] = false;
	flag['email'] = false;
	flag['password'] = false;
	flag['stato'] = false;
	flag['citta'] = false;
	//flag['tipologia'] = false;
	flag['genM'] = false;
	
	var objReg = jhp_frm(obj);
	
	/* CONTROLLO LA VALIDITà DEI CAMPI OBBLIGATORI */
	
	//Controllo NOME
	/*
	if(objReg['iNome'].length != 0){
		objReg['iNome'] = jsUcFirst(objReg['iNome']);
	}*/
	var nome = objReg['iNome'];
	if(nome == ""){
		flag['nome'] = false;
		alert("Attenzione!! Hai dimenticato di inserire il tuo nome");
	}
	else{
		flag['nome'] = true;
	}
	
	//Controllo COGNOME
	/*if(objReg['iCognome'].length != 0){
		objReg['iCognome'] = jsUcFirst(objReg['iCognome']);
	}*/
	var cognome = objReg['iCognome'];
	if(cognome == ""){
		flag['cognome'] = false;
		alert("Attenzione!! Hai dimenticato di inserire il tuo cognome");
	}
	else{
		flag['cognome'] = true;
	}
	
	//Controllo DATA DI NASCITA
	//Controllare anno in confronto a passato futuro o numeri strani
	var dataNascita = objReg['iDataNascita'];
	/*if(dataNascita == ""){
		flag['dataNascita'] = false;
		alert("Attenzione!! Hai dimenticato di inserire la data di nascita");
	}
	else{
		flag['dataNascita'] = true;
	}*/
	
	//Controllo EMAIL
	var email = objReg['iEmailReg'].toLowerCase();
	//Controllo che sia una stringa non vuota
	if(email.length != 0){
		//controllo che abbia '@' e '.'
		if((email.includes("@") && email.includes(".")) == false){
			flag['email'] = false;
			alert("Attenzione! Campo email non corretto!");
		}
		else{
			//controllo che email non sia nel db
			var result = jhp("jhp/jhp_checkEmail.php", { email : email });
			if(result.value == 0){
				flag['email'] = true;
			}
			else{
				flag['email'] = false;
				alert("Attenzione! Esiste già un'account associata a questa email");
			}
		}
	}
	else{
		flag['email'] = false;
		alert("Attenzione! Campo email vuoto!");
	}
	
	//Controllo PASSWORD E RIPETI Password
	var password = objReg['iPassword'];
	var confPassword = objReg['iConfPassword'];
	//Controllo che password == confPassword
	if(password.length != 0 || confPassword.length != 0){
		if(password == confPassword){
			flag['password'] = true;
		}
		else{
			flag['password'] = false;
			alert("Attenzione! Le due passwords non corrispondono");
		}
	}
	else{
		flag['password'] = false;
		alert("Attenzione!! Password e/o Ripeti Password non corretti");
	}
	
	//Controllo Stato
	var stato = objReg['iStato'];
	if(stato == ""){
		flag['stato'] = false;
		alert("Attenzione!! Selezionare stato di appartenenza");
	}
	else{
		flag['stato'] = true;
	}
	
	//Controllo CITTà
	var citta = objReg['iCitta'];
	if(citta == ""){
		flag['citta'] = false;
		alert("Attenzione!! Selezionare citta di appartenenza");
	}
	else{
		flag['citta'] = true;
	}
	
	//Controllo TIPO PROFILO
	//Attualmente è inutile farlo visto che il default è un valore sensato.
	//Se vogliamo visualizzare anche qua il termine 'Scegli' allora andrà costruito il codice
	
	//Controllo GENERE MUSICALE
	var genM = objReg['iGenMus'];
	if(genM == ""){
		flag['genM'] = false;
		alert("Attenzione!! Selezionare un genere musicale");
	}
	else{
		flag['genM'] = true;
	}
	
	//Codice Fiscale
	objReg['iCF'] = objReg['iCF'].toUpperCase();
	//Partita IVA
	objReg['iPIVA'] = objReg['iPIVA'].toUpperCase();
	
	//Esecuzione della registrazione solo se tutti i campi obbligatori hanno restituito il valore true
	if(	flag['nome'] == true && flag['cognome'] == true && 
		flag['email'] == true && flag['password'] == true && 
		flag['stato'] == true && flag['citta'] == true && flag['genM'] == true){
		var result = jhp("jhp/jhp_registrazione.php",objReg);;
		//console.log(result);
		if(result.state){
			alert(result.message);
		}
		else{
			//richiamo specifica home a seconda della tipologia dell'utente
			window.location.href = "../home/"+result.value['home'];
		}
	}
}

/*
	Modifica i dati dell'utente
*/
function modAccount(obj){
	//prendo tutti i valori e aggiorno l'intero record dell'utente
	var objModAccount = jhp_frm(obj);
	
	var flag = [];
	flag['nome'] = false;
	flag['cognome'] = false;
	flag['dataNascita'] = false;
	flag['email'] = false;
	flag['stato'] = false;
	flag['citta'] = false;
	flag['genM'] = false;
	
	/* CONTROLLO LA VALIDITà DEI CAMPI OBBLIGATORI */
	
	//Controllo NOME
	/*
	if(objReg['iNome'].length != 0){
		objReg['iNome'] = jsUcFirst(objReg['iNome']);
	}*/
	var nome = objModAccount['iNome'];
	if(nome == ""){
		flag['nome'] = false;
		alert(messaggi.campoNomeVuoto);
	}
	else{
		flag['nome'] = true;
	}
	
	//Controllo COGNOME
	/*if(objReg['iCognome'].length != 0){
		objReg['iCognome'] = jsUcFirst(objReg['iCognome']);
	}*/
	var cognome = objModAccount['iCognome'];
	if(cognome == ""){
		flag['cognome'] = false;
		alert(messaggi.campoCognomeVuoto);
	}
	else{
		flag['cognome'] = true;
	}
	
	//Controllo DATA DI NASCITA
	//Controllare anno in confronto a passato futuro o numeri strani
	var dataNascita = objModAccount['iDataNascita'];
	/*if(dataNascita == ""){
		flag['dataNascita'] = false;
		alert("Attenzione!! Campo data di nascita vuoto");
	}
	else{
		flag['dataNascita'] = true;
	}*/
	
	//Controllo EMAIL
	var email = objModAccount['iEmail'];
	//Controllo che sia una stringa non vuota
	if(email.length != 0){
		//controllo che abbia '@' e '.'
		if((email.includes("@") && email.includes(".")) == false){
			flag['email'] = false;
			alert(messaggi.campoEmailNoCorretto);
		}
		else{
			//controllo che email non sia nel db
			var result = jhp("jhp/jhp_checkEmail.php", { email : email });
			if(result.value == 0 || result.value == 1){
				flag['email'] = true;
			}
			else{
				flag['email'] = false;
				alert(messaggi.accountEsistente);
			}
		}
	}
	else{
		flag['email'] = false;
		alert(messaggi.campoEmailVuoto);
	}
	
	//Controllo Stato
	var stato = objModAccount['iStato'];
	if(stato == ""){
		flag['stato'] = false;
		alert(messaggi.campoStatoVuoto);
	}
	else{
		flag['stato'] = true;
	}
	
	//Controllo CITTà
	var citta = objModAccount['iCitta'];
	if(citta == ""){
		flag['citta'] = false;
		alert(messaggi.campoCittaVuoto);
	}
	else{
		flag['citta'] = true;
	}
	
	//Genere Musicale
	var genM = objModAccount['iGenMus'];
	if(genM == ""){
		flag['genM'] = false;
		alert(messaggi.campoGenereVuoto);
	}
	else{
		flag['genM'] = true;
	}
	//Codice Fiscale
	objModAccount['iCF'] = objModAccount['iCF'].toUpperCase();
	//Partita IVA
	objModAccount['iPIVA'] = objModAccount['iPIVA'].toUpperCase();

	if(	flag['nome'] == true && flag['cognome'] == true && 
		flag['email'] == true && true && flag['stato'] == true && flag['citta'] == true &&
		flag['genM'] == true){
		var result = jhp("jhp/jhp_modAccount.php",objModAccount);
		var pageA = result.value;
		console.log(pageA);
		if(result.state){
			alert(result.message);
		}
		else{
			//richiamo home
			window.location.href = pageA;
		}
	}
	else{
		document.formModAccount.submit();
	}
}

/*
	Esegue il logout dall'applicazione
*/
function logout(){
	var result = jhp("jhp/jhp_logout.php");
	var page = result.value;
		if(result.state){
			alert(result.message);
		}
		else{
			//richiamo home
			window.location.href = page;
		}
}

/*
	Elimina l'account	(Porta il campo 'validate' = 0)
*/
function eliminaAccount(){
	//porto stato di validate a 0
	var result = jhp("jhp/jhp_eliminaAccount.php");
	
	if(result.state){
		alert(result.message);
	}
	else{
		//eseguo il logout
		logout();
	}
}
