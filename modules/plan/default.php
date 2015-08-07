<?php
	if($_SESSION['user_os']=='mobile'){
	include("modules/plan/planproject/plan_show_plan_mobile.php");	
	}
	else{

	echo "<div style='background-image: url(images/plan.jpg); height: 48em; width: 100%; border: 0px solid lawngreen; background-attachment: none; background-color:transparent; background-repeat:no-repeat; background-position: 50% 0%;'></div>";
	}
?>
	
