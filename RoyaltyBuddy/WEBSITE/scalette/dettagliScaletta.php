<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("SCA_000_003", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("SCA_000_003", "IT", __FILE__);
	
	$next = "listaScalette.php";
	$back = $_SESSION['page'];
	$idScaletta = $_SESSION['idSelect'];
		
	$sql = " 	SELECT		nomeScaletta, dataInserimento
				FROM       	scalette
				WHERE 		idScaletta = '$idScaletta' AND validate = 1";
	
	$query = ntxQuery($sql);
	
	while($rs=ntxRecord($query))
	{
		$rs[dataInserimento] = ntxDate($rs[dataInserimento]);
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}
	
	//Lista brani della scaletta selezionata
	$brani = "	SELECT     	liste_brani.idListaBrani, brani.idBrano, brani.nomeBrano, album.nomeAlbum, utenti.nome+' '+utenti.cognome as compositore
				FROM        ScalettatoListaBrani 
					INNER JOIN
							liste_brani ON scalettaToListaBrani.idListaBrani = liste_brani.idListaBrani 
					INNER JOIN
							brani ON liste_brani.brano = brani.idBrano 
					INNER JOIN
							album ON liste_brani.album = album.idAlbum 
					INNER JOIN
							utenti ON liste_brani.compositore = utenti.idUtente
				WHERE		scalettaToListaBrani.idScaletta = $idScaletta
				AND 	liste_brani.validate = 1";
	
	$queryBrani = ntxQuery($brani);
	
	while($rs=ntxRecord($queryBrani))
	{
		foreach($rs as $k=>$v)
			$htmlBrani[$k] = htmlentities($v);
			
		$listaBrani .= "<li><a onclick='openData(\"$htmlBrani[idBrano]\",\"../brani/dettagliBrano.php\",\"listaBrani.php\")'>
						$htmlBrani[nomeBrano] di $htmlBrani[compositore]</a></li>";
		
		
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
					<?php $traduttore->html('Dettagli Scaletta') ?>  
				</h1>
				<a onclick="openPage('<?php echo $next ?>','<?php echo $back ?>')" data-ajax="false" data-icon="arrow-l" data-iconpos="notext" >
					Back
				</a>
				<a onclick="openHelp()" data-icon="info" data-iconpos="notext">
					Help
				</a>
			</div><!-- /header -->
			<div role="main" data-theme="a" class="ui-content">
				<!-- Lista Campi -->
				<div>
					<label for="iNomeScaletta"><?php $traduttore->html('Scaletta') ?></label>
					<input type="text" name="iNomeScaletta" id="iNomeScaletta" value="<?php echo $html['nomeScaletta'] ?>" readonly>
				</div>
				<div>
					<label for="iDataCreazione"><?php $traduttore->html('Creata il') ?></label>
					<input type="text" name="iDataCreazione" id="iDataCreazione" value="<?php echo $html['dataInserimento'] ?>" readonly>
				</div>
				<br>
				<hr>
				<br>
				<div>
					<label for="iBrani"><?php $traduttore->html('Lista brani') ?></label>
					<ul data-role="listview" data-inset="true" name="iBrani">
						<?php
							echo $listaBrani;
						?>
					</ul>	
				</div>
				<br>
				<br>
				<!-- Btn Modifica -->
				<div>
					<a onclick="openData('<?php echo $idScaletta ?>','modificaScaletta.php','dettagliScaletta.php')"><button type="button"><?php $traduttore->html('Modifica') ?></button></a>
				</div>
			
				<br>
				<!-- ElProf -->
				<div style="float:right;">
					<a onclick="openData('<?php echo $idScaletta ?>','confEliminaScaletta.php','dettagliscaletta.php')"><?php $traduttore->html('Elimina scaletta') ?></a>
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
						<?php $traduttore->html('Dettagli Scaletta') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>