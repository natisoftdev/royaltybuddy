// Variabili di appoggio
var tipPro;
var genMus;
var stato;
var paginaHtml;
var myArray;

$(document).ready(function() {
	//$('#iCitta').prop("disabled",true);
	
	$('#iTipPro').on('change',function(){ 
		//ottengo valore selezionato
		tipPro = $(this).val();
	});
	
	$('#iGenMus').on('change',function(){ 
		//ottengo valore selezionato
		genMus = $(this).val();
		});
	
	$('#iStato').on('change',function(){ 
		//ottengo valore selezionato
		stato = $(this).val();
		//rendo visibile il select per città
		//$('#iCitta').prop("disabled",false);
	});
});

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
	Accedere all'applicazione 
	Parametri d'ingresso: email e password
*/
function login(obj) {
	
	logout();
	
	var email = obj.iemail.value;
	var password = obj.ipassword.value;
	//alert(email);
	//alert(password);
	
	if((email == null || email == "") && (password == null || password == "")) {
		alert("Attenzione! Campi email e password vuoti!");
		document.formLogin.submit();
	}
	else if(email == null || email == "") {
		alert("Attenzione! Campo email vuoto!");
		document.formLogin.submit();
	}
	else if ((email.includes("@") && email.includes(".")) == false) {
		alert("Attenzione! Campo email non corretto!");
		document.formLogin.submit();
	}
	else if(password == null || password == "") {
		alert("Attenzione! Campo password vuoto!");
		document.formLogin.submit();
	}
	else {
		var result = jhp("jhp/jhp_login.php", { email : email, password : password });
	
		if(result.state){
			alert(result.message);
		}
		else if(result.value['home'] == "errore"){
			//alert("Attenzione!! Non sei iscritto a RoyaltyBuddy");
			alert("Attenzione!! A queste credenziali non corrisponde nessun account");
			document.formLogin.submit();
		}
		else{
			//richiamo home
			paginaHtml = "home/"+result.value['home'];
			//alert(paginaHtml);
			window.location.href = paginaHtml;
		}
	}	
}

/*
	Mette il primo char in maiuscolo
*/
function jsUcFirst(string) {
    //separo parole nella stringa
	string = string.split(" ");
	var result = "";
	//ciclo per count(string)
	for (i = 0; i < string.length; i++) {
		var firstChar = string[i][0].toUpperCase();
		string[i] = string[i].replace(string[i][0],firstChar);
		result += string[i]+" ";
	}
	result = result.substring(0, result.length - 1);
	return result;
}

/*
	Refresh di $_SESSION
	(FINIRE DA SVILUPPARE)
*/
function refreshSESSION(){
	var result = jhp("jhp/jhp_refresh.php");
	
	if(result.state){
		alert(result.message);
	}
	else{
		//check
		//alert("Pulizia effettuata");
	}
}

/*
	Apre la pagina e viene salvato il nome della pagina di partenza per eventuale back
*/
function openPage(page, back){
	//porto stato di validate a 0
	var result = jhp("jhp/jhp_openPage.php", { page : page, back : back } );
	//alert(result.value);
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
	Apre l'informazione richiesta nella pagina appropriata e viene salvato il nome della pagina di partenza per eventuale back
*/
function openData(idSelect,page, back){
	//porto stato di validate a 0
	var result = jhp("jhp/jhp_openPage.php", { idSelect : idSelect, page : page, back : back } );
	//alert(result.value);
	var page = result.value;
	if(result.state){
		alert(result.message);
	}
	else{
		//richiamo home
		window.location.href = page;
	}
}


/**
	METODI PER APERTURA E CHIUSURA DEL MESSAGGIO DI HELP
**/
function openHelp(){
	$('#divMessage').show();
	$('#overlay').show();
}

function closeHelp(){
	$('#divMessage').hide();
	$('#overlay').hide();
}


/**
	METODI PER L'APERTURA DELLA HOME
**/

function openHome(valore) {
	window.location.href = valore;
}

function openBack(valore){
	window.location.href = valore;
}
