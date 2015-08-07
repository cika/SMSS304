<?php
$sql="ALTER TABLE `savings_money` CHANGE `amount_money` `amount_money` DECIMAL(8,2) NOT NULL" ;
$dbquery = mysqli_query($connect,$sql);
?>
