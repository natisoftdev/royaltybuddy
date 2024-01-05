<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("ACC_000_001", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("ACC_000_001", "IT", __FILE__);
	
	$idUtente = $_SESSION['idUtente'];
	$home = '../home/'.$_SESSION['home'];
	
	$sql = "SELECT  idUtente, nome, cognome, dataNascita, pseudonimo, 
					email, biografia, citta, stato, 
					compositore, esecutore, casaEditrice, 
					codiceFiscale, partitaIVA, genereMusicale, strumentoMusicale
			FROM         utenti
			WHERE idUtente = '$idUtente' 
			AND validate = 1 ";
		
	$query = ntxQuery($sql);
	$html = array();
	$htmlTot = array();
	
	while($rs=ntxRecord($query))
	{
		$rs[dataNascita] = ntxDate($rs[dataNascita]);
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}
	
	//nome
	$nome = $html['nome'];
	//cognome
	$cognome = $html['cognome'];
	//dataNascita
	$dataNascita = $html['dataNascita'];
	//pseudonimo
	$pseudonimo = $html['pseudonimo'];
	//email
	$email = $html['email'];
	//biografia
	$biografia = $html['biografia'];
	//citta
	$citta = $html['citta'];
	//stato
	$stato = $html['stato'];
	//compositore
	$compositore = $html['compositore'];
	//esecutore
	$esecutore = $html['esecutore'];
	//casaEditrice
	$casaEditrice = $html['casaEditrice'];
	//codiceFiscale
	$codiceFiscale = $html['codiceFiscale'];
	//partitaIVA
	$partitaIVA = $html['partitaIVA'];
	//genereMusicale
	$genereMusicale = $html['genereMusicale'];
	//strumentoMusicale
	$strumentoMusicale = $html['strumentoMusicale'];
	//validate
	$validate = $html['validate'];
	
	$tipPro = "";
	//Controllo la tipologia del profilo
	if($compositore == 1 && $esecutore == 0 && $casaEditrice == 0) {
		$tipPro = 'Compositore';
	}
	elseif($compositore == 0 && $esecutore == 1 && $casaEditrice == 0) {
		$tipPro = 'Esecutore';
	}
	elseif($compositore == 1 && $esecutore == 1 && $casaEditrice == 0) {
		$tipPro = 'Compositore e Esecutore';
	}
	
	//Query per ricavare il nome della città
	$cittaQ = " SELECT nomeCitta FROM citta WHERE idCitta = $citta";
	$nomeCitta = ntxScalar($cittaQ);
	
	$nomeG = ntxTraduciCampoTabella("generi", "nomeGenere", "nomeGenere", $_SESSION[NTX_LINGUA_DEST]);
	
	//Query per ricavare il nome del genereMusicale
	$genere = " SELECT $nomeG nomeGenere FROM generi WHERE idGenere = $genereMusicale";
	$nomeGenere = ntxScalar($genere);
	
	//Query per ricavare il nome dello stato
	$statoQ = " SELECT nomeStato FROM stati WHERE siglaStato = '$stato'";
	$nomeStato = ntxScalar($statoQ);
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- my css -->
		<link rel="stylesheet" type="text/css" href="../css/template.css?vers=<?php echo $vers ?>" />
		<!-- JQuery Mobile Library CSS -->
		<link rel="stylesheet" type="text/css" href="/repository2/jqm142/jquery.mobile-1.4.2.min.css" />
		<!-- JQuery Library JS -->
		<script src="/repository2/jqm142/jquery-1.11.0.min.js"></script>
		<script src="/repository2/jqm142/jquery.mobile-1.4.2.min.js"></script>
		<script src="/repository/libs/jhp/jhp-1.5.1.min.js"></script>
		<!-- my js -->
		<script src="js/index.js?vers=<?php echo $vers ?>" ></script>
		<script src="../js/index.js?vers=<?php echo $vers ?>"></script>
		
	</head>
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					<?php $traduttore->html('Account') ?>
				</h1>
				<a onclick="openHome('<?php echo "../home/".$home ?>')" data-ajax="false" data-icon="arrow-l" data-iconpos="notext" >
					Back
				</a>
				<a onclick="openPage('alertLogout.php','account.php')" data-ajax="false" data-icon="power" data-iconpos="notext" >
					Exit
				</a>
			</div><!-- /header -->
			<div role="main" class="ui-content" data-theme="a">
				<!-- Img -->
				<div style="text-align:center">
					<img src="../img/img_profilo.jpg" alt="Img Profilo" height="100" width="100">
				</div>
				<br>
				<!-- Lista Campi -->
				<div>
					<div>
						<label for="iNome"><?php $traduttore->html('Nome') ?></label>
						<input type="text" name="iNome" id="iNome" value="<?php echo $nome ?>" readonly>
					</div>
					<div>
						<label for="iCognome"><?php $traduttore->html('Cognome') ?></label>
						<input type="text" name="iCognome" id="iCognome" value="<?php echo $cognome ?>" readonly>
					</div>
					<div>
						<label for="iDataNascita"><?php $traduttore->html('Data di nascita') ?></label>
						<input type="text" name="iDataNascita" id="iDataNascita" value="<?php echo $dataNascita ?>" readonly>
					</div>
					<div>
						<label for="iPseudonimo"><?php $traduttore->html('Pseudonimo') ?></label>
						<input type="text" name="iPseudonimo" id="iPseudonimo" value="<?php echo $pseudonimo ?>" readonly>
					</div>
					<div>
						<label for="iEmail"><?php $traduttore->html('Email') ?></label>
						<input type="text" name="iEmail" id="iEmail" value="<?php echo $email ?>" readonly>
					</div>
					<div>
						<label for="iBiografia"><?php $traduttore->html('Biografia') ?></label>
						<textarea rows="4" cols="50" name="iBiografia" id="iBiografia" value="" readonly><?php echo $biografia ?></textarea>
					</div>
					<div>
						<label for="iStato"><?php $traduttore->html('Stato') ?></label>
						<input type="text" name="iStato" id="iStato" value="<?php echo $nomeStato ?>" readonly>
					</div>
					<div>
						<label for="iCitta"><?php $traduttore->html('Città') ?></label>
						<input type="text" name="iCitta" id="iCitta" value="<?php echo $nomeCitta ?>" readonly>
					</div>
					<div>
						<label for="iTipPro"><?php $traduttore->html('Tipo profilo') ?></label>
						<input type="text" name="iTipPro" id="iTipPro" value="<?php echo $tipPro ?>" readonly>
					</div>
					<div>
						<label for="iCF"><?php $traduttore->html('Codice fiscale') ?></label>
						<input type="text" name="iCF" id="iCF" value="<?php echo $codiceFiscale ?>" readonly>
					</div>
					<div>
						<label for="iPIVA"><?php $traduttore->html('Partita IVA') ?></label>
						<input type="text" name="iPIVA" id="iPIVA" value="<?php echo $partitaIVA ?>" readonly>
					</div>
					<div>
						<label for="iGenMus"><?php $traduttore->html('Genere musicale') ?></label>
						<input type="text" name="iGenMus" id="iGenMus" value="<?php echo $nomeGenere ?>" readonly>
					</div>
					<div>
						<label for="iStruMus"><?php $traduttore->html('Strumento musicale') ?></label>
						<input type="text" name="iStruMus" id="iStruMus" value="<?php echo $strumentoMusicale ?>" readonly>
					</div>
				</div>
				<br>
				<br>
				<!-- Btn Modifica -->
				<div>
					<a onclick="openPage('modificaAccount.php','account.php')"><button type="button"><?php $traduttore->html('Modifica') ?></button></a>
				</div>
				<br>
				<!-- Elimina account -->
				<div class="float_right">
				  <a onclick="openPage('confEliminaAccount.php','account.php')"><?php $traduttore->html('Elimina account') ?></a>
				</div>
			</div>
	</div><!-- /page -->
	
	<?php $traduttore->Salva() ?>
	
</body>
</html>