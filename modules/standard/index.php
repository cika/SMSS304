<?php
if(isset($_GET['index'])){
$index=$_GET['index'];
}else{
$index="";
}

if($_SESSION['user_os']=='mobile'){
include("./modules/standard/menu_mobile.php");
}
else{
include("./modules/standard/menu.php");
}
//ผนวกไฟล์

if(isset($_GET['task'])){
$task=$_GET['task'];
}else{
$task="";
}
if($task!=""){
include("$task.php");
}
else {
include("default.php");
}
?>