<?php
	if ( !$_SESSION ) session_start();
	
	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$_SESSION[NTX_LINGUA_DEST] = $_POST[lingua];
	$idUtente = $_SESSION[idUtente];
	
	$query = <<< query
		UPDATE    	utenti
		SET			lingua ='$_POST[lingua]', 
					dataUltimaModifica = GETDATE()
		WHERE 		idUtente = $idUtente
query;

	ntxQuery($query);

	$result = "impostazioni.php";
	jhp(&$result);
?>