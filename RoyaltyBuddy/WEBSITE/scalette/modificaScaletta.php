<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("SCA_000_005", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("SCA_000_005", "IT", __FILE__);
	
	$next = "dettagliScaletta.php";
	$back = $_SESSION['page'];
	$idScaletta = $_SESSION['idSelect'];
	
	$queryIdListaBrani = <<< queryBrani
							SELECT     	idListaBrani
							FROM       	scalettaToListaBrani
							WHERE		idScaletta = $idScaletta
							AND 		validate = 1
queryBrani;
	
	$lista = ntxQuery($queryIdListaBrani);
	$arrayIdListaBrani = array();
	
	while($rs=ntxRecord($lista))
	{
		$htmlLista = array();
	
		foreach($rs as $k=>$v)
			$htmlLista[$k] = htmlentities($v);
			
		$arrayIdListaBrani[] = (int)$htmlLista['idListaBrani'];
	}
		
	$brani = "	SELECT     	brani.nomeBrano, album.nomeAlbum, liste_brani.idListaBrani, utenti.nome+' '+utenti.cognome as compositore
				FROM		album 
					INNER JOIN
							liste_brani ON album.idAlbum = liste_brani.album 
					INNER JOIN
							brani ON liste_brani.brano = brani.idBrano 
					INNER JOIN
							utenti ON liste_brani.compositore = utenti.idUtente
				AND			liste_brani.validate = 1";
	
			
	$queryBrani = ntxQuery($brani);
	
	while($rs=ntxRecord($queryBrani))
	{
		$html = array();
	
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);

		$id = (int)$html['idListaBrani'];
		if(in_array( $id, $arrayIdListaBrani)){
			$listaBrani .= "<input type='checkbox' name='brano_$html[idListaBrani]' id='brano_$html[idListaBrani]' idListaBrani = $html[idListaBrani] data-cacheval='false' />
					<label for='brano_$html[idListaBrani]'>$html[nomeBrano] di $html[compositore]</label>";
		}
		else{
			$listaBrani .= "<input type='checkbox' name='brano_$html[idListaBrani]' id='brano_$html[idListaBrani]' idListaBrani = $html[idListaBrani] data-cacheval='true' />
					<label for='brano_$html[idListaBrani]' >$html[nomeBrano] di $html[compositore]</label>";
		}
	}
	
	$scaletta = "	SELECT     	nomeScaletta, dataInserimento
					FROM        scalette
					WHERE 		idScaletta = $idScaletta
					AND 		validate = 1";
	
	$dettagli = ntxQuery($scaletta);
	
	while($rs=ntxRecord($dettagli))
	{
		$htmlS = array();
		
		$rs[dataInserimento] = ntxDate($rs[dataInserimento]);
		foreach($rs as $k=>$v)
			$htmlS[$k] = htmlentities($v);
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
		<script src="/repository/libs/jhp/jhp-1.5.1.min.js" type="text/javascript"></script>
		<!-- my js -->
		<script src="js/index.js?vers=<?php echo $vers ?>"></script>
		<script src="../js/index.js?vers=<?php echo $vers ?>"></script>
		<script>
			var myArray = [<?php echo '"'.implode('","', $arrayIdListaBrani).'"' ?>];
			$(document).ready(function() {	
				changeStatusCheckboxradio(myArray);
			});
			
			var messaggi = {
				campoScalettaVuoto: "<?php $traduttore->js('Attenzione! Campo scaletta vuoto!') ?>",
				campoInserireBrano: "<?php $traduttore->js('Scegliere almeno un brano') ?>"
			};
		</script>
	</head>
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					<?php $traduttore->html('Modifica Scaletta') ?> 
				</h1>
				<a onclick="openPage('<?php echo $next ?>','<?php echo $back ?>')" data-ajax="false" data-icon="arrow-l" data-iconpos="notext" >
					Back
				</a>
				<a onclick="openHelp()"
				data-icon="info" data-iconpos="notext">
					Help
				</a>
			</div><!-- /header -->
			<div role="main" data-theme="a" class="ui-content">
				<form name="formModScaletta" method="post">
					<!-- Lista Campi -->
					<div>
						<label for="iNomeScaletta"><?php $traduttore->html('Scaletta') ?></label>
						<input class="capitalize" type="text" name="iNomeScaletta" id="iNomeScaletta" value="<?php echo $htmlS['nomeScaletta']?>" >
					</div>
					<br>
					<hr>
					<br>
					<div>
						<label for="iListaBrani"><?php $traduttore->html('Lista brani') ?></label>
						<fieldset name="ListaBrani" data-role="controlgroup" data-filter="true" data-filter-placeholder="Cerca brano..." data-inset="true" data-type="vertical">
							<?php
								echo $listaBrani;
							?>
						</fieldset>
					</div>					
					<br>
					<br>
					<!-- Btn Modifica -->
					<div>
						<input type="submit" name="iSalva" id="iSalva" value="<?php $traduttore->html('Salva') ?>" onclick="modScaletta(formModScaletta)" />	
					</div>
				</div>
			</form>
		</div><!-- /page -->
		<div class="overlay" id="overlay" style="display:none;"></div>
		<div id=divMessage style="display:none" class="modal">
			<div id=divMessage2 style="text-align:center" class="modal-content">
				<div style="text-align:right">
					<img onclick="closeHelp()" src="../css\themes\images\icons-png\delete-black.png" alt="Chiudi" class="closeHelp"/>
				</div> 
				<div id="messaggioVero">
					<p>
						<?php $traduttore->html('Modificare le informazioni della scaletta') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>
