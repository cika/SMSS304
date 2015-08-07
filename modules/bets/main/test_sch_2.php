<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<?php
require_once("modules/bets/time_inc.php");
$officer=$_SESSION['login_user_id'];
echo "<br />";

if(isset($_REQUEST['class_index'])){
	$class_index=$_REQUEST['class_index'];
}else{
	$class_index="";
}

//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มรายการสอบ</B></Font>";
echo "</Cener>";
echo "<Br>";
$date_now=date("Y-m-d H:i:s");
echo "<Table width='60%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>ชื่อรายการสอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='sch_test_name' Size='40'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>แบบทดสอบที่ใช้&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
//$sql = "select *,bets_test.id from bets_test  left join bets_test_schuser on bets_test.id=bets_test_schuser.test_id where bets_test_schuser.teacher='$_SESSION[login_user_id]' and bets_test.test_active='1' and bets_test_schuser.stop_date>'$date_now' order by bets_test.id desc";
$sql = "select *,bets_test_schuser.id from bets_test  left join bets_test_schuser on bets_test.id=bets_test_schuser.test_id where bets_test_schuser.teacher='$_SESSION[login_user_id]' and bets_test.test_active='1' and bets_test_schuser.stop_date>'$date_now' order by bets_test.id desc";
$dbquery = mysqli_query($connect,$sql);
echo "<Select  name='test_id' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
While ($result= mysqli_fetch_array($dbquery)){
echo  "<option  value ='$result[id]'>$result[test_name] (แบบฯ$result[id])</option>" ;
}	
echo "</select>";
echo "</Td></Tr>";
$sch_test_code=rand();
echo "<Tr align='left'><Td width=30></Td><Td align='right'>รหัสการสอบครั้งนี้ (แก้ไขได้)&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='sch_test_code' Size='10' value='$sch_test_code'>&nbsp;(<b>หมายเหตุ</b> ผู้สอบต้องใช้รหัสนี้จึงสามารถสอบได้) </Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<input type='hidden' name='page' value='$_REQUEST[page]'>";	
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'>";

echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=bets&task=main/test_sch_2&index=3&id=$_GET[id]&test_id=$_REQUEST[test_id]&page=$_REQUEST[page]\"'>
		&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=bets&task=main/test_sch_2&test_id=$_REQUEST[test_id]&page=$_REQUEST[page]&index=7\"'";
echo "</td></tr></table>";
}

if($index==2.2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=bets&task=main/test_sch_2&index=3.2&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=bets&task=main/test_sch_2&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from bets_schtest_testuser where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
$index=7;
}

if($index==3.2){
$sql = "delete from bets_schtest_testuser where sch_test_id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
$sql = "delete from bets_sch_test where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$rec_date = date("Y-m-d");

		//หาปีการศึกษาปัจจุบัน
		$sql_edyear = "select ed_year from student_main_edyear where year_active='1' ";
		$dbquery_edyear = mysqli_query($connect,$sql_edyear);
		$result_edyear = mysqli_fetch_array($dbquery_edyear);

		foreach ($_POST as $person=>$person_value){
				$sql_check = "select id from bets_schtest_testuser where person_id='$person'  and sch_test_id='$_POST[sch_test_id]'";
				$dbquery_check= mysqli_query($connect,$sql_check);
				$result_check=mysqli_fetch_array($dbquery_check);
				if(!($result_check)){
						if($person_value=='sch_person_id'){
								//หาชั้น ห้อง
								$sql_class = "select student_main_class.class_name,student_main.room from student_main left join student_main_class on student_main.class_now=student_main_class.class_code where student_main.student_id='$person'";
								$dbquery_class=mysqli_query($connect,$sql_class);
								$result_class= mysqli_fetch_array($dbquery_class);
								//
						$sql_insert = "insert into bets_schtest_testuser(person_id,class_name,room,ed_year,sch_test_id,officer,rec_date) values ('$person','$result_class[class_name]','$result_class[room]','$result_edyear[ed_year]','$_POST[sch_test_id]','$officer','$rec_date')";
						$dbquery_insert  = mysqli_query($connect,$sql_insert);
						}
				}	
		}
$index=7;		
$_GET['add_index']=1;	
}

