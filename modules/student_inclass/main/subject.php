<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script> 
<?php
require_once "modules/student_inclass/time_inc.php";	

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

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายวิชาที่สอน</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>ของ$_SESSION[login_prename]$_SESSION[login_name] $_SESSION[login_surname]</strong></font></td></tr>";

echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){

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
echo "<Center>";
echo "<Font color='#006666' Size=3><B>กำหนดรายวิชา ปีการศึกษา $year_active_result[student_check_year]</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0'>";

echo "<Tr><Td align='right'>ภาคเรียนที่&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='part' id='part' Size='4' maxlength='1' onkeydown='integerOnly()'></Td></Tr>";
echo "<Tr><Td align='right'>ชื่อรายวิชา&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='subject' id='subject' Size='40' maxlength='50'></Td></Tr>";

$sql="SELECT student_main.id,student_main.class_now,student_main.room,student_main_class.class_name from student_main left join student_main_class on student_main.class_now=student_main_class.class_code GROUP BY student_main.class_now,student_main.room";
$dbquery = mysqli_query($connect,$sql);
echo "<Tr><Td align='right'>ชั้น&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'>";
echo "<select  name='class_now' id='class_now' size='1'>";
echo "<option  value =''>เลือก</option>";
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$class_now= $result['class_now'];
		$room_now= $result['room'];
		$class_name= $result['class_name'];
		$class_now_value=$class_now."/".$room_now;
			if($room_now==0){
			echo "<option value = '$class_now_value'>$class_name</option>";
			}
			else{
			echo "<option value = '$class_now_value'>$class_name/$room_now</option>";
			}
		}			
echo "</select>";
echo "</Td></Tr>";

echo "<Tr><Td align='right'>ตารางสอน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'>";
echo "<table border='1' cellpadding='0' cellspacing='0'>";
echo "<TR bgcolor='#FFCCCC'><td align='center'>วัน/คาบ</td>";
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
		echo "<td>$day_arr[$day]</td>";	
					for($t=0;$t<$num_period;$t++){
					echo "<td align='center' valign='center'>";
						if($t!=$lunch_period){
						echo "<input type='checkbox' name='$eday_arr[$day]-$t' value='1'>";
						}
					echo "</td>";
					}
		echo "</TR>";
		}			
echo "</table>";
echo "</Td></Tr>";


echo "<Input Type='hidden' Name='ed_year' value='$year_active_result[student_check_year]'>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'></td>";
echo "<td align='left'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
	&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=student_inclass&task=main/subject&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=student_inclass&task=main/subject&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "select * from student_inclass_subject where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

$sql = "delete from student_inclass_ref where ref_id='$ref_result[ref_id]'";
$dbquery = mysqli_query($connect,$sql);

$sql = "delete from student_inclass_subject where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
list($std_class,$room)=explode("/", $_POST['class_now']);
$time_mk=time();
$rand_num=rand();
$ref_id = $time_mk.$rand_num;

$sql = "insert into student_inclass_subject(ed_year,part,subject,std_class,room,ref_id,officer,rec_date) values ('$_POST[ed_year]', '$_POST[part]','$_POST[subject]','$std_class','$room','$ref_id','$_SESSION[login_user_id]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);

		for($day=0;$day<7;$day++){
					for($t=0;$t<$num_period;$t++){
						$text=$eday_arr[$day]."-".$t;
						if(isset($_POST[$text])){
						//แยกชั้นห้อง
						list($ed_day,$ed_period)=explode("-",$text);
						$ed_period=$ed_period+1;
						$sql = "insert into student_inclass_ref(ref_id,ed_day,period) values ('$ref_id','$ed_day','$ed_period')";
						$dbquery = mysqli_query($connect,$sql);
						}
					}
		}			
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>แก้ไขรายวิชา</B></Font>";
echo "</Cener>";
echo "<Br><Br>";

echo "<Table width='50%' Border= '0'>";
$sql = "select * from student_inclass_subject where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

