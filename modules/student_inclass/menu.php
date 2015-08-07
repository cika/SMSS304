<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$sql_permission = "select * from student_inclass_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(isset($_SESSION['admin_student_inclass'])){
	$admin_student_inclass=$_SESSION['admin_student_inclass'];
}else{
	$admin_student_inclass=null;
	}


echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	
if(isset($ses)){
$ses='admin_'.$_GET['option'];
}	
else{
$ses="";
}
if(!isset($_SESSION[$ses])){
$_SESSION[$ses]="";
}

if($admin_student_inclass=='student_inclass'){
	echo "<li><a href='?option=".$_GET['option']."' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=".$_GET['option']."&task=set/period'>ปีการศึกษา/จำนวนคาบ</a></li>";
			echo "<li><a href='?option=".$_GET['option']."&task=set/part'>ภาคเรียน</a></li>";
			echo "<li><a href='?option=".$_GET['option']."&task=set/permission'>ผู้รับผิดชอบ</a></li>";
		echo "</ul>";
	echo "</li>";
}	
if($_SESSION['login_status']<=4 ){	
	echo "<li><a href='?option=".$_GET['option']."&task=main/subject' class='dir'>รายวิชา</a>";
		echo "<ul>";
			echo "<li><a href='?option=".$_GET['option']."&task=main/subject'>กำหนดรายวิชา</a></li>";
			echo "<li><a href='?option=".$_GET['option']."&task=main/person_table2'>ตารางสอนของตนเอง</a></li>";		
		echo "</ul>";
	echo "</li>";
} 
if($_SESSION['login_status']<=4 ){	
	echo "<li><a href='?option=".$_GET['option']."' class='dir'>การเข้าชั้นเรียน</a>";
		echo "<ul>";
			echo "<li><a href='?option=".$_GET['option']."&task=main/teach_check'>บันทึกการเข้าเรียน(ผู้สอน)</a></li>";

			echo "<li><a href='?option=".$_GET['option']."&task=main/check'>บันทึกการเข้าเรียน(เจ้าหน้าที่)</a></li>";
			echo "<li><a href='?option=".$_GET['option']."&task=main/checkDays_ago'>บันทึกการเข้าเรียนย้อนหลัง<br>(เจ้าหน้าที่)</a></li>";
		echo "</ul>";
	echo "</li>";
} 
	echo "<li><a href='?option=".$_GET['option']."' class='dir'>รายงาน</a>";
		echo "<ul>";
			echo "<li><a href='?option=".$_GET['option']."&task=main/report_today'>การเข้าเรียน (ประจำวัน)</a></li>";		
			echo "<li><a href='?option=".$_GET['option']."&task=main/report_person'>การเข้าเรียน (บุคคล/ห้องเรียน)</a></li>";		
			echo "<li><a href='?option=".$_GET['option']."&task=main/report_subject'>การเข้าเรียนตามรายวิชา</a></li>";		
			echo "<li><a href='?option=".$_GET['option']."&task=main/teach_table'>ตารางสอนรายชั้น</a></li>";		
			echo "<li><a href='?option=".$_GET['option']."&task=main/person_table'>ตารางสอนรายบุคคล</a></li>";		
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='modules/student_inclass/manual/student_inclass.pdf' target='_blank'>คู่มือ</a></a>";
		echo "<ul>";
				echo "<li><a href='modules/student_inclass/manual/student_inclass.pdf' target='_blank'>คู่มือ</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";
?>
</td></tr>
</table>