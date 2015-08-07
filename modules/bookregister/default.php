<?php
	if($_SESSION['user_os']=='mobile'){
	include("modules/bookregister/main/receive_mobile.php");	
	}
	else{
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<div align='center'><img src='modules/bookregister/images/register.jpg' border='0' width='20%'></div>";
	}
?>
