<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$result = "";

	$nome = trim(ucwords(strtolower($_POST['iNome'])));
	$cognome = trim(ucwords(strtolower($_POST['iCognome'])));
	
	
	$dataNascita = trim($_POST['iDataNascita']);
	$arrayDN = explode("-",$dataNascita);
	$dataNascita = $arrayDN[2]."/".$arrayDN[1]."/".$arrayDN[0];
	$dataNascita = ntxt($dataNascita);
	
	$pseudonimo = trim($_POST['iPseudonimo']);
	$email = trim(strtolower($_POST['iEmailReg']));
	$password = trim($_POST['iPassword']);
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

	$sqlL = "	SELECT	lingua	FROM	Lingue";
	$query2 = ntxQuery($sqlL);

	while($rs=ntxRecord($query2))
	{
		foreach($rs as $k=>$v)
			$arrayLingue[] = htmlentities($v);
		
	}
	
	//se stato è in_array lingua = stato se no = "EN"
	if(in_array($stato,$arrayLingue)){
		$lingua = $stato;
	}
	else{
		$lingua = "EN";
	}

	//Insert 
	$query = <<< query
		INSERT INTO utenti
			(	
				nome,cognome,dataNascita,
				pseudonimo,email,password,biografia,
				citta,stato,compositore,esecutore,
				casaEditrice,codiceFiscale,partitaIVA,genereMusicale,
				strumentoMusicale,validate,dataInserimento,dataUltimaModifica,lingua
			)
		VALUES  
			(	
				'$nome','$cognome',$dataNascita,
				'$pseudonimo','$email',dbo.criptaInMd5('$password'),'$biografia',
				'$citta','$stato','$compositore','$esecutore',
				'$casaEditrice','$codiceFiscale','$partitaIVA','$genereMusicale',
				'$strumentoMusicale',1,GETDATE(),GETDATE(),'$lingua'
			)
query;

	////jhp_log($query);
	ntxQuery($query);

	$queryId = <<< query
		SELECT idUtente, lingua
		FROM utenti
		WHERE password = dbo.criptaInMd5('$password')
			AND email = '$email'
			AND validate = 1
query;

	$sql = ntxQuery($queryId);

	while($rs=ntxRecord($sql))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}
	
	//Carico in $_SESSION idUtente
	$_SESSION['idUtente'] = $html[idUtente];
	$_SESSION[NTX_LINGUA_DEST] = $html[lingua];


	if($compositore == 1 && $esecutore == 0 && $casaEditrice == 0) {
		$result[home] = "homeCompositore.php";
		$_SESSION['home'] = "homeCompositore.php";
		
		//Creo un album chiamato 'Singolo' per Compositore
		$sqlAlbum = "INSERT INTO album
						(nomeAlbum, idUtente, dataInserimento, dataUltimaModifica, validate)
				VALUES     
						('Singolo_$html[idUtente]',$html[idUtente],GETDATE(),GETDATE(),1)";
		ntxQuery($sqlAlbum);				
	}
	elseif($compositore == 0 && $esecutore == 1 && $casaEditrice == 0) {
		$result[home] = "homeEsecutore.php";
		$_SESSION['home'] = "homeEsecutore.php";
	
	}
	elseif($compositore == 1 && $esecutore == 1 && $casaEditrice == 0) {
		$result[home] = "homeCompEsec.php";
		$_SESSION['home'] = "homeCompEsec.php";
		
		//Creo un album chiamato 'Singolo' per Comp_Esec
		$sqlAlbum = "INSERT INTO album
						(nomeAlbum, idUtente, dataInserimento, dataUltimaModifica, validate)
				VALUES     
						('Singolo_$html[idUtente]',$html[idUtente],GETDATE(),GETDATE(),1)";
		ntxQuery($sqlAlbum);
	}
	//jhp_ok();
	jhp(&$result);
?>