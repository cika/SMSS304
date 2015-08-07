<?php
if($_SESSION['user_os']=='mobile'){
include("./modules/la/menu_mobile.php");
}
else{
include("./modules/la/menu.php");
}
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>