//ส่วนเพิ่มข้อมูลรายการสอบ
if($index==4.2){
		//$_POST[test_id] คือ id ของตาราง bets_test schuser
		// แก้ไขสมดมภ์ teacher มาใช้เก็บค่า id ของตาราง bets_test schuser
		$sql = "select test_id from bets_test_schuser where id='$_POST[test_id]'";
		$dbquery = mysqli_query($connect,$sql);
		$result= mysqli_fetch_array($dbquery);
		$test_id=$result['test_id'];

$rec_date = date("Y-m-d");
$sql_insert = "insert into bets_sch_test (teacher,test_id,sch_test_name,sch_test_code,sch_test_active,officer,rec_date) values ('$_POST[test_id]','$test_id]','$_POST[sch_test_name]','$_POST[sch_test_code]','1','$officer','$rec_date')";
$dbquery_insert  = mysqli_query($connect,$sql_insert);

		$sql = "select * from bets_sch_test  order by id desc limit 1 ";
		$dbquery = mysqli_query($connect,$sql);
		$result= mysqli_fetch_array($dbquery);
		$index=7;
		$_REQUEST['sch_test_id']=$result['id'];
		$_REQUEST['page']=$_POST['page']+1;
		$_GET['add_index']=1;		
}
	
//ส่วนฟอร์มแก้ไขข้อมูล
if($index==5.2){
$sql = "select * from bets_test where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขรายการสอบ</B></Font>";
echo "</Cener>";
echo "<Br>";
$sql_testcode = "select * from bets_sch_test where id='$_GET[id]'";
$dbquery_testcode = mysqli_query($connect,$sql_testcode);
$result_testcode= mysqli_fetch_array($dbquery_testcode);

echo "<Table width='60%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>ชื่อรายการสอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='sch_test_name' Size='40' value='$result_testcode[sch_test_name]'></Td></Tr>";

echo "<Tr align='left'><Td width=30></Td><Td align='right'>รหัสการสอบครั้งนี้&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='sch_test_code' Size='10' value='$result_testcode[sch_test_code]'></Td></Tr>";

if($result_testcode['sch_test_active']==1){
$active_check_1="checked";
$active_check_2="";
}
else{
$active_check_1="";
$active_check_2="checked";
}
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เปิดสอบ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>เปิด<input  type=radio name='sch_test_active' value='1' $active_check_1>&nbsp;&nbsp;ปิด<input  type=radio name='sch_test_active' value='0' $active_check_2></Td></Tr>";
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
if ($index==6.2){
$sql = "update bets_sch_test set sch_test_active='$_GET[active]' where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
}

if ($index==6.4){
$sql = "update bets_sch_test set  sch_test_name='$_POST[sch_test_name]',sch_test_code='$_POST[sch_test_code]',sch_test_active='$_POST[sch_test_active]',officer=$officer where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//จบการสอบ
if ($index==6.5){
		$stop=0;
		if($_GET['stop_test']==1){
		$stop=1;
		}
		if($_GET['stop_test']==2){
		$stop=0;
		}
		$sql = "update bets_schtest_testuser set stop_test='$stop' where id='$_GET[id]'";
		$dbquery = mysqli_query($connect,$sql);
		$index=7;
}

//ส่วนเพิ่มข้อมูล
if($index==7){
$sql_test = "select * from bets_sch_test where id='$_REQUEST[sch_test_id]'";
$dbquery_test = mysqli_query($connect,$sql_test);
$result_test=mysqli_fetch_array($dbquery_test);

//ส่วนตรวจว่ามีการกำหนดผู้ใช้หรือยัง
$sql_check = "select * from bets_schtest_testuser where sch_test_id='$_REQUEST[sch_test_id]'";
$dbquery_check = mysqli_query($connect,$sql_check);
if(mysqli_fetch_array($dbquery_check)){
		echo "<Center>";
		echo "<Font color='#006666' Size='3'><B>รายชื่อผู้สอบ</B></Font><br>";	
		echo "<Font color='#006666' Size='2'><B>$result_test[sch_test_name]</B></Font>";
		echo "</Cener>";
		echo  "<table width='60%' border='0' align='center'>";
		if(isset($_GET['add_index'])){
		echo "<Tr align='center'><Td colspan='2' align='left'>[<a href=?option=bets&task=main/test_sch_2&index=7.2&sch_test_id=$_REQUEST[sch_test_id]&page=$_REQUEST[page]>เพิ่มรายชื่อผู้สอบ</a>]</Td><td colspan='5' align='right'>[<a href=?option=bets&task=main/test_sch_2&page=$_REQUEST[page]><<กลับ</a>]</td></Tr>";
		}
		else{
		echo "<Tr align='center'><Td colspan='2' align='left'></Td><td colspan='5' align='right'>[<a href=?option=bets&task=main/test_sch_2&page=$_REQUEST[page]><<กลับ</a>]</td></Tr>";
		}
		echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td><Td width='120'>เลขประจำตัว<br>นักเรียน</Td><Td>ชื่อ</Td><Td width='150'>ชั้น</Td><Td width='40'>ห้อง</Td><Td width='60'>จบ<br>การสอบ</Td><Td width='40'>ลบ</Td>";
		echo "</Tr>";
		$sql = "select *,bets_schtest_testuser.id,bets_schtest_testuser.room from bets_schtest_testuser left join student_main on bets_schtest_testuser.person_id=student_main.student_id where bets_schtest_testuser.sch_test_id='$_REQUEST[sch_test_id]' order by bets_schtest_testuser.id";
		$dbquery = mysqli_query($connect,$sql); 
		$N=1;
		While ($result=mysqli_fetch_array($dbquery)){
					if(($N%2) == 0)
					$color="#FFFFC";
					else  	$color="#FFFFFF";
					
		echo "<Tr bgcolor='$color' align='center'><Td>$N</Td><Td>$result[student_id]</Td><Td align='left'>$result[prename]$result[name] $result[surname]</Td><Td align='left'>$result[class_name]</Td>";
		if($result['room']){
		echo "<Td>$result[room]</Td>";
		}
		else{
		echo "<Td></Td>";
		}
		if(isset($_GET['add_index'])){
		echo "<td>";
				if($result['stop_test']==1){
				echo "<a href=?option=bets&task=main/test_sch_2&index=6.5&stop_test=2&id=$result[id]&page=$_REQUEST[page]&sch_test_id=$_REQUEST[sch_test_id]&add_index=$_GET[add_index]>จบ</a>";
				}
				else{
				echo "<a href=?option=bets&task=main/test_sch_2&index=6.5&stop_test=1&id=$result[id]&page=$_REQUEST[page]&sch_test_id=$_REQUEST[sch_test_id]&add_index=$_GET[add_index]>ยัง</a>";
				}
		echo "</td>";
		}
		else{
		echo "<td></td>";
		}
		if(isset($_GET['add_index'])){
		echo "<Td><a href=?option=bets&task=main/test_sch_2&index=3&id=$result[id]&sch_test_id=$_REQUEST[sch_test_id]&page=$_REQUEST[page]&add_index=1><img src=images/drop.png border='0'></a></div></Td>";
		}
		else{
		echo "<Td></td>";
		}
		echo "</Tr>";
		$N++;
		}
		echo "</table>";
}
else{
		if(isset($_GET['add_index'])){
		$index=7.2;
		}
		else{
		echo "<br><div align='center'>ไม่มีรายชื่อผู้สอบ</div><br>";
		echo "<div align='center'>[<a href=?option=bets&task=main/test_sch_2&page=$_REQUEST[page]>กลับ</a>]</div>";
		}
$index_2=1;
}
}

//ส่วนกำหนดผู้สอบ
if($index==7.2){
		$sql_class_text = "select * from student_main_class order by  class_code";
		$dbquery_class_text = mysqli_query($connect,$sql_class_text );
		While ($result_class_text=mysqli_fetch_array($dbquery_class_text )){
		$class_text[$result_class_text['class_code']]=$result_class_text['class_name'];
		}

$sql_test = "select * from bets_sch_test where id='$_REQUEST[sch_test_id]'";
$dbquery_test = mysqli_query($connect,$sql_test);
$result_test=mysqli_fetch_array($dbquery_test);
		echo "<Center>";
		echo "<Font color='#006666' Size='3'><B>กำหนดผู้สอบ</B></Font><br>";
		echo "<Font color='#006666' Size='2'><B>$result_test[sch_test_name]</B></Font>";
		echo "</Cener>";
		echo "<form id='frm1' name='frm1'>";
		echo  "<table width='60%' border='0' align='center'>";
					if(isset($index_2)){
					echo "<Tr align='center'><Td colspan='2'></Td><td colspan='2' align='right'><a href=?option=bets&task=main/test_sch_2&page=$_REQUEST[page]><<กลับ</a></td></Tr>";
					}
					else{
					echo "<Tr align='center'><Td colspan='2'></Td><td colspan='2' align='right'><a href=?option=bets&task=main/test_sch_2&index=7&sch_test_id=$_REQUEST[sch_test_id]&page=$_REQUEST[page]&add_index=1><<กลับ</a></td></Tr>";
					}
					
		//เลือกชั้นห้อง			
		echo "<Tr align='right'><Td colspan='4'>";
				echo "<div align='right'>";
		echo "<Select  name='class_index' size='1' onchange='goto_index(1)'>";
		echo  "<option  value = ''>เลือกชั้น</option>" ;
		$sql = "select * from  student_main_class order by class_code";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
			$class_name = $result['class_name'];
				if($result['class_code']==$class_index){
				$select="selected";
				}
				else{
				$select="";
				}
		echo  "<option value = $result[class_code] $select>$class_name</option>";
			}
		echo "</select>";
		echo "</div>";
		echo "</td></Tr>";
		//
		
		echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td><Td>ชื่อ<br><input type='checkbox' name='allchk' id='allchk' onclick='CheckAll()'><font color='#006666'>เลือกทั้งหมด</font></Td><Td width='200'>ชั้น</Td><Td width='40'>ห้อง</Td>";
		echo "</Tr>";
		
		//หาชั้นที่จะสอบ
		$sql_class = "select bets_test.class_room from bets_sch_test,bets_test where bets_sch_test.test_id=bets_test.id and bets_sch_test.id='$_REQUEST[sch_test_id]' ";
		$dbquery_class = mysqli_query($connect,$sql_class);
		$result_class = mysqli_fetch_array($dbquery_class);
		
		if($class_index!=""){
		$sql = "select  * from student_main where class_now='$class_index' and status='0' order by room,student_number";
		}
		else{
		$sql = "select  * from student_main where class_now='$result_class[class_room]' and status='0' order by room,student_number";
		}
		$dbquery = mysqli_query($connect,$sql);
		
		$N=1;
		$M=1;
		While ($result = mysqli_fetch_array($dbquery))
			{
				$id = $result['id'];
				$person_id =$result['student_id'];  //ระบบทดสอบของโรงเรียนปรับมาใช้เลขประจำตัวนักเรียนแทนเลขประชาชน
				$prename= $result['prename'];
				$name= $result['name'];
				$surname= $result['surname'];
				$classlevel= $result['class_now'];
				$classroom= $result['room'];
					if(($M%2) == 0)
					$color="#FFFFC";
					else  	$color="#FFFFFF";
		
		echo "<Tr bgcolor='$color' align='center'><Td>$N</Td><Td align='left'><input type='checkbox' name='$person_id' id='$person_id' value='sch_person_id'>$prename$name&nbsp;$surname</Td>";
		echo "<td align='left'>$class_text[$classlevel]</td><td>";
		if($classroom!=0){
		echo $classroom;
		}
		echo "</td>";		
		echo "</Tr>";
		$M++;
		$N++;
			}
		echo "<input type='hidden' name='sch_test_id' value='$_REQUEST[sch_test_id]'>";	
		echo "<input type='hidden' name='page' value='$_REQUEST[page]'>";	
		echo "<tr bgcolor='#FFCCCC'><td align='center' colspan='4'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url2(1)'></td></tr>";
		echo "</Table>";
		echo "</form>";
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==2.2) or ($index==3) or ($index==4) or ($index==5.2) or ($index==7) or ($index==7.2))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายการสอบ</strong></font></td></tr>";
echo "</table>";
$sql_page = "select *,bets_sch_test.id,bets_sch_test.officer from bets_sch_test left join bets_test on bets_sch_test.test_id=bets_test.id where bets_sch_test.officer='$_SESSION[login_user_id]' ";
$dbquery_page = mysqli_query($connect,$sql_page);
$num_rows=mysqli_num_rows($dbquery_page);

