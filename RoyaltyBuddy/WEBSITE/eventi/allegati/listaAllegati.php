<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	
	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("EVE_ALL_004", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("EVE_ALL_004", "IT", __FILE__);
	
	var_dump($_SESSION);
	
	$idUtente = $_SESSION['idUtente'];
	$idEvento = $_SESSION['idSelect'];
	$home = $_SESSION['home'];
	
	$sql = " SELECT nome, cognome, email FROM utenti WHERE idUtente = '$idUtente' AND validate = 1";
	$sql2 = " SELECT pathHTML FROM _pathPortale";
	$sql3 = "SELECT idAllegatiEvento, pathAllegato, descrizione FROM allegati_evento WHERE evento = $idEvento AND validate = 1";

	$query = ntxQuery($sql);
	$query3 = ntxQuery($sql3);
	
	$pathS = ntxScalar($sql2);
	
	while($rs=ntxRecord($query))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}

	while($rs=ntxRecord($query3))
	{
		foreach($rs as $k=>$v)
			$htmlI[$k] = htmlentities($v);
			$idImg[] .= $htmlI[idAllegatiEvento];
			$nameImg[] .= $htmlI[pathAllegato];
			$descImg[] .= $htmlI[descrizione];
			$path[] .= $pathS.$htmlI[pathAllegato];	
	}
	
	$size = (int)(count($path));
	$c = $size/2;
	//var_dump("Size: ".$size);
	//var_dump("C: ".$c);
	//var_dump("Size%2: ".($size%2));

	if( (($size%2) != 0) && (($size%2) != 1) ){
		$c += 2;
	}
	
	for($i = 0;$i < $size;$i += 2){
		//var_dump("Ciclo");
		//var_dump($i);
		//var_dump($path[$i]);
		//var_dump($path[($i+1)]);
		$tr = "
		<tr>
			<td width='50%'><a href='dettagliAllegato.php?id=".$idImg[$i]."' ><img src='".$path[$i]."' alt='Img 4' height='auto' width='100%'></td>
		";
		if($path[($i+1)] != null){
			$tr .= "
				<td width='50%'><a href='dettagliAllegato.php?id=".$idImg[($i+1)]."' ><img src='".$path[($i+1)]."' alt='Img 1' height='auto' width='100%'></td>	
			";
		}
		$table .= $tr."</tr>";
	}
	
	if(!($size >= 6)){
		$aggiungiAllegato = 
		'
			<div class="float_right" style="width:auto">
				<a onclick="openData('.$idEvento.',\'aggiungiAllegato.php\',\'listaAllegati.php\')">'.
					 $traduttore->traduci('Aggiungi').'
				</a>
			</div>
		';
	}
	
	$nome = $html['nome'];
	$cognome = $html['cognome'];
	$email = $html['email'];
	
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
		<link rel="stylesheet" href="../../css/template.css?vers=<?php echo $vers ?>" />
		<link href="../../css/modal.css?ver=<?php echo $vers ?>" rel="stylesheet" type="text/css">
		<!-- ManPro.NEt CSS -->
		<link href="/repository/css/grid-2.0.0.css?vers=<?php echo $vers ?>" rel="stylesheet" type="text/css">
		<!-- JQuery Mobile Library CSS -->
		<link rel="stylesheet" href="/repository2/jqm142/jquery.mobile-1.4.2.min.css" />
		<!-- JQuery Library JS -->
		<script src="/repository2/jqm142/jquery-1.11.0.min.js"></script>
		<script src="/repository2/jqm142/jquery.mobile-1.4.2.min.js"></script>
		<script src="/repository/libs/jhp/jhp-1.5.1.min.js"></script>
		<!-- my js -->
		<script src="../js/index.js?vers=<?php echo $vers ?>"></script>
		<script src="../../js/index.js?vers=<?php echo $vers ?>"></script>
	</head>
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					Royalty Buddy
				</h1>
				<a href="<?php echo "../dettagliEvento.php" ?>" data-ajax="false" data-icon="arrow-l" data-iconpos="notext" >
					Back
				</a>
				<a onclick="openHelp()"
					data-icon="info" data-iconpos="notext">
					Help
				</a>
			</div><!-- /header -->
			<div role="main" class="ui-content">
				<?php
					echo $aggiungiAllegato;
				?>
				<div>
					<label for="iGalleria" ><?php $traduttore->html('Lista Allegati') ?></label>
					<p><?php $traduttore->html('( selezionare immagine per vedere i dettagli e/o modificarla )') ?></p>
					<table width="100%" name="iGalleria">
						<?php echo $table ?>
					</table>
				</div>
				<br>
				<?php
					echo $aggiungiAllegato;
				?>
			</div><!-- /content -->
		</div><!-- /page -->
		<div class="overlay" id="overlay" style="display:none;"></div>
		<div id=divMessage style="display:none" class="modal">
			<div id=divMessage2 style="text-align:center" class="modal-content">
				<div style="text-align:right">
					<img onclick="closeHelp()" src="../../css\themes\images\icons-png\delete-black.png" alt="Chiudi" class="closeHelp" />
				</div>
				<div id="messaggioVero">
					<p>
						<?php $traduttore->html('Galleria degli allegati dell\'evento') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>
