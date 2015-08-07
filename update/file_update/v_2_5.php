<?php
$sql="ALTER TABLE  `cabinet_main` ADD  `status` TINYINT NOT NULL AFTER  `doc_type`" ;
$dbquery = mysqli_query($connect,$sql);

$sql="ALTER TABLE `mail_main` ADD INDEX ( `ref_id` )" ;
$dbquery = mysqli_query($connect,$sql);

$sql="ALTER TABLE `mail_sendto_answer` ADD INDEX ( `ref_id` )" ;
$dbquery = mysqli_query($connect,$sql);

$sql="ALTER TABLE `mail_sendto_answer` ADD INDEX ( `send_to` )" ;
$dbquery = mysqli_query($connect,$sql);
?>
