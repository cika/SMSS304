<?php
$sql="CREATE TABLE IF NOT EXISTS `budget_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(150) CHARACTER SET utf8 NOT NULL,
  `file_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `rec_date` date NOT NULL,
  `officer` varchar(13) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$dbquery = mysqli_query($connect,$sql);
?>
