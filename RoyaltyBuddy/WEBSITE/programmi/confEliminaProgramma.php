<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("PRO_000_002", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("PRO_000_002", "IT", __FILE__);
	
	$idProgramma = $_SESSION['idSelect'];
	//var_dump($_SESSION);
	
	$datiProgramma = "	SELECT     	eventi.nomeEvento, scalette.nomeScaletta
						FROM       	programmi 
							INNER JOIN
									eventi ON programmi.evento = eventi.idEvento
							INNER JOIN
									scalette ON programmi.scaletta = scalette.idScaletta
						WHERE programmi.idProgramma = $idProgramma
						AND programmi.validate = 1";
	
	$query = ntxQuery($datiProgramma);
	
	while($rs=ntxRecord($query))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- my css -->
		<link rel="stylesheet" type="text/css" href="../css/template.css?vers=<?php echo $vers ?>" />
		<link rel="stylesheet" type="text/css" href="css/style.css?vers=<?php echo $vers ?>" />
		<link rel="stylesheet" type="text/css" href="../css/modal.css?ver=<?php echo $vers ?>" />
		<!-- JQuery Mobile Library CSS -->
		<link rel="stylesheet" type="text/css" href="/repository2/jqm142/jquery.mobile-1.4.2.min.css" />
		<!-- JQuery Library JS -->
		<script src="/repository2/jqm142/jquery-1.11.0.min.js"></script>
		<script src="/repository2/jqm142/jquery.mobile-1.4.2.min.js"></script>
		<script src="/repository/libs/jhp/jhp-1.5.1.min.js" type="text/javascript"></script>
		<!-- my js -->
		<script src="js/index.js?vers=<?php echo $vers ?>" type="text/javascript"></script>
		<script src="../js/index.js?vers=<?php echo $vers ?>" type="text/javascript"></script>
	</head>
	<body>
		<div data-role="page" data-theme="b">
			<div role="main" class="ui-content" >
				<div style="" class="confEli ui-nodisc-icon alertCancella"><!-- Class added to the wrapper -->
					<p><?php $traduttore->html('Confermare l\'eliminazione del programma') ?> <br><?php $traduttore->html('dell\'evento') ?> <b class="boldElimina"><?php echo $html['nomeEvento'] ?></b> 
						<?php $traduttore->html('con scaletta') ?> <b class="boldElimina"><?php echo $html['nomeScaletta'] ?> </b>?
					</p>
					<a onclick="eliminaProgramma()" class="check ui-btn ui-shadow ui-corner-all ui-icon-check ui-btn-icon-notext ui-btn-b ui-btn-inline">Check</a>
					<a onclick="openBack('<?php echo $_SESSION['back'] ?>')" class="delete ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext ui-btn-b ui-btn-inline">Cancel</a>
				</div>
			</div><!-- /content -->
		</div><!-- /page -->
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>
