<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("PRO_000_003", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("PRO_000_003", "IT", __FILE__);
	
	$next = "listaProgrammi.php";
	$back = $_SESSION['page'];
	$idProgramma = $_SESSION['idSelect'];
	
	//var_dump($_SESSION);
	
	//ottengo gli id (idEvento e idScaletta)
	$sql = "SELECT evento, scaletta FROM programmi WHERE idProgramma = '$idProgramma' AND validate = 1";
	//var_dump($sql);
	$query = ntxQuery($sql);
	
	while($rs=ntxRecord($query))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}
	
	//ottengo i dati i Evento
	$evento = "	SELECT     eventi.nomeEvento, eventi.dataEvento, eventi.nomeLuogo, eventi.indirizzo, citta.siglaStato, citta.nomeCitta
				FROM         eventi INNER JOIN
                      citta ON citta.idCitta = eventi.citta 
				WHERE idEvento = '$html[evento]' AND eventi.validate = 1";
	$queryE = ntxQuery($evento);
	
	while($rs=ntxRecord($queryE))
	{
		$rs[dataEvento] = ntxDate($rs[dataEvento]);
		foreach($rs as $k=>$v)
			$htmlE[$k] = htmlentities($v);
	}
	
	//ottengo i dati di Scaletta
	$scaletta = "	SELECT nomeScaletta 
					FROM scalette 
					WHERE idScaletta = $html[scaletta] AND validate = 1";
	$queryS = ntxQuery($scaletta);
	
	while($rs=ntxRecord($queryS))
	{
		foreach($rs as $k=>$v)
			$htmlS[$k] = htmlentities($v);

	}
	
	$brani = " SELECT	brani.idBrano, brani.nomeBrano, album.nomeAlbum, utenti.nome+' '+utenti.cognome as compositore
				FROM	album INNER JOIN
						liste_brani ON album.idAlbum = liste_brani.album INNER JOIN
						brani ON liste_brani.brano = brani.idBrano INNER JOIN
						scalettatoListaBrani ON liste_brani.idListaBrani = scalettatoListaBrani.idListaBrani INNER JOIN
						utenti ON liste_brani.compositore = utenti.idUtente
				WHERE 	scalettatoListaBrani.idScaletta =  $html[scaletta] 
				AND 	liste_brani.validate = 1";
				
	$queryBrani = ntxQuery($brani);
	
	while($rs=ntxRecord($queryBrani))
	{
		$html = array();
	
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);

		$listaBrani .= "<li><a onclick='openData(\"$html[idBrano]\",\"dettagliBrano.php\",\"$home\")'>$html[nomeBrano] - $html[nomeAlbum] di $html[compositore]</a></li>";
	
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
					<?php $traduttore->html('Dettagli Programma') ?> 
				</h1>
				<a onclick="openPage('<?php echo $next ?>','<?php echo $back ?>')" data-ajax="false" data-icon="arrow-l" data-iconpos="notext" >
					Back
				</a>
				<a onclick="openHelp()"
					data-icon="info" data-iconpos="notext">
					Help
				</a>
			</div><!-- /header -->
			<div data-role="main" class="ui-content" data-theme="a">
				<!-- Lista Campi -->
				<div>
					<!-- Zona Evento -->
					<div>
						<!-- Nome Evento -->
						<div>
							<label for="iNomeEvento"><?php $traduttore->html('Evento') ?></label>
							<input type="text" name="iNomeEvento" id="iNomeEvento" value="<?php echo $htmlE['nomeEvento'] ?>" readonly>
						</div>
						<!-- Data Evento -->
						<div>
							<label for="iDataEvento"><?php $traduttore->html('Data evento') ?></label>
							<input type="text" name="iDataEvento" id="iDataEvento" value="<?php echo $htmlE['dataEvento'] ?>" readonly>
						</div>
						<!-- Nome Luogo -->
						<div>
							<label for="iNomeLuogo"><?php $traduttore->html('Luogo') ?></label>
							<input type="text" name="iNomeLuogo" id="iNomeLuogo" value="<?php echo $htmlE['nomeLuogo'].' - '.$htmlE['indirizzo'].' - '.$htmlE['nomeCitta'].' ('.$htmlE['siglaStato'].')'?>" readonly>
						</div>
						<!-- Nome Scaletta -->
						<div>
							<label for="iNomeLuogo"><?php $traduttore->html('Scaletta') ?></label>
							<input type="text" name="iNomeScaletta" id="iNomeScaletta" value="<?php echo $htmlS['nomeScaletta'] ?>" readonly>
						</div>
					</div>
					<!-- Zona Scaletta -->
					<div>
						<label for="iBrani"><?php $traduttore->html('Lista brani') ?></label>
						<ul data-role="listview" data-inset="true" name="iBrani">
							<?php
								echo $listaBrani;
							?>
						</ul>
					</div>
				</div>
				<br>
				<br>
				<!-- Btn Modifica -->
				<div>
					<a onclick="openData('<?php echo $idProgramma ?>','modificaProgramma.php','dettagliProgramma.php')"><button type="button"><?php $traduttore->html('Modifica') ?></button></a>
				</div>
				<br>
				<!-- Elimina album -->
				<div style="float:right;">
					<a onclick="openData('<?php echo $idProgramma ?>','confEliminaProgramma.php','dettagliProgramma.php')"><?php $traduttore->html('Elimina programma') ?></a>
				</div>
			</div>
		</div><!-- page -->
		<div class="overlay" id="overlay" style="display:none;"></div>
		<!-- Div per messaggio info -->
		<div id=divMessage style="display:none" class="modal">
			<div id=divMessage2 style="text-align:center" class="modal-content">
				<div style="text-align:right">
					<img onclick="closeHelp()" src="../css\themes\images\icons-png\delete-black.png" alt="Chiudi" class="closeHelp" />
				</div> 
				<div id="messaggioVero">
					<p>
						<?php $traduttore->html('Dettagli Programma') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>