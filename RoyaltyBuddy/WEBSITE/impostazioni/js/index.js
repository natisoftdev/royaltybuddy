function cambiaLingua(lingua){
	//alert(lingua.value);
	var result = jhp("jhp/jhp_cambia_lingua.php", { lingua : lingua.value } );	
	var page = result.value;
	if(result.state){
		alert(result.message);
	}
	else{
		//richiamo home
		window.location.href = page;
	}
}