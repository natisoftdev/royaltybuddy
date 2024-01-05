<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$idUtente = $_SESSION['idUtente'];
	$idEvento = $_SESSION['idSelect'];

	//Porto programmi.validate = 0 
	$sqlUpdate = <<< sqlUpdate
			UPDATE    programmi
			SET		validate = 0
			FROM	programmi 
			WHERE evento = $idEvento
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	//Porto eventi.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    eventi
			SET		validate = 0
			FROM	eventi 
			WHERE 	idEvento = $idEvento
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	$result = "listaEventi.php";
	jhp(&$result);
	
?>