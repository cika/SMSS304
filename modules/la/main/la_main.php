<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
require_once "modules/la/time_inc.php";	

?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script> 
<?php

$user=$_SESSION['login_user_id'];

if(!isset($_POST['no_comment'])){
$_POST['no_comment']="";
}

//ฟังชั่นupload
function file_upload() {
		$uploaddir = 'modules/la/upload_files/';      //ที่เก็บไไฟล์
		$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
		$basename = basename($_FILES['userfile']['name']);

		if (move_uploaded_file($_FILES['userfile']['tmp_name'],  $uploadfile))
			{
				$rand_num=rand();
				$time_mk=mktime();
				$txt ="doc_".$time_mk.$rand_num;
				$before_name  = $uploaddir . $basename;
				///////
				$array_lastname = explode("." ,$basename) ;
				 $c =count ($array_lastname) - 1 ;
				 $lastname = strtolower ($array_lastname[$c]) ;
				$changed_name = $uploaddir.$txt.".".$lastname;
				///////
				rename("$before_name" , "$changed_name");
				return  $changed_name;
			}
		else
			{
			return  $changed_name;
			}
}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==1.1) or ($index==1.2) or ($index==2) or ($index==5) or ($index==7))){

$sql_name = "select * from person_main where person_id='$user'";
$dbquery_name = mysqli_query($connect,$sql_name);
$result_name = mysqli_fetch_array($dbquery_name);
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
		$position_code = $result_name['position_code'];
$full_name="$prename$name&nbsp;&nbsp;$surname";

echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ทะเบียนการลา</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>$full_name</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){

//สถิติ
$cur_date = date("Y-m-d"); 
$f_date=explode("-", $cur_date);
if($f_date[1]>9){
$year=$f_date[0]+544;
}
else{
$year=$f_date[0]+543;
}
$start_year=$year-544;
$end_year=$year-543;
$start_date=$start_year."-10-01";
$end_date=$end_year."-09-30";

	$sick_num=0;
	$sick_day=0;
	$busy_num=0;
	$busy_day=0;
	$kod_num=0;
	$kod_day=0;
	
$sick_num_cancel=0;
$busy_num_cancel=0;
$kod_num_cancel=0;
	
$sick_day_cancel=0;
$busy_day_cancel=0;
$kod_day_cancel=0;

$cancel_la_start='';

			$sql_la=	"select  la_type, la_total from la_main where person_id='$user' and (la_start>='$start_date') and (la_finish<='$end_date') and commander_grant='1' " ;	
			$query_la= mysqli_query($connect,$sql_la);
			While ($result_la= mysqli_fetch_array($query_la)){ 
					if($result_la['la_type']==1){
					$sick_num=$sick_num+1;
					$sick_day=$sick_day+$result_la['la_total'];
					}
					else if($result_la['la_type']==2){
					$busy_num=$busy_num+1;
					$busy_day=$busy_day+$result_la['la_total'];
					}
					else if($result_la['la_type']==3){
					$kod_num=$kod_num+1;
					$kod_day=$kod_day+$result_la['la_total'];
					}
			}
			
			$sql_la=	"select  * from la_cancel where person_id='$user' and (cancel_la_start>='$start_date') and (cancel_la_finish<='$end_date')  and commander_grant='1' " ;	
			$query_la= mysqli_query($connect,$sql_la);
			While ($result_la= mysqli_fetch_array($query_la)){ 
					$cancel_la_type=$result_la['la_type'];
					$cancel_la_start=$result_la['cancel_la_start'];
					$cancel_la_finish=$result_la['cancel_la_finish'];
					if($result_la['la_type']==1){
							$sql_chk="select  la_type, la_total from la_main where person_id='$user' and (la_start='$cancel_la_start') and (la_finish='$cancel_la_finish') and commander_grant='1' and $cancel_la_type='1' " ;	
							$query_chk= mysqli_query($connect,$sql_chk);
							if(mysqli_fetch_array($query_chk)){
							$sick_num_cancel=$sick_num_cancel+1;		
							}
					$sick_day_cancel=$sick_day_cancel+$result_la['cancel_la_total'];
					}
					else if($result_la['la_type']==2){
							$sql_chk="select  la_type, la_total from la_main where person_id='$user' and (la_start='$cancel_la_start') and (la_finish='$cancel_la_finish') and commander_grant='1' and $cancel_la_type='2' " ;	
							$query_chk= mysqli_query($connect,$sql_chk);
							if(mysqli_fetch_array($query_chk)){
							$busy_num_cancel=$busy_num_cancel+1;
							}
					$busy_day_cancel=$busy_day_cancel+$result_la['cancel_la_total'];
					}
					else if($result_la['la_type']==3){
							$sql_chk="select  la_type, la_total from la_main where person_id='$user' and (la_start='$cancel_la_start') and (la_finish='$cancel_la_finish') and commander_grant='1' and $cancel_la_type='3' " ;	
							$query_chk= mysqli_query($connect,$sql_chk);
							if(mysqli_fetch_array($query_chk)){
							$kod_num_cancel=$kod_num_cancel+1;
							}
					$kod_day_cancel=$kod_day_cancel+$result_la['cancel_la_total'];
					}
			}
			$sick_day=$sick_day-$sick_day_cancel;  //วันลาป่วยหักยกเลิกวันลา
			$busy_day=$busy_day-$busy_day_cancel;
			$kod_day=$kod_day-$kod_day_cancel;
			
			//จำนวนวัน
				$sick_num=$sick_num-$sick_num_cancel;
				$busy_num=$busy_num-$busy_num_cancel;
				$kod_num=$kod_num-$kod_num_cancel;

// end สถิติ

echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>บันทึกขออนุญาตลาป่วย ลากิจ ลาคลอด</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='90%'>";

echo "<Tr align='left'><Td align='right'>เขียนที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='write_at' Size='60'></Td></Tr>";

echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='la_type' value='1'>ลาป่วย&nbsp;&nbsp;<Input Type='radio' Name='la_type' value='2'>ลากิจ&nbsp;&nbsp;<Input Type='radio' Name='la_type' value='3'>ลาคลอด</Td></Tr>";

echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[school_name]</Td></Tr>";

echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$_SESSION[login_prename]$_SESSION[login_name]&nbsp;&nbsp;$_SESSION[login_surname]&nbsp;&nbsp;ตำแหน่ง$_SESSION[login_userposition]</Td></Tr>";

echo "<Tr align='left'><Td align='right'>เนื่องจาก&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='because' Size='60'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>ขอลาตั้งแต่วันที่&nbsp;&nbsp;</Td>";

echo "<Td align='left'>";
?>
<script>
								var Y_date=<?php echo date("Y")?>  
								var m_date=<?php echo date("m")?>  
								var d_date=<?php echo date("d")?>  
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('la_start', true, 'YYYY-MM-DD', Y_date)</script> 
<?php
								
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";

echo "<Td align='left'>";

?>
<script>
								var Y_date=<?php echo date("Y")?>  
								var m_date=<?php echo date("m")?>  
								var d_date=<?php echo date("d")?>  
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('la_finish', true, 'YYYY-MM-DD', Y_date)</script> 
<?php echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";

echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='la_total' Size='5'>&nbsp;&nbsp;วัน";

echo "<Tr align='left'><Td align='right'>ลาครั้งสุดท้ายตั้งแต่วันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
?>
<script>
								var Y_date=<?php echo date("Y")?>  
								var m_date=<?php echo date("m")?>  
								var d_date=<?php echo date("d")?>  
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('last_la_start', true, 'YYYY-MM-DD', Y_date)</script> 
<?php echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
?>
<script>
								var Y_date=<?php echo date("Y")?>  
								var m_date=<?php echo date("m")?>  
								var d_date=<?php echo date("d")?>  
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('last_la_finish', true, 'YYYY-MM-DD', Y_date)</script> 
<?php echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='last_la_total' Size='5'>&nbsp;&nbsp;วัน";


echo "<Tr align='left'><Td align='right'>ระหว่างลาติดต่อได้ที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='contact' Size='60'>&nbsp;&nbsp;เบอร์โทรศัพท์&nbsp;&nbsp;<Input Type='Text' Name='contact_tel'  Size='10'></Td></Tr>";

echo  "<tr align='left'>";
echo  "<td align='right'>เอกสาร(ถ้ามี)&nbsp;&nbsp;</td>";
echo  "<td align='left'><input name = 'userfile' type = 'file'></td>";
echo  "</tr>";
echo "<Tr align='left'><Td align='right'>ไม่ต้องผ่านผู้บังคับบัญชาขั้นต้น&nbsp;&nbsp;</Td><Td><input type='checkbox'  name='no_comment' id='no_comment' value='1'>&nbsp;&nbsp;(เลือกกรณีผู้บังคับบัญชาขั้นต้นไม่ได้ปฏิบัติราชการ)</Td></Tr>";
echo "<Tr align='left'><Td align='right'>เลือกผู้อนุมัติ (ปกติไม่ต้องเลือก)&nbsp;&nbsp;</Td><Td><Select  name='grant_p_selected'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from person_main where status='0' and (position_code='1' or position_code='2') order by position_code,person_order";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		echo  "<option value = $person_id>$name $surname</option>";
	}
