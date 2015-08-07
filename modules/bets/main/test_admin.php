<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<script type="text/javascript" src="./css/js/calendarDateInput2.js"></script> 
<?php
require_once("modules/bets/time_inc.php");
$officer=$_SESSION['login_user_id'];
echo "<br />";

//ส่วนเพิ่มข้อมูล
if($index==1){
	$sql_num = "select id from bets_answer";
	$dbquery_num= mysqli_query($connect,$sql_num);
	$answer_num=mysqli_num_rows($dbquery_num);
	if($answer_num>500000){
	echo "<script>alert('ตารางข้อมูลคำตอบมีจำนวน $answer_num รายการ อาจทำให้การประมวลผลใช้เวลามาก ควรพิจารณาลบแบบทดสอบที่หมดความจำเป็นออก ');</script>\n";
	}

echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มแบบทดสอบ</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table width='60%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>ชื่อแบบทดสอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='test_name' Size='40'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชุดข้อคำถาม(ที่ใช้)&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
$sql = "select * from  bets_master_test where officer='$officer' order by id desc";
$dbquery_master = mysqli_query($connect,$sql);
echo "<Select  name='master_test' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
While ($result_master = mysqli_fetch_array($dbquery_master)){
echo  "<option  value ='$result_master[id]'>$result_master[id] $result_master[master_name]</option>" ;
}	
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>กลุ่มสาระ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql_curriculum = "select * from bets_curriculum order by curriculum_code desc";
$dbquery_curriculum = mysqli_query($connect,$sql_curriculum);
while($result_curriculum = mysqli_fetch_array($dbquery_curriculum)){
echo"<optgroup label='หลักสูตร$result_curriculum[curriculum_code]'>";
				$sql = "select  * from bets_group where curriculum_code='$result_curriculum[curriculum_code]' order by id";
				$dbquery = mysqli_query($connect,$sql);
				While ($result = mysqli_fetch_array($dbquery))
				   {
				$group_code = $result['group_code']; 
				$group_name = $result['group_name'];
							if($result['group_code']==$result_ref['group_code']){
							echo  "<option value=$group_code selected>$group_name</option>" ;
							}
							else {
							echo  "<option value=$group_code>$group_name</option>" ;
							}
					}
echo"</optgroup>\n";			
}				
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชั้นสอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='class_room' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option  value ='4'>ป.1</option>" ;
echo  "<option  value ='5'>ป.2</option>" ;
echo  "<option  value ='6'>ป.3</option>" ;
echo  "<option  value ='7'>ป.4</option>" ;
echo  "<option  value ='8'>ป.5</option>" ;
echo  "<option  value ='9'>ป.6</option>" ;
echo  "<option  value ='10'>ม.1</option>" ;
echo  "<option  value ='11'>ม.2</option>" ;
echo  "<option  value ='12'>ม.3</option>" ;
echo  "<option  value ='13'>ม.4</option>" ;
echo  "<option  value ='14'>ม.5</option>" ;
echo  "<option  value ='15'>ม.6</option>" ;
echo "</select>";
echo "</Td></Tr>";


echo "<Tr align='left'><Td width=30></Td><Td align='right'>จำนวนข้อ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='item_num' Size='5'></Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>คะแนนเต็ม&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='test_score' Size='5'></Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เวลาสอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='test_time' Size='5'>นาที</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>คำชี้แจง&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='statement' Size='70'></Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เกณฑ์ประเมินระดับดี&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='g1' Size='5'>% (มากกว่าหรือเท่ากับค่านี้)</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เกณฑ์ประเมินระดับพอใช้&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>อยู่ระหว่างค่าระดับดีกับระดับปรับปรุง</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เกณฑ์ประเมินระดับปรับปรุง&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='g2' Size='5'>% (น้อยกว่าหรือเท่ากับค่านี้)</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เปิดใช้งาน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><input  type=radio name='test_active' value='1' checked>เปิด&nbsp;&nbsp;<input  type=radio name='test_active' value='0'>ปิด</Td></Tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'>";

echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=bets&task=main/test_admin&index=3&id=$_GET[id]&test_id=$_REQUEST[test_id]&page=$_REQUEST[page]\"'>
		&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=bets&task=main/test_admin&test_id=$_REQUEST[test_id]&page=$_REQUEST[page]&index=7\"'";
echo "</td></tr></table>";
}

if($index==2.2) {
echo "<script>alert('การลบแบบทดสอบ จะลบทุกส่วนที่เกี่ยวข้องทั้งหมด จนถึงข้อมูลการสอบของผู้สอบ');</script>\n";
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=bets&task=main/test_admin&index=3.2&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=bets&task=main/test_admin&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from bets_test_schuser where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
$index=7;
}

