<?php 
	
	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	// stato selezionato
	$siglaStato = ntxsp('stato');
		
	$query = "	SELECT  nomeCitta, idCitta
				FROM	citta
				WHERE siglaStato = $siglaStato
				ORDER BY nomeCitta";
	
	$sql = ntxQuery($query);

	while($rs=ntxRecord($sql))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
			
			$selectStati .= "<option value='$html[idCitta]'>$html[nomeCitta]</option>";
	}

	jhp(&$selectStati);
?>