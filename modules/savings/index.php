<?php
if($_SESSION['user_os']=='mobile'){
include("./modules/savings/menu_mobile.php");
}
else{
include("./modules/savings/menu.php");
}
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>

