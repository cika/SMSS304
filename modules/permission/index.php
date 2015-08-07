<?php
if($_SESSION['user_os']=='mobile'){
include("./modules/permission/menu_mobile.php");
}
else{
include("./modules/permission/menu.php");
}
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>