if($index==3.2){
//ส่วนของคำตอบ
mysqli_query($connect,"delete from bets_answer where test_id='$_GET[id]'");

//ส่วนของรายชื่อผู้เข้าสอบ
$sql = "select id from bets_sch_test where test_id='$_GET[id]'";
$dbquery= mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$school_test_id=$result['id'];		
	mysqli_query($connect,"delete from bets_schtest_testuser where sch_test_id='$school_test_id'");
}

//ส่วน
mysqli_query($connect,"delete from bets_sch_test where test_id='$_GET[id]'");

//ส่วน
mysqli_query($connect,"delete from bets_test_schuser where test_id=$_GET[id]");

//ส่วน
mysqli_query($connect,"delete from bets_test where id=$_GET[id]");
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$f_start_time=explode(".", $_POST['start_time']);
$test_start=$_POST['test_start']." ".$f_start_time[0].":".$f_start_time[1].":"."00";
$f_stop_time=explode(".", $_POST['stop_time']);
$test_stop=$_POST['test_stop']." ".$f_stop_time[0].":".$f_stop_time[1].":"."00";
			$sql = "select  person_id  from person_main order by position_code,person_order";
			$dbquery= mysqli_query($connect,$sql);
			While ($result = mysqli_fetch_array($dbquery)){
					$person_id=$result['person_id'];
					$chk1_start="chk1$person_id";
					$chk2_stop="chk2$person_id";
					
					if(isset($_POST[$chk1_start]) and $_POST[$chk1_start]==1){
							
							$sql_check= "select  id  from bets_test_schuser where teacher='$person_id' and test_id='$_POST[test_id]'";
							$dbquery_check=mysqli_query($connect,$sql_check);
							if(mysqli_fetch_array($dbquery_check)){
							$sql_update = "update bets_test_schuser set start_date='$test_start',stop_date='$test_stop',officer='$officer',rec_date='$rec_date]' where teacher='$person_id' and test_id='$_POST[test_id]'";
							$dbquery_update=mysqli_query($connect,$sql_update);
							}
							else{
							$sql_insert = "insert into bets_test_schuser (test_id,teacher,start_date,stop_date,officer,rec_date) values ( '$_POST[test_id]','$person_id','$test_start','$test_stop','$officer','$rec_date')";
							$dbquery_insert  = mysqli_query($connect,$sql_insert);
							}
					}
			}		
$index=7;			
}

//ส่วนเพิ่มข้อมูลแบบทดสอบ
if($index==4.2){
$rec_date = date("Y-m-d");
$sql_insert = "insert into bets_test (test_name,master_test,s_group,statement,class_room,item_num,test_score,test_time,g1,g2,test_active,officer,rec_date) values ( '$_POST[test_name]','$_POST[master_test]','$_POST[group]','$_POST[statement]','$_POST[class_room]','$_POST[item_num]','$_POST[test_score]','$_POST[test_time]','$_POST[g1]','$_POST[g2]','$_POST[test_active]','$officer','$rec_date')";
$dbquery_insert  = mysqli_query($connect,$sql_insert);
			echo "<script>alert('หลังจากเพิ่มแบบทดสอบแล้ว ลำดับต่อไปต้องกำหนดคุณครูผู้ใช้'); </script>\n";
}
	
//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>แก้ไขช่วงเวลา</B></Font>";
echo "<br>";
echo "<Font color='#006666' Size='2'><B>$_REQUEST[teacher_name]</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
$sql = "select * from bets_test_schuser where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$f_start_date=explode(" ", $result ['start_date']);
$f_stop_date=explode(" ", $result ['stop_date']);
echo "<Table width='70%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right' valign='top'>วันเวลาเริ่ม&nbsp;</Td><Td>";
?>
<script>
var start="<?php echo $f_start_date[0]; ?>"
DateInput('test_start', true, 'YYYY-MM-DD',start)
</script>
<?php
$f_start_time_1=explode(":", $f_start_date[1]);
$f_start_time_2=$f_start_time_1[0].".".$f_start_time_1[1];
$start_select_1=""; $start_select_2=""; $start_select_3=""; $start_select_4=""; $start_select_5=""; $start_select_6=""; $start_select_7=""; $start_select_8=""; $start_select_9=""; $start_select_10=""; $start_select_11=""; $start_select_12=""; $start_select_13=""; $start_select_14=""; $start_select_15=""; $start_select_16=""; $start_select_17=""; $start_select_18=""; $start_select_19=""; $start_select_20=""; $start_select_21=""; 

