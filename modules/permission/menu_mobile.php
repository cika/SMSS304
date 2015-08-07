<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$sql_permission = "select * from permission_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_permission'])){
$_SESSION['admin_permission']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"; 
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	echo "<li><a href='?option=permission&task=main/permission_main_mobile'>ของฉัน</a></li>";
	echo "<li><a href='?option=permission&task=main/report_1_mobile'>วันนี้(ทั้งหมด)</a></li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
