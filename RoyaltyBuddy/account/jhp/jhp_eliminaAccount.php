<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');

	$idUtente = $_SESSION['idUtente'];

	//Porto programmi.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    programmi
			SET		validate = 0
			FROM	programmi INNER JOIN
					utenti ON programmi.esecutore = utenti.idUtente
			WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	//Porto liste_brani.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    liste_brani
			SET		validate = 0
			FROM	liste_brani INNER JOIN
					utenti ON liste_brani.compositore = utenti.idUtente
			WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	//Porto scalettatolistabrani.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    scalettatolistabrani
			SET		validate = 0
			FROM 	scalettatolistabrani INNER JOIN
					utenti ON scalettatolistabrani.idUtente = utenti.idUtente
			WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
sqlUpdate;

	ntxQuery($sqlUpdate);
		
	//Porto brani.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
				UPDATE    brani
				SET		validate = 0
				FROM	brani INNER JOIN
						liste_brani ON brani.idBrano = liste_brani.brano INNER JOIN
						utenti ON liste_brani.compositore = utenti.idUtente
			WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	//Porto album.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    album
			SET		validate = 0
			WHERE idUtente = $idUtente
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	//Porto scalette.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    scalette
			SET       validate = 0
			WHERE idUtente = $idUtente
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	//Porto eventi.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    eventi
			SET		validate = 0
			FROM	eventi INNER JOIN
					programmi ON eventi.idEvento = programmi.evento INNER JOIN
					utenti ON programmi.esecutore = utenti.idUtente
			WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	//Porto allegati_evento.validate = 0 WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
	$sqlUpdate = <<< sqlUpdate
			UPDATE    allegati_evento
			SET		validate = 0
			FROM	allegati_evento INNER JOIN
					eventi ON allegati_evento.evento = eventi.idEvento INNER JOIN
					programmi ON eventi.idEvento = programmi.evento INNER JOIN
					utenti ON programmi.esecutore = utenti.idUtente
			WHERE utenti.idUtente = $idUtente AND utenti.validate = 1
sqlUpdate;

	ntxQuery($sqlUpdate);
	
	/*	IMPORTANTE:	ESEGUIRE LA QUERY PER UTENTI DOPO AVER ESEGUITO LE ALTRE	*/
	//Porto utenti.validate = 0
	$sqlUpdate = <<< sqlUpdate
			UPDATE    	utenti
			SET			validate = 0
			WHERE 		idUtente = $idUtente AND validate = 1
sqlUpdate;

	ntxQuery($sqlUpdate);
	jhp_ok();
?>