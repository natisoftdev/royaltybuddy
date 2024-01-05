<?php
	//Apertura del login la $_SESSION va resettata e settata per il corretto funzionamento dell'app
	$_SESSION = "";
	
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("LOG_000_001", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("LOG_000_001", "IT", __FILE__);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- my css -->
		<link rel="stylesheet" href="css/template.css?vers=<?php echo $vers ?>" />
		<!-- JQuery Mobile Library CSS -->
		<link rel="stylesheet" href="/repository2/jqm142/jquery.mobile-1.4.2.min.css" />
		<!-- JQuery Library JS -->
		<script src="/repository2/jqm142/jquery-1.11.0.min.js"></script>
		<script src="/repository2/jqm142/jquery.mobile-1.4.2.min.js"></script>
		<script src="/repository/libs/jhp/jhp-1.5.1.min.js"></script>
		<!-- my js -->
		<script src="js/index.js?vers=<?php echo $vers ?>"></script>
	</head>
	<body>
		<div data-role="page">
			<div role="main" class="ui-content">
				<br>
				<br>
				<!-- Img -->
				<div style="text-align:center">
					<img src="img/logo.jpg" alt="Img Logo" height="150" width="auto" />
				</div>
				<br>
				<br>
				<!-- Lista Campi -->
				<form id="formLogin" name="formLogin" method="post">
					<div>
						<!-- Campo Email -->
						<div>
							<label for="iemail"><?php $traduttore->html('Email') ?></label>
							<input class="lowercase" type="email" name="iemail" id="iemail" placeholder="email" required/>
						</div>
						<br>
						<!-- Campo Password -->
						<div>
							<label for="ipassword"><?php $traduttore->html('Password') ?></label>
							<input type="password" name="ipassword" id="ipassword" placeholder="password" required/>
						</div>
					</div>
					<br>
					<!-- Btn Login -->
					<div>
						<input type="submit" value="Login" onclick="login(formLogin)" />
					</div>
				</form>
				<br>
				<!-- Btn Registrati -->
				<div style="text-align:center">
					<a onclick="openPage('account/registrazione.php','../login.php')"><?php $traduttore->html('Oppure Registrati') ?></a>
				</div>
				<br>
				<br>
				<!-- Btn Credenziali perse -->
				<!--
				<div class="float_left" style="opacity:0.8">
				  <a onclick="openPage('account/ottieniCredenziali.php','../login.php')"><?php //$traduttore->html('Credenziali perse') ?>?</a>
				</div>
				-->
			</div><!-- /content -->
		</div><!-- /page -->
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>