<?php
	if($_SESSION['user_os']=='mobile'){
	include("modules/permission/main/report_1_mobile.php");	
	}
	else{
	echo "<br />";
	echo "<br />";
	echo "<div align='center'><img src='modules/permission/images/permission.jpg' border='0'></div>";
	}
?>
