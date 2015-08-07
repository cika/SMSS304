<?php
if($_SESSION['user_os']=='mobile'){
include("./modules/person/menu_mobile.php");
}
else{
include("./modules/person/menu.php");
}
//ผนวกไฟล์
if(isset($_GET['task'])!=""){
$task=$_GET['task'].".php";
include("$task");
}
else {
include("default.php");
}
?>

