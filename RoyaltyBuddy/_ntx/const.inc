<?php 

$RootApache = "C:/ms4w/Apache";
$RootHtdocs = "C:/ms4w/Apache/htdocs";
$RootNtx = "C:/ms4w/Apache/_ntx_2";

$subPathLib = "build/_ntx";
$subPathPortal = "royalty_buddy";
$subPathLibDedicated = "build/royalty_buddy";

define('NTX_CLIENTE', "ROYALTY_BUDDY");
define('EMAIL_DEBUG', "natisoft.alert@gmail.com");

define('NTX_SUBPATH_PORTALE', $subPathPortal);
define('NTX_PATH', "$RootNtx/$subPathLib/");
define('NTX_WEBPORTAL_PATH', "$RootNtx/$subPathLibDedicated/");
define('NTX_WEBPORTAL_EXT_PATH', "/$subPathPortal");
define('NTX_PHP_PATH', "/$subPathPortal/_ntx/ntxphp.php");
define('NTX_WEBPORTAL_EXT_PHP_PATH', "$RootHtdocs/$subPathPortal");

?>
