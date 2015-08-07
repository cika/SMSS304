<?php
	if($_SESSION['user_os']=='mobile'){
	include("modules/cabinet/main/private_document_mobile.php");	
	}
	else{
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<div align='center'><img src='modules/cabinet/images/cabinet.jpg' border='0' width='15%'></div>";
	}
?>
