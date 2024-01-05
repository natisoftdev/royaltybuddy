<?php

if ( !$_SESSION ) session_start();

require_once("../../_ntx/const.inc");
require_once(NTX_PATH."jhp/jhp.inc");
require_once(NTX_WEBPORTAL_PATH.'_database.inc');

////jhp_log($_POST);
$idProgramma = $_SESSION['idSelect'];
//ottengo id di Evento
$idEvento = $_POST['iEvento'];
////jhp_log($idEvento);
//ottengo id di Scaletta
$idScaletta = $_POST['iScaletta'];
////jhp_log($idScaletta);
//ottengo id di idUtente
$idUtente = $_SESSION['idUtente'];
////jhp_log($idUtente);

$sql = "UPDATE  programmi
        SET     evento = $idEvento, 
				esecutore = $idUtente,
                scaletta = $idScaletta,
                dataUltimaModifica = GETDATE()
		WHERE 	idProgramma = $idProgramma AND validate = 1";

ntxQuery($sql);

$result = "dettagliProgramma.php";
jhp($result);

?>
