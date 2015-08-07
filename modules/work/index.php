<?php
if($_SESSION['user_os']=='mobile'){
include("./modules/work/menu_mobile.php");
}
else{
include("./modules/work/menu.php");
}
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>

