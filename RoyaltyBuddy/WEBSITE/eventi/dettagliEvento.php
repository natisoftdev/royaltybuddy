<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("EVE_000_003", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("EVE_000_003", "IT", __FILE__);
	
	$next = "listaEventi.php";
	$back = $_SESSION['page'];
	$idEvento = $_SESSION['idSelect'];
	
	$sql = " 	SELECT     	idEvento, nomeEvento, dataEvento, nomeLuogo, tipoLuogo, 
							indirizzo, citta, stato, oraEvento
				FROM		eventi 
				WHERE 		idEvento = '$idEvento' AND validate = 1 ";
	
	$query = ntxQuery($sql);
	
	while($rs=ntxRecord($query))
	{
		$rs[dataEvento] = ntxDateT($rs[dataEvento]);
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}
	$hours = floor($html['oraEvento'] / 3600);
	if($hours < 10){
		$hours = "0".$hours;
	}
	$html['oraEvento'] -= $hours * 3600;
	$minutes = floor($html['oraEvento'] / 60);
	if($minutes < 10){
		$minutes = "0".$minutes;
	}
	$html['oraEvento'] -= $minutes * 60;
	
	$html['oraEvento'] = $hours.":".$minutes;
	
	//Per recuperare il nome della città
	$idCitta = $html['citta'];
	
	$sql = " 	SELECT     	nomeCitta
				FROM		citta 
				WHERE 		idCitta = $idCitta ";
	
	$query = ntxQuery($sql);
	
	while($rs=ntxRecord($query))
	{
		foreach($rs as $k=>$v)
			$html2[$k] = htmlentities($v);
	}
	
	//Per recuperare il nome dello stato
	$siglaStato = $html['stato'];
	
	$sql = " 	SELECT     	nomeStato
				FROM		stati 
				WHERE 		siglaStato = '$siglaStato' ";
	
	$query = ntxQuery($sql);
	
	while($rs=ntxRecord($query))
	{
		foreach($rs as $k=>$v)
			$html3[$k] = htmlentities($v);
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
	</head>
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					<?php $traduttore->html('Dettagli Evento') ?>
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
				<div>
					<div>
						<label for="iEvento"><?php $traduttore->html('Evento') ?></label>
						<input type="text" name="iEvento" id="iEvento" value="<?php echo $html['nomeEvento'] ?>" readonly>
					</div>
					<div>
						<label for="iDataEvento"><?php $traduttore->html('Data evento') ?></label>
						<input type="date" name="iDataEvento" id="iDataEvento" value="<?php echo $html['dataEvento'] ?>" readonly>
					</div>
					<div>
						<label for="iOra"><?php $traduttore->html('Ora evento (hh:mm)') ?></label>
						<input type="time" name="iOra" id="iOra" value="<?php echo $html['oraEvento'] ?>" readonly>
					</div>
					<div>
						<label for="iNomeLuogo"><?php $traduttore->html('Luogo') ?></label>
						<input type="text" name="iNomeLuogo" id="iNomeLuogo" value="<?php echo $html['nomeLuogo'] ?>" readonly>
					</div>
					<div>
						<label for="iTipoLuogo"><?php $traduttore->html('Tipo luogo') ?></label>
						<input type="text" name="iTipoLuogo" id="iTipoLuogo" value="<?php echo $html['tipoLuogo'] ?>" readonly>
					</div>
					<div>
						<label for="iIndirizzo"><?php $traduttore->html('Indirizzo') ?></label>
						<input type="text" name="iIndirizzo" id="iIndirizzo" value="<?php echo $html['indirizzo'] ?>" readonly>
					</div>
					<div>
						<label for="iStato"><?php $traduttore->html('Stato') ?></label>
						<input type="text" name="iStato" id="iStato" value="<?php echo $html3['nomeStato'] ?>" readonly>
					</div>
					<div>
						<label for="iCitta"><?php $traduttore->html('Città') ?></label>
						<input type="text" name="iCitta" id="iCitta" value="<?php echo $html2['nomeCitta'] ?>" readonly>
					</div>
					
					<div>
						<label for="iAllegato"><?php $traduttore->html('Allegati del programma') ?></label>
						<a onclick="openData('<?php echo $idEvento ?>','allegati/listaAllegati.php','dettagliEvento.php')">
							<button type="button"><?php $traduttore->html('Visualizza Allegati') ?></button></a>
					</div>
				</div>
				<br>
				<br>
				<!-- Btn Modifica -->
				<div>
					<a onclick="openData('<?php echo $idEvento ?>','modificaEvento.php','dettagliEvento.php')"><button type="button"><?php $traduttore->html('Modifica') ?></button></a>
				</div>
				<br>
				<!-- Elimina evento -->
				<div style="float:right;">
					<a onclick="openData('<?php echo $idEvento ?>','confEliminaEvento.php','dettagliEvento.php')"><?php $traduttore->html('Elimina evento') ?></a>
				</div>
			</div>
		</div><!-- /page -->
		<div class="overlay" id="overlay" style="display:none;"></div>
		<!-- Div per messaggio info -->
		<div id=divMessage style="display:none" class="modal">
			<div id=divMessage2 style="text-align:center" class="modal-content">
				<div style="text-align:right">
					<img onclick="closeHelp()" src="../css\themes\images\icons-png\delete-black.png" alt="Chiudi" class="closeHelp" />
				</div> 
				<div id="messaggioVero">
					<p>
						<?php $traduttore->html('Dettagli Evento') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>