if($f_start_time_2=="08.00"){
$start_select_1="selected";
}
else if($f_start_time_2=="08.30"){
$start_select_2="selected";
}
else if($f_start_time_2=="09.00"){
$start_select_3="selected";
}
else if($f_start_time_2=="09.30"){
$start_select_4="selected";
}
else if($f_start_time_2=="10.00"){
$start_select_5="selected";
}
else if($f_start_time_2=="10.30"){
$start_select_6="selected";
}
else if($f_start_time_2=="11.00"){
$start_select_7="selected";
}
else if($f_start_time_2=="11.30"){
$start_select_8="selected";
}
else if($f_start_time_2=="12.00"){
$start_select_9="selected";
}
else if($f_start_time_2=="12.30"){
$start_select_10="selected";
}
else if($f_start_time_2=="13.00"){
$start_select_11="selected";
}
else if($f_start_time_2=="13.30"){
$start_select_12="selected";
}
else if($f_start_time_2=="14.00"){
$start_select_13="selected";
}
else if($f_start_time_2=="14.30"){
$start_select_14="selected";
}
else if($f_start_time_2=="15.00"){
$start_select_15="selected";
}
else if($f_start_time_2=="15.30"){
$start_select_16="selected";
}
else if($f_start_time_2=="16.00"){
$start_select_17="selected";
}
else if($f_start_time_2=="16.30"){
$start_select_18="selected";
}
else if($f_start_time_2=="17.00"){
$start_select_19="selected";
}
else if($f_start_time_2=="17.30"){
$start_select_20="selected";
}
else if($f_start_time_2=="18.00"){
$start_select_21="selected";
}
echo "<Select  name='start_time'  size='1'>";
echo  "<option  value = '08.00' $start_select_1>08.00 น.</option>" ;
echo  "<option  value = '08.30' $start_select_2>08.30 น.</option>" ;
echo  "<option  value = '09.00' $start_select_3>09.00 น.</option>" ;
echo  "<option  value = '09.30' $start_select_4>09.30 น.</option>" ;
echo  "<option  value = '10.00' $start_select_5>10.00 น.</option>" ;
echo  "<option  value = '10.30' $start_select_6>10.30 น.</option>" ;
echo  "<option  value = '11.00' $start_select_7>11.00 น.</option>" ;
echo  "<option  value = '11.30' $start_select_8>11.30 น.</option>" ;
echo  "<option  value = '12.00' $start_select_9>12.00 น.</option>" ;
echo  "<option  value = '12.30' $start_select_10>12.30 น.</option>" ;
echo  "<option  value = '13.00' $start_select_11>13.00 น.</option>" ;
echo  "<option  value = '13.30' $start_select_12>13.30 น.</option>" ;
echo  "<option  value = '14.00' $start_select_13>14.00 น.</option>" ;
echo  "<option  value = '14.30' $start_select_14>14.30 น.</option>" ;
echo  "<option  value = '15.00' $start_select_15>15.00 น.</option>" ;
echo  "<option  value = '15.30' $start_select_16>15.30 น.</option>" ;
echo  "<option  value = '16.00' $start_select_17>16.00 น.</option>" ;
echo  "<option  value = '16.30' $start_select_18>16.30 น.</option>" ;
echo  "<option  value = '17.00' $start_select_19>17.00 น.</option>" ;
echo  "<option  value = '17.30' $start_select_20>17.30 น.</option>" ;
echo  "<option  value = '18.00' $start_select_21>18.00 น.</option>" ;
echo "</select>";
echo "</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right' valign='top'>วันเวลาสิ้นสุด&nbsp;</Td><Td>";
?>
<script>
var stop="<?php echo $f_stop_date[0]; ?>"
DateInput('test_stop', true, 'YYYY-MM-DD',stop)
</script>
<?php
$f_stop_time_1=explode(":", $f_stop_date[1]);
$f_stop_time_2=$f_stop_time_1[0].".".$f_stop_time_1[1];
$stop_select_1=""; $stop_select_2=""; $stop_select_3=""; $stop_select_4=""; $stop_select_5=""; $stop_select_6=""; $stop_select_7=""; $stop_select_8=""; $stop_select_9=""; $stop_select_10=""; $stop_select_11=""; $stop_select_12=""; $stop_select_13=""; $stop_select_14=""; $stop_select_15=""; $stop_select_16=""; $stop_select_17=""; $stop_select_18=""; $stop_select_19=""; $stop_select_20=""; $stop_select_21=""; 
if($f_stop_time_2=="08.00"){
$stop_select_1="selected";
}
else if($f_stop_time_2=="08.30"){
$stop_select_2="selected";
}
else if($f_stop_time_2=="09.00"){
$stop_select_3="selected";
}
else if($f_stop_time_2=="09.30"){
$stop_select_4="selected";
}
else if($f_stop_time_2=="10.00"){
$stop_select_5="selected";
}
else if($f_stop_time_2=="10.30"){
$stop_select_6="selected";
}
else if($f_stop_time_2=="11.00"){
$stop_select_7="selected";
}
else if($f_stop_time_2=="11.30"){
$stop_select_8="selected";
}
else if($f_stop_time_2=="12.00"){
$stop_select_9="selected";
}
else if($f_stop_time_2=="12.30"){
$stop_select_10="selected";
}
else if($f_stop_time_2=="13.00"){
$stop_select_11="selected";
}
else if($f_stop_time_2=="13.30"){
$stop_select_12="selected";
}
else if($f_stop_time_2=="14.00"){
$stop_select_13="selected";
}
else if($f_stop_time_2=="14.30"){
$stop_select_14="selected";
}
else if($f_stop_time_2=="15.00"){
$stop_select_15="selected";
}
else if($f_stop_time_2=="15.30"){
$stop_select_16="selected";
}
else if($f_stop_time_2=="16.00"){
$stop_select_17="selected";
}
else if($f_stop_time_2=="16.30"){
$stop_select_18="selected";
}
else if($f_stop_time_2=="17.00"){
$stop_select_19="selected";
}
else if($f_stop_time_2=="17.30"){
$stop_select_20="selected";
}
else if($f_stop_time_2=="18.00"){
$stop_select_21="selected";
}
echo "<Select  name='stop_time'  size='1'>";
echo  "<option  value = '08.00' $stop_select_1>08.00 น.</option>" ;
echo  "<option  value = '08.30' $stop_select_2>08.30 น.</option>" ;
echo  "<option  value = '09.00' $stop_select_3>09.00 น.</option>" ;
echo  "<option  value = '09.30' $stop_select_4>09.30 น.</option>" ;
echo  "<option  value = '10.00' $stop_select_5>10.00 น.</option>" ;
echo  "<option  value = '10.30' $stop_select_6>10.30 น.</option>" ;
echo  "<option  value = '11.00' $stop_select_7>11.00 น.</option>" ;
echo  "<option  value = '11.30' $stop_select_8>11.30 น.</option>" ;
echo  "<option  value = '12.00' $stop_select_9>12.00 น.</option>" ;
echo  "<option  value = '12.30' $stop_select_10>12.30 น.</option>" ;
echo  "<option  value = '13.00' $stop_select_11>13.00 น.</option>" ;
echo  "<option  value = '13.30' $stop_select_12>13.30 น.</option>" ;
echo  "<option  value = '14.00' $stop_select_13>14.00 น.</option>" ;
echo  "<option  value = '14.30' $stop_select_14>14.30 น.</option>" ;
echo  "<option  value = '15.00' $stop_select_15>15.00 น.</option>" ;
echo  "<option  value = '15.30' $stop_select_16>15.30 น.</option>" ;
echo  "<option  value = '16.00' $stop_select_17>16.00 น.</option>" ;
echo  "<option  value = '16.30' $stop_select_18>16.30 น.</option>" ;
echo  "<option  value = '17.00' $stop_select_19>17.00 น.</option>" ;
echo  "<option  value = '17.30' $stop_select_20>17.30 น.</option>" ;
echo  "<option  value = '18.00' $stop_select_21>18.00 น.</option>" ;
echo "</select>";
echo "</Td></Tr>";
echo "</Table>";
echo "<Br />";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='test_id' Value='$_GET[test_id]'>";
if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
echo "<input type='hidden' name='page' value='$_REQUEST[page]'>";	
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>
		&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'>";
