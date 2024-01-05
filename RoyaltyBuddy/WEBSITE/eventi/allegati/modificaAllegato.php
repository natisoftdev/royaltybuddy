<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	
	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("EVE_ALL_005", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("EVE_ALL_005", "IT", __FILE__);
	
	//var_dump($_SESSION);
	
	$next = $_SESSION['back'];
	$back = $_SESSION['page'];
	$idAllegato = $_SESSION['idSelectAllegato'];
	$sql3 = "SELECT pathAllegato, descrizione, evento FROM allegati_evento WHERE idAllegatiEvento = $idAllegato AND validate = 1";
	$query3 = ntxQuery($sql3);
	
	while($rs=ntxRecord($query3))
	{
		foreach($rs as $k=>$v)
			$htmlImg[$k] = htmlentities($v);
	}
	
	function multiexplode ($delimiters,$string) {	
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return  $launch;
	}
	
	$pathAllegato = multiexplode( array( '\\' , "." ) , $htmlImg['pathAllegato'] );
	$pathAllegato = $pathAllegato[ ( count($pathAllegato) -2 ) ];
	$path = "../../tmp/".$htmlImg['pathAllegato'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- my css -->
		<link rel="stylesheet" href="../../css/template.css?vers=<?php echo $vers ?>" />
		<link rel="stylesheet" href="../css/style.css?vers=<?php //echo $vers ?>" />
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
		<script src="js/scriptAllegati.js?vers=<?php echo $vers ?>"></script>
	</head>
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					<?php $traduttore->html('Modifica Allegato') ?> 
				</h1>
				<a onclick="openPage('<?php echo $next ?>?id=<?php echo $idAllegato ?>','<?php echo $back ?>')" data-ajax="false" data-icon="arrow-l" data-iconpos="notext" >
					Back
				</a>
				<a onclick="openHelp()"
					data-icon="info" data-iconpos="notext">
					Help
				</a>
			</div><!-- /header -->
			<div data-role="main" class="ui-content" data-theme="a">
				<!-- Lista Campi -->
				<form name="formModAllegato" method="post" enctype="multipart/form-data" action="uploadAllegatoMod.php" target="dettagliAllegato.php">
					<div>
						<div>
							<input type="hidden" name="iEvento" id="iEvento" value="<?php echo $htmlImg['evento'] ?>" readonly>
						</div>
						<div>
							<label for="iNomeAllegato"><?php $traduttore->html('Nome file') ?></label>
							<input type="text" name="iNomeAllegato" id="iNomeAllegato" value="<?php echo $pathAllegato ?>" readonly>
						</div>
						<div>
							<label for="iDescrizione"><?php $traduttore->html('Descrizione') ?></label>
							<textarea rows="4" cols="50" name="iDescrizione" id="iDescrizione"><?php echo $htmlImg['descrizione'] ?></textarea>
						</div>
					</div>
					<br>
					<!-- Btn Sostituisci Img -->
					<div>
						<input type="file" id="fileToUpload" name="fileToUpload" accept="image/*"/>
						<div id="progress_bar"><div class="percent">0%</div></div>
						<!-- Funzione che mi consente di leggere img e sostituirla con quella già presente -->
						<script>
							//var reader;
							var progress = document.querySelector('.percent');
							
							function handleFileSelect(evt) {
								var files = evt.target.files; // FileList object
								// Loop through the FileList and render image files as thumbnails.
								for (var i = 0, f; f = files[i]; i++) {
									// Only process image files.
									if (!f.type.match('image.*')) {
										continue;
									}
									var reader = new FileReader();
									// Closure to capture the file information.
									reader.onload = (function(theFile) {
										return function(e) {
											var img = document.getElementById('imgAllegato');
											img.innerHTML = ['<img height="auto" width="100%" src="', e.target.result,
												'" title="', escape(theFile.name), '"/>'].join('');
										};
									})(f);
									// Read in the image file as a data URL.
									reader.readAsDataURL(f);
								}
							}
							//All'azione 'change' aggiungo un evento per la selezione della immagine e la rispettiva sostituzione nel tag img
							document.getElementById('fileToUpload')
								.addEventListener('change', handleFileSelect, false);
							//Visualizzo lo stato di caricamento della img
							document.getElementById('fileToUpload')
								.addEventListener('change', handleFileSelect2, false);
								
							var messaggi = {
								noFile: "<?php $traduttore->js('File non trovato') ?>",
								noLeggibile: "<?php $traduttore->js('File non leggibile') ?>",
								erroreLettura: "<?php $traduttore->js('Errore riscontrato nella lettura del file') ?>",
								cancellaLettura: "<?php $traduttore->js('Lettura file cancellata') ?>"
							};
						</script>
					</div>
					<br>
					<div id="imgAllegato">
						<img src="<?php echo $path . "?" . $vers ?>" alt="Img 2" height="auto" width="100%">
					</div>
					<br>
					<br>
					<!-- Btn Salva -->
					<div>
						<input type="submit" value="<?php $traduttore->html('Salva') ?>">
					</div>
					<br>
				</form>
			</div>
		</div><!-- page -->
		<div class="overlay" id="overlay" style="display:none;"></div>
		<!-- Div per messaggio info -->
		<div id=divMessage style="display:none" class="modal">
			<div id=divMessage2 style="text-align:center" class="modal-content">
				<div style="text-align:right">
					<img onclick="closeHelp()" src="../../css\themes\images\icons-png\delete-black.png" alt="Chiudi" class="closeHelp" />
				</div>
				<div id="messaggioVero">
					<p>
						<?php $traduttore->html('Modificare le informazioni dell\'allegato') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>