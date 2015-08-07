<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$sql_permission = "select * from bets_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_bets'])){
$_SESSION['admin_bets']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"; 
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	if($_SESSION['admin_bets']=="bets"){
	echo "<li><a href='#' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=bets&task=main/permission'>กำหนดเจ้าหน้าที่</a></li>";
		echo "</ul>";
	echo "</li>";
	}
	if($_SESSION['login_status']<=4 and $result_permission['p1']==1){	
	echo "<li><a href='#' class='dir'>มาตรฐานการศึกษา</a>";
		echo "<ul>";
		echo "<li><a href='?option=bets&task=main/curriculum'>หลักสูตรแกนกลาง</a></li>";
		echo "<li><a href='?option=bets&task=main/substance'>สาระ</a></li>";
		echo "<li><a href='?option=bets&task=main/standard'>มาตรฐานการศึกษา</a></li>";
		echo "<li><a href='?option=bets&task=main/indicator'>ตัวชี้ัวัด</a></li>";
		echo "</ul>";
	echo "</li>";
	}	
	if($_SESSION['login_status']<=4 and $result_permission['p2']==1){	
	echo "<li><a href='#' class='dir'>ข้อสอบและแบบทดสอบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=bets&task=main/test_item'>คลังข้อสอบ</a></li>";
			echo "<li><a href='?option=bets&task=main/test_master'>ชุดข้อคำถาม</a></li>";
			echo "<li><a href='?option=bets&task=main/test_admin'>แบบทดสอบ</a></li>";
		echo "</ul>";
	echo "</li>";
	}	
	if($_SESSION['login_status']<=4){
	echo "<li><a href='#' class='dir'>บริหารการสอบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=bets&task=main/test_sch'>รายการทดสอบ</a></li>";
			echo "<li><a href='?option=bets&task=main/test_sch_2'>กำหนดการสอบ</a></li>";
		echo "</ul>";
	echo "</li>";
	}
	if($_SESSION['login_status']==6){	
	echo "<li><a href='?option=bets&task=main/test_student' class='dir'>ทดสอบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=bets&task=main/test_student'>รายการสอบ</a></li>";
		echo "</ul>";
	
	echo "</li>";
	}	
	echo "<li><a href='#' class='dir'>รายงาน</a>";
		echo "<ul>";
		if($_SESSION['login_status']<=4){	
		echo "<li><a href='?option=bets&task=main/sch_report_1'>รายงานทั้งหมด</a></li>";
		echo "<li><a href='?option=bets&task=main/sch_report_2'>รายงานเฉพาะตน</a></li>";
		}
		if($_SESSION['login_status']==6){	
		echo "<li><a href='?option=bets&task=main/student_report_1'>รายงานผลการสอบ</a></li>";
		}

		echo "</ul>";
	echo "</li>";
	echo "<li><a href='#' class='dir'>คู่มือ</a>";
		echo "<ul>";
				echo "<li><a href='modules/bets/manual/bets.pdf' target='_blank'>คู่มือระบบทดสอบการศึกษา</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
