<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$day_arr=array("จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์","อาทิตย์");
$eday_arr=array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
$thai_day =array(
"Sunday"=>"วันอาทิตย์",
"Monday"=>"วันจันทร์",
"Tuesday"=>"วันอังคาร",
"Wednesday"=>"วันพุธ",
"Thursday"=>"วันพฤหัสบดี",
"Friday"=>"วันศุกร์",
"Saturday"=>"วันเสาร์",
);

#เรียกปีการศึกษาปัจจบัน และคาบ
$sql_y="select * from student_inclass_year where year_active=1";
$ry=mysqli_query($connect,$sql_y);
$yactive=mysqli_fetch_assoc($ry);
$year_active=$yactive['student_check_year'];
$num_period=$yactive['num_period'];
$lunch_period=($yactive['lunch_period'])-1;

if(!isset($_POST['person'])){
$_POST['person']="";
}
//ส่วนหัว
echo "<br />";
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ตารางสอนรายบุคคล</strong></font></td></tr>";
echo "</table>";

//ส่วนแสดงผล
//ปีการศึกษา
$sql = "select * from student_inclass_year where year_active='1' order by student_check_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['student_check_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีการศึกษาใด ๆ  กรุณาแจ้งผู้ดูแลระบบ เพื่อกำหนดปีการศึกษาทำงานปัจจุบัน</div>";
exit();
}

echo "<form id='frm1' name='frm1'>";
echo "<Br>";
echo "<Table width='50%' Border='0' align='center'>";
echo "<Tr align='center'><Td align='center'>";
echo "&nbsp;&nbsp;บุคคล&nbsp;&nbsp;";
//person
		$sql_person = "select * from person_main where status='0' order by position_code,person_order";
		$dbquery_person = mysqli_query($connect,$sql_person);
		echo "<select  name='person' id='person' size='1' onchange='goto_url(1)'>";
		echo "<option  value =''>เลือก</option>";
		While ($result_person = mysqli_fetch_array($dbquery_person)){
			if($result_person['person_id']==$_POST['person']){
			echo "<option value = '$result_person[person_id]' selected>$result_person[prename]$result_person[name] $result_person[surname]</option>";
			}
			else{
			echo "<option value = '$result_person[person_id]'>$result_person[prename]$result_person[name] $result_person[surname]</option>";
			}
		}
echo "</select>";
echo "</Table>";
echo "</form>";


if($index==1){
echo "<Br>";
//ภาคเรียน
$sql_part = "select * from student_inclass_part where ed_year='$year_active' order by part";
$dbquery_part = mysqli_query($connect,$sql_part);
While ($result_part = mysqli_fetch_array($dbquery_part)){
			echo "<table width='95%' border='0' cellpadding='0' cellspacing='0' align='center'>";
			echo "<tr align='left'><td><b>ภาคเรียนที่ $result_part[part] ปีการศึกษา $year_active</b></td></tr>";
			echo "</table>";

			echo "<table width='95%' border='1' cellpadding='0' cellspacing='0' align='center'>";
			echo "<TR bgcolor='#FFCCCC'><td align='center'><b>วัน/คาบ</b></td>";
				for($t=0;$t<$num_period;$t++){
						if($t==$lunch_period){
						echo "<TD align='center' Bgcolor='#Fcf9d8'><B>คาบ ".($t+1)." (พัก)</B></TD>\n";
						}
						else{
						echo "<TD align='center'><B>คาบ ".($t+1)."</B></TD>\n";
						}
				}
			echo "</TR>";
					for($day=0;$day<7;$day++){
					echo "<TR>";
					echo "<td><b>$day_arr[$day]</b></td>";	
								for($t=0;$t<$num_period;$t++){
								echo "<td valign='top' align='left'>";
									if($t!=$lunch_period){
										$tt=$t+1;
											//รายวิชา
											$sql_subject = "select * from student_inclass_subject,student_inclass_ref,person_main,student_main_class where student_inclass_subject.ref_id=student_inclass_ref.ref_id and student_inclass_subject.officer=person_main.person_id and student_inclass_subject.std_class=student_main_class.class_code and student_inclass_subject.ed_year='$year_active'  and student_inclass_subject.part='$result_part[part]' and student_inclass_ref.ed_day='$eday_arr[$day]' and student_inclass_ref.period='$tt' and student_inclass_subject.officer='$_POST[person]'";
											$dbquery_subject = mysqli_query($connect,$sql_subject);
											While ($result_subject = mysqli_fetch_array($dbquery_subject)){
											echo "<font color='#0000FF'>$result_subject[subject]</font>";
											echo " <font color='#0000FF'>$result_subject[class_name]</font>";
													if($result_subject['room']!=0){
													echo "<font color='#0000FF'>/$result_subject[room]</font>";
													}
											echo "<br>";
											}
									}
								echo "</td>";
								}
					echo "</TR>";
					}			
			echo "</table>";
			echo "<br>";
}//ภาคเรียน
} //if index==1



?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=student_inclass&task=main/person_table");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person.value == ""){
			alert("กรุณาเลือกบุคคล");
		}else{
			callfrm("?option=student_inclass&task=main/person_table&index=1");   //page ประมวลผล
		}
	}
}

</script>

