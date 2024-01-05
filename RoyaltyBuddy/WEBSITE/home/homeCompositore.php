<?php
	if ( !$_SESSION ) @session_start();
	$vers = time();
	//var_dump($_SESSION);

	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("HOM_000_002", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("HOM_000_002", "IT", __FILE__);
	
	$idUtente = $_SESSION['idUtente'];
	$home = $_SESSION['home'];
	
	$sql = " SELECT nome, cognome, email FROM utenti WHERE idUtente = '$idUtente' AND validate = 1 ";
	$brani = " 	SELECT  TOP 3  brani.idBrano, brani.nomeBrano, brani.durata, liste_brani.brano, liste_brani.compositore
				FROM    brani INNER JOIN
						liste_brani ON brani.idBrano = liste_brani.brano INNER JOIN
						utenti ON liste_brani.compositore = utenti.idUtente
				WHERE utenti.idUtente = $idUtente AND brani.validate = 1
				ORDER BY brani.annoUscita DESC";
	$album = "	SELECT  DISTINCT TOP 63 album.idAlbum, album.nomeAlbum, album.annoPubblicazione
				FROM	album 
				WHERE album.idUtente = $idUtente AND album.validate = 1 AND album.nomeAlbum != 'Singolo_$idUtente'
				ORDER BY album.annoPubblicazione DESC";
		
	$query = ntxQuery($sql);
	$queryBrani = ntxQuery($brani);
	$queryAlbum = ntxQuery($album);
	
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
			$html[$k] = htmlentities($v);
			
		$listaBrani .= "<li><a onclick='openData(\"$html[idBrano]\",\"../brani/dettagliBrano.php\",\"../home/$home\")'>$html[nomeBrano]</a></li>";
	}
	while($rs=ntxRecord($queryAlbum))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
			
		$listaAlbum .= "<li><a onclick='openData(\"$html[idAlbum]\",\"../album/dettagliAlbum.php\",\"../home/$home\")'>$html[nomeAlbum]</a></li>";
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
					require_once("menuCompositore.php");
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
					<h3 style="text-align:center;"><?php $traduttore->html('Attività Recenti') ?></h3>
				</div>
				<div>
					<p class="boldListe"><?php $traduttore->html('Ultimi album:') ?></p>
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
			</div><!-- /content -->
		</div><!-- /page -->
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>