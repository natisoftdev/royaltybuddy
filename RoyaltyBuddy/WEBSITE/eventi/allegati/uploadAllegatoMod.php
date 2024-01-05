<?php

	if ( !$_SESSION ) session_start();

	require_once("../../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	/*
	var_dump("POST");
	var_dump($_POST);
	var_dump("SESSION");
	var_dump($_SESSION);
	var_dump("FILES");
	var_dump($_FILES);
	*/
	
	//Dati che devo aver inserito nel DB per corretto completamento
	/*[descrizione]
      ,[nomeAllegato]
      ,[pathAllegato]
      ,[evento]
      ,[dataInserimento]
      ,[dataUltimaModifica]
      ,[validate]*/
	
	$descrizione = $_POST['iDescrizione'];
	$idEvento =  $_POST['iEvento'];
	//In più idUtente per la creazione completa di $pathAllegato
	$idUtente = $_SESSION['idUtente'];
	$idAllegatiEvento = $_SESSION['idSelectAllegato'];
	
	if($_FILES["fileToUpload"]["name"] != null){//Se cambio IMG
		$img = basename($_FILES["fileToUpload"]["name"]);
		//var_dump($img);
		$extension = explode(".",$img);
		$extension = $extension[count($extension)-1];
		//var_dump($extension);
		
		$pathAllegato = $idUtente."\\".$idEvento."\\".$_POST['iNomeAllegato'].".".$extension;
		$pathAllegato = "pathAllegato = '" . $pathAllegato . "',";
	}
	else{//Se non cambio IMG
		$pathAllegato = "";
	}
	
	$query = 	"
					UPDATE	allegati_evento
					SET		descrizione = '$_POST[iDescrizione]', 
				"
				.
				$pathAllegato
				.
				"
							dataUltimaModifica = GETDATE()
					WHERE	idAllegatiEvento = $idAllegatiEvento
				";

	ntxQuery($query);
	//var_dump($query);
		
	//Ottengo le due path E:.... e C:....
	$sqlPath = "SELECT pathAllegati, pathTmp FROM _pathPortale";
	$query = ntxQuery($sqlPath);
	
	while($rs=ntxRecord($query))
	{
		foreach($rs as $k=>$v)
			$html[$k] = htmlentities($v);
	}
		
	$flag = false;
	if($_FILES["fileToUpload"]["name"] != null){//Se cambio IMG
		//Copio img in cartelle:
		// E:... e in C:....

		$target_dir = $html['pathTmp'];
		//var_dump("target_dir: ".$target_dir);
		$target_E = $html['pathAllegati'];
		//var_dump("target_E: ".$target_E);
		$target_file = $target_dir ."\\".$idUtente."\\".$idEvento."\\".$_POST['iNomeAllegato'].".". $extension; 
		$pathE = $target_E ."\\".$idUtente."\\".$idEvento."\\".$_POST['iNomeAllegato'].".". $extension; 

		$fileToUpload_C_tmp_name = $_FILES["fileToUpload"]["tmp_name"];
		$fileToUpload_E_tmp_name = $_FILES["fileToUpload"]["tmp_name"];

		/*
		var_dump($target_file);
		var_dump($pathE);
		
		var_dump($fileToUpload_C_tmp_name);
		var_dump($fileToUpload_E_tmp_name);
		*/
		
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
		/*// Check if file already exists
		if (file_exists($target_file)) {
			echo "<script>alert('Sorry, file already exists.')</script>";
			$flag = false;
			$uploadOk = 0;
		}*/
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
			echo "<script>alert('Extension : ".$imageFileType."');</script>";
			//echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
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
				echo "<script>alert('Disk C - Sorry, there was an error uploading your file.')</script>";
				$flag = false;
			}
			if (move_uploaded_file($fileToUpload_E_tmp_name, $pathE)) {
				//echo "<script>alert('The file ". basename($fileToUpload_E_tmp_name). " has been uploaded.')</script>";
				$flag = true;
			} else {
				echo "<script>alert('Disk E - Sorry, there was an error uploading your file.')</script>";
				$flag = false;
			}	
		}
	}
	else{
		echo "<script>alert('ERRORE')</script>";
		$flag = true;
	}
	
	if($flag == true){
			
		echo "	<script>
					window.location.href = 'dettagliAllegato.php?id=$idAllegatiEvento';
					window.open('','modificaAllegato.php').close();
				</script>
			";
	}
	else{
		echo 
			"	<script>
					window.location.href = 'modificaAllegato.php';
					window.open('','modificaAllegato.php').close();
				</script>
			";
	}
?>