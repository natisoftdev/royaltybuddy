<?php

	if ( !$_SESSION ) session_start();

	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	$_SESSION['page'] = $_POST['page'];
	$_SESSION['back'] = $_POST['back'];
	//$_POST è vuoto non aggiorno
	if($_POST['idSelect'] != null ||  $_POST['idSelect'] != ""){
		$_SESSION['idSelect'] = $_POST['idSelect'];
	}
	
	jhp(&$_SESSION['page']);
?>