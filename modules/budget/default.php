<?php
	if($_SESSION['user_os']=='mobile'){
	include("modules/budget/main/report_1_mobile.php");	
	}
	else{
	echo "<div align='center'><img src='images/budget.jpg' border='0' width='100%'></div>";
	}
?>
