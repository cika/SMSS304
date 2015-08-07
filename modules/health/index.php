<?php 
if($_SESSION['user_os']=='mobile'){
include("./modules/health/menu_mobile.php");
}
else{
include("./modules/health/menu.php");
}
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>

