<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$idUtente = $_SESSION['idUtente'];
	$idBrano = $_SESSION['idSelect'];
	
	//Porto programmi.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    programmi
			SET		validate = 0
			FROM	programmi INNER JOIN
					utenti ON programmi.esecutore = utenti.idUtente
			WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	$result = "listaProgrammi.php";
	jhp(&$result);
	

?>