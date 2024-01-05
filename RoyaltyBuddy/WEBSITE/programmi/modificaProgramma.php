<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("PRO_000_005", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("PRO_000_005", "IT", __FILE__);
	
	$next = "dettagliProgramma.php";
	$back = $_SESSION['page'];
	$idProgramma = $_SESSION['idSelect'];
	$idUtente = $_SESSION['idUtente'];
	
	//var_dump($_SESSION);
	
	$evento = " SELECT idEvento, nomeEvento, dataEvento, nomeLuogo FROM eventi WHERE idUtente = '$idUtente' AND validate = 1 ";
	//var_dump($evento);
	$scaletta = " SELECT idScaletta, nomeScaletta FROM scalette WHERE idUtente = '$idUtente' AND validate = 1 ";
	//var_dump($scaletta);
	$programmi = "SELECT evento, scaletta FROM programmi WHERE validate = 1 AND idProgramma = $idProgramma";
	

	$query2 = ntxQuery($evento);
	$query3 = ntxQuery($scaletta);
	$query4 = ntxQuery($programmi);
	
	while($rs=ntxRecord($query4))
	{
		foreach($rs as $k=>$v)
			$htmlP[$k] = htmlentities($v);
	}
	
	//Zona per codice Evento
	while($rs=ntxRecord($query2))
	{
		$rs[dataEvento] = ntxDate($rs[dataEvento]);
		foreach($rs as $k=>$v)
			$html2[$k] = htmlentities($v);
			
		if($html2[idEvento] == $htmlP['evento']){
			$selectEvento .= "<option selected='selected' value='$html2[idEvento]'>$html2[nomeEvento] - $html2[nomeLuogo] - $html2[dataEvento]</option>";
		}
		else{
			$selectEvento .= "<option value='$html2[idEvento]'>$html2[nomeEvento] - $html2[nomeLuogo] - $html2[dataEvento]</option>";
		}
	}
	
	//Zona per codice Scaletta
	while($rs=ntxRecord($query3))
	{
		foreach($rs as $k=>$v)
			$html3[$k] = htmlentities($v);

		if($html3[idScaletta] == $htmlP['scaletta']){
			$selectScaletta .= "<option selected='selected' value='$html3[idScaletta]'>$html3[nomeScaletta]</option>";
		}
		else{
			$selectScaletta .= "<option value='$html3[idScaletta]'>$html3[nomeScaletta]</option>";
		}
		
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- my css -->
		<link rel="stylesheet" href="../css/template.css?vers=<?php echo $vers ?>" />
		<link href="../css/modal.css?ver=<?php echo $vers ?>" rel="stylesheet" type="text/css">
		
		<!-- ManPro.NEt CSS -->
		<link href="/repository/css/grid-2.0.0.css?vers=<?php echo $vers ?>" rel="stylesheet" type="text/css">
		<!-- JQuery Mobile Library CSS -->
		
		<link rel="stylesheet" href="/repository2/jqm142/jquery.mobile-1.4.2.min.css" />
		<!-- JQuery Library JS -->
		<script src="/repository2/jqm142/jquery-1.11.0.min.js"></script>
		<script src="/repository2/jqm142/jquery.mobile-1.4.2.min.js"></script>
		<script src="/repository/libs/jhp/jhp-1.5.1.min.js"></script>
		<!-- my js -->
		<script src="js/index.js?vers=<?php echo $vers ?>"></script>
		<script src="../js/index.js?vers=<?php echo $vers ?>"></script>
		<script>
			var messaggi = {
				campoEventoVuoto: "<?php $traduttore->js('Attenzione! Campo evento vuoto!') ?>",
				campoScalettaVuoto: "<?php $traduttore->js('Attenzione! Campo scaletta vuoto!') ?>"
			};
		</script>
	</head>
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					<?php $traduttore->html('Modifica Programma') ?>
				</h1>
				<a onclick="openPage('<?php echo $next ?>','<?php echo $back ?>')" data-ajax="false" data-icon="arrow-l" data-iconpos="notext" >
					Back
				</a>
				<a onclick="openHelp()"
					data-icon="info" data-iconpos="notext">
					Help
				</a>
			</div><!-- /header -->
			<div role="main" class="ui-content" data-theme="a">
				<!-- Lista Campi -->
				<form name="formModProgramma" method="post">
					<div>
						<!-- SELECT per Evento -->
						<div>
							<label for="iEvento"><?php $traduttore->html('Evento') ?></label>
							<select name="iEvento" id="iEvento" data-overlay-theme="b">
								<option value=""><?php $traduttore->html('Scegli') ?></option>
								<?php
									echo $selectEvento;
								?>
							</select>
						</div>
						<!-- idUtente di ESECUTORE -->
						<div>
							<!--<label for="iCompositore">IdUtente:</label>-->
							<input type="hidden" name="idUtente" id="idUtente" value="<?php echo $idUtente ?>" >
						</div>
						<!-- SELECT per Scaletta -->
						<div>
							<label for="iScaletta"><?php $traduttore->html('Scaletta') ?></label>
							<select name="iScaletta" id="iScaletta" data-overlay-theme="b">
								<option value=""><?php $traduttore->html('Scegli') ?></option>
								<?php
									echo $selectScaletta;
								?>
							</select>
						</div>
					</div>
					<br>
					<br>
					<!-- Btn Modifica -->
					<div>
						<input type="submit" name="iSalva" id="iSalva" value="<?php $traduttore->html('Salva') ?>" onclick="modProgramma(formModProgramma)" />
					</div>
				</form>
			</div>
		</div><!-- /page -->
		<div class="overlay" id="overlay" style="display:none;"></div>
		<div id=divMessage style="display:none" class="modal">
			<div id=divMessage2 style="text-align:center" class="modal-content">
				<div style="text-align:right">
					<img onclick="closeHelp()" src="../css\themes\images\icons-png\delete-black.png" alt="Chiudi" class="closeHelp" />
				</div> 
				<div id="messaggioVero">
					<p>
						<?php $traduttore->html('Modificare le informazioni del programma') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>
 