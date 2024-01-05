<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("ACC_000_004", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("ACC_000_004", "IT", __FILE__);
	
	$idUtente = $_SESSION['idUtente'];
	$home = $_SESSION['home'];
	
	$sql = "SELECT  idUtente, nome, cognome, dataNascita, pseudonimo, 
					email, password, biografia, citta, stato, 
					compositore, esecutore, casaEditrice, 
					codiceFiscale, partitaIVA, genereMusicale, strumentoMusicale
			FROM         utenti
			WHERE idUtente = '$idUtente' 
			AND validate = 1 ";
		
	$query = ntxQuery($sql);
	$html = array();
		
	while($rs=ntxRecord($query))
	{
		$rs[dataNascita] = ntxDateT($rs[dataNascita]);
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
	//password
	$password = $html['password'];
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
		$selComp = 'selected';
		$selEsec = '';
		$selCompEsec = '';
	}
	elseif($compositore == 0 && $esecutore == 1 && $casaEditrice == 0) {
		$tipPro = 'Esecutore';
		$selEsec = 'selected';
		$selComp = '';
		$selCompEsec = '';
	}
	elseif($compositore == 1 && $esecutore == 1 && $casaEditrice == 0) {
		$tipPro = 'Compositore e Esecutore';
		$selCompEsec = 'selected';
		$selEsec = '';
		$selComp = '';
	}
	
	$nomeGenere  = ntxTraduciCampoTabella("generi", "nomeGenere", "nomeGenere", $_SESSION[NTX_LINGUA_DEST]);
	
	$stati = " SELECT siglaStato, nomeStato FROM stati order by nomeStato";
	$generi = " SELECT idGenere, $nomeGenere nomeGenere FROM generi";
	$queryStati = ntxQuery($stati);
	$queryGeneri = ntxQuery($generi);
	
	while($rs=ntxRecord($queryStati))
	{
		$html = array();
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);

		if($html[siglaStato] == $stato){
			$selectStati .= "<option selected='selected' value='$html[siglaStato]'>$html[nomeStato]</option>";
			$statoD = $html[siglaStato];
		}
		else{
			$selectStati .= "<option value='$html[siglaStato]'>$html[nomeStato]</option>";
		}
	}
		
	while($rs=ntxRecord($queryGeneri))
	{
		$html = array();
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
		
		if($html[idGenere] == $genereMusicale){
			$selectGeneri .= "<option selected='selected' value='$html[idGenere]'>$html[nomeGenere]</option>";
		}
		else{
			$selectGeneri .= "<option value='$html[idGenere]'>$html[nomeGenere]</option>";
		}
	}
	
	$cittaQ = "SELECT idCitta, nomeCitta FROM citta WHERE siglaStato = '$statoD'";
	$queryCitta = ntxQuery($cittaQ);
	
	while($rs=ntxRecord($queryCitta))
	{
		$html = array();
	
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
		
		if($html[idCitta] == $citta){
			$selectCitta .= "<option selected='selected' value='$html[idCitta]'>$html[nomeCitta]</option>";
		}
		else{
			$selectCitta .= "<option value='$html[idCitta]'>$html[nomeCitta]</option>";
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- my css -->
		<link rel="stylesheet" type="text/css" href="../css/template.css?vers=<?php echo $vers ?>" />
		<link rel="stylesheet" type="text/css" href="../css/modal.css?ver=<?php echo $vers ?>" />
		<link rel="stylesheet" type="text/css" href="css/style.css?vers=<?php echo $vers ?>" />
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
			// Variabili di appoggio
			var listaCitta;
			//var flag = false;

			function changeListaCitta(){
				var statoB = false;
				
				var selectBox = document.getElementById("iStato");
				var stato = selectBox.options[selectBox.selectedIndex].value;
				//alert(stato);
				if(stato == ""){
					statoB = false;
					alert("<?php $traduttore->js('Attenzione! Selezionare Stato di appartenenza') ?>");
				}
				else{
					statoB = true;
					var result = jhp("jhp/jhp_listaCitta.php", { stato : stato });
					listaCitta = '<option value=""><?php $traduttore->traduci('Scegli') ?></option>'+result.value;
					document.getElementById("iCitta").innerHTML = listaCitta;
					$('#zonaCitta span').text("Scegli");
				}
			}
			
			var messaggi = {
				campoNomeVuoto: "<?php $traduttore->js('Attenzione! Campo nome vuoto!') ?>",
				campoCognomeVuoto: "<?php $traduttore->js('Attenzione! Campo cognome vuoto!') ?>",
				campoEmailNoCorretto: "<?php $traduttore->js('Attenzione! Campo email non corretto!') ?>",
				accountEsistente: "<?php $traduttore->js('Attenzione! Esiste già un\'account associata a questa email') ?>",
				campoEmailVuoto: "<?php $traduttore->js('Attenzione! Campo email vuoto!') ?>",
				campoStatoVuoto: "<?php $traduttore->js('Attenzione! Campo stato vuoto!') ?>",
				campoCittaVuoto: "<?php $traduttore->js('Attenzione! Campo città vuoto!') ?>",
				campoGenereVuoto: "<?php $traduttore->js('Attenzione! campo genere musicale') ?>"
			};
		</script>
	</head>
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					<?php $traduttore->html('Modifica Account') ?> 
				</h1>
				<a href="<?php echo $_SESSION['back'] ?>" data-ajax="false" data-icon="arrow-l" data-iconpos="notext" >
					Back
				</a>
				<a onclick="openHelp()"	data-icon="info" data-iconpos="notext">
					Help
				</a>
			</div><!-- /header -->
			<!-- Contenuto della pagina -->
			<div role="main" class="ui-content" data-theme="a">
				<!-- Lista Campi -->
				<form name="formModAccount" method="post">
					<div>
						<p class="campiOblg"><?php $traduttore->html('L\'asterisco (*) indica i campi obbligatori') ?> </p>
					</div>
					<!-- Lista Campi -->
					<div>
						<div>
							<label for="iNome"><?php $traduttore->html('Nome') ?> *</label>
							<input type="text" class="capitalize" name="iNome" id="iNome" value="<?php echo $nome ?>" >
						</div>
						<div>
							<label for="iCognome"><?php $traduttore->html('Cognome') ?> *</label>
							<input type="text" class="capitalize" name="iCognome" id="iCognome" value="<?php echo $cognome ?>" >
						</div>
						<div>
							<label for="iDataNascita"><?php $traduttore->html('Data di nascita') ?> *</label>
							<input type="date" name="iDataNascita" id="iDataNascita" value="<?php echo $dataNascita ?>" >
						</div>
						<div>
							<label for="iPseudonimo"><?php $traduttore->html('Pseudonimo') ?></label>
							<input type="text" name="iPseudonimo" id="iPseudonimo" value="<?php echo $pseudonimo ?>" >
						</div>
						<div>
							<label for="iEmail"><?php $traduttore->html('Email') ?> *</label>
							<input type="email" name="iEmail" id="iEmail" value="<?php echo $email ?>" >
						</div>
						<div>
							<label for="iBiografia"><?php $traduttore->html('Biografia') ?></label>
							<textarea rows="4" cols="50" name="iBiografia" id="iBiografia" value="" ><?php echo $biografia ?></textarea>
						</div>
						<div>
							<label for="iStato"><?php $traduttore->html('Stato') ?> *</label>
							<select name="iStato" id="iStato" onchange="changeListaCitta();">
								<option value=""><?php $traduttore->html('Scegli') ?></option>
								<?php
									echo $selectStati;
								?>
							</select>
						</div>
						<div id="zonaCitta">
							<label for="iCitta"><?php $traduttore->html('Città') ?> *</label>
							<select name="iCitta" id="iCitta">
								<option value=""><?php $traduttore->html('Scegli') ?></option>
								<?php
									echo $selectCitta;
								?>
							</select>
						</div>
						<div>
							<label for="iTipPro"><?php $traduttore->html('Tipo profilo') ?> </label>
							<select name="iTipPro" id="iTipPro" disabled>
								<option value="compositore" <?php echo $selComp ?>><?php $traduttore->html('Compositore') ?></option>
								<option value="esecutore" <?php echo $selEsec ?>><?php $traduttore->html('Esecutore') ?></option>
								<option value="comp_esec" <?php echo $selCompEsec ?>><?php $traduttore->html('Compositore e Esecutore') ?></option>
							</select>
						</div>
						<div>
							<label for="iCF"><?php $traduttore->html('Codice fiscale') ?></label>
							<input type="text" name="iCF" id="iCF" value="<?php echo $codiceFiscale ?>" >
						</div>
						<div>
							<label for="iPIVA"><?php $traduttore->html('Partita IVA') ?></label>
							<input type="text" name="iPIVA" id="iPIVA" value="<?php echo $partitaIVA ?>" >
						</div>
						<div>
							<label for="iGenMus"><?php $traduttore->html('Genere musicale') ?> *</label>
							<select name="iGenMus" id="iGenMus" data-overlay-theme="b">
								<option value=""><?php $traduttore->html('Scegli') ?></option>
								<?php
									echo $selectGeneri;
								?>
							</select>
						</div>
						<div>
							<label for="iStruMus"><?php $traduttore->html('Strumento musicale') ?></label>
							<input type="text" name="iStruMus" id="iStruMus" value="<?php echo $strumentoMusicale ?>" >
						</div>
					</div>
					<br>
					<br>
					<!-- Btn Modifica -->
					<div>
						<input type="submit" name="iSalva" id="iSalva" value="<?php $traduttore->html('Salva') ?>" onclick="modAccount(formModAccount)" />
					</div>
				</form>
			</div>
		</div><!-- /page -->
		<div class="overlay" id="overlay" style="display:none;"></div>
		<div id=divMessage style="display:none" class="modal">
			<div id=divMessage2 style="text-align:center" class="modal-content">
				<div style="text-align:right">
					<img onclick="closeHelp()" src="../css\themes\images\icons-png\delete-black.png" alt="Chiudi" class="closeHelp" />
				</div> 
				<div id="messaggioVero">
					<p>
						<?php $traduttore->html('Modificare le proprie informazioni personali') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>