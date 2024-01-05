<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$result = "";
	$nomeAlbum = trim(ucwords(strtolower($_POST['iAlbum'])));
	$annoPubblicazione = $_POST['iAnno'];
	$idUtente = $_SESSION['idUtente']; 
	
	//Insert
	$query = <<< query
	INSERT INTO album
		(nomeAlbum, annoPubblicazione, idUtente, dataInserimento, dataUltimaModifica, validate)
	VALUES
		('$nomeAlbum','$annoPubblicazione',$idUtente,GETDATE(),GETDATE(),1)
query;

	ntxQuery($query);
	
	$query2 = <<< query
		SELECT     MAX(idAlbum) AS maxIdAlbum
		FROM         album
query;

	$sql = ntxQuery($query2);
	while($rs=ntxRecord($sql))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}
	
	//ottenere idBrano e associarlo a $_SESSION['idSelect']
	$_SESSION['idSelect'] = $html['maxIdAlbum'];
	$result = "dettagliAlbum.php";
	jhp(&$result);
?>