echo "</form>";
}

if($index==5.2){
$sql = "select * from bets_test where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขแบบทดสอบ</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table width='60%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>ชื่อแบบทดสอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='test_name' Size='40' value='$result[test_name]'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชุดข้อคำถาม&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
$sql = "select * from  bets_master_test where officer='$officer' order by id desc";
$dbquery_master = mysqli_query($connect,$sql);
echo "<Select  name='master_test' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
While ($result_master = mysqli_fetch_array($dbquery_master)){
		if($result['master_test']==$result_master['id']){
		echo  "<option  value ='$result_master[id]' selected>$result_master[id] $result_master[master_name]</option>" ;
		}
		else{
		echo  "<option  value ='$result_master[id]'>$result_master[id] $result_master[master_name]</option>" ;
		}
}	
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>กลุ่มสาระ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql_curriculum = "select * from bets_curriculum order by curriculum_code desc";
$dbquery_curriculum = mysqli_query($connect,$sql_curriculum);
while($result_curriculum = mysqli_fetch_array($dbquery_curriculum)){
echo"<optgroup label='หลักสูตร$result_curriculum[curriculum_code]'>";
				$sql = "select  * from bets_group where curriculum_code='$result_curriculum[curriculum_code]' order by id";
				$dbquery = mysqli_query($connect,$sql);
				While ($result_g = mysqli_fetch_array($dbquery))
				   {
				$group_code = $result_g['group_code']; 
				$group_name = $result_g['group_name'];
							if($result_g['group_code']==$result['s_group']){
							echo  "<option value=$group_code selected>$group_name</option>" ;
							}
							else {
							echo  "<option value=$group_code>$group_name</option>" ;
							}
					}
echo"</optgroup>\n";			
}				
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชั้นสอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='class_room' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
if($result['class_room']==4){
echo  "<option  value ='4' selected>ป.1</option>" ;
}
else{
echo  "<option  value ='4'>ป.1</option>" ;
}
if($result['class_room']==5){
echo  "<option  value ='5' selected>ป.2</option>" ;
}
else{
echo  "<option  value ='5'>ป.2</option>" ;
}
if($result['class_room']==6){
echo  "<option  value ='6' selected>ป.3</option>" ;
}
else{
echo  "<option  value ='6'>ป.3</option>" ;
}
if($result['class_room']==7){
echo  "<option  value ='7' selected>ป.4</option>" ;
}
else{
echo  "<option  value ='7'>ป.4</option>" ;
}
if($result['class_room']==8){
echo  "<option  value ='8' selected>ป.5</option>" ;
}
else{
echo  "<option  value ='8'>ป.5</option>" ;
}
if($result['class_room']==9){
echo  "<option  value ='9' selected>ป.6</option>" ;
}
else{
echo  "<option  value ='9'>ป.6</option>" ;
}
if($result['class_room']==10){
echo  "<option  value ='10' selected>ม.1</option>" ;
}
else{
echo  "<option  value ='10'>ม.1</option>" ;
}
if($result['class_room']==11){
echo  "<option  value ='11' selected>ม.2</option>" ;
}
else{
echo  "<option  value ='11'>ม.2</option>" ;
}
if($result['class_room']==12){
echo  "<option  value ='12' selected>ม.3</option>" ;
}
else{
echo  "<option  value ='12'>ม.3</option>" ;
}
if($result['class_room']==13){
echo  "<option  value ='13' selected>ม.4</option>" ;
}
else{
echo  "<option  value ='13'>ม.4</option>" ;
}
if($result['class_room']==14){
echo  "<option  value ='14' selected>ม.5</option>" ;
}
else{
echo  "<option  value ='14'>ม.5</option>" ;
}
if($result['class_room']==15){
echo  "<option  value ='15' selected>ม.6</option>" ;
}
else{
echo  "<option  value ='15'>ม.6</option>" ;
}
echo "</select>";
echo "</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>จำนวนข้อ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='item_num' Size='5' value='$result[item_num]'></Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>คะแนนเต็ม&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='test_score' Size='5' value='$result[test_score]'></Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เวลาสอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='test_time' Size='5' value='$result[test_time]'>นาที</Td></Tr>";

if($result['test_active']==1){
$active_check_1="checked";
$active_check_2="";
}
else{
$active_check_1="";
$active_check_2="checked";
}
echo "<Tr align='left'><Td width=30></Td><Td align='right'>คำชี้แจง&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='statement' Size='70' value='$result[statement]'></Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เกณฑ์ประเมินระดับดี&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='g1' Size='5' value='$result[g1]'>% (มากกว่าหรือเท่ากับค่านี้)</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เกณฑ์ประเมินระดับพอใช้&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>อยู่ระหว่างค่าระดับดีกับระดับปรับปรุง</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เกณฑ์ประเมินระดับปรับปรุง&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='g2' Size='5' value='$result[g2]'>% (น้อยกว่าหรือเท่ากับค่านี้)</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เปิดใช้งาน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>เปิด<input  type=radio name='test_active' value='1' $active_check_1>&nbsp;&nbsp;ปิด<input  type=radio name='test_active' value='0' $active_check_2></Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<input type='hidden' name='page' value='$_REQUEST[page]'>";	
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update2(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update2(0)'>";

echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$f_start_time=explode(".", $_POST['start_time']);
$test_start=$_POST['test_start']." ".$f_start_time[0].":".$f_start_time[1].":"."00";
$f_stop_time=explode(".", $_POST['stop_time']);
$test_stop=$_POST['test_stop']." ".$f_stop_time[0].":".$f_stop_time[1].":"."00";
$sql = "update bets_test_schuser set start_date='$test_start', stop_date='$test_stop',officer='$officer',rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
$index=7;
}

if ($index==6.2){
$sql = "update bets_test set  test_active='$_GET[active]' where id='$_GET[test_id]'";
$dbquery = mysqli_query($connect,$sql);
}

if ($index==6.4){
$sql = "update bets_test set test_name='$_POST[test_name]',master_test='$_POST[master_test]',s_group='$_POST[group]',statement='$_POST[statement]',class_room='$_POST[class_room]',item_num='$_POST[item_num]',test_score='$_POST[test_score]',test_time='$_POST[test_time]',g1='$_POST[g1]',g2='$_POST[g2]',test_active='$_POST[test_active]',officer=$officer where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนเพิ่มข้อมูล
if($index==7){
$sql_test = "select * from bets_test where id='$_REQUEST[test_id]'";
$dbquery_test = mysqli_query($connect,$sql_test);
$result_test=mysqli_fetch_array($dbquery_test);
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>กำหนดผู้ใช้แบบทดสอบ และวันเวลาใช้</B></Font><br>";
echo "<Font color='#006666' Size='2'><B>$result_test[test_name]</B></Font> (รหัสการสอบ $result_test[id])";
echo "</Cener>";
echo "<form id='frm1' name='frm1'>";
echo  "<table width='90%' border='0' align='center'>";
echo "<Tr align='center'><Td colspan='2'></Td><Td><font color='#006666' size='2'>วันเวลาเริ่ม</font></Td><Td><font color='#006666' size='2'>วันเวลาสิ้นสุด</font></Td><td colspan='2' align='right'><a href=?option=bets&task=main/test_admin&page=$_REQUEST[page]><<กลับ</a></td></Tr>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td><Td>ชื่อ</Td><Td width='250'>";
?>
<script>DateInput('test_start', true, 'YYYY-MM-DD')</script>
<?php
echo "เวลา ";
echo "<Select  name='start_time'  size='1'>";
echo  "<option  value = '08.00'>08.00 น.</option>" ;
echo  "<option  value = '08.30'>08.30 น.</option>" ;
echo  "<option  value = '09.00'>09.00 น.</option>" ;
echo  "<option  value = '09.30'>09.30 น.</option>" ;
echo  "<option  value = '10.00'>10.00 น.</option>" ;
echo  "<option  value = '10.30'>10.30 น.</option>" ;
echo  "<option  value = '11.00'>11.00 น.</option>" ;
echo  "<option  value = '11.30'>11.30 น.</option>" ;
echo  "<option  value = '12.00'>12.00 น.</option>" ;
echo  "<option  value = '12.30'>12.30 น.</option>" ;
echo  "<option  value = '13.00'>13.00 น.</option>" ;
echo  "<option  value = '13.30'>13.30 น.</option>" ;
echo  "<option  value = '14.00'>14.00 น.</option>" ;
echo  "<option  value = '14.30'>14.30 น.</option>" ;
echo  "<option  value = '15.00'>15.00 น.</option>" ;
echo  "<option  value = '15.30'>15.30 น.</option>" ;
echo  "<option  value = '16.00'>16.00 น.</option>" ;
echo  "<option  value = '16.30'>16.30 น.</option>" ;
echo  "<option  value = '17.00'>17.00 น.</option>" ;
echo  "<option  value = '17.30'>17.30 น.</option>" ;
echo  "<option  value = '18.00'>18.00 น.</option>" ;
echo "</select>";
echo "<br>";
echo "<div align='left'><input type='checkbox' name='allchk' id='allchk' onclick='CheckAll()'><font color='#006666'>เลือกทั้งหมด</font></div>";
echo "</Td><Td width='250'>";
?>
<script>DateInput('test_stop', true, 'YYYY-MM-DD')</script>
<?php
echo "เวลา ";
echo "<Select  name='stop_time'  size='1'>";
echo  "<option  value = '08.00'>08.00 น.</option>" ;
echo  "<option  value = '08.30'>08.30 น.</option>" ;
echo  "<option  value = '09.00'>09.00 น.</option>" ;
echo  "<option  value = '09.30'>09.30 น.</option>" ;
echo  "<option  value = '10.00'>10.00 น.</option>" ;
echo  "<option  value = '10.30'>10.30 น.</option>" ;
echo  "<option  value = '11.00'>11.00 น.</option>" ;
echo  "<option  value = '11.30'>11.30 น.</option>" ;
echo  "<option  value = '12.00'>12.00 น.</option>" ;
echo  "<option  value = '12.30'>12.30 น.</option>" ;
echo  "<option  value = '13.00'>13.00 น.</option>" ;
echo  "<option  value = '13.30'>13.30 น.</option>" ;
echo  "<option  value = '14.00'>14.00 น.</option>" ;
echo  "<option  value = '14.30'>14.30 น.</option>" ;
echo  "<option  value = '15.00'>15.00 น.</option>" ;
echo  "<option  value = '15.30'>15.30 น.</option>" ;
echo  "<option  value = '16.00'>16.00 น.</option>" ;
echo  "<option  value = '16.30'>16.30 น.</option>" ;
echo  "<option  value = '17.00'>17.00 น.</option>" ;
echo  "<option  value = '17.30'>17.30 น.</option>" ;
echo  "<option  value = '18.00' selected>18.00 น.</option>" ;
echo "</select>";
echo "</Td>";
echo "<Td width='40'>ลบ</Td>";
echo "<td width='40'>แก้ไข</td>";
echo "</Tr>";
$sql = "select  * from person_main where status='0' order by position_code,person_order";

$dbquery = mysqli_query($connect,$sql);

$N=1;
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$person_id= $result['person_id'];
		$prename= $result['prename'];
		$name= $result['name'];
		$surname= $result['surname'];
		$fullname="$prename$name&nbsp;$surname";
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
			
			$sql_check= "select id,start_date,stop_date  from bets_test_schuser where teacher='$person_id' and test_id='$_REQUEST[test_id]'";
			$dbquery_check=mysqli_query($connect,$sql_check);
			$result_check = mysqli_fetch_array($dbquery_check);
			
echo "<Tr  bgcolor=$color align=center><Td>$N</Td><Td align='left'>$fullname</Td>";

		if($result_check){
		$start_1=thai_date_4($result_check['start_date']);
		$stop_1=thai_date_4($result_check['stop_date']);
		echo "<td align='left'><input type='checkbox' name='chk1$person_id' id='chk1$person_id' value='1'>";
		echo $start_1;
		echo "</td>";
		echo "<td align='left'>";
		echo $stop_1;
		echo "</td>";
		}
		else{
		echo "<td align='left'>";
if($result_test['officer']==$officer){			
		echo "<input type='checkbox' name='chk1$person_id' id='chk1$person_id' value='1'><font color='#006666'>เลือก</font>";
}
		echo "</td>";
		echo "<td></td>";
		}
if($result_test['officer']==$officer){				
		echo "<td valign='top' align='center'>";
		if($result_check){
		echo "<a href=?option=bets&task=main/test_admin&index=2&id=$result_check[id]&test_id=$_REQUEST[test_id]&page=$_REQUEST[page]><img src=images/drop.png border='0' alt='ลบ'></a>";
		}
		echo "</td>";
		echo "<Td valign='top' align='center'>";
		if($result_check){
		echo "<a href=?option=bets&task=main/test_admin&index=5&id=$result_check[id]&test_id=$_REQUEST[test_id]&teacher_name=$fullname&page=$_REQUEST[page]><img src=images/edit.png border='0' alt='แก้ไข'></a>";
		}
		echo "</Td>";
}
else{
echo "<td></td><td></td>";
}
echo "</Tr>";
$M++;
$N++;
	}
echo "<input type='hidden' name='test_id' value='$result_test[id]'>";	
echo "<input type='hidden' name='page' value='$_REQUEST[page]'>";	
if($result_test['officer']==$officer){	
echo "<tr bgcolor='#FFCCCC'><td align='center' colspan='6'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url2(1)'></td></tr>";
}
else{
echo "<tr bgcolor='#FFCCCC'><td align='center' colspan='6'></td></tr>";
}
echo "</Table>";
echo "</form>";
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==2.2) or ($index==3) or ($index==4) or ($index==5) or ($index==5.2) or ($index==6) or ($index==7))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>แบบทดสอบ</strong></font></td></tr>";
echo "</table>";
	
