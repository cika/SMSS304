<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
  	echo "<li><a href='?option=standard&task=elementary_report_mobile' class='dir'>ปฐมวัย</a></li>";
  	echo "<li><a href='?option=standard&task=basic_report_mobile' class='dir'>ขั้นพื้นฐาน</a></li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>