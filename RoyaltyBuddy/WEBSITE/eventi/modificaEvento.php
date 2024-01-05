<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("EVE_000_005", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("EVE_000_005", "IT", __FILE__);
	
	$next = "dettagliEvento.php";
	$back = $_SESSION['page'];
	$idEvento = $_SESSION['idSelect'];
	
	//Query per recuperare i dati dell'evento selezionato
	$sql = "SELECT     	nomeEvento, dataEvento, nomeLuogo, tipoLuogo, indirizzo, citta, stato, oraEvento
			FROM       	eventi
			WHERE 		idEvento = '$idEvento' 
			AND validate = 1 ";
	
	$query = ntxQuery($sql);
	
	while($rs=ntxRecord($query))
	{
		$rs[dataEvento] = ntxDateT($rs[dataEvento]);
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}
	
	$hours = floor($html['oraEvento'] / 3600);
	if($hours < 10){
		$hours = "0".$hours;
	}
	$html['oraEvento'] -= $hours * 3600;
	$minutes = floor($html['oraEvento'] / 60);
	if($minutes < 10){
		$minutes = "0".$minutes;
	}
	$html['oraEvento'] -= $minutes * 60;
	
	$html['oraEvento'] = $hours.":".$minutes;
	
	$nomeEvento = $html['nomeEvento'];
	$dataEvento = $html['dataEvento'];
	$oraEvento = $html['oraEvento'];
	$nomeLuogo = $html['nomeLuogo'];
	$tipoLuogo = $html['tipoLuogo'];
	$indirizzo = $html['indirizzo'];
	$citta = $html['citta'];
	$stato = $html['stato'];
		
	//Query per popolare casella a discesa di stati
	$stati = " SELECT siglaStato, nomeStato FROM stati";
	
	$queryStati = ntxQuery($stati);
	
	while($rs=ntxRecord($queryStati))
	{
		$html2 = array();
	
		foreach($rs as $k=>$v)
			$html2[$k] = htmlentities($v);
		
		if($html2[siglaStato] == $stato){
			$selectStati .= "<option selected='selected' value='$html2[siglaStato]'>$html2[nomeStato]</option>";
			$statoD = $html2[siglaStato];
		}
		else{
			$selectStati .= "<option value='$html2[siglaStato]'>$html2[nomeStato]</option>";
		}
	}
	
	//Query per popolare casella a discesa di città
	$cittaQ = " SELECT idCitta, nomeCitta FROM citta WHERE siglaStato = '$statoD' ";
	
	$queryCitta = ntxQuery($cittaQ);
	
	while($rs=ntxRecord($queryCitta))
	{
		$html2 = array();
	
		foreach($rs as $k=>$v)
			$html2[$k] = htmlentities($v);
	
		if($html2[idCitta] == $citta){
			$selectCitta .= "<option selected='selected' value='$html2[idCitta]'>$html2[nomeCitta]</option>";
		}
		else{
			$selectCitta .= "<option value='$html2[idCitta]'>$html2[nomeCitta]</option>";
		}
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- my css -->
		<link href="../css/modal.css?ver=<?php echo $vers ?>" rel="stylesheet" type="text/css">
		<link href="../css/template.css?ver=<?php echo $vers ?>" rel="stylesheet" type="text/css">
		<!-- JQuery Mobile Library CSS -->
		<link rel="stylesheet" href="/repository2/jqm142/jquery.mobile-1.4.2.min.css" />
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
					listaCitta = '<option value="">Scegli</option>'+result.value;
					document.getElementById("iCitta").innerHTML = listaCitta;
					
					$('#zonaCitta span').text("Scegli");
				}
			}
			
			var messaggi = {
				campoEventoVuoto: "<?php $traduttore->js('Attenzione! Campo evento vuoto!') ?>",
				campoDataVuoto: "<?php $traduttore->js('Attenzione! Campo data vuoto!') ?>",
				campoLuogoVuoto: "<?php $traduttore->js('Attenzione! Campo luogo vuoto!') ?>",
				campoTLuogoVuoto: "<?php $traduttore->js('Attenzione! Campo tipo luogo vuoto!') ?>",
				campoIndirizzoVuoto: "<?php $traduttore->js('Attenzione! Campo indirizzo vuoto!') ?>",
				campoCittaVuoto: "<?php $traduttore->js('Attenzione! Campo città vuoto!') ?>",
				campoStatoVuoto: "<?php $traduttore->js('Attenzione! Campo stato vuoto!') ?>"
			};
		</script>
	</head>
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					<?php $traduttore->html('Modifica Evento') ?>
				</h1>
				<a onclick="openPage('<?php echo $next ?>','<?php echo $back ?>')" data-ajax="false" data-icon="arrow-l" data-iconpos="notext" >
					Back
				</a>
				<a onclick="openHelp()"
					data-icon="info" data-iconpos="notext">
					Help
				</a>
			</div><!-- /header -->

			<div role="main" class="ui-content" data-theme="a">
				<!-- Lista Campi -->
				<form name="formModEvento" method="post">
					<div>
						<div>
							<label for="iEvento"><?php $traduttore->html('Evento') ?></label>
							<input type="text" class="capitalize" name="iEvento" id="iEvento" value="<?php echo $nomeEvento ?>" >
						</div>
						<div>
							<label for="iDataEvento"><?php $traduttore->html('Data evento') ?></label>
							<input type="date" name="iDataEvento" id="iDataEvento" value="<?php echo $dataEvento ?>" >
						</div>
						<div>
						<label for="iOra"><?php $traduttore->html('Ora evento (hh:mm)') ?></label>
						<input type="time" name="iOra" id="iOra" value="<?php echo $oraEvento ?>" >
					</div>
						<div>
							<label for="iNomeLuogo"><?php $traduttore->html('Luogo') ?></label>
							<input type="text" name="iNomeLuogo" id="iNomeLuogo" value="<?php echo $nomeLuogo ?>" >
						</div>
						<div>
							<label for="iTipoLuogo"><?php $traduttore->html('Tipo luogo') ?></label>
							<input type="text" name="iTipoLuogo" id="iTipoLuogo" value="<?php echo $tipoLuogo ?>" >
						</div>
						<div>
							<label for="iIndirizzo"><?php $traduttore->html('Indirizzo') ?></label>
							<input type="text" name="iIndirizzo" id="iIndirizzo" value="<?php echo $indirizzo ?>" >
						</div><div>
							<label for="iStato"><?php $traduttore->html('Stato') ?></label>
							<select name="iStato" id="iStato" onchange="changeListaCitta();">
								<option value=""><?php $traduttore->html('Scegli') ?></option>
								<?php
									echo $selectStati;
								?>
							</select>
						</div>
						<div id="zonaCitta">
							<label for="iCitta"><?php $traduttore->html('Città') ?></label>
							<select name="iCitta" id="iCitta">
								<option value=""><?php $traduttore->html('Scegli') ?></option>
								<?php
									echo $selectCitta;
								?>
							</select>
						</div>
					</div>
					<br>
					<br>
					<!-- Btn Modifica -->
					<div>
						<input type="submit" name="iSalva" id="iSalva" value="<?php $traduttore->html('Salva') ?>" onclick="modificaEvento(formModEvento)" />
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
						<?php $traduttore->html('Modificare le informazioni dell\'evento') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>