echo "</select>";
echo "&nbsp;&nbsp;(ใช้กรณีผู้อนุมัติปกติไม่อยู่) </Td></Tr>";

echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>";

echo "<table><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>สถิติการลาในปีงบประมาณนี้</B>: &nbsp;</legend>";
echo "<table border='1'>";
echo "<tr align='center'><td>ประเภทการลา</td><td>ลามาแล้ว<br>(วันทำการ)</td><td>ลาครั้งนี้<br>(วันทำการ)</td><td>รวมเป็น<br>(วันทำการ)</td></tr>";

echo "<tr align='center'><td>ป่วย</td><td><Input Type='Text' Name='sick_ago'  Size='5' value='$sick_day'></td><td><Input Type='Text' Name='sick_this' Size='5'></td><td><Input Type='Text' Name='sick_total' Size='5'></td></tr>";

echo "<tr align='center'><td>กิจส่วนตัว</td><td><Input Type='Text' Name='privacy_ago' Size='5' value='$busy_day'></td><td><Input Type='Text' Name='privacy_this' Size='5'></td><td><Input Type='Text' Name='privacy_total' Size='5'></td></tr>";

echo "<tr align='center'><td>คลอดบุตร</td><td><Input Type='Text' Name='birth_ago' Size='5' value='$kod_day'></td><td><Input Type='Text' Name='birth_this' Size='5'></td><td><Input Type='Text' Name='birth_total' Size='5'></td></tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";


echo "</Td></tr>";


echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'>";
echo "</form>";
}

if($index==1.1){

//สถิติ
$cur_date = date("Y-m-d"); 
$f_date=explode("-", $cur_date);
if($f_date[1]>9){
$year=$f_date[0]+544;
}
else{
$year=$f_date[0]+543;
}
$start_year=$year-544;
$end_year=$year-543;
$start_date=$start_year."-10-01";
$end_date=$end_year."-09-30";

//อาเรย์วันลาสะสม
$sql = "select * from la_collect where year='$year' and person_id='$user'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$collect_day=$result['collect_day'];
$this_year_day=$result['this_year_day'];
$total_day=$collect_day+$this_year_day;

	$sum_collect=0;
	$rest=0;
	$la_num=0;
	$la_day=0;
	$la_cancel_num=0;
	$la_cancel_day=0;
	
			$sql_la=	"select  la_type, la_total from la_main where person_id='$user' and (la_start>='$start_date') and (la_finish<='$end_date') and la_type='4' and commander_grant='1' " ;	
			$query_la= mysqli_query($connect,$sql_la);
			While ($result_la= mysqli_fetch_array($query_la)){ 
					$la_num=$la_num+1;
					$la_day=$la_day+$result_la['la_total'];
			}
			
			$sql_la=	"select  * from la_cancel where person_id='$user' and (cancel_la_start>='$start_date') and (cancel_la_finish<='$end_date') and la_type='4' and commander_grant='1' " ;	
			$query_la= mysqli_query($connect,$sql_la);
			While ($result_la= mysqli_fetch_array($query_la)){ 
			$cancel_la_type=$result_la['la_type'];
			$cancel_la_start=$result_la['cancel_la_start'];
			$cancel_la_finish=$result_la['cancel_la_finish'];

							$sql_chk="select  la_type, la_total from la_main where person_id='$user' and (la_start='$cancel_la_start') and (la_finish='$cancel_la_finish') and commander_grant='1' and $cancel_la_type='4' " ;	
							$query_chk= mysqli_query($connect,$sql_chk);
							if(mysqli_fetch_array($query_chk)){
							$la_cancel_num=$la_cancel_num+1;		
							}
					$la_cancel_day=$la_cancel_day+$result_la['cancel_la_total'];
			}
			$la_day=$la_day-$la_cancel_day;  //วันลาหักยกเลิกวันลา
			$rest=$sum_collect-$la_day;    //วันลาคงเหลือ
			$la_num=$la_num-$la_cancel_num;  //จำนวนครั้งหักยกเลิก

//end สถิติ

echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>บันทึกขออนุญาตลาพักผ่อน</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='90%'>";

echo "<Tr align='left'><Td align='right'>เขียนที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='write_at' Size='60'></Td></Tr>";

echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td>ลาพักผ่อน</Td></Tr>";

echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[school_name]</Td></Tr>";

echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$_SESSION[login_prename]$_SESSION[login_name]&nbsp;&nbsp;$_SESSION[login_surname]&nbsp;&nbsp;ตำแหน่ง$_SESSION[login_userposition]</Td></Tr>";

echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";

echo "<Td>มีวันลาพักผ่อนสะสม&nbsp;&nbsp;<Input Type='Text' Name='relax_collect' Size='5' value='$collect_day'>&nbsp;&nbsp;วันทำการ และประจำปีอีก 10 วันทำการ รวมเป็น&nbsp;&nbsp;<Input Type='Text' Name='relax_this_year' Size='5' value='$total_day'>&nbsp;&nbsp;วันทำการ";

echo "<Tr align='left'><Td align='right'>ขอลาตั้งแต่วันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
?>
<script>
								var Y_date=<?php echo date("Y")?>  
								var m_date=<?php echo date("m")?>  
								var d_date=<?php echo date("d")?>  
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('la_start', true, 'YYYY-MM-DD', Y_date)</script> 
<?php echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
echo "<Td align='left'>";
?>
<script>
								var Y_date=<?php echo date("Y")?>  
								var m_date=<?php echo date("m")?>  
								var d_date=<?php echo date("d")?>  
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('la_finish', true, 'YYYY-MM-DD', Y_date)</script> 
<?php echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='la_total' id='la_total' Size='5'>&nbsp;&nbsp;วัน";

echo "<Tr align='left'><Td align='right'>ระหว่างลาติดต่อได้ที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='contact'  Size='60'>&nbsp;&nbsp;เบอร์โทรศัพท์&nbsp;&nbsp;<Input Type='Text' Name='contact_tel' Size='10'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>ไม่ต้องผ่านผู้บังคับบัญชาขั้นต้น&nbsp;&nbsp;</Td><Td><input type='checkbox'  name='no_comment' id='no_comment' value='1'>&nbsp;&nbsp;(เลือกกรณีผู้บังคับบัญชาขั้นต้นไม่ได้ปฏิบัติราชการ)</Td></Tr>";
echo "<Tr align='left'><Td align='right'>เลือกผู้อนุมัติ (ปกติไม่ต้องเลือก)&nbsp;&nbsp;</Td><Td><Select  name='grant_p_selected'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from person_main where status='0' and (position_code='1' or position_code='2') order by position_code,person_order";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		echo  "<option value = $person_id>$name $surname</option>";
	}
