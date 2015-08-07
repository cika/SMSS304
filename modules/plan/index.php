<?php
if(isset($_GET['index'])){
$index=$_GET['index'];
}
else{
$index="";
}

if($_SESSION['user_os']=='mobile'){
include("./modules/plan/menu_mobile.php");
}
else{
include("./modules/plan/menu.php");
}
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>