$sql_page ="select *,bets_test.id, bets_test.test_name,bets_test.class_room,bets_test.test_active, bets_master_test.master_name from bets_test,bets_master_test,bets_group where bets_test.master_test=bets_master_test.id and bets_test.s_group=bets_group.group_code and bets_test.officer='$officer' ";
$dbquery_page = mysqli_query($connect,$sql_page);
$num_rows=mysqli_num_rows($dbquery_page);

$pagelen=20; // กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/test_admin";
$totalpages=ceil($num_rows/$pagelen);
if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
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

echo "<form id='frm1' name='frm1'>";
echo "<table width='95%' align='center'><tr><Td align='left'><INPUT TYPE='button' name='smb' value='เพิ่มแบบทดสอบ' onclick='location.href=\"?option=bets&task=main/test_admin&index=1\"'></Td><td align='right'>";
echo "</td></tr></table>";

$sql = "select *,bets_test.officer,bets_test.id, bets_test.test_name,bets_test.class_room,bets_test.test_active, bets_master_test.master_name from bets_test,bets_master_test,bets_group where bets_test.master_test=bets_master_test.id and bets_test.s_group=bets_group.group_code and bets_test.officer='$officer' order by bets_test.id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='95%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>ลำดับที่</Td><Td width='80'>รหัสรายการ</Td><Td>ชื่อแบบทดสอบ</Td><Td>กลุ่มสาระ</Td><Td>แบบทดสอบ(ต้นฉบับ)</Td><Td width='70'>ชั้น</Td><Td width='70'>จำนวนข้อ</Td><Td width='70'>คะแนนเต็ม</Td><Td width='70'>เวลาสอบ<br>นาที</Td><Td width='70'>เกณฑ์</Td><Td width='70'>เปิด/ปิด<br>[คลิก]</Td><Td  width='50'>ลบ</Td><Td width='50'>แก้ไข</Td><Td width='70'>กำหนดผู้ใช้</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$test_name= $result['test_name'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr bgcolor=$color align='center'><Td>$N</Td><Td>$id</Td><Td align='left'>$test_name</Td><Td align='left'>$result[group_name]</Td><Td align='left'>$result[master_name]</Td>";
echo "<td>";
if($result['class_room']==4){
echo "ป.1";
}
else if($result['class_room']==5){
echo "ป.2";
}
else if($result['class_room']==6){
echo "ป.3";
}
else if($result['class_room']==7){
echo "ป.4";
}
else if($result['class_room']==8){
echo "ป.5";
}
else if($result['class_room']==9){
echo "ป.6";
}
else if($result['class_room']==10){
echo "ม.1";
}
else if($result['class_room']==11){
echo "ม.2";
}
else if($result['class_room']==12){
echo "ม.3";
}
else if($result['class_room']==13){
echo "ม.4";
}
else if($result['class_room']==14){
echo "ม.5";
}
else if($result['class_room']==15){
echo "ม.6";
}
echo "</td>";
echo "<td align='center'>$result[item_num]</td><td align='center'>$result[test_score]</td><td align='center'>$result[test_time]</td><td align='center'>$result[g1]/$result[g2]</td>";
echo "<td>";
if($result['test_active']==1){
			if($result['officer']==$officer){		
			echo "<a href=?option=bets&task=main/test_admin&test_id=$id&active=0&index=6.2&page=$page><img src=images/yes.png border='0'></a>";
			}
			else{
			echo "<img src=images/yes.png border='0'>";
			}
}
else{
			if($result['officer']==$officer){		
			echo "<a href=?option=bets&task=main/test_admin&test_id=$id&active=1&index=6.2&page=$page><img src=images/no.png border='0'></a>";
			}
			else{
			echo "<img src=images/no.png border='0'>";
			}
}
echo "</td>";
if($result['officer']==$officer){		
echo "<Td><a href=?option=bets&task=main/test_admin&index=2.2&id=$id&page=$page><img src=images/drop.png border='0'></a></div></Td>";
echo "<Td><a href=?option=bets&task=main/test_admin&index=5.2&id=$id&page=$page><img src=images/edit.png border='0'></a></div></Td>";
}
else{
echo "<td></td><td></td>";
}
echo "<Td><a href=?option=bets&task=main/test_admin&index=7&test_id=$id&page=$page><img src=images/edit.png border='0'></a></div></Td>";
echo "</Tr>";
$M++;
$N++;
	}