echo "</select>";
echo "&nbsp;&nbsp;</Td></Tr>";

echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>";

echo "<table><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>สถิติการลาในปีงบประมาณนี้</B>: &nbsp;</legend>";
echo "<table border='1'>";
echo "<tr align='center'><td>ลามาแล้ว<br>(วันทำการ)</td><td>ลาครั้งนี้<br>(วันทำการ)</td><td>รวมเป็น<br>(วันทำการ)</td></tr>";


echo "<tr align='center'><td><Input Type='Text' Name='relax_ago'  Size='5' value='$la_day'></td><td><Input Type='Text' Name='relax_this' Size='5'></td><td><Input Type='Text' Name='relax_total' Size='5'></td></tr>";

echo "</table>";
echo "</fieldset></td></tr></table>";
echo "</Td></tr>";

echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>";
echo "<table><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>มอบหมายงานให้ผู้ทำหน้าที่แทน</B>: &nbsp;</legend>";
echo "<table border='1'>";
echo "<Tr align='left'><Td align='right'>ผู้รับมอบ&nbsp;&nbsp;</Td><Td><Select  name='job_person'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from person_main where status='0' and position_code>'1' order by name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		echo  "<option value = $person_id>$name $surname</option>";
	}
echo "</select>";
echo "</Td></Tr>";

echo "</table>";
echo "</fieldset></td></tr></table>";
echo "</Td></tr>";

echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url2(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'>";

echo "</form>";
}


//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=la&task=main/la_main&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=la&task=main/la_main&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from la_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){

$rec_date = date("Y-m-d");
$date_time_now = date("Y-m-d H:i:s");
$rand_num=rand();
$time_mk=time();
$ref_id = $time_mk.$rand_num;

if(!isset($changed_name)){
$changed_name="";
}

$sql = "insert into la_main (person_id, la_type, write_at, because, la_start, la_finish, la_total, last_la_start, last_la_finish, last_la_total, contact, contact_tel, no_comment, grant_p_selected, rec_date,sick_ago,sick_this,sick_total,privacy_ago,privacy_this,privacy_total,birth_ago,birth_this,birth_total,document) 
values ('$user','$_POST[la_type]','$_POST[write_at]', '$_POST[because]', '$_POST[la_start]','$_POST[la_finish]','$_POST[la_total]','$_POST[last_la_start]','$_POST[last_la_finish]','$_POST[last_la_total]', '$_POST[contact]','$_POST[contact_tel]', '$_POST[no_comment]', '$_POST[grant_p_selected]','$date_time_now','$_POST[sick_ago]','$_POST[sick_this]','$_POST[sick_total]','$_POST[privacy_ago]','$_POST[privacy_this]','$_POST[privacy_total]','$_POST[birth_ago]','$_POST[birth_this]','$_POST[birth_total]','$changed_name')";
$dbquery = mysqli_query($connect,$sql);
}

if($index==4.1){
$rec_date = date("Y-m-d");
$date_time_now = date("Y-m-d H:i:s");
$rand_num=rand();
$time_mk=time();
$ref_id = $time_mk.$rand_num;

$sql = "insert into la_main (person_id, la_type, write_at, la_start, la_finish, la_total, relax_collect,relax_this_year,contact, contact_tel, no_comment, grant_p_selected, rec_date,relax_ago,relax_this,relax_total,job_person) 
values ('$user','4','$_POST[write_at]','$_POST[la_start]','$_POST[la_finish]','$_POST[la_total]','$_POST[relax_collect]','$_POST[relax_this_year]','$_POST[contact]','$_POST[contact_tel]', '$_POST[no_comment]', '$_POST[grant_p_selected]','$date_time_now','$_POST[relax_ago]','$_POST[relax_this]','$_POST[relax_total]','$_POST[job_person]')";
$dbquery = mysqli_query($connect,$sql);
}


//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขรายการ</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='90%' Border='0'>";

