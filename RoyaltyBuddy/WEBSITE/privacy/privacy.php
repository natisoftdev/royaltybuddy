<?php
	if ( !$_SESSION ) session_start();
	$vers = time();
	//var_dump($_SESSION);
	
	require_once("$_SERVER[DOCUMENT_ROOT]/repository/traduttore/traduttore_RoyaltyBuddy.inc");
	
	$traduttore = new NtxTraduttore("PRI_000_001", "IT", $_SESSION[NTX_LINGUA_DEST]);
	//$traduttore = new NtxCreaTraduzione("PRI_000_001", "IT", __FILE__);
	
	$home = $_SESSION['home'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- my css -->
		<link rel="stylesheet" href="../css/template.css?vers=<?php echo $vers ?>" />
		<link rel="stylesheet" href="css/style.css?vers=<?php echo $vers ?>" />
		<link href="../css/modal.css?ver=<?php echo $vers ?>" rel="stylesheet" type="text/css">
		<!-- ManPro.NEt CSS -->
		<link href="/repository/css/grid-2.0.0.css?vers=<?php echo $vers ?>" rel="stylesheet" type="text/css">
		<!-- JQuery Mobile Library CSS -->
		<link rel="stylesheet" href="/repository2/jqm142/jquery.mobile-1.4.2.min.css" />
		<!-- JQuery Library JS -->
		<script src="/repository2/jqm142/jquery-1.11.0.min.js"></script>
		<script src="/repository2/jqm142/jquery.mobile-1.4.2.min.js"></script>
		<script src="/repository/libs/jhp/jhp-1.5.1.min.js"></script>
		<!-- my js -->
		<script src="js/index.js?vers=<?php echo $vers ?>"></script>
		<script src="../js/index.js?vers=<?php echo $vers ?>"></script>
	</head>
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="b" data-position="fixed">
				<h1>
					Privacy Policy
				</h1>
				<a onclick="openHome('<?php echo "../home/".$home ?>')" data-ajax="false" data-icon="arrow-l" data-iconpos="notext" >
					Back
				</a>
				<a onclick="openHelp()" data-icon="info" data-iconpos="notext">
					Help
				</a>
			</div><!-- /header -->
			<div role="main" class="ui-content">
				<h2>Privacy Policy</h2> 
				<p> Natisoft s.r.l. built the Royalty Buddy app as a Commercial app. This SERVICE is provided by Natisoft s.r.l.  and is intended for use as is.
				</p> <p>This page is used to inform website visitors regarding our policies with the collection, use, and
				disclosure of Personal Information if anyone decided to use our Service.
				</p> <p>If you choose to use our Service, then you agree to the collection and use of information in relation
				to this policy. The Personal Information that we collect is used for providing and improving the
				Service. We will not use or share your information with anyone except as described
				in this Privacy Policy.
				</p> <p>The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible
				at Royalty Buddy unless otherwise defined in this Privacy Policy.
				</p> <p><strong>Information Collection and Use</strong></p> <p>For a better experience, while using our Service, we may require you to provide us with certain
				personally identifiable information. The information that we request is will be retained by us and used as described in this privacy policy.
				</p> <p>The app does use third party services that may collect information used to identify you.</p> <div><p>Link to privacy policy of third party service providers used by the app</p> <ul><li><a class="googlePlayServices" href="https://www.google.com/policies/privacy/" target="_blank">Google Play Services</a></li> 
					<!----> <!----> <!----> <!----> <!----></ul></div> <p><strong>Log Data</strong></p> 
				<p> We want to inform you that whenever you use our Service, in a case of an
				error in the app we collect data and information (through third party products) on your phone
				called Log Data. This Log Data may include information such as your device Internet Protocol (“IP”) address,
				device name, operating system version, the configuration of the app when utilizing our Service,
				the time and date of your use of the Service, and other statistics.
				</p> <p><strong>Cookies</strong></p> <p>Cookies are files with a small amount of data that are commonly used as anonymous unique identifiers. These
				are sent to your browser from the websites that you visit and are stored on your device's internal memory.
				</p> <p>This Service does not use these “cookies” explicitly. However, the app may use third party code and libraries
				that use “cookies” to collect information and improve their services. You have the option to either
				accept or refuse these cookies and know when a cookie is being sent to your device. If you choose to
				refuse our cookies, you may not be able to use some portions of this Service.
				</p> <p><strong>Service Providers</strong></p> <p> We may employ third-party companies and individuals due to the following reasons:</p> <ul><li>To facilitate our Service;</li> <li>To provide the Service on our behalf;</li> <li>To perform Service-related services; or</li> 
				<li>To assist us in analyzing how our Service is used.</li></ul> 
				<p> We want to inform users of this Service that these third parties have access to your
				Personal Information. The reason is to perform the tasks assigned to them on our behalf. However, they
				are obligated not to disclose or use the information for any other purpose.
				</p> <p><strong>Security</strong></p> <p> We value your trust in providing us your Personal Information, thus we are striving
				to use commercially acceptable means of protecting it. But remember that no method of transmission over
				the internet, or method of electronic storage is 100% secure and reliable, and we cannot guarantee
				its absolute security.
				</p> <p><strong>Links to Other Sites</strong></p> <p>This Service may contain links to other sites. If you click on a third-party link, you will be directed
				to that site. Note that these external sites are not operated by us. Therefore, we strongly
				advise you to review the Privacy Policy of these websites. We have no control over
				and assume no responsibility for the content, privacy policies, or practices of any third-party sites
				or services.
				</p> <p><strong>Children’s Privacy</strong></p> <p>These Services do not address anyone under the age of 13. We do not knowingly collect
				personally identifiable information from children under 13. In the case we discover that a child
				under 13 has provided us with personal information, we immediately delete this from
				our servers. If you are a parent or guardian and you are aware that your child has provided us with personal
				information, please contact us so that we will be able to do necessary actions.
				</p> <p><strong>Changes to This Privacy Policy</strong></p> <p> We may update our Privacy Policy from time to time. Thus, you are advised to review
				this page periodically for any changes. We will notify you of any changes by posting
				the new Privacy Policy on this page. These changes are effective immediately after they are posted on
				this page.
				</p> <p><strong>Contact Us</strong></p> <p>If you have any questions or suggestions about our Privacy Policy, do not hesitate to contact us.
			</div><!-- /content -->
		</div><!-- /page -->
		<div class="overlay" id="overlay" style="display:none;"></div>
		<div id=divMessage style="display:none" class="modal">
			<div id=divMessage2 style="text-align:center" class="modal-content">
				<div style="text-align:right">
					<img onclick="closeHelp()" src="../css\themes\images\icons-png\delete-black.png" alt="Chiudi" class="closeHelp" />
				</div> 
				<div id="messaggioVero">
					<p>
						<?php $traduttore->html('Regolamento e informazioni legali') ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php $traduttore->Salva() ?>
		
	</body>
</html>