<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("INF_000_001", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("INF_000_001", "IT", __FILE__);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- my css -->
		<link rel="stylesheet" href="../css/template.css?vers=<?php echo $vers ?>" />
		<link rel="stylesheet" href="css/style.css?vers=<?php echo $vers ?>" />
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
		<div data-role="page" class="sfondo">
			<div role="main" class="ui-content centrato">
				<!-- Img -->
				<div style="text-align:center">
					<img src="../img/logo.jpg" alt="Img Logo" height="150" width="auto">
				</div>
				<div style="text-align:center">
					<p><?php $traduttore->html('Versione') ?>: <b>1.9.9</b></p>
				</div>
				<div style="text-align:center">
					<p><?php $traduttore->html('Sviluppata da') ?>:</p>
					<a href="http://www.natisoft.it/">
						<img src="../img/natisoft.jpg" alt="Img Logo Azienda" height="auto" width="150">
					</a>
				</div>
				<div class="copyright">
					<p>Copyright &copy; 2018 ROYALTYBUDDY LLC.</p>
					<p><?php $traduttore->html('Tutti i diritti sono riservati') ?></p>
					<a href="mailto:malferrari.natisoft@gmail.com"><b>info@royaltybuddy.com</b></a>				
				</div>
			</div><!-- /content -->
		</div><!-- /page -->
		<?php $traduttore->Salva() ?>
	</body>
</html>