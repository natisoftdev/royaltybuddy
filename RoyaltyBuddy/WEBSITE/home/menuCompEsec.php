<div>
	<div>
		<img src="../img/logo.jpg" alt="Img Logo" height="auto" width="150">
		<h3><?php echo $nome." ".$cognome ?></h3>
		<h5><?php echo $email ?></h5>
	</div>
	<hr>
	<h4><a onclick="openPage('../home/homeCompEsec.php','<?php echo $home ?>')"><?php $traduttore->html('HOME') ?></a></h4>
	<h4><a onclick="openPage('../album/listaAlbum.php','<?php echo $home ?>')"><?php $traduttore->html('Lista Album') ?></a></h4>
	<h4><a onclick="openPage('../brani/listaBrani.php','<?php echo $home ?>')"><?php $traduttore->html('Lista Brani') ?></a></h4>
	<h4><a onclick="openPage('../eventi/listaEventi.php','<?php echo $home ?>')"><?php $traduttore->html('Lista Eventi') ?></a></h4>
	<h4><a onclick="openPage('../scalette/listaScalette.php','<?php echo $home ?>')"><?php $traduttore->html('Lista Scalette') ?></a></h4>
	<h4><a onclick="openPage('../programmi/listaProgrammi.php','<?php echo $home ?>')"><?php $traduttore->html('Lista Programmi') ?></a></h4>
	<hr>
	<h4><a onclick="openPage('../account/account.php','<?php echo $home ?>')"><?php $traduttore->html('Account') ?></a></h4>
	<h4><a onclick="openPage('../impostazioni/impostazioni.php','<?php echo $home ?>')"><?php $traduttore->html('Impostazioni') ?></a></h4>
	<h4><a onclick="openPage('../privacy/privacy.php','<?php echo $home ?>')"><?php $traduttore->html('Privacy') ?></a></h4>
	<h4><a onclick="openPage('../infoApp/infoApp.php','<?php echo $home ?>')"><?php $traduttore->html('Info App') ?></a></h4>
</div>