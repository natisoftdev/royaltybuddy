<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$result = "";

	$idUtente = $_SESSION['idUtente'];

	$nomeScaletta = trim(ucwords(strtolower($_POST['iNomeScaletta'])));
			
	$arrayBraniKey = array();
	$arrayBrani = array();
	
	$b = "brano_";
	////jhp_log("POST: ".$_POST);
	foreach($_POST as $key=>$val) {
		$subKey = substr($key,0,6);
		//$subKey = substr($key,0,count($key)+1);
		////jhp_log("Confronto: ".$key." con ".$subKey);
		////jhp_log($subKey == $b);
		if($subKey == $b && $val == 1){
			$arrayBraniKey[] = $key;
			$arrayBrani[] = substr($key,6,count($key)+2);
			////jhp_log("true");
			////jhp_log($key." => ".$val);
		}
	}
	
	//jhp_log($arrayBrani);
	
	//Insert 
	$query = <<< query
		INSERT INTO 	scalette(nomeScaletta, dataInserimento, dataUltimaModifica, validate, idUtente)
		VALUES     		('$nomeScaletta', GETDATE(),GETDATE(),1,$idUtente)
query;

	ntxQuery($query);

	$query2 = <<< query
			SELECT     	MAX(idScaletta) AS maxIdScaletta
			FROM        scalette
query;

	$sql = ntxQuery($query2);

	while($rs=ntxRecord($sql))
	{
		foreach($rs as $k=>$v)
		$html[$k] = htmlentities($v);
	}
	
	
	for($k=0;$k<count($arrayBrani);$k++){
		$idB = (int)$arrayBrani[$k];
		$idS = (int)$html['maxIdScaletta'];
		//jhp_log($idB);
		$queryBrani = <<< brani
				INSERT INTO scalettaToListaBrani
							(idScaletta, idListaBrani,validate,idUtente)
				VALUES     	($idS,$idB,1,$idUtente)
brani;

	ntxQuery($queryBrani);
	}
	
	$_SESSION['idSelect'] = $html['maxIdScaletta'];
	$result = "dettagliScaletta.php";
	jhp(&$result);

?>