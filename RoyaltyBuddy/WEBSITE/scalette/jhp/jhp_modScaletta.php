<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	////jhp_log($_POST);
	$idUtente = $_SESSION['idUtente'];
	//id
	$idScaletta = $_SESSION['idSelect'];
	//nome scaletta
	$nomeScaletta = trim(ucwords(strtolower($_POST['iNomeScaletta'])));
	
	$arrayBraniKey = array();
	$arrayBrani = array();
	
	$b = "brano_";
	foreach($_POST as $key=>$val) {
		$subKey = substr($key,0,6);
		////jhp_log("Confronto: ".$key." con ".$subKey);
		////jhp_log($subKey == $b);
		if($subKey == $b && $val == 1){
			$arrayBraniKey[] = $key;
			$arrayBrani[] = substr($key,6,count($key)+2);
			////jhp_log("true");
			////jhp_log($key." => ".$val);
		}
	}
  
	$braniDB = "	SELECT  idListaBrani
					FROM    scalettaToListaBrani
					WHERE	idScaletta = $idScaletta
					AND validate = 1";
	
	$queryBraniDB = ntxQuery($braniDB);
	
	$index = 0;
	while($rs=ntxRecord($queryBraniDB))
	{
		////jhp_log($rs);
		foreach($rs as $k=>$v)
		$arrayBraniDB[$index] = htmlentities($v);
		$index++;
	}
	
	
	//Ciclo for DELETE
	for($i=0;$i<count($arrayBraniDB);$i++){
		////jhp_log($i.': '.$arrayBraniDB[$i]);
		if(in_array($arrayBraniDB[$i],$arrayBrani) == false){
			//query DELETE
			$delete = "	DELETE FROM scalettaToListaBrani
						WHERE idScaletta = $idScaletta
						AND idListaBrani = $arrayBraniDB[$i]";
			ntxQuery($delete);
			////jhp_log($arrayBraniDB[$i]);
		}
	}
	
	//Ciclo for INSERT
	for($i=0;$i<count($arrayBrani);$i++){
		////jhp_log($i.': '.$arrayBrani[$i]);
		if(in_array($arrayBrani[$i],$arrayBraniDB) == false){
			//query INSERT
			$insert = "	INSERT INTO scalettaToListaBrani(idScaletta,idListaBrani,validate,idUtente)
						VALUES($idScaletta,$arrayBrani[$i],1,$idUtente)";
			ntxQuery($insert);
			////jhp_log('$arrayBrani');
			////jhp_log($i.': '.$arrayBrani[$i]);
		}
	}
	
	//Aggiornamento
	$query = "	UPDATE scalette
				SET nomeScaletta = '$nomeScaletta',
				dataUltimaModifica = GETDATE()
				WHERE validate = 1
				AND idScaletta = $idScaletta";

	ntxQuery($query);

	$result = "dettagliScaletta.php";
	jhp(&$result);
	//jhp_ok();
?>
