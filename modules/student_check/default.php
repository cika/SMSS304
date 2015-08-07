<?php	
	
	if($_SESSION['user_os']=='mobile'){
	include("modules/student_check/main/check_mobile.php");	
	}
	else{
	echo "<img src='./modules/student_check/images/background.jpg' width='100%' />";
	}
?>