$sql = "select * from la_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
$id=$ref_result['id'];
$la_type=$ref_result['la_type'];
$grant_p_selected=$ref_result['grant_p_selected'];
$rec_date=$ref_result['rec_date'];
		if($la_type<4){
		echo "<Tr align='left'><Td align='right'>เขียนที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='write_at' Size='60' value='$ref_result[write_at]'></Td></Tr>";
		$check1=""; $check2=""; $check3="";
		if($ref_result['la_type']==1){
		$check1="checked";
		}
		else if($ref_result['la_type']==2){
		$check2="checked";
		}
		else if($ref_result['la_type']==3){
		$check3="checked";
		}
		echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='la_type' value='1' $check1>ลาป่วย&nbsp;&nbsp;<Input Type='radio' Name='la_type' value='2' $check2>ลากิจ&nbsp;&nbsp;<Input Type='radio' Name='la_type' value='3' $check3>ลาคลอด</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[school_name]</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$_SESSION[login_prename]$_SESSION[login_name]&nbsp;&nbsp;$_SESSION[login_surname]&nbsp;&nbsp;ตำแหน่ง$_SESSION[login_userposition]</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>สาเหตุ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='because' Size='60' value='$ref_result[because]'></Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>ขอลาตั้งแต่วันที่&nbsp;&nbsp;</Td>";
		
		echo "<Td align='left'>";
		$la_start=explode("-", $ref_result['la_start']);
		?>
		<script>
										var Y_date=<?php echo $la_start[0]?>  
										var m_date=<?php echo $la_start[1]?>  
										var d_date=<?php echo $la_start[2]?>  
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_start', true, 'YYYY-MM-DD', Y_date)</script> 
		<?php
										
		echo "</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
		
		echo "<Td align='left'>";
		$la_finish=explode("-", $ref_result['la_finish']);
		?>
		<script>
										var Y_date=<?php echo $la_finish[0]?>  
										var m_date=<?php echo $la_finish[1]?>  
										var d_date=<?php echo $la_finish[2]?>  
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_finish', true, 'YYYY-MM-DD', Y_date)</script> 
		<?php
		echo "</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
		
		echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='la_total' Size='5' value='$ref_result[la_total]'>&nbsp;&nbsp;วัน";
		
		echo "<Tr align='left'><Td align='right'>ลาครั้งสุดท้ายตั้งแต่วันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$last_la_start=explode("-", $ref_result['last_la_start']);
		?>
		<script>
										var Y_date=<?php echo $last_la_start[0]?>  
										var m_date=<?php echo $last_la_start[1]?>  
										var d_date=<?php echo $last_la_start[2]?>  
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('last_la_start', true, 'YYYY-MM-DD', Y_date)</script> 
		<?php
		echo "</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$last_la_finish=explode("-", $ref_result['last_la_finish']);
		?>
		<script>
										var Y_date=<?php echo $last_la_finish[0]?>  
										var m_date=<?php echo $last_la_finish[1]?>  
										var d_date=<?php echo $last_la_finish[2]?>  
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('last_la_finish', true, 'YYYY-MM-DD', Y_date)</script> 
		<?php
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
		echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='last_la_total' Size='5' value='$ref_result[last_la_total]'>&nbsp;&nbsp;วัน";
		
		
		echo "<Tr align='left'><Td align='right'>ระหว่างลาติดต่อได้ที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='contact' Size='60' value='$ref_result[contact]'>&nbsp;&nbsp;เบอร์โทรศัพท์&nbsp;&nbsp;<Input Type='Text' Name='contact_tel'  Size='10' value='$ref_result[contact_tel]'></Td></Tr>";
		
		echo  "<tr align='left'>";
		echo  "<td align='right'>เอกสาร(ถ้ามี)&nbsp;&nbsp;</td>";
		echo  "<td align='left'><input name = 'userfile' type = 'file'></td>";
		echo  "</tr>";
if($ref_result['no_comment']==1){
$no_comment_select="checked";
}
else{
$no_comment_select="";
}
echo "<Tr align='left'><Td align='right'>ไม่ต้องผ่านผู้บังคับบัญชาขั้นต้น&nbsp;&nbsp;</Td><Td><input type='checkbox'  name='no_comment' id='no_comment' value='1' $no_comment_select>&nbsp;&nbsp;(เลือกกรณีผู้บังคับบัญชาขั้นต้นไม่ได้ปฏิบัติราชการ)</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>เลือกผู้อนุมัติ (ปกติไม่ต้องเลือก)&nbsp;&nbsp;</Td><Td><Select  name='grant_p_selected'  size='1'>";
		echo  "<option  value = ''>เลือก</option>" ;
		$sql = "select * from person_main where status='0' and (position_code='1' or position_code='2') order by position_code,person_order";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
				$person_id = $result['person_id'];
				$name = $result['name'];
				$surname = $result['surname'];
				if($person_id==$ref_result['grant_p_selected']){
				echo  "<option value = $person_id selected>$name $surname</option>";
				}
				else{
				echo  "<option value = $person_id>$name $surname</option>";
				}
			}
		echo "</select>";
		echo "&nbsp;&nbsp;</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>";
		
		echo "<table><tr><td>";
		echo "<fieldset>";
		echo "<legend>&nbsp;<B>สถิติการลาในปีงบประมาณนี้</B>: &nbsp;</legend>";
		echo "<table border='1'>";
		echo "<tr align='center'><td>ประเภทการลา</td><td>ลามาแล้ว<br>(วันทำการ)</td><td>ลาครั้งนี้<br>(วันทำการ)</td><td>รวมเป็น<br>(วันทำการ)</td></tr>";
		
		echo "<tr align='center'><td>ป่วย</td><td><Input Type='Text' Name='sick_ago' Size='5'  value='$ref_result[sick_ago]'></td><td><Input Type='Text' Name='sick_this' Size='5'  value='$ref_result[sick_this]'></td><td><Input Type='Text' Name='sick_total' Size='5' value='$ref_result[sick_total]'></td></tr>";
		
		echo "<tr align='center'><td>กิจส่วนตัว</td><td><Input Type='Text' Name='privacy_ago' Size='5' value='$ref_result[privacy_ago]'></td><td><Input Type='Text' Name='privacy_this' Size='5' value='$ref_result[privacy_this]'></td><td><Input Type='Text' Name='privacy_total' Size='5' value='$ref_result[privacy_total]'></td></tr>";
		
		echo "<tr align='center'><td>คลอดบุตร</td><td><Input Type='Text' Name='birth_ago' Size='5' value='$ref_result[birth_ago]'></td><td><Input Type='Text' Name='birth_this' Size='5' value='$ref_result[birth_this]'></td><td><Input Type='Text' Name='birth_total' Size='5' value='$ref_result[birth_total]'></td></tr>";
		echo "</table>";
		echo "</fieldset></td></tr></table>";
		echo "</Td></tr>";
		}
		if($la_type==4){
		echo "<Tr align='left'><Td align='right'>เขียนที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='write_at' Size='60' value='$ref_result[write_at]'></Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td>ลาพักผ่อน</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[school_name]</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$_SESSION[login_prename]$_SESSION[login_name]&nbsp;&nbsp;$_SESSION[login_surname]&nbsp;&nbsp;ตำแหน่ง$_SESSION[login_userposition]</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
		
		echo "<Td>มีวันลาพักผ่อนสะสม&nbsp;&nbsp;<Input Type='Text' Name='relax_collect' Size='5' value='$ref_result[relax_collect]'>&nbsp;&nbsp;วันทำการ และประจำปีอีก 10 วันทำการ รวมเป็น&nbsp;&nbsp;<Input Type='Text' Name='relax_this_year' Size='5' value='$ref_result[relax_this_year]'>&nbsp;&nbsp;วันทำการ";
		
		echo "<Tr align='left'><Td align='right'>ขอลาตั้งแต่วันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$la_start=explode("-", $ref_result['la_start']);
		?>
		<script>
										var Y_date=<?php echo $la_start[0]?>  
										var m_date=<?php echo $la_start[1]?>  
										var d_date=<?php echo $la_start[2]?>  
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_start', true, 'YYYY-MM-DD', Y_date)</script> 
		<?php
		echo "</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$la_finish=explode("-", $ref_result['la_finish']);
		?>
		<script>
										var Y_date=<?php echo $la_finish[0]?>  
										var m_date=<?php echo $la_finish[1]?>  
										var d_date=<?php echo $la_finish[2]?>  
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_finish', true, 'YYYY-MM-DD', Y_date)</script> 
		<?php
		echo "</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
		echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='la_total' id='la_total' Size='5' value='$ref_result[la_total]'>&nbsp;&nbsp;วัน";
		
		echo "<Tr align='left'><Td align='right'>ระหว่างลาติดต่อได้ที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='contact'  Size='60' value='$ref_result[contact]'>&nbsp;&nbsp;เบอร์โทรศัพท์&nbsp;&nbsp;<Input Type='Text' Name='contact_tel' Size='10' value='$ref_result[contact_tel]'></Td></Tr>";
		
if($ref_result['no_comment']==1){
$no_comment_select="checked";
}
else{
$no_comment_select="";
}
echo "<Tr align='left'><Td align='right'>ไม่ต้องผ่านผู้บังคับบัญชาขั้นต้น&nbsp;&nbsp;</Td><Td><input type='checkbox'  name='no_comment' id='no_comment' value='1' $no_comment_select>&nbsp;&nbsp;(เลือกกรณีผู้บังคับบัญชาขั้นต้นไม่ได้ปฏิบัติราชการ)</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เลือกผู้อนุมัติ (ปกติไม่ต้องเลือก)&nbsp;&nbsp;</Td><Td><Select  name='grant_p_selected'  size='1'>";
		echo  "<option  value = ''>เลือก</option>" ;
		$sql = "select * from person_main where status='0' and (position_code='1' or position_code='2') order by position_code,person_order";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
				$person_id = $result['person_id'];
				$name = $result['name'];
				$surname = $result['surname'];
				if($person_id==$ref_result['grant_p_selected']){
				echo  "<option value = $person_id selected>$name $surname</option>";
				}
				else{
				echo  "<option value = $person_id>$name $surname</option>";
				}
			}
		echo "</select>";
		echo "&nbsp;&nbsp;</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>";
		
		echo "<table><tr><td>";
		echo "<fieldset>";
		echo "<legend>&nbsp;<B>สถิติการลาในปีงบประมาณนี้</B>: &nbsp;</legend>";
		echo "<table border='1'>";
		echo "<tr align='center'><td>ลามาแล้ว<br>(วันทำการ)</td><td>ลาครั้งนี้<br>(วันทำการ)</td><td>รวมเป็น<br>(วันทำการ)</td></tr>";
		
		echo "<tr align='center'><td><Input Type='Text' Name='relax_ago'  Size='5'  value='$ref_result[relax_ago]'></td><td><Input Type='Text' Name='relax_this' Size='5' value='$ref_result[relax_this]'></td><td><Input Type='Text' Name='relax_total' Size='5' value='$ref_result[relax_total]'></td></tr>";
		echo "</table>";
		echo "</fieldset></td></tr></table>";
		echo "</Td></tr>";
		
echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>";
echo "<table><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>มอบหมายงานให้ผู้ทำหน้าที่แทน</B>: &nbsp;</legend>";
echo "<table border='1'>";
echo "<Tr align='left'><Td align='right'>ผู้รับมอบ&nbsp;&nbsp;</Td><Td><Select  name='job_person'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from person_main where status='0' and position_code>'1' order by name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		if($person_id==$ref_result['job_person']){
		echo  "<option value = $person_id selected>$name $surname</option>";
		}
		else{
		echo  "<option value = $person_id>$name $surname</option>";
		}
	}
echo "</select>";
echo "</Td></Tr>";

echo "</table>";
echo "</fieldset></td></tr></table>";
echo "</Td></tr>";
		
		
		echo "<Input Type=Hidden Name='la_type' Value='4'>";
		}
echo "</Table>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
	if($_POST['la_type']<4){
		if($_FILES['userfile']['name']==""){
		$sql = "update la_main set la_type='$_POST[la_type]', 
		write_at='$_POST[write_at]', 
		because='$_POST[because]', 
		la_start='$_POST[la_start]', 
		la_finish='$_POST[la_finish]', 
		la_total='$_POST[la_total]', 
		last_la_start='$_POST[last_la_start]', 
		last_la_finish='$_POST[last_la_finish]', 
		last_la_total='$_POST[last_la_total]', 
		contact='$_POST[contact]', 
		contact_tel='$_POST[contact_tel]', 
		no_comment='$_POST[no_comment]',		
		grant_p_selected='$_POST[grant_p_selected]',
		sick_ago='$_POST[sick_ago]',
		sick_this='$_POST[sick_this]',
		sick_total='$_POST[sick_total]',
		privacy_ago='$_POST[privacy_ago]',
		privacy_this='$_POST[privacy_this]',
		privacy_total='$_POST[privacy_total]',
		birth_ago='$_POST[birth_ago]',
		birth_this='$_POST[birth_this]',
		birth_total='$_POST[birth_total]'
		where id='$_POST[id]'";
		$dbquery = mysqli_query($connect,$sql);
		}
		else{
		$changed_name = file_upload();
		$sql = "update la_main set la_type='$_POST[la_type]', 
		write_at='$_POST[write_at]', 
		la_start='$_POST[la_start]', 
		la_finish='$_POST[la_finish]', 
		la_total='$_POST[la_total]', 
		last_la_start='$_POST[last_la_start]', 
		last_la_finish='$_POST[last_la_finish]', 
		last_la_total='$_POST[last_la_total]', 
		contact='$_POST[contact]', 
		contact_tel='$_POST[contact_tel]', 
		document='$changed_name', 	
		no_comment='$_POST[no_comment]',		
		grant_p_selected='$_POST[grant_p_selected]',
		relax_ago='$_POST[relax_ago]',
		relax_this='$_POST[relax_this]',
		relax_total='$_POST[relax_total]',
		privacy_ago='$_POST[privacy_ago]',
		privacy_this='$_POST[privacy_this]',
		privacy_total='$_POST[privacy_total]',
		birth_ago='$_POST[birth_ago]',
		birth_this='$_POST[birth_this]',
		birth_total='$_POST[birth_total]'
		where id='$_POST[id]'";
		$dbquery = mysqli_query($connect,$sql);
		}
	}
	if($_POST['la_type']==4){
		$sql = "update la_main set write_at='$_POST[write_at]', 
		la_start='$_POST[la_start]', 
		la_finish='$_POST[la_finish]', 
		la_total='$_POST[la_total]', 
		relax_collect='$_POST[relax_collect]', 
		relax_this_year='$_POST[relax_this_year]', 
		contact='$_POST[contact]', 
		contact_tel='$_POST[contact_tel]', 
		no_comment='$_POST[no_comment]',		
		grant_p_selected='$_POST[grant_p_selected]',
		relax_ago='$_POST[relax_ago]',
		relax_this='$_POST[relax_this]',
		relax_total='$_POST[relax_total]',
		job_person='$_POST[job_person]'
		where id='$_POST[id]'";
		$dbquery = mysqli_query($connect,$sql);
	}
}

