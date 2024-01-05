<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("ALB_000_004", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("ALB_000_004", "IT", __FILE__);
	
	$idUtente = $_SESSION['idUtente'];
	$home = $_SESSION['home'];
	$sql = " SELECT nome, cognome, email FROM utenti WHERE idUtente = '$idUtente' AND validate = 1";
	$album = "	SELECT idAlbum, nomeAlbum
				FROM	album 
				WHERE idUtente = $idUtente AND validate = 1 AND nomeAlbum != 'Singolo_$idUtente'
				ORDER BY album.annoPubblicazione DESC";
	$query = ntxQuery($sql);
	$queryAlbum = ntxQuery($album);
	while($rs=ntxRecord($query))
	{
		foreach($rs as $k=>$v)
		$html[$k] = htmlentities($v);
	}
	
	$nome = $html['nome'];
	$cognome = $html['cognome'];
	$email = $html['email'];
	while($rs=ntxRecord($queryAlbum))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
			
		$listaAlbum .= "<li><a onclick='openData(\"$html[idAlbum]\",\"dettagliAlbum.php\",\"listaAlbum.php\")'>$html[nomeAlbum]</a></li>";
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
		<script>
			/*
			$('#closeHelpDiv').click(function(){
				$( "#divMessage" ).effect( "explode",{pieces: 4},5000);
			});
			
			$('#closeHelpDiv').click(function(){
				$( "#overlay" ).effect( "explode",{pieces: 4},5000);
			});
			*/
		</script>
	
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
					<a onclick="openPage('aggiungiAlbum.php','listaAlbum.php')">
						<?php $traduttore->html('Aggiungi') ?>
					</a>
				</div>
				<div>
					<label class="lista" for="iAlbum"><?php $traduttore->html('Lista Album') ?></label>
					<ul data-role="listview" data-filter="true" data-filter-placeholder="<?php $traduttore->html('Cerca album...') ?>" data-inset="true" name="iAlbum">
						<?php
							echo $listaAlbum;
						?>
					</ul>
				</div>
				<div class="float_right" style="width:auto">
					<a onclick="openPage('aggiungiAlbum.php','listaAlbum.php')">
						<?php $traduttore->html('Aggiungi') ?>
					</a>
				</div>
			</div><!-- /content -->
		</div><!-- /page -->
		<div class="overlay" id="overlay" style="display:none;"></div>
		<div id=divMessage style="display:none" class="modal">
			<div id=divMessage2 style="text-align:center" class="modal-content">
				<div id="closeHelpDiv" style="text-align:right">
					<img onclick="closeHelp()" src="../css\themes\images\icons-png\delete-black.png" alt="Chiudi" class="closeHelp" />
				</div> 
				<div id="messaggioVero">
					<p>
						<?php $traduttore->html('Lista degli album presenti') ?> <br><?php $traduttore->html('( usare la ricerca per filtrarli )') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>