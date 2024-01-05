<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("ALB_000_003", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("ALB_000_003", "IT", __FILE__);
	
	$next = "listaAlbum.php";//pagina dove posso andare
	$back = $_SESSION['page'];//pagina dove mi trovo
	$idAlbum = $_SESSION['idSelect'];//idAlbum scelto
	
	$sql = " SELECT * FROM album WHERE idAlbum = '$idAlbum' AND validate = 1 ";
	$query = ntxQuery($sql);
	while($rs=ntxRecord($query))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}
	if($html['nomeAlbum'] == "Singolo"){
		$displayNone = "displayNone";
	}
	
	$idUtente = $html['idUtente'];
	//Con idUtente ottengo nome e cognome del compositore
	$utente = " SELECT nome, cognome FROM utenti WHERE idUtente = $idUtente AND validate = 1 ";
	$queryUtente = ntxQuery($utente);
	while($rs=ntxRecord($queryUtente))
	{
		foreach($rs as $k=>$v)
			$htmlUtente[$k] = htmlentities($v);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- my css -->
		<link rel="stylesheet" type="text/css" href="../css/template.css?vers=<?php echo $vers ?>" />
		<link rel="stylesheet" type="text/css" href="../css/modal.css?ver=<?php echo $vers ?>" />
		<!-- JQuery Mobile Library CSS -->
		<link rel="stylesheet" type="text/css" href="/repository2/jqm142/jquery.mobile-1.4.2.min.css" />
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
					<?php $traduttore->html('Dettagli Album') ?> 
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
					<div>
						<label for="iAlbum"><?php $traduttore->html('Album') ?></label>
						<input type="text" name="iAlbum" id="iAlbum" value="<?php echo $html['nomeAlbum']?>" readonly>
					</div>
					<div class="<?php echo $displayNone ?>">
						<label for="iAnno"><?php $traduttore->html('Anno di pubblicazione') ?></label>
						<input type="number" name="iAnno" id="iAnno" value="<?php echo $html['annoPubblicazione']?>" readonly>
					</div>
					<div>
						<label for="iCompositore"><?php $traduttore->html('Compositore') ?></label>
						<input type="text" name="nomeCompositore" id="nomeCompositore" value="<?php echo $htmlUtente['nome'].' '.$htmlUtente['cognome'] ?>" readonly>
					</div>
					<div>
						<input type="hidden" name="iCompositore" id="iCompositore" value="<?php echo $html['idUtente'] ?>" readonly>
					</div>
				</div>
				<br>
				<br>
				<!-- Btn Modifica -->
				<div class="<?php echo $displayNone ?>">
					<a onclick="openData('<?php echo $idAlbum ?>','modificaAlbum.php','dettagliAlbum.php')"><button type="button"><?php $traduttore->html('Modifica') ?></button></a>
				</div>
				<br>
				<!-- Elimina album -->
				<div class="<?php echo $displayNone ?>" style="float:right;">
					<a onclick="openData('<?php echo $idAlbum ?>','confEliminaAlbum.php','dettagliAlbum.php')"><?php $traduttore->html('Elimina album') ?></a>
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
						<?php $traduttore->html('Dettagli Album') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>
