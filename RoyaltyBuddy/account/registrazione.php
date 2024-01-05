<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	$stati = " SELECT siglaStato, nomeStato FROM stati order by nomeStato";
	$generi = " SELECT idGenere, nomeGenere FROM generi order by nomeGenere";
	$queryStati = ntxQuery($stati);
	$queryGeneri = ntxQuery($generi);
	
	while($rs=ntxRecord($queryStati))
	{
		$html = array();
	
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);

		$selectStati .= "<option value='$html[siglaStato]'>$html[nomeStato]</option>";
		
	}
	
	while($rs=ntxRecord($queryGeneri))
	{
		$html = array();
	
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
			
		$selectGeneri .= "<option value='$html[idGenere]'>$html[nomeGenere]</option>";
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
		<script src="/repository/libs/jhp/jhp-1.5.1.min.js"></script>
		<!-- my js -->
		<script src="js/index.js?vers=<?php echo $vers ?>"></script>
		<script src="../js/index.js?vers=<?php echo $vers ?>"></script>
		<script>
			// Variabili di appoggio
			var listaCitta;
			var flag = false;

			$(document).ready(function() {
				if(flag == false){
					flag = true;
					$('#iCitta').selectmenu('disable');
				}
				else{
					changeListaCitta();
					flag = true;
				}
			});

			function changeListaCitta(){
				var statoB = false;
				
				var selectBox = document.getElementById("iStato");
				var stato = selectBox.options[selectBox.selectedIndex].value;
				
				if(stato == ""){
					statoB = false;
					alert("Attenzione!! Selezionare Stato di appartenenza");
				}
				else{
					statoB = true;
					var result = jhp("jhp/jhp_listaCitta.php", { stato : stato });
					//result corrisponde ad array di città che hanno lo stato in comune
					
					listaCitta = '<option value="">Scegli</option>'+result.value;
					document.getElementById("iCitta").innerHTML = listaCitta;
					
					$('#iCitta').selectmenu('enable');
				}
			}
		</script>
	</head>
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					Registrazione
				</h1>
				<a href="../login.php" data-ajax="false" data-icon="arrow-l" data-iconpos="notext" >
					Back
				</a>
				<a onclick="openHelp()" data-icon="info" data-iconpos="notext">
					Help
				</a>
			</div><!-- /header -->
			<div role="main" class="ui-content" data-position="fixed">
				<form name="formRegistrazione" method="post">
					<div>
						<p class="campiOblg">L'asterisco (*) indica i campi obbligatori</p>
					</div>
					<!-- Lista Campi -->
					<div>
						<div>
							<div>
								<label for="iNome" >Nome *</label>
								<input class="capitalize" type="text" name="iNome" id="iNome" placeholder="Nome" >
							</div>
						</div>
						<div>
							<label for="iCognome">Cognome *</label>
							<input class="capitalize" type="text" name="iCognome" id="iCognome" placeholder="Cognome" >
						</div>
						<div>
							<label for="iDataNascita">Data di nascita *</label>
							<input type="date" name="iDataNascita" id="iDataNascita" placeholder="dd/mm/yyyy" >
						</div>
						<div>
							<label for="iPseudonimo">Pseudonimo</label>
							<input type="text" name="iPseudonimo" id="iPseudonimo" placeholder="Pseudonimo" >
						</div>
						<div>
							<label for="iEmail">Email *</label>
							<input class="lowercase" type="email" name="iEmailReg" id="iEmailReg" placeholder="Email" >
						</div>
						<div>
							<label for="iPassword">Password *</label>
							<input type="password" name="iPassword" id="iPassword" placeholder="Password" >
						</div>
						<div>
							<label for="iConfPassword">Ripeti password *</label>
							<input type="password" name="iConfPassword" id="iConfPassword" placeholder="Ripeti Password" >
						</div>
						<div>
							<label for="iBiografia">Biografia</label>
							<textarea rows="4" cols="50" name="iBiografia" id="iBiografia" placeholder="Vuoi raccontarci qualcosa?" ></textarea>
						</div>
						<div>
							<label for="iStato">Stato *</label>
							<select name="iStato" id="iStato" onchange="changeListaCitta();">
								<option value="">Scegli</option>
								<?php
									echo $selectStati;
								?>
							</select>
						</div>
						<div>
							<label for="iCitta">Citt&agrave; *</label>
							<select name="iCitta" id="iCitta" >
								<option value="">Scegli</option>
								
							</select>
						</div>
						<div>
							<label for="iTipPro">Tipo profilo *</label>
							<select name="iTipPro" id="iTipPro">
								<option value="compositore">Compositore</option>
								<option value="esecutore">Esecutore</option>
								<option value="comp_esec">Compositore e Esecutore</option>
							</select>
						</div>
						<div>
							<label for="iCF">Codice fiscale</label>
							<input class="uppercase" type="text" name="iCF" id="iCF" placeholder="Codice Fiscale" >
						</div>
						<div>
							<label for="iPIVA">Partita IVA</label>
							<input class="uppercase" type="text" name="iPIVA" id="iPIVA" placeholder="Partita IVA" >
						</div>
						<div>
							<label for="iGenMus">Genere musicale *</label>
							<select name="iGenMus" id="iGenMus" data-overlay-theme="b">
								<option value="">Scegli</option>
								<?php
									echo $selectGeneri;
								?>
							</select>
						</div>
						<div>
							<label for="iStruMus">Strumento musicale</label>
							<input class="capitalize" type="text" name="iStruMus" id="iStruMus" placeholder="Strumento Musicale" >
						</div>
					</div>
					<!-- Btn Salva -->
					<br>
					<br>
					<div>
						<a onclick="registrazione2(formRegistrazione)"><button type="button">Salva</button></a>
					</div>
				</form>
				<br>
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
						Compilare i campi per registrarsi all'applicazione
					</p>
				</div>
			</div>
		</div>
	</body>
</html>