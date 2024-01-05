<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$idUtente = $_SESSION['idUtente'];
	$idAlbum = $_SESSION['idSelect'];
	
	//Porto liste_brani.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    liste_brani
			SET		validate = 0
			FROM	liste_brani 
			WHERE	album = $idAlbum
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	//Porto album.validate = 0 
	$sqlUpdate = <<< sqlUpdate
			UPDATE    album
			SET		validate = 0
			WHERE idAlbum = $idAlbum
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	//Porto brani.validate = 0 WHERE idAlbum = $idAlbum
	$sqlUpdate = <<< sqlUpdate
				UPDATE  brani
				SET		validate = 0
				FROM	brani INNER JOIN
						liste_brani ON brani.idBrano = liste_brani.brano 
				WHERE 	liste_brani.validate = 0
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	//Porto scalettatolistabrani.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE  scalettatolistabrani
			SET		validate = 0
			FROM 	scalettatolistabrani INNER JOIN
					liste_brani ON scalettatolistabrani.idListaBrani = liste_brani.idListaBrani
			WHERE	liste_brani.validate = 0
			AND		liste_brani.compositore = $idUtente
sqlUpdate;

	ntxQuery($sqlUpdate);
	$result = "listaAlbum.php";
	jhp(&$result);
?>