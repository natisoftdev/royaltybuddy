<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$idUtente = $_SESSION['idUtente'];
	$nome = trim(ucwords(strtolower($_POST['iNome'])));
	$cognome = trim(ucwords(strtolower($_POST['iCognome'])));
	////jhp_log("POST['iDataNascita'] = ".$_POST['iDataNascita']);
	////jhp_log("gettype = ".gettype($_POST['iDataNascita']));
	$dataNascita = trim($_POST['iDataNascita']);
	////jhp_log("dataNascita = ".$dataNascita);
	////jhp_log("gettype = ".gettype($dataNascita));
	$arrayDN = explode("-",$dataNascita);
	////jhp_log("arrayDN");
	////jhp_log($arrayDN);
	$dataNascita = $arrayDN[2]."/".$arrayDN[1]."/".$arrayDN[0];
	$dataNascita = ntxt($dataNascita);
	////jhp_log("dataNascita = ".$dataNascita);
	$pseudonimo = trim($_POST['iPseudonimo']);
	$email = trim(strtolower($_POST['iEmail']));
	$biografia = trim(ucfirst($_POST['iBiografia']));
	$stato = trim($_POST['iStato']);
	$citta = trim($_POST['iCitta']);
	$tipProfilo = trim($_POST['iTipPro']);
	$codiceFiscale = trim(strtoupper($_POST['iCF']));
	$partitaIVA = trim($_POST['iPIVA']);
	$genereMusicale = trim($_POST['iGenMus']);
	$strumentoMusicale = trim(ucfirst($_POST['iStruMus']));

	$compositore = 0;
	$esecutore = 0;
	$casaEditrice = 0;

	if($tipProfilo == "compositore")
		$compositore = 1;
	else if($tipProfilo == "esecutore")
		$esecutore = 1;
	else {
		$compositore = 1;
		$esecutore = 1;
	}

	//Insert 
	$query = <<< query
		UPDATE    	utenti
		SET			nome = '$nome', 
					cognome = '$cognome', 
					dataNascita = $dataNascita, 
					pseudonimo = '$pseudonimo', 
					email = '$email', 
					biografia = '$biografia', 
					citta = $citta, 
					stato = '$stato', 
					compositore = '$compositore', 
					esecutore = '$esecutore', 
					casaEditrice = '$casaEditrice', 
					codiceFiscale = '$codiceFiscale', 
					partitaIVA = '$partitaIVA', 
					genereMusicale = '$genereMusicale', 
					strumentoMusicale = '$strumentoMusicale', 
					validate = 1, 
					dataUltimaModifica = GETDATE()
		WHERE		idUtente = '$idUtente'
query;

	ntxQuery($query);
	$result = "";
	$result = "account.php";
	jhp(&$result);
?>