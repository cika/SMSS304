<?php
$sql="ALTER TABLE  `achievement_main` CHANGE  `school`  `level` TINYINT NOT NULL" ;
$dbquery = mysqli_query($connect,$sql);
?>
