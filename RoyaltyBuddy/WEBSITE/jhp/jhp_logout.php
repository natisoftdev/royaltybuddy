<?php

	if ( !$_SESSION ) session_start();

	require_once("../_ntx/const.inc");
	require_once(NTX_PATH."jhp/jhp.inc");
	require_once(NTX_WEBPORTAL_PATH.'_database.inc');
	
	//$_SESSION = array();
	//session_destroy();
	
	session_start();
	session_unset();
	session_destroy();
	
	////jhp_log($_SESSION);
	$result = "../login.php";
	jhp(&$result);
?>