if ($index==7){
$sql_name = "select * from person_main";
$dbquery_name = mysqli_query($connect,$sql_name);
While ($result_name = mysqli_fetch_array($dbquery_name)){
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
		$position_code = $result_name['position_code'];
$full_name_ar[$person_id]="$prename$name&nbsp;&nbsp;$surname";
}

echo "<Center>";
echo "<Font color='#006666' Size=3><B>รายละเอียดการขออนุญาตลา</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Br>";
echo "<Table  align='center' width='80%' Border='0'>";
echo "<Tr ><Td colspan='2' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=la&task=main/la_main&page=$_GET[page]\"'></Td></Tr>";
$sql = "select * from la_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
$id=$ref_result['id'];
$la_type=$ref_result['la_type'];
$grant_p_selected=$ref_result['grant_p_selected'];
$rec_date=$ref_result['rec_date'];

		$sql_person = "select * from  person_main where person_id='$ref_result[person_id]' ";
		$dbquery_person = mysqli_query($connect,$sql_person);
		$result_person = mysqli_fetch_array($dbquery_person);
		$fullname=$result_person['prename'].$result_person['name']." ".$result_person['surname'];
		$position=$result_person['position_code']; 
		$sql = "select * from  person_position where position_code='$position'";
		$dbquery = mysqli_query($connect,$sql);
		$result = mysqli_fetch_array($dbquery);
		$position_name=$result['position_name'];

		if($la_type<4){
		echo "<Tr align='left'><Td align='right'>วันเดือนปี&nbsp;&nbsp;</Td><Td>";
echo thai_date_4($rec_date);
echo "</Td></Tr>";
		echo "<Tr align='left'><Td align='right'>เขียนที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='write_at' Size='60' value='$ref_result[write_at]'></Td></Tr>";
		$check1=""; $check2=""; $check3="";
		if($ref_result['la_type']==1){
		$check1="checked";
		}
		else if($ref_result['la_type']==2){
		$check2="checked";
		}
		else if($ref_result['la_type']==3){
		$check3="checked";
		}
		echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='la_type' value='1' $check1>ลาป่วย&nbsp;&nbsp;<Input Type='radio' Name='la_type' value='2' $check2>ลากิจ&nbsp;&nbsp;<Input Type='radio' Name='la_type' value='3' $check3>ลาคลอด</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[school_name]</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$fullname&nbsp;&nbsp;ตำแหน่ง&nbsp;&nbsp;$position_name</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>เนื่องจาก&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='because' Size='60' value='$ref_result[because]'></Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>ขอลาตั้งแต่วันที่&nbsp;&nbsp;</Td>";
		
		echo "<Td align='left'>";
		$la_start=explode("-", $ref_result['la_start']);
		?>
		<script>
										var Y_date=<?php echo $la_start[0]?>  
										var m_date=<?php echo $la_start[1]?>  
										var d_date=<?php echo $la_start[2]?>  
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_start', true, 'YYYY-MM-DD', Y_date)</script> 
		<?php
										
		echo "</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
		
		echo "<Td align='left'>";
		$la_finish=explode("-", $ref_result['la_finish']);
		?>
		<script>
										var Y_date=<?php echo $la_finish[0]?>  
										var m_date=<?php echo $la_finish[1]?>  
										var d_date=<?php echo $la_finish[2]?>  
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_finish', true, 'YYYY-MM-DD', Y_date)</script> 
		<?php
		echo "</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
		
		echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='la_total' Size='5' value='$ref_result[la_total]'>&nbsp;&nbsp;วัน";
		
		echo "<Tr align='left'><Td align='right'>ลาครั้งสุดท้ายตั้งแต่วันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$last_la_start=explode("-", $ref_result['last_la_start']);
		?>
		<script>
										var Y_date=<?php echo $last_la_start[0]?>  
										var m_date=<?php echo $last_la_start[1]?>  
										var d_date=<?php echo $last_la_start[2]?>  
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('last_la_start', true, 'YYYY-MM-DD', Y_date)</script> 
		<?php
		echo "</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$last_la_finish=explode("-", $ref_result['last_la_finish']);
		?>
		<script>
										var Y_date=<?php echo $last_la_finish[0]?>  
										var m_date=<?php echo $last_la_finish[1]?>  
										var d_date=<?php echo $last_la_finish[2]?>  
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('last_la_finish', true, 'YYYY-MM-DD', Y_date)</script> 
		<?php
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
		echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='last_la_total' Size='5' value='$ref_result[last_la_total]'>&nbsp;&nbsp;วัน";
		
		
		echo "<Tr align='left'><Td align='right'>ระหว่างลาติดต่อได้ที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='contact' Size='60' value='$ref_result[contact]'>&nbsp;&nbsp;เบอร์โทรศัพท์&nbsp;&nbsp;<Input Type='Text' Name='contact_tel'  Size='10' value='$ref_result[contact_tel]'></Td></Tr>";
		
		echo  "<tr align='left'>";
		echo  "<td align='right'>เอกสาร(ถ้ามี)&nbsp;&nbsp;</td>";
		echo  "<td align='left'><input name = 'userfile' type = 'file'></td>";
		echo  "</tr>";
if($ref_result['no_comment']==1){
$no_comment_select="checked";
}
else{
$no_comment_select="";
}
		echo "<Tr align='left'><Td align='right'></Td><Td><input type='checkbox'  name='no_comment' id='no_comment' value='1' $no_comment_select>&nbsp;ไม่ต้องผ่านผู้บังคับบัญชาขั้นต้น</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เลือกผู้อนุมัติ (ปกติไม่ต้องเลือก)&nbsp;&nbsp;</Td><Td><Select  name='grant_p_selected'  size='1'>";
		echo  "<option  value = ''>เลือก</option>" ;
		$sql = "select * from person_main where position_code='1' or position_code='2' order by position_code,person_order";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
				$person_id = $result['person_id'];
				$name = $result['name'];
				$surname = $result['surname'];
				if($person_id==$ref_result['grant_p_selected']){
				echo  "<option value = $person_id selected>$name $surname</option>";
				}
				else{
				//echo  "<option value = $person_id>$name $surname</option>";
				}
			}
		echo "</select>";
		echo "&nbsp;&nbsp;</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>";
		
		echo "<table><tr><td>";
		echo "<fieldset>";
		echo "<legend>&nbsp;<B>สถิติการลาในปีงบประมาณนี้</B>: &nbsp;</legend>";
		echo "<table border='1'>";
		echo "<tr align='center'><td>ประเภทการลา</td><td>ลามาแล้ว<br>(วันทำการ)</td><td>ลาครั้งนี้<br>(วันทำการ)</td><td>รวมเป็น<br>(วันทำการ)</td></tr>";
		
		echo "<tr align='center'><td>ป่วย</td><td><Input Type='Text' Name='sick_ago' Size='5'  value='$ref_result[sick_ago]'></td><td><Input Type='Text' Name='sick_this' Size='5'  value='$ref_result[sick_this]'></td><td><Input Type='Text' Name='sick_total' Size='5' value='$ref_result[sick_total]'></td></tr>";
		
		echo "<tr align='center'><td>กิจส่วนตัว</td><td><Input Type='Text' Name='privacy_ago' Size='5' value='$ref_result[privacy_ago]'></td><td><Input Type='Text' Name='privacy_this' Size='5' value='$ref_result[privacy_this]'></td><td><Input Type='Text' Name='privacy_total' Size='5' value='$ref_result[privacy_total]'></td></tr>";
		
		echo "<tr align='center'><td>คลอดบุตร</td><td><Input Type='Text' Name='birth_ago' Size='5' value='$ref_result[birth_ago]'></td><td><Input Type='Text' Name='birth_this' Size='5' value='$ref_result[birth_this]'></td><td><Input Type='Text' Name='birth_total' Size='5' value='$ref_result[birth_total]'></td></tr>";
		echo "</table>";
		echo "</fieldset></td></tr></table>";
		echo "</Td></tr>";
		}
		if($la_type==4){
		echo "<Tr align='left'><Td align='right'>วันเดือนปี&nbsp;&nbsp;</Td><Td>";
echo thai_date_4($rec_date);
echo "</Td></Tr>";
		echo "<Tr align='left'><Td align='right'>เขียนที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='write_at' Size='60' value='$ref_result[write_at]'></Td></Tr>";
		echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td>ลาพักผ่อน</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[school_name]</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$fullname&nbsp;&nbsp;ตำแหน่ง&nbsp;&nbsp;$position_name</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
		
		echo "<Td>มีวันลาพักผ่อนสะสม&nbsp;&nbsp;<Input Type='Text' Name='relax_collect' Size='5' value='$ref_result[relax_collect]'>&nbsp;&nbsp;วันทำการ และประจำปีอีก 10 วันทำการ รวมเป็น&nbsp;&nbsp;<Input Type='Text' Name='relax_this_year' Size='5' value='$ref_result[relax_this_year]'>&nbsp;&nbsp;วันทำการ";
		
		echo "<Tr align='left'><Td align='right'>ขอลาตั้งแต่วันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$la_start=explode("-", $ref_result['la_start']);
		?>
		<script>
										var Y_date=<?php echo $la_start[0]?>  
										var m_date=<?php echo $la_start[1]?>  
										var d_date=<?php echo $la_start[2]?>  
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_start', true, 'YYYY-MM-DD', Y_date)</script> 
		<?php
		echo "</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$la_finish=explode("-", $ref_result['la_finish']);
		?>
		<script>
										var Y_date=<?php echo $la_finish[0]?>  
										var m_date=<?php echo $la_finish[1]?>  
										var d_date=<?php echo $la_finish[2]?>  
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_finish', true, 'YYYY-MM-DD', Y_date)</script> 
		<?php
		echo "</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
		echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='la_total' id='la_total' Size='5' value='$ref_result[la_total]'>&nbsp;&nbsp;วัน";
		
		echo "<Tr align='left'><Td align='right'>ระหว่างลาติดต่อได้ที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='contact'  Size='60' value='$ref_result[contact]'>&nbsp;&nbsp;เบอร์โทรศัพท์&nbsp;&nbsp;<Input Type='Text' Name='contact_tel' Size='10' value='$ref_result[contact_tel]'></Td></Tr>";
		
if($ref_result['no_comment']==1){
$no_comment_select="checked";
}
else{
$no_comment_select="";
}
		echo "<Tr align='left'><Td align='right'></Td><Td><input type='checkbox'  name='no_comment' id='no_comment' value='1' $no_comment_select>&nbsp;ไม่ต้องผ่านผู้บังคับบัญชาขั้นต้น</Td></Tr>";
		echo "<Tr align='left'><Td align='right'>เลือกผู้อนุมัติ (ปกติไม่ต้องเลือก)&nbsp;&nbsp;</Td><Td><Select  name='grant_p_selected'  size='1'>";
		echo  "<option  value = ''>เลือก</option>" ;
		$sql = "select * from person_main where position_code='1' or position_code='2' order by position_code,person_order";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
				$person_id = $result['person_id'];
				$name = $result['name'];
				$surname = $result['surname'];
				if($person_id==$ref_result['grant_p_selected']){
				echo  "<option value = $person_id selected>$name $surname</option>";
				}
				else{
			//	echo  "<option value = $person_id>$name $surname</option>";
				}
			}
		echo "</select>";
		echo "&nbsp;&nbsp;</Td></Tr>";
		
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>";
		
		echo "<table><tr><td>";
		echo "<fieldset>";
		echo "<legend>&nbsp;<B>สถิติการลาในปีงบประมาณนี้</B>: &nbsp;</legend>";
		echo "<table border='1'>";
		echo "<tr align='center'><td>ลามาแล้ว<br>(วันทำการ)</td><td>ลาครั้งนี้<br>(วันทำการ)</td><td>รวมเป็น<br>(วันทำการ)</td></tr>";
		
		echo "<tr align='center'><td><Input Type='Text' Name='relax_ago'  Size='5'  value='$ref_result[relax_ago]'></td><td><Input Type='Text' Name='relax_this' Size='5' value='$ref_result[relax_this]'></td><td><Input Type='Text' Name='relax_total' Size='5' value='$ref_result[relax_total]'></td></tr>";
		
		echo "</table>";
		echo "</fieldset></td></tr></table>";
		echo "</Td></tr>";
		}