$pagelen=20; // กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/test_sch_2";
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
echo "<table width='95%' align='center'><tr><Td align='left'><INPUT TYPE='button' name='smb' value='เพิ่มรายการสอบ' onclick='location.href=\"?option=bets&task=main/test_sch_2&index=1&page=$page\"'></Td><td align='right'>";
echo "</td></tr></table>";
$sql = "select *,bets_sch_test.id,bets_sch_test.officer from bets_sch_test left join bets_test on bets_sch_test.test_id=bets_test.id where bets_sch_test.officer='$_SESSION[login_user_id]' order by bets_sch_test.id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='95%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ลำดับที่</Td><Td>ชื่อการสอบ</Td><Td width='70'>ชั้น</Td><Td width='170'>วันสอบ(ระหว่าง)</Td><Td width='60'>เวลาสอบ<br>(นาที)</Td><Td width='70'>รหัสการสอบ</Td><Td width='150'>ครูผู้สอบ</Td><Td width='80'>เปิด/ปิด<br>การสอบ[คลิก]</Td><Td width='50'>ลบ</Td><Td width='50'>แก้ไข</Td><Td width='50'>ผู้สอบ</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$sch_test_name= $result['sch_test_name'];
		$test_name= $result['test_name'];
					$sql_person="select * from person_main where person_id='$result[officer]' ";  
					$dbquery_person=mysqli_query($connect,$sql_person);
					$result_person=mysqli_fetch_array($dbquery_person);
					
					//หาวันสอบ
				$sql_datetest="select * from bets_test_schuser where id='$result[teacher]'";  
				$dbquery_datetest=mysqli_query($connect,$sql_datetest);
				$result_datetest=mysqli_fetch_array($dbquery_datetest);
				$start_date=thai_date_4($result_datetest['start_date']);
				$stop_date=thai_date_4($result_datetest['stop_date']);

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
			
		$class_text="";
		if($result['class_room']==4){
		$class_text="ป.1";
		}	
		else if($result['class_room']==5){
		$class_text="ป.2";
		}		
		else if($result['class_room']==6){
		$class_text="ป.3";
		}		
		else if($result['class_room']==7){
		$class_text="ป.4";
		}		
		else if($result['class_room']==8){
		$class_text="ป.5";
		}		
		else if($result['class_room']==9){
		$class_text="ป.6";
		}		
		else if($result['class_room']==10){
		$class_text="ม.1";
		}		
		else if($result['class_room']==11){
		$class_text="ม.2";
		}		
		else if($result['class_room']==12){
		$class_text="ม.3";
		}		
		else if($result['class_room']==13){
		$class_text="ม.4";
		}		
		else if($result['class_room']==14){
		$class_text="ม.5";
		}		
		else if($result['class_room']==15){
		$class_text="ม.6";
		}		

