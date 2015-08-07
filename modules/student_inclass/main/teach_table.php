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

if(!isset($_POST['class_now'])){
$_POST['class_now']="";
}
if(!isset($_POST['part'])){
$_POST['part']="";
}

//ส่วนหัว
echo "<br />";
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ตารางสอนรายชั้น</strong></font></td></tr>";
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
$sql="SELECT student_main.id,student_main.class_now,student_main.room,student_main_class.class_name from student_main left join student_main_class on student_main.class_now=student_main_class.class_code GROUP BY student_main.class_now,student_main.room";
$dbquery = mysqli_query($connect,$sql);
echo "<Tr align='center'><Td align='center'>ชั้น&nbsp;&nbsp;";
echo "<select  name='class_now' id='class_now' size='1'>";
echo "<option  value =''>เลือก</option>";
list($class,$room)=explode("/", $_POST['class_now']);
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$class_now= $result['class_now'];
		$room_now= $result['room'];
		$class_name= $result['class_name'];
		$class_now_value=$class_now."/".$room_now;
		
		if(($class_now==$class) and ($room_now==$room)){
		$selected="selected";
		}
		else{
		$selected="";
		}
			if($room_now==0){
			echo "<option value = '$class_now_value' $selected>$class_name</option>";
			}
			else{
			echo "<option value = '$class_now_value' $selected>$class_name/$room_now</option>";
			}
		}			
echo "</select>";
echo "&nbsp;&nbsp;ภาคเรียน&nbsp;&nbsp;";
//part
		$sql_part = "select * from student_inclass_part where ed_year='$year_active' order by part";
		$dbquery_part = mysqli_query($connect,$sql_part);
		echo "<select  name='part' id='part' size='1'>";
		echo "<option  value =''>เลือก</option>";
		While ($result_part = mysqli_fetch_array($dbquery_part)){
			if($result_part['part']==$_POST['part']){
			echo "<option value = '$result_part[part]' selected>ภาคเรียนที่ $result_part[part] </option>";
			}
			else{
			echo "<option value = '$result_part[part]'>ภาคเรียนที่ $result_part[part] </option>";
			}
		}
echo "</select>";
echo "&nbsp;&nbsp;<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'></Td></Tr>";
echo "</Table>";
echo "</form>";


if($index==1){
echo "<Br>";
echo "<table width='75%' border='1' cellpadding='0' cellspacing='0' align='center'>";
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
					echo "<td valign='top' align='center'>";
						if($t!=$lunch_period){
							$tt=$t+1;
								//รายวิชา
								$sql_subject = "select * from student_inclass_subject,student_inclass_ref,person_main where student_inclass_subject.ref_id=student_inclass_ref.ref_id and student_inclass_subject.officer=person_main.person_id and student_inclass_subject.ed_year='$year_active' and student_inclass_subject.part='$_POST[part]' and student_inclass_subject.std_class='$class' and student_inclass_subject.room='$room' and student_inclass_ref.period='$tt' and student_inclass_ref.ed_day='$eday_arr[$day]'";
								$dbquery_subject = mysqli_query($connect,$sql_subject);
								While ($result_subject = mysqli_fetch_array($dbquery_subject)){
								echo "<font color='#0000FF'>$result_subject[subject]</font>";
								echo "<br>";
								echo  "(".$result_subject['prename'].$result_subject['name']." ".$result_subject['surname'].")";
								echo "<br>";
								}
						}
					echo "</td>";
					}
		echo "</TR>";
		}			
echo "</table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=student_inclass&task=main/teach_table");   // page ย้อนกลับ 
	}else if(val==1){
		 if(frm1.class_now.value == ""){
			alert("กรุณาเลือกชั้น");
		}else if(frm1.part.value == ""){
			alert("กรุณาเลือกภาคเรียน");
		}else{
			callfrm("?option=student_inclass&task=main/teach_table&index=1");   //page ประมวลผล
		}
	}
}

</script>

