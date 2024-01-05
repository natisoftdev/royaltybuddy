<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("IMP_000_001", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("IMP_000_001", "IT", __FILE__);
	
	$idUtente = $_SESSION['idUtente'];
	$home = $_SESSION['home'];
	
	$sql = "	SELECT	lingua 
				FROM	utenti
				WHERE idUtente = $idUtente";
	$sqlL = "	SELECT     	lingua
				FROM		Lingue";
		
	$query = ntxQuery($sql);
	$query2 = ntxQuery($sqlL);
		
	while($rs=ntxRecord($query))
	{
		$html = array();
		
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);//lingua dell'utente
		
	}
	
	while($rs=ntxRecord($query2))
	{
		foreach($rs as $k=>$v)
			$arrayLingue[] = htmlentities($v);
		
	}
	
	for ($i = 0; $i <= count($arrayLingue)-1; $i++) {
		
		if($html[lingua] == $arrayLingue[$i]){
			$selectStati .= "<option selected='selected' value='$html[lingua]'>$html[lingua]</option>";
		}
		else{
			$selectStati .= "<option value='$arrayLingue[$i]'>$arrayLingue[$i]</option>";
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
	</head>
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					<?php $traduttore->html('Impostazioni') ?>
				</h1>
				<a onclick="openHome('<?php echo "../home/".$home ?>')" data-ajax="false" data-icon="arrow-l" data-iconpos="notext" >
					Back
				</a>
				<a onclick="openHelp()" data-icon="info" data-iconpos="notext">
					Help
				</a>
			</div><!-- /header -->
			<div role="main" class="ui-content" data-theme="a">
				<div id="lingua" class="lingua">
					<div class="float_left" style=" width:70%;">
							<p class="boldListe"><?php $traduttore->html('Scegliere lingua') ?></p>
					</div>
					<div class="float_left" style=" width:30%;">
						<select name="iLingua" id="iLingua" onchange="cambiaLingua(this)">
							<?php 
								echo $selectStati;
							?>
						</select>
					</div>
					<div class="clear"></div>
				</div>
				<hr>
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
						<?php $traduttore->html('Modificare le impostazioni dell\'applicazione') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>