echo "<Tr bgcolor=$color align='center'><Td>$N</Td><Td align='left'>$sch_test_name <font color='#006666'>[รหัส$result[test_id]]</font></Td><td>$class_text</td><td align='left'>$start_date ถึง<br>$stop_date</td><td>$result[test_time]</td>";
echo "<Td align='center'>$result[sch_test_code]</Td>";
echo "<td align='left'>$result_person[prename]$result_person[name]&nbsp;$result_person[surname]</td>";
if($result['officer']==$officer){
			if($result['sch_test_active']==1){
			echo "<td><a href=?option=bets&task=main/test_sch_2&id=$id&active=0&index=6.2&page=$page><img src=images/yes.png border='0'></a></td>";
			}
			else{
			echo "<td><a href=?option=bets&task=main/test_sch_2&id=$id&active=1&index=6.2&page=$page><img src=images/no.png border='0'></a></td>";
			}
}
else{
			if($result['sch_test_active']==1){
			echo "<td><img src=images/yes.png border='0'></td>";
			}
			else{
			echo "<td><img src=images/no.png border='0'></td>";
			}
}	
if($result['officer']==$officer){		
echo "<Td><a href=?option=bets&task=main/test_sch_2&index=2.2&id=$id&page=$page><img src=images/drop.png border='0'></a></div></Td>";
echo "<Td><a href=?option=bets&task=main/test_sch_2&index=5.2&id=$id&page=$page><img src=images/edit.png border='0'></a></div></Td>";
}
else{
echo "<td></td><td></td>";
}
if($result['officer']==$officer){		
echo "<Td><a href=?option=bets&task=main/test_sch_2&index=7&sch_test_id=$id&page=$page&add_index=1><img src=images/edit.png border='0'></a></div></Td>";
}
else{
echo "<Td><a href=?option=bets&task=main/test_sch_2&index=7&sch_test_id=$id&page=$page><img src=images/browse.png border='0'></a></Td>";
}
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
		callfrm("?option=bets&task=main/test_sch_2"); 
	}else if(val==1){
		if(frm1.sch_test_name.value == ""){
			alert("กรุณากรอกชื่อรายการสอบ");
		}else if(frm1.test_id.value == ""){
			alert("กรุณาเลือกแบบทดสอบที่จะใช้");
		}else{
			callfrm("?option=bets&task=main/test_sch_2&index=4.2"); 
		}
	}
}

function goto_url2(val){
callfrm("?option=bets&task=main/test_sch_2&index=4"); 
}

function goto_url_update2(val){
	if(val==0){
		callfrm("?option=bets&task=main/test_sch_2"); 
	}else if(val==1){
		if(frm1.sch_test_name.value == ""){
			alert("กรุณากรอกชื่อรายการสอบ");
		}else if(frm1.sch_test_code.value == ""){
			alert("กรุณาระบุรหัสการสอบครั้งนี้");
		}else{
			callfrm("?option=bets&task=main/test_sch_2&index=6.4"); 
		}	
	}
}

function CheckAll() {
	for (var i = 0; i < document.frm1.elements.length; i++)
	{
	var e = document.frm1.elements[i];
	if (e.name != "allchk")
		if(e.value=="sch_person_id" && e.type=="checkbox"){
		e.checked = document.frm1.allchk.checked;
		}
	}
}

function goto_index(val){
	if(val==1){
		callfrm("?option=bets&task=main/test_sch_2&index=7.2&add_index=1");  
		}
}

</script>
