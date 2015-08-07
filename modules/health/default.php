<?php
	if($_SESSION['user_os']=='mobile'){
	include("modules/health/report_all_mobile.php");	
	}
	else{
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<div align='center'><p><img src='modules/health/iconH/logospt.jpg' width='262' height='192' /></p></div>";
	}
?>
