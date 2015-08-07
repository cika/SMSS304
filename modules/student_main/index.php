<?php
if(isset($_GET['index'])){
$index=$_GET['index'];
}else{
$index="";
}
if($_SESSION['user_os']=='mobile'){
include("modules/student_main/menu_mobile.php");
}
else{
include("modules/student_main/menu.php");
}
//ผนวกไฟล์

if(isset($_REQUEST['page'])){
$page=$_REQUEST['page'];
}else{
$page="";
}

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