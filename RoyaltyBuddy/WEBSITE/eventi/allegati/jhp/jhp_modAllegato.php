<?php

if ( !$_SESSION ) session_start();

require_once("../../../_ntx/const.inc");
require_once(NTX_PATH."jhp/jhp.inc");
require_once(NTX_WEBPORTAL_PATH.'_database.inc');

//jhp_log($_POST);
$idUtente = $_SESSION['idUtente'];
//jhp_log($idUtente);
$idAllegatiEvento = $_SESSION['idSelect'];
$descrizione = trim($_POST['iDescrizione']);
$pathAllegato = $_POST['files'];
$extensionImg = explode(".",$pathAllegato);
$extensionImg = $extensionImg[1];
//jhp_log($extensionImg);
$pathAllegato = $idUtente."\\".$_POST[iNomeAllegato].".".$extensionImg;
//jhp_log($pathAllegato);

//Controllo se $_POST['files'] = '' mantengo la img che è già presente 
//se no prendo sua estensione e ricostruisco pathAllegato da caricare su DB

//Insert 
$query = <<< query
		UPDATE	allegati_evento
		SET		descrizione = '$descrizione', 
				pathAllegato = '$pathAllegato', 
				dataUltimaModifica = GETDATE()
		WHERE	idAllegatiEvento = $idAllegatiEvento
		AND 	validate = 1
query;

//ntxQuery($query);

$_SESSION['idSelect'] = $_POST[iEvento];

$result = "listaAllegati.php";
jhp(&$result);

?>