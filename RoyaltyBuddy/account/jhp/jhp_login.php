<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$result = "";
	$email = $_POST['email'];
	$password = $_POST['password'];

	$query = <<< query
				SELECT idUtente, nome, cognome, compositore, esecutore, casaEditrice, lingua
				FROM utenti
				WHERE password = dbo.criptaInMd5('$password')
				AND email = '$email'
				AND validate = 1
query;

	$sql = ntxQuery($query);

	while($rs=ntxRecord($sql))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}

	if($rs == "" || $rs == 'null'){
		$result = "errore";
	}
		
	$idUtente = $html['idUtente'];
	$compositore = $html['compositore'];
	$esecutore = $html['esecutore'];
	$casaEditrice = $html['casaEditrice'];
	$lingua = $html['lingua'];
	$ritorno = array();

	if($compositore == 1 && $esecutore == 0 && $casaEditrice == 0) {
		//apro home compositore
		$ritorno[home] = "homeCompositore.php";
		$_SESSION['home'] = "homeCompositore.php";
		//$_SESSION['tipPro'] = "compositore";
	}
	elseif($compositore == 0 && $esecutore == 1 && $casaEditrice == 0) {
		//apro home esecutore
		$ritorno[home] = "homeEsecutore.php";
		$_SESSION['home'] = "homeEsecutore.php";
		//$_SESSION['tipPro'] = "esecutore";
	}
	elseif($compositore == 1 && $esecutore == 1 && $casaEditrice == 0) {
		//apro home comp_esec
		$ritorno[home] = "homeCompEsec.php";
		$_SESSION['home'] = "homeCompEsec.php";
		//$_SESSION['tipPro'] = "comp_esec";
	}
	else{
		$ritorno[home] = "errore";
	}

	$_SESSION['idUtente'] = $idUtente;
	$_SESSION[NTX_LINGUA_DEST] = $lingua;
	$ritorno[idUtente] = $idUtente;
	jhp(&$ritorno);
?>