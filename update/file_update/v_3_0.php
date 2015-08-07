<?php
$sql="ALTER TABLE  `system_module` ADD  `where_work` TINYINT NOT NULL DEFAULT  '0' AFTER  `url`" ;
$dbquery = mysqli_query($connect,$sql);

$sql="ALTER TABLE `system_school_name` ADD `school_type` TINYINT NOT NULL DEFAULT '0' AFTER `school_name`" ;
$dbquery = mysqli_query($connect,$sql);

$sql="SHOW TABLES LIKE 'student_inclass_main'" ;
$dbquery = mysqli_query($connect,$sql);
if(mysqli_num_rows($dbquery)){
	$sql="CREATE TABLE IF NOT EXISTS `student_inclass_part` (
`id` int(11) NOT NULL,
  `ed_year` int(11) NOT NULL,
  `part` tinyint(4) NOT NULL,
  `start_date` date NOT NULL,
  `stop_date` date NOT NULL,
  `rec_date` date NOT NULL,
  `officer` varchar(13) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8" ;
	$dbquery = mysqli_query($connect,$sql);
	
	$sql="CREATE TABLE IF NOT EXISTS `student_inclass_ref` (
`id` int(11) NOT NULL,
  `ref_id` varchar(50) NOT NULL,
  `ed_day` varchar(10) NOT NULL,
  `period` tinyint(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8" ;
	$dbquery = mysqli_query($connect,$sql);

	$sql="CREATE TABLE IF NOT EXISTS `student_inclass_subject` (
`id` int(11) NOT NULL,
  `ed_year` int(11) NOT NULL,
  `part` tinyint(4) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `std_class` tinyint(4) NOT NULL,
  `room` tinyint(4) NOT NULL,
  `ref_id` varchar(50) NOT NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8" ;
	$dbquery = mysqli_query($connect,$sql);
}

?>
