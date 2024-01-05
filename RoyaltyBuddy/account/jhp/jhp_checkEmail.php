<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	$email = $_POST['email'];
	
	$query = <<< query
				SELECT     COUNT(idUtente) as 'numEmail'
				FROM         utenti
				WHERE email = '$email' AND validate = 1
query;

	$sql = ntxQuery($query);

	while($rs=ntxRecord($sql))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}
	
	$result = 0;
	if($html[numEmail] == 0){
		$result = 0;
	}
	else if($html[numEmail] == 1){
		$result = 1;
	}
	else{
		$result = 2;
	}
	
	jhp(&$result);
?>