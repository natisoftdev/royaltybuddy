<?php

  if ( !$_SESSION ) session_start();

  require_once("../../_ntx/const.inc");
  require_once(NTX_PATH."jhp/jhp.inc");
  require_once(NTX_WEBPORTAL_PATH.'_database.inc');

  //id
  $idAlbum = $_SESSION['idSelect'];
  //nome Album
  $nomeAlbum = trim(ucwords(strtolower($_POST['iAlbum'])));
  //anno Pubblicazione
  $annoP = $_POST['iAnno'];
  //idCompositore
  $idUtente = $_SESSION['idUtente'];

  //Aggiornamento
  $query = <<< query
    UPDATE    album
    SET   nomeAlbum ='$nomeAlbum',
          annoPubblicazione ='$annoP',
          idUtente = '$idUtente',
          dataUltimaModifica = GETDATE()
    WHERE idAlbum = $idAlbum
	AND  validate = 1;
query;

  ntxQuery($query);
  $result = "";
  $result = "dettagliAlbum.php";
  jhp(&$result);
?>