echo "</Table>";
echo "</form>";
}
?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=bets&task=main/test_admin"); 
	}else if(val==1){
		if(frm1.test_name.value == ""){
			alert("กรุณากรอกชื่อแบบทดสอบ");
		}else if(frm1.master_test.value == ""){
			alert("กรุณาเลือกชุดข้อคำถามที่จะใช้");
		}else if(frm1.group.value == ""){
			alert("กรุณาเลือกกลุ่มสาระ");
		}else if(frm1.class_room.value==""){
			alert("กรุณาเลือกชั้นสอบ");
		}else if(frm1.item_num.value==""){
			alert("กรุณาระบุจำนวนข้อ");
		}else if((frm1.test_score.value=="0") || (frm1.test_score.value=="")){
			alert("กรุณาระบุคะแนนเต็ม");
		}else if(frm1.test_time.value==""){
			alert("กรุณาระบุเวลาสอบ");
		}else if(frm1.g1.value==""){
			alert("กรุณาระบุเกณฑ์ระดับดี");
		}else if(frm1.g2.value==""){
			alert("กรุณาระบุเกณฑ์ระดับปรับปรุง");
		}else{
			callfrm("?option=bets&task=main/test_admin&index=4.2"); 
		}
	}
}

function goto_url2(val){
callfrm("?option=bets&task=main/test_admin&index=4"); 
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=bets&task=main/test_admin&index=7"); 
	}else if(val==1){
			callfrm("?option=bets&task=main/test_admin&index=6"); 
	}
}

