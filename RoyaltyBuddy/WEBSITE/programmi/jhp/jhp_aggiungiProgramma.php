<?php

if ( !$_SESSION ) session_start();

require_once("../../_ntx/const.inc");
require_once(NTX_PATH."jhp/jhp.inc");
require_once(NTX_WEBPORTAL_PATH.'_database.inc');

////jhp_log($_POST);

//ottengo id di Evento
$idEvento = $_POST['iEvento'];
////jhp_log($idEvento);
//ottengo id di Scaletta
$idScaletta = $_POST['iScaletta'];
////jhp_log($idScaletta);
//ottengo id di idUtente
$idUtente = $_SESSION['idUtente'];
////jhp_log($idUtente);

$sql = "  INSERT INTO programmi
          (
            evento, esecutore, scaletta,
            dataInserimento, dataUltimaModifica, validate
          )
          VALUES
          (
            $idEvento,$idUtente,$idScaletta,
            GETDATE(),GETDATE(),1
          )
        ";

ntxQuery($sql);

$query2 = <<< query
		SELECT     MAX(idProgramma) AS maxIdProgrammi
		FROM       programmi
query;

$sql = ntxQuery($query2);

	while($rs=ntxRecord($sql))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}

	//ottenere idProgrammi e associarlo a $_SESSION['idSelect']
	$_SESSION['idSelect'] = $html['maxIdProgrammi'];

	$result = "dettagliProgramma.php";
	jhp($result);
?>
