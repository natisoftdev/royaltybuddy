<?php
	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	//var_dump($_POST);
	//var_dump($_SESSION);
	
	//Dati che devo aver inserito nel DB per corretto completamento
	/*
		[descrizione],
		[nomeAllegato],
		[pathAllegato],
		[evento],
		[dataInserimento],
		[dataUltimaModifica],
		[validate]
	*/
	
	$descrizione = $_POST['iDescrizione'];
	$idEvento =  $_SESSION['idSelect'];
	//In più idUtente per la creazione completa di $pathAllegato
	$idUtente = $_SESSION['idUtente'];

	$queryNumAllegati = <<< query
		SELECT	MAX(nomeAllegato)
		FROM    allegati_evento 
		WHERE evento = $idEvento 
			AND validate = 1
query;

	////jhp_log($queryNumAllegati);
	if($_FILES["fileToUpload"]["name"] != null){//Se IMG
		$num = explode( "_" , ntxScalar( $queryNumAllegati ) );
		$num = $num[1];
		//var_dump($num);
		$nomeAllegato = "allegato_".($num+1);
		$img = basename($_FILES["fileToUpload"]["name"]);
		//var_dump($img);
		$extension = explode(".",$img);
		$extension = $extension[count($extension)-1];
		
		$pathAllegato = $idUtente."\\".$idEvento."\\".$nomeAllegato.".".$extension;
		////jhp_log($pathAllegato);
			
		$query = <<< query
			INSERT INTO allegati_evento
				(descrizione, nomeAllegato, pathAllegato, evento, dataInserimento, dataUltimaModifica, validate)
			VALUES
				('$descrizione',
				'$nomeAllegato',
				'$pathAllegato',
				$idEvento,
				GETDATE(),
				GETDATE(),
				1)
query;

		ntxQuery($query);
		////jhp_log($query);
				
		//Ottengo le due path E:.... e C:....
		$sqlPath = "SELECT pathAllegati, pathTmp FROM _pathPortale";
		$query = ntxQuery($sqlPath);
		
		while($rs=ntxRecord($query))
		{
			foreach($rs as $k=>$v)
				$html[$k] = htmlentities($v);
		}
	}
	else {
		echo "<script>alert('Inserire IMG');</script>";
	}
	
	$flag = false;
	if($_FILES["fileToUpload"]["name"] != null){//Se cambio IMG
		//Copio img in cartelle:
		// E:... e in C:....

		$target_dir = $html['pathTmp'];
		//var_dump("target_dir: ".$target_dir);
		$target_E = $html['pathAllegati'];
		//var_dump("target_E: ".$target_E);
		//$img = basename($_FILES["fileToUpload"]["name"]);
		//var_dump($img);

		// Creo cartella dell'utente se non esiste
		if ( !is_dir($target_dir ."\\".$idUtente) ) mkdir($target_dir ."\\".$idUtente);
		if ( !is_dir($target_E ."\\".$idUtente) ) mkdir($target_E ."\\".$idUtente);

		// Creo cartella dell'evento se non esiste
		if ( !is_dir($target_dir ."\\".$idUtente."\\".$idEvento) ) mkdir($target_dir ."\\".$idUtente."\\".$idEvento);
		if ( !is_dir($target_E ."\\".$idUtente."\\".$idEvento) ) mkdir($target_E ."\\".$idUtente."\\".$idEvento);

		$target_file = $target_dir ."\\".$idUtente."\\".$idEvento."\\".$nomeAllegato.$n .".". $extension; 
		$pathE = $target_E ."\\".$idUtente."\\".$idEvento."\\".$nomeAllegato.$n .".". $extension; 
		
		$fileToUpload_C_tmp_name = $_FILES["fileToUpload"]["tmp_name"];
		$fileToUpload_E_tmp_name = $_FILES["fileToUpload"]["tmp_name"];

		//var_dump($target_file);
		//var_dump($pathE);

		$uploadOk = 1;
		//pathinfo si ferma al primo punto che trova nel file, 
		//non è consapevole realmente delle possibili estensioni dei file
		//$arrTarget_file = explode(".",$target_file);
		//echo "<script>alert('".$arrTarget_file[0]."');</script>";
		//$extensionFile = $arrTarget_file[1];
		//$imageFileType = strtolower($extensionFile);
		//echo "<script>alert('".$extension."');</script>";
		$imageFileType = strtolower($extension);
		//$imageFileType = strtolower(pathinfo($targetF,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($fileToUpload_C_tmp_name);
			if($check !== false) {
				//echo "<script>alert('File is an image - " . $check["mime"] . "');</script>";
				$flag = true;
				$uploadOk = 1;
			} else {
				echo "<script>alert('File is not an image.');</script>";
				$flag = false;
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "<script>alert('Sorry, file already exists.')</script>";
			$flag = false;
			$uploadOk = 0;
		}
		// Check file size
		/*if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "<script>alert('Sorry, your file is too large.')</script>";
			$flag = false;
			$uploadOk = 0;
		}*/
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			//var_dump($arrTarget_file);
			//echo $imageFileType;
			echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
			$flag = false;
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "<script>alert('Sorry, your file was not uploaded.');</script>";
			$flag = false;
		// if everything is ok, try to upload file
		} else {
			if (copy($fileToUpload_C_tmp_name, $target_file)) {
				//echo "<script>alert('The file ". basename($fileToUpload_C_tmp_name). " has been uploaded.')</script>";
				$flag = true;
			} else {
				echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
				$flag = false;
			}
			if (move_uploaded_file($fileToUpload_E_tmp_name, $pathE)) {
				//echo "<script>alert('The file ". basename($fileToUpload_E_tmp_name). " has been uploaded.')</script>";
				$flag = true;
			} else {
				echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
				$flag = false;
			}	
		}
	}
	else{
		$flag = false;
	}
	
	if($flag == true){
			
		$queryNumAllegati = <<< query
			SELECT	MAX(idAllegatiEvento)
			FROM    allegati_evento where evento = $idEvento
query;
		
		$idAllegatiEvento = ntxScalar($queryNumAllegati);
		
		echo "	<script>
					window.location.href = 'dettagliAllegato.php?id=$idAllegatiEvento';
					window.open('','aggiungiAllegato.php').close();
				</script>
			";
		
	}
	else{
		echo "	<script>
					window.location.href = 'aggiungiAllegato.php';
					window.open('','aggiungiAllegato.php').close();
				</script>
			";
	}
?>