function goto_url_update2(val){
	if(val==0){
		callfrm("?option=bets&task=main/test_admin"); 
	}else if(val==1){
		if(frm1.test_name.value == ""){
			alert("กรุณากรอกชื่อแบบทดสอบ");
		}else if(frm1.master_test.value == ""){
			alert("กรุณาเลือกชุดข้อคำถามที่จะใช้");
		}else if(frm1.group.value == ""){
			alert("กรุณาเลือกกลุ่มสาระ");
		}else if(frm1.class_room.value==""){
			alert("กรุณาเลือกชั้นสอบ");
		}else if(frm1.item_num.value==""){
			alert("กรุณาระบุจำนวนข้อ");
		}else if((frm1.test_score.value=="0") || (frm1.test_score.value=="")){
			alert("กรุณาระบุคะแนนเต็ม");
		}else if(frm1.test_time.value==""){
			alert("กรุณาระบุเวลาสอบ");
		}else if(frm1.g1.value==""){
			alert("กรุณาระบุเกณฑ์ระดับดี");
		}else if(frm1.g2.value==""){
			alert("กรุณาระบุเกณฑ์ระดับปรับปรุง");
		}else{
			callfrm("?option=bets&task=main/test_admin&index=6.4"); 
		}	
	}
}

function CheckAll() {
	for (var i = 0; i < document.frm1.elements.length; i++)
	{
	var e = document.frm1.elements[i];
	if (e.name != "allchk")
		if(e.value==1 && e.type=="checkbox"){
		e.checked = document.frm1.allchk.checked;
		}
	}
}

</script>
