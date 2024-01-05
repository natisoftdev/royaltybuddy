<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$result = "";

	$idUtente = $_SESSION['idUtente'];
	
	$evento = trim(ucwords(strtolower($_POST['iEvento'])));
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
	$tipoLuogo = trim(ucwords(strtolower($_POST['iTipoLuogo'])));
	$indirizzo = trim(ucwords(strtolower($_POST['iIndirizzo'])));
	$citta = $_POST['iCitta'];
	$stato = $_POST['iStato'];

	//Insert 
	$query = <<< query
		INSERT INTO eventi
			(	nomeEvento, dataEvento, oraEvento, nomeLuogo, tipoLuogo, indirizzo, 
				citta, stato, validate, dataInserimento, dataUltimaModifica, idUtente
			)
		VALUES     
			(	'$evento',$dataEvento, '$oraEvento', '$nomeLuogo','$tipoLuogo','$indirizzo',
				'$citta','$stato',1,GETDATE(),GETDATE(), $idUtente
			)
query;

	ntxQuery($query);

	$query2 = <<< query
			SELECT     	MAX(idEvento) AS maxIdEvento
			FROM        eventi
query;

	$sql = ntxQuery($query2);

	while($rs=ntxRecord($sql))
	{
		foreach($rs as $k=>$v)
		$html[$k] = htmlentities($v);
	}

	$_SESSION['idSelect'] = $html['maxIdEvento'];
	$result = "dettagliEvento.php";
	////jhp_log($result);
	jhp(&$result);
?>