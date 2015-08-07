<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page 

if(!isset($_SESSION['admin_student_check'])){
$_SESSION['admin_student_check']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
if($_SESSION['login_status']<=4 ){
	echo "<li><a href='?option=student_check&task=main/check_mobile' class='dir'>บันทึกมาเรียน</a></li>";
} 
	echo "<li><a href='?option=student_check&task=main/report_today_mobile' class='dir'>รายงาน</a></li>";

echo "</ul>";
?>
</td></tr>
</table>