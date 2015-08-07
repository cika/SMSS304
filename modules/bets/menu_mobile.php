<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$sql_permission = "select * from bets_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"; 
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	/*
	echo "<li><a href='#' class='dir'>รายงานผลการสอบ</a>";
		echo "<ul>";
		if($_SESSION['login_status']>=2 and $_SESSION['login_status']<=4){	
		echo "<li><a href='?option=bets&task=main/khet_report_1_mobile'>ภาพรวมเขตพื้นที่การศึกษา</a></li>";
		}
		if($_SESSION['login_status']>=12 and $_SESSION['login_status']<=14){	
		echo "<li><a href='?option=bets&task=main/sch_report_1_mobile'>รายงานผลการสอบ</a></li>";
		}
		if($_SESSION['login_status']==16){	
		echo "<li><a href='?option=bets&task=main/student_report_1_mobile'>รายงานผลการสอบ</a></li>";
		}
		echo "</ul>";
	echo "</li>";
	*/
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