echo "<Tr><Td align='right'>ภาคเรียนที่&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='part' id='part' Size='4' maxlength='1' value='$ref_result[part]' onkeydown='integerOnly()'> ปีการศึกษา $ref_result[ed_year] </Td></Tr>";

echo "<Tr><Td align='right'>ชื่อรายวิชา&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='subject' id='subject' Size='40' maxlength='50' value='$ref_result[subject]'></Td></Tr>";

$sql="SELECT student_main.id,student_main.class_now,student_main.room,student_main_class.class_name from student_main left join student_main_class on student_main.class_now=student_main_class.class_code GROUP BY student_main.class_now,student_main.room";
$dbquery = mysqli_query($connect,$sql);
echo "<Tr><Td align='right'>ชั้น&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'>";
echo "<select  name='class_now' id='class_now' size='1'>";
echo "<option  value =''>เลือก</option>";
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$class_now= $result['class_now'];
		$room_now= $result['room'];
		$class_name= $result['class_name'];
		$class_now_value=$class_now."/".$room_now;
		
		if(($class_now==$ref_result['std_class']) and ($room_now==$ref_result['room'])){
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
echo "</Td></Tr>";

echo "<Tr><Td align='right'>ตารางสอน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'>";
echo "<table border='1' cellpadding='0' cellspacing='0'>";
echo "<TR bgcolor='#FFCCCC'><td align='center'>วัน/คาบ</td>";
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
		echo "<td>$day_arr[$day]</td>";	
					for($t=0;$t<$num_period;$t++){
						$tt=$t+1;
						$sql_ref_id = "select * from student_inclass_ref where ref_id='$ref_result[ref_id]' and ed_day='$eday_arr[$day]' and period='$tt'";
						$dbquery_ref_id = mysqli_query($connect,$sql_ref_id);
							if(mysqli_fetch_array($dbquery_ref_id)){
							$checked="checked";
							}
							else{
							$checked="";
							}

					echo "<td align='center' valign='center'>";
						if($t!=$lunch_period){
						echo "<input type='checkbox' name='$eday_arr[$day]-$t' value='1' $checked >";
						}
					echo "</td>";
					}
		echo "</TR>";
		}			
echo "</table>";
echo "</Td></Tr>";

echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
echo "<tr><td align='right'></td>";
echo "<td align='left'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Input Type=Hidden Name='ref_id' Value='$ref_result[ref_id]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
	list($std_class,$room)=explode("/", $_POST['class_now']);
	$sql = "update student_inclass_subject set part='$_POST[part]', subject='$_POST[subject]', std_class='$std_class' , room='$room' where id='$_POST[id]'";
	$dbquery = mysqli_query($connect,$sql);

	$sql = "delete from student_inclass_ref where ref_id='$_POST[ref_id]'";
	$dbquery = mysqli_query($connect,$sql);

		for($day=0;$day<7;$day++){
					for($t=0;$t<$num_period;$t++){
						$text=$eday_arr[$day]."-".$t;
						if(isset($_POST[$text])){
						//แยกชั้นห้อง
						list($ed_day,$ed_period)=explode("-",$text);
						$ed_period=$ed_period+1;
						$sql = "insert into student_inclass_ref(ref_id,ed_day,period) values ('$_POST[ref_id]','$ed_day','$ed_period')";
						$dbquery = mysqli_query($connect,$sql);
						}
					}
		}			
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){
	//ส่วนของการแยกหน้า
$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=student_inclass&task=main/subject";  // 2_กำหนดลิงค์
$sql = "select * from  student_inclass_subject where officer='$_SESSION[login_user_id]'"; // 3_กำหนด sql

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );  
$totalpages=ceil($num_rows/$pagelen);
//
if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
//
if($_REQUEST['page']==""){
$page=$totalpages;
		if($page<2){
		$page=1;
		}
}
else{
		if($totalpages<$_REQUEST['page']){
		$page=$totalpages;
					if($page<1){
					$page=1;
					}
		}
		else{
		$page=$_REQUEST['page'];
		}
}

$start=($page-1)*$pagelen;

