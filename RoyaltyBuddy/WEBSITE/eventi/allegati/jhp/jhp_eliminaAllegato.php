<?php
	if ( !$_SESSION ) session_start();

	require_once("../../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$idUtente = $_SESSION['idUtente'];
	$idAllegato = $_SESSION['idSelect'];

	$eventoQuery = "SELECT evento from allegati_evento WHERE idAllegatiEvento = $idAllegato AND validate = 1";
	$idEvento = ntxScalar($eventoQuery);	
	
	$_SESSION['idSelect'] = $idEvento;
	
	//Porto allegati_evento.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    allegati_evento
			SET		validate = 0
			FROM	allegati_evento 
			WHERE 	idAllegatiEvento = $idAllegato
sqlUpdate;

	ntxQuery($sqlUpdate);
	$result = "listaAllegati.php";
	jhp(&$result);
?>