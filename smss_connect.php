<?php
$hostname="localhost";
$user="root";
$password="xxxxxxxx";
$dbname="smss";
$system_office_code="xxxxxxxx";     //รหัสสถานศึกษา
$connect=mysqli_connect($hostname,$user,$password,$dbname) or die("Could not connect MySql");
mysqli_query($connect,"SET NAMES utf8");
?> 