if(($totalpages>1) and ($totalpages<16)){
echo "<div align=center>";
echo "หน้า	";
			for($i=1; $i<=$totalpages; $i++)	{
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
echo "</div>";
}			
if($totalpages>15){
			if($page <=8){
			$e_page=15;
			$s_page=1;
			}
			if($page>8){
					if($totalpages-$page>=7){
					$e_page=$page+7;
					$s_page=$page-7;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-15;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>หน้าแรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>หน้าก่อน </a>";
			}
			else {
			echo "หน้า	";
			}					
			for($i=$s_page; $i<=$e_page; $i++){
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
			if($page<$totalpages)	{
			$f_page2=$page+1;
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> หน้าถัดไป</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> หน้าสุดท้าย</a>>";
			}
			echo " <select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
			echo "<option  value=\"\">หน้า</option>";
				for($p=1;$p<=$totalpages;$p++){
				echo "<option  value=\"?$url_link&page=$p\">$p</option>";
				}
			echo "</select>";
echo "</div>";  
}					
//จบแยกหน้า

$sql = "select *,student_inclass_subject.id from  student_inclass_subject left join student_main_class on student_inclass_subject.std_class=student_main_class.class_code where student_inclass_subject.officer='$_SESSION[login_user_id]' order by student_inclass_subject.ed_year,student_inclass_subject.part,student_inclass_subject.std_class,student_inclass_subject.room limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='80%' border='0' align='center'>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='button' name='smb' value='กำหนดรายวิชา' onclick='location.href=\"?option=student_inclass&task=main/subject&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td align='center'>ที่</Td><Td align='center' width='150'>ปีการศึกษา</Td><Td align='center' width='100'>ภาคเรียนที่</Td><Td  align='center'>รายวิชา</Td><Td align='center' width='150'>ชั้น</Td><Td align='center' width='100'>ห้อง</Td><Td align='center' width='200'>สอน</Td><Td  align='center' width='50'>ลบ</Td><Td align='center' width='50'>แก้ไข</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$ed_year= $result['ed_year'];
		$part = $result['part'];
		$subject = $result['subject'];
		$class_name = $result['class_name'];
		$room = $result['room'];
		$ref_id = $result['ref_id'];
			if($room==0){
			$room="";
			}

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr bgcolor=$color align='left' valign='top'><Td align='center' width='50'>$N</Td><Td align='center'>$ed_year</Td><Td align='center'>$part</Td>";
		echo "<td>$subject</td><td>$class_name</td><td align='center'>$room</td><td align='left'>";
		
		$sql_ref = "select * from student_inclass_ref where ref_id='$ref_id' order by id";
		$dbquery_ref = mysqli_query($connect,$sql_ref);
		While ($result_ref = mysqli_fetch_array($dbquery_ref))
			{
			echo $thai_day[$result_ref ['ed_day']]; 
			echo " คาบที่ ";
			echo $result_ref ['period'];
			echo "<br>";
			}
		
		echo "</td>";
		echo "<Td align='center'><a href=?option=student_inclass&task=main/subject&index=2&id=$id&page=$page><img src=images/drop.png border='0' alt='ลบ'></a></a></Td>
		<Td align='center'><a href=?option=student_inclass&task=main/subject&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";
}


?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=student_inclass&task=main/subject");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.part.value == ""){
			alert("กรุณากรอกภาคเรียนที่");
		}else if(frm1.subject.value == ""){
			alert("กรุณากรอกชื่อรายวิชา");
		}else if(frm1.class_now.value == ""){
			alert("กรุณาเลือกชั้น");
		}else{
			callfrm("?option=student_inclass&task=main/subject&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=student_inclass&task=main/subject");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.part.value == ""){
			alert("กรุณากรอกภาคเรียนที่");
		}else if(frm1.subject.value == ""){
			alert("กรุณากรอกชื่อรายวิชา");
		}else if(frm1.class_now.value == ""){
			alert("กรุณาเลือกชั้น");
		}else{
			callfrm("?option=student_inclass&task=main/subject&index=6");   //page ประมวลผล
		}
	}
}
</script>

