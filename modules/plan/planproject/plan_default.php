<?php
$sql = "SELECT *  FROM  plan_year where year_active='1'  limit 1";
$result0 = DBfieldQuery($sql);
$fetyear = mysqli_fetch_array($result0);
if($fetyear){ 
$_SESSION["budget_year"]=$fetyear['budget_year'];
}
else $_SESSION["budget_year"]="";
 
$sql = "SELECT *  FROM  plan_setgic_year  where (year_active=1)  limit 1";
$result0 = DBfieldQuery($sql);
$fetyear = mysqli_fetch_array($result0);
if($fetyear){ 
$_SESSION["sd_year"]=$fetyear['budget_year'];
}
else $_SESSION["sd_year"]="";
?>
