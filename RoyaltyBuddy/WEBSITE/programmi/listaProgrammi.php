<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);

	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("PRO_000_004", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("PRO_000_004", "IT", __FILE__);
	
	$idUtente = $_SESSION['idUtente'];
	$home = $_SESSION['home'];
	
	$sql = " SELECT nome, cognome, email FROM utenti WHERE idUtente = '$idUtente' AND validate = 1 ";
		
	$query = ntxQuery($sql);
		
	while($rs=ntxRecord($query))
	{
		foreach($rs as $k=>$v)
		$htmlUtente[$k] = htmlentities($v);
	}
	
	$nome = $htmlUtente['nome'];
	$cognome = $htmlUtente['cognome'];
	$email = $htmlUtente['email'];
	
	$programmi = "	SELECT     programmi.idProgramma, programmi.evento, programmi.scaletta, eventi.nomeEvento, scalette.nomeScaletta
					FROM         programmi INNER JOIN
							eventi ON programmi.evento = eventi.idEvento INNER JOIN
							scalette ON programmi.scaletta = scalette.idScaletta
					WHERE esecutore = $idUtente AND programmi.validate = 1
					ORDER BY programmi.dataUltimaModifica DESC";
	
	$queryProgrammi = ntxQuery($programmi);
	
	while($rs=ntxRecord($queryProgrammi))
	{
		foreach($rs as $k=>$v)
			$htmlP[$k] = htmlentities($v);
			
		$listaProgrammi .= "<li><a onclick='openData(\"$htmlP[idProgramma]\",\"dettagliProgramma.php\",\"listaProgrammi.php\")'>$htmlP[nomeEvento] - $htmlP[nomeScaletta]</a></li>";
	}
		
	$menu = "";
	if($_SESSION['home'] == "homeCompositore.php"){
		$menu = "menuCompositore.php";
	}
	elseif($_SESSION['home'] == "homeEsecutore.php"){
		$menu = "menuEsecutore.php";
	}
	else{
		$menu = "menuCompEsec.php";
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
			<div data-role="panel" id="myPanel" data-theme="b" data-display="overlay">
				<?php
					require_once("../home/".$menu);
				?>
			</div>
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					Royalty Buddy
				</h1>
				<a href="#myPanel" data-ajax="false" data-icon="bars" data-iconpos="notext" >
					Menu
				</a>
				<a onclick="openHelp()"
					data-icon="info" data-iconpos="notext">
					Help
				</a>
			</div><!-- /header -->
			<div role="main" class="ui-content">
				<div class="float_right" style="width:auto">
					<a onclick="openPage('aggiungiProgramma.php','listaProgrammi.php')">
						<?php $traduttore->html('Aggiungi') ?>
					</a>
				</div>
				<div>
					<label class="lista" for="iProgrammi"><?php $traduttore->html('Lista Programmi') ?></label>
					<ul data-role="listview" data-filter="true" data-filter-placeholder="<?php $traduttore->html('Cerca programma...') ?>" data-inset="true" name="iProgrammi">
						<?php
							echo $listaProgrammi;
						?>
					</ul>
				</div>
				<div class="float_right" style="width:auto">
					<a onclick="openPage('aggiungiProgramma.php','listaProgrammi.php')">
						<?php $traduttore->html('Aggiungi') ?>
					</a>
				</div>
			</div><!-- /content -->
		</div><!-- /page -->
		<div class="overlay" id="overlay" style="display:none;"></div>
		<div id=divMessage style="display:none" class="modal">
			<div id=divMessage2 style="text-align:center" class="modal-content">
				<div style="text-align:right">
					<img onclick="closeHelp()" src="../css\themes\images\icons-png\delete-black.png" alt="Chiudi" class="closeHelp" />
				</div> 
				<div id="messaggioVero">
					<p>
						<?php $traduttore->html('Lista dei programmi presenti') ?> <br><?php $traduttore->html('( usare la ricerca per filtrarli )') ?>
						</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>