<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$idUtente = $_SESSION['idUtente'];
	$idScaletta = $_SESSION['idSelect'];

	//Porto programmi.validate = 0 
	$sqlUpdate = <<< sqlUpdate
			UPDATE    programmi
			SET		validate = 0
			FROM	programmi 
			WHERE scaletta = $idScaletta
sqlUpdate;

	ntxQuery($sqlUpdate);

	//Porto scalettatolistabrani.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    scalettatolistabrani
			SET		validate = 0
			FROM 	scalettatolistabrani 
			WHERE 	idScaletta = $idScaletta
sqlUpdate;

	ntxQuery($sqlUpdate);
		
	//Porto scalette.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    scalette
			SET       validate = 0
			WHERE idScaletta = $idScaletta
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	$result = "listaScalette.php";
	jhp(&$result);
	
?>