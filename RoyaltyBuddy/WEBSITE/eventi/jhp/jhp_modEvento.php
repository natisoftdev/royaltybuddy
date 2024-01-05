<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$idEvento = $_SESSION['idSelect'];

	$nomeEvento = trim(ucwords(strtolower($_POST['iEvento'])));
	//jhp_log("POST['iDataEvento'] = ".$_POST['iDataEvento']);
	//jhp_log("gettype = ".gettype($_POST['iDataEvento']));
	$dataEvento = $_POST['iDataEvento'];
	//jhp_log("dataEvento = ".$dataEvento);
	//jhp_log("gettype = ".gettype($dataEvento));
	$arrayDN = explode("-",$dataEvento);
	//jhp_log("arrayDN");
	//jhp_log($arrayDN);
	$dataEvento = $arrayDN[2]."/".$arrayDN[1]."/".$arrayDN[0];
	$dataEvento = ntxt($dataEvento);
	//jhp_log("dataEvento = ".$dataEvento);
	$oraEvento = $_POST['iOra'];
	$nomeLuogo = trim(ucwords(strtolower($_POST['iNomeLuogo'])));
	$tipoLuogo = trim(ucfirst($_POST['iTipoLuogo']));
	$indirizzo = trim(ucwords(strtolower($_POST['iIndirizzo'])));
	$stato = $_POST['iStato'];
	$citta = $_POST['iCitta'];

	$setOra = explode(":",$oraEvento);
	$oraEvento = ($setOra[0]*3600)+($setOra[1]*60);
	
	//Controllo validità campi

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
			UPDATE    	eventi
			SET     	nomeEvento = '$nomeEvento', 
						dataEvento = $dataEvento, 
						oraEvento = '$oraEvento',
						nomeLuogo = '$nomeLuogo', 
						tipoLuogo = '$tipoLuogo', 
						indirizzo = '$indirizzo', 
						citta = $citta, 
						stato = '$stato', 
						dataUltimaModifica = GETDATE()
			WHERE idEvento = $idEvento
			AND validate = 1
query;

	ntxQuery($query);

	$result = "dettagliEvento.php";
	jhp(&$result);

?>