echo "</table>";

echo "<table width='70%'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนการรับมอบงาน</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>ผู้รับมอบ&nbsp;&nbsp;</Td><Td><Select  name='job_person'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from person_main where position_code>'1' order by position_code,person_order";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		if($person_id==$ref_result['job_person']){
		echo  "<option value = $person_id selected>$name $surname</option>";
		}
		else{
		//echo  "<option value = $person_id>$name $surname</option>";
		}
	}
echo "</select>";
echo "</Td>";

if($ref_result['job_person_sign']==1){
echo "<td><input type='checkbox' checked>รับมอบงาน</td>";
}
else{
echo "<td><input type='checkbox'>รับมอบงาน</td>";
}
echo "</Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";


echo "<table width='70%'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนการตรวจสอบ</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right' width='180'>บันทึกการตรวจสอบ(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='officer_comment' Size='60' value='$ref_result[officer_comment]'></Td></Tr>";
$officer_sign=$ref_result['officer_sign'];

if(!isset($full_name_ar[$officer_sign])){
$full_name_ar[$officer_sign]="";
}

echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='40' value='$full_name_ar[$officer_sign]'></Td></Tr>";
$officer_date= thai_date_4($ref_result['officer_date']);
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='30' value='$officer_date'></Td></Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<table width='70%'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนความเห็นของผู้บังคับบัญชาขั้นต้น</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right' width='180'>บันทึกความเห็น(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='group_comment' Size='60' value='$ref_result[group_comment]'></Td></Tr>";
$group_sign=$ref_result['group_sign'];

if(!isset($full_name_ar[$group_sign])){
$full_name_ar[$group_sign]="";
}

echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='40' value='$full_name_ar[$group_sign]'></Td></Tr>";
$group_date= thai_date_4($ref_result['group_date']);
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='30' value='$group_date'></Td></Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<table width='70%'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนการอนุมัติ</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right' width='180'>คำสั่ง(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='commander_comment' Size='60' value='$ref_result[commander_comment]'></Td></Tr>";
		$commander_grant_check1=""; $commander_grant_check2="";
		if($ref_result['commander_grant']==1){
		$commander_grant_check1="checked";
		}
		else if($ref_result['commander_grant']==2){
		$commander_grant_check2="checked";
		}
echo "<Tr align='left'><Td align='right'>อนุมัติ/ไม่อนุมัติ&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='commander_grant' value='1' $commander_grant_check1>อนุมัติ&nbsp;&nbsp;<Input Type='radio' Name='commander_grant' value='2' $commander_grant_check2>ไม่อนุมัติ&nbsp;&nbsp;</Td></Tr>";
$commander_sign=$ref_result['commander_sign'];

if(!isset($full_name_ar[$commander_sign])){
$full_name_ar[$commander_sign]="";
}

echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='40' value='$full_name_ar[$commander_sign]'></Td></Tr>";
$grant_date= thai_date_4($ref_result['grant_date']);
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='30' value='$grant_date'></Td></Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";
}


//ส่วนแสดงผล
if(!(($index==1) or ($index==1.1) or ($index==1.2) or ($index==2) or ($index==5) or ($index==7))){

//ส่วนของการแยกหน้า
$sql="select id from la_main where person_id='$user'";
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery);

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=la&task=main/la_main";  // 2_กำหนดลิงค์ฺ
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

$sql="select * from la_main where person_id='$user' order by id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width=95% border=0 align=center>";
echo "<Tr><Td colspan='11' align='left'><INPUT TYPE='button' name='smb' value='ขออนุญาตลาป่วย ลากิจ ลาคลอด' onclick='location.href=\"?option=la&task=main/la_main&index=1\"'><INPUT TYPE='button' name='smb' value='ขออนุญาตลาพักผ่อน' onclick='location.href=\"?option=la&task=main/la_main&index=1.1\"'></Td></Tr>";

echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>เลขที่</Td><Td width='100'>วันขออนุญาต</Td><Td width='100'>ประเภทการลา</Td><Td>ตั้งแต่วันที่ี</Td><Td>ถึงวันที่</Td><Td width='80'>มีกำหนด</Td><Td width='50'>เอกสาร</Td><Td>อนุมัติ/คำสั่ง</Td><Td width='60'>รายละเอียด</Td><Td width='40'>ลบ</Td><Td width='40'>แก้ไข</Td></Tr>";

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['id'];
		$la_type = $result['la_type'];
			$la_type_name="";
			if($la_type==1){
			$la_type_name="ลาป่วย";
			}
			else if($la_type==2){
			$la_type_name="ลากิจ";
			}
			else if($la_type==3){
			$la_type_name="ลาคลอด";
			}
			else if($la_type==4){
			$la_type_name="ลาพักผ่อน";
			}
		$la_start = $result['la_start'];
		$la_finish = $result['la_finish'];
		$la_total = $result['la_total'];
		
		$file = $result['document'];
		$officer_sign = $result['officer_sign'];		
		$group_sign = $result['group_sign'];	
		$grant = $result['commander_grant'];
		$commander_sign = $result['commander_sign'];
		$rec_date = $result['rec_date'];
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
echo "<Tr bgcolor='$color'><Td valign='top' align='center'>$id</Td><Td valign='top' align='left'>";
echo thai_date_3($rec_date);
echo "</Td><Td align='left'>$la_type_name</Td>";
echo "<Td valign='top' align='left' >";
echo thai_date_3($la_start);
echo "</Td>";
echo "<Td valign='top' align='left' >";
echo thai_date_3($la_finish);
echo "</Td>";
echo "<Td valign='top' align='center' >$la_total&nbsp;วัน</Td>";

if($file!=""){
echo   "<Td valign='top' align='center'><a href='$file' target=_blank><IMG SRC='images/b_browse.png' width='16' height='16' border=0 alt='เอกสาร'></a></td>";
}
else{
echo "<Td valign='top' align='left'>&nbsp;</Td>";
}
echo "<Td valign='top' align='center'>";
if($grant==1){
echo "<img src=images/yes.png border='0'><br><font color='#339900'>$result[commander_comment]</font>";
}
else if($grant==2){
echo "<img src=images/no.png border='0'><br><font color='#990000'>$result[commander_comment]</font>";
}
else{
echo "รออนุมัติ";
}
echo "</Td>";
echo "<Td valign='top' align='center'><a href=?option=la&task=main/la_main&index=7&id=$id&page=$page><img src=images/browse.png border='0' alt='รายละเอียด'></Td>";
if(($officer_sign=="") and ($group_sign=="") and ($commander_sign=="")){
echo "<Td valign='top' align='center'><a href=?option=la&task=main/la_main&index=2&id=$id&page=$page><img src=images/drop.png border='0' alt='ลบ'></Td><Td valign='top'  align='center'><a href=?option=la&task=main/la_main&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>";
}
else{
echo "<td></td><td></td>";
}
echo "</Tr>";

$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}	
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=la&task=main/la_main");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.write_at.value == ""){
			alert("กรุณากรอกสถานที่เขียน");
		}else if(frm1.because.value == ""){
		alert("กรุณาระบุสาเหตุ");
		}else if(!(frm1.la_type[0].checked || frm1.la_type[1].checked || frm1.la_type[2].checked)){
			alert("กรุณาเลือกประเภทการลา");
		}else if(frm1.la_total.value == ""){
			alert("กรุณากรอกจำนวนวันลา");
		}else if(frm1.contact.value == ""){
			alert("กรุณากรอกสถานที่ติดต่อระหว่างลา");
		}else{
			callfrm("?option=la&task=main/la_main&index=4");   //page ประมวลผล
		}
	}
}

function goto_url2(val){
	if(val==0){
		callfrm("?option=la&task=main/la_main");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.write_at.value == ""){
			alert("กรุณากรอกสถานที่เขียน");
		}else if(frm1.la_total.value == ""){
			alert("กรุณากรอกจำนวนวันลา");
		}else if(frm1.contact.value == ""){
			alert("กรุณากรอกสถานที่ติดต่อระหว่างลา");
		}else{
			callfrm("?option=la&task=main/la_main&index=4.1");   //page ประมวลผล
		}
	}
}


function goto_url_update(val){
	if(val==0){
		callfrm("?option=la&task=main/la_main");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.write_at.value == ""){
			alert("กรุณากรอกสถานที่เขียน");
		}else if(frm1.la_total.value == ""){
			alert("กรุณากรอกจำนวนวันลา");
		}else if(frm1.contact.value == ""){
			alert("กรุณากรอกสถานที่ติดต่อระหว่างลา");
		}else{
			callfrm("?option=la&task=main/la_main&index=6");   //page ประมวลผล
		}
	}
}

</script>
