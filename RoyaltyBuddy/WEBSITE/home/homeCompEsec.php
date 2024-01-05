<?php 
	if ( !$_SESSION ) @session_start();
	$vers = time();
	//var_dump($_SESSION);

	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("HOM_000_001", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("HOM_000_001", "IT", __FILE__);
	
	$idUtente = $_SESSION['idUtente'];
	$home = $_SESSION['home'];
	
	$sql = " SELECT nome, cognome, email FROM utenti WHERE idUtente = '$idUtente' AND validate = 1 ";
	$brani = " 	SELECT  TOP 3 brani.idBrano, brani.nomeBrano, brani.durata, liste_brani.brano, liste_brani.compositore
				FROM    brani INNER JOIN
						liste_brani ON brani.idBrano = liste_brani.brano INNER JOIN
						utenti ON liste_brani.compositore = utenti.idUtente
				WHERE 	utenti.idUtente = $idUtente AND brani.validate = 1
				ORDER BY brani.annoUscita DESC";
	$album = "	SELECT  DISTINCT TOP 3 album.idAlbum, album.nomeAlbum, album.annoPubblicazione
				FROM	album 
				WHERE 	album.idUtente = $idUtente AND album.validate = 1 AND album.nomeAlbum != 'Singolo_$idUtente'
				ORDER BY album.annoPubblicazione DESC";

	$eventi = "	SELECT  TOP 3 eventi.idEvento, eventi.nomeEvento, eventi.nomeLuogo, eventi.dataEvento
				FROM  	eventi 
				WHERE 	eventi.idUtente = $idUtente AND eventi.validate = 1
				ORDER BY eventi.dataEvento DESC";
				
	$scalette = " 	SELECT    TOP 3 scalette.idScaletta, scalette.nomeScaletta, scalette.dataInserimento
					FROM   	scalette
					WHERE 	scalette.idUtente = $idUtente AND scalette.validate = 1
					ORDER BY scalette.dataInserimento DESC";
					
	$programmi = " 	SELECT	TOP 3 programmi.idProgramma, eventi.nomeEvento, scalette.nomeScaletta
					FROM    eventi INNER JOIN
							programmi ON eventi.idEvento = programmi.evento INNER JOIN
							scalette ON programmi.scaletta = scalette.idScaletta
					WHERE 	programmi.esecutore = $idUtente AND programmi.validate = 1
					ORDER BY programmi.dataInserimento DESC";
		
	$query = ntxQuery($sql);
	$queryBrani = ntxQuery($brani);
	$queryAlbum = ntxQuery($album);
	$queryEventi = ntxQuery($eventi);
	$queryScalette = ntxQuery($scalette);
	$queryProgrammi = ntxQuery($programmi);
	
	while($rs=ntxRecord($query))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}
	
	$nome = $html['nome'];
	$cognome = $html['cognome'];
	$email = $html['email'];
	
	while($rs=ntxRecord($queryBrani))
	{
		foreach($rs as $k=>$v)
			$htmlB[$k] = htmlentities($v);
			
		$listaBrani .= "<li><a onclick='openData(\"$htmlB[idBrano]\",\"../brani/dettagliBrano.php\",\"../home/$home\")'>$htmlB[nomeBrano]</a></li>";
	}
	
	while($rs=ntxRecord($queryAlbum))
	{
		foreach($rs as $k=>$v)
			$htmlA[$k] = htmlentities($v);
			
		$listaAlbum .= "<li><a onclick='openData(\"$htmlA[idAlbum]\",\"../album/dettagliAlbum.php\",\"../home/$home\")'>$htmlA[nomeAlbum]</a></li>";
	}
	
	while($rs=ntxRecord($queryEventi))
	{
		$rs[dataEvento] = ntxDate($rs[dataEvento]);
		foreach($rs as $k=>$v)
			$htmlE[$k] = htmlentities($v);
	
		$listaEventi .= "<li><a onclick='openData(\"$htmlE[idEvento]\",\"../eventi/dettagliEvento.php\",\"../home/$home\")'>$htmlE[nomeEvento] - $htmlE[nomeLuogo] - $htmlE[dataEvento]</a></li>";
	}
	
	while($rs=ntxRecord($queryScalette))
	{
		foreach($rs as $k=>$v)
			$htmlS[$k] = htmlentities($v);
			
		$listaScalette .= "<li><a onclick='openData(\"$htmlS[idScaletta]\",\"../scalette/dettagliScaletta.php\",\"../home/$home\")'>$htmlS[nomeScaletta]</a></li>";
	}
	
	while($rs=ntxRecord($queryProgrammi))
	{
		foreach($rs as $k=>$v)
			$htmlP[$k] = htmlentities($v);
			
		$listaProgrammi .= "<li><a onclick='openData(\"$htmlP[idProgramma]\",\"../programmi/dettagliProgramma.php\",\"../home/$home\")'>$htmlP[nomeEvento] - $htmlP[nomeScaletta]</a></li>";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- my css -->
		<link rel="stylesheet" href="../css/template.css" />
		<!-- ManPro.NEt CSS -->
		<link href="/repository/css/grid-2.0.0.css" rel="stylesheet" type="text/css">
		<!-- JQuery Mobile Library CSS -->
		<link rel="stylesheet" href="/repository2/jqm142/jquery.mobile-1.4.2.min.css" />
		<!-- libreria jhp -->
		<script src="/repository/libs/jhp/jhp-1.5.1.min.js" type="text/javascript"></script>
		<!-- JQuery Library JS -->
		<script src="/repository2/jqm142/jquery-1.11.0.min.js"></script>
		<script src="/repository2/jqm142/jquery.mobile-1.4.2.min.js"></script>
		<script src="/repository/libs/jhp/jhp-1.5.1.min.js" type="text/javascript"></script>
		<!-- my js -->
		<script src="../js/index.js?vers=<?php echo $vers ?>"></script>
		<script src="js/index.js?vers=<?php echo $vers ?>"></script>
	</head>
	<body>
		<div data-role="page">
			<div data-role="panel" id="myPanel" data-theme="b" data-display="overlay">
				<?php
					require_once("menuCompEsec.php");
				?>
			</div>
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					Royalty Buddy
				</h1>
				<a href="#myPanel" data-ajax="false" data-icon="bars" data-iconpos="notext" >
					Menu
				</a>
			</div><!-- /header -->
			<div role="main" class="ui-content">
				<div>
					<h3 style="text-align:center;"><?php $traduttore->html('Attività Recenti') ?> </h3>
				</div>
				<div>
					<p class="boldListe"><?php $traduttore->html('Ultimi album:') ?> </p>
					<ul data-role="listview" data-inset="true">
						<?php
							echo $listaAlbum;
						?>
					</ul>
				</div>
				<div>
					<p class="boldListe"><?php $traduttore->html('Ultimi brani:') ?> </p>
					<ul data-role="listview" data-inset="true">
						<?php
							echo $listaBrani;
						?>
					</ul>
				</div>
				<div>
					<p class="boldListe"><?php $traduttore->html('Ultimi eventi:') ?> </p>
					<ul data-role="listview" data-inset="true">
						<?php
							echo $listaEventi;
						?>
					</ul>
				</div>
				<div>
					<p class="boldListe"><?php $traduttore->html('Ultime scalette:') ?> </p>
					<ul data-role="listview" data-inset="true">
						<?php
							echo $listaScalette;
						?>
					</ul>
					<p class="boldListe"><?php $traduttore->html('Ultimi programmi:') ?></p>
					<ul data-role="listview" data-inset="true">
						<?php
							echo $listaProgrammi;
						?>
					</ul>
				</div>
			</div><!-- /content -->
		</div><!-- /page -->
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>