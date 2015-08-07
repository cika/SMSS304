<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if(isset($_REQUEST['class_index'])){
	$class_index=$_REQUEST['class_index'];
}else{
	$class_index="";
}

if(isset($_REQUEST['year_index'])){
	$year_index=$_REQUEST['year_index'];
}else{
	$year_index="";
}

if(isset($_REQUEST['room_index'])){
	$room_index=$_REQUEST['room_index'];
}else{
	$room_index="";
}

if(isset($_REQUEST['page'])){
	$page=$_REQUEST['page'];
}else{
	$page="";
}

$sql = "select * from  student_main_class order by class_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$class_ar[$result['class_code']]=$result['class_name'];
}

echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>ข้อมูลนักเรียนปัจจุบัน</strong></font></td></tr>";
echo "</table>";

//ส่วนการแสดงผล

//ตรวจสอบตัวแปรห้องที่ส่งมาว่าในชั้นนั้นมีห้องหรือไม่
$sql_check_room = "select distinct room from student_main where class_now='$class_index' and room >= '1' ";
$dbquery_check_room = mysqli_query($connect,$sql_check_room);
$num_rows_check_room=mysqli_num_rows($dbquery_check_room);
if($num_rows_check_room==0){
$room_index="";
}

//ส่วนของการแยกหน้า
$pagelen=45;  // 1_กำหนดแถวต่อหน้า
$url_link="option=student_main&task=student_report1_mobile";  // 2_กำหนดลิงค์ฺ
if($class_index!=""){
		if($room_index>=1){
		$sql = "select * from student_main where status='0' and  class_now='$class_index' and room='$room_index' ";
		}
		else{
		$sql = "select * from student_main where status='0' and  class_now='$class_index' ";
		}
}		
else{
$sql = "select * from student_main where status='0' ";
}
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery);
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

if(($totalpages>1) and ($totalpages<6)){
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
if($totalpages>5){
			if($page <=3){
			$e_page=5;
			$s_page=1;
			}
			if($page>3){
					if($totalpages-$page>=2){
					$e_page=$page+2;
					$s_page=$page-2;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-5;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>แรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>ก่อน </a>";
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
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> ถัด</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> ท้าย</a>>";
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
		//เลืิอกชั้น
		echo  "<table width='100%' border='0' align='center'>";
		echo "<Tr><td>";
		echo "<form id='frm1' name='frm1'>";
		echo "<div align='right'>";
		echo "<Select  name='class_index' size='1' onchange='goto_index(1)'>";
		echo  "<option  value = ''>ทุกชั้น</option>" ;
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
		
//เลือกห้อง		
if($class_index!=""){
		$sql_room = "select distinct room from student_main where status='0' and  class_now='$class_index' and room >= '1' order by room";
		$dbquery_room = mysqli_query($connect,$sql_room);
		$room_num= mysqli_num_rows($dbquery_room);
		if($room_num>=1){
		echo " <Select  name='room_index' size='1' onchange='goto_index(1)'>";
		echo  "<option  value = ''>ทุกห้อง</option>" ;
		While ($result_room = mysqli_fetch_array($dbquery_room)){
		echo $class_index;
				if($result_room['room']==$room_index){
				echo  "<option  value = $result_room[room] selected>ห้องที่ $result_room[room]</option>" ;	
				}
				else{
				echo  "<option  value = '$result_room[room]'>ห้องที่ $result_room[room]</option>" ;	
				}
		}
		}
		echo "</select>";
}		
		
			
		echo "</div>";
		echo "</form>";
		echo "</td></Tr></Table>";
		//จบส่วนเลือกชั้น

if($class_index!=""){
		if($room_index>=1){
		$sql = "select * from student_main where status='0' and class_now='$class_index' and room='$room_index' order by class_now,room,student_number,student_id limit $start,$pagelen";
		}
		else{
		$sql = "select * from student_main where status='0' and class_now='$class_index'  order by class_now,room,student_number,student_id limit $start,$pagelen";
		}
}
else{
$sql = "select * from student_main where status= '0' order by class_now,room,student_number,student_id limit $start,$pagelen";
}
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='100%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td>ที่</Td><Td>เลขที่</Td><Td>ชื่อ</Td><Td>รูป</Td><Td>ชั้น</Td><Td>ห้อง</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$student_id = $result['student_id'];	
		$person_id = $result['person_id'];	
		$student_number=$result['student_number'];		
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$class_now= $result['class_now'];
		$room= $result['room'];
		$sex = $result['sex'];
			if($sex==1){
			$sex="ชาย";
			}
			else if($sex==2){
			$sex="หญิง";
			}
			else{
			$sex="";
			}

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

echo "<Tr  bgcolor=$color align=center class=style1><Td>$N</Td><td>";
		if($student_number>0){
		echo $student_number;
		}
		else{
		echo "";
		}
echo "</td><Td align='left'>$prename&nbsp;$name&nbsp;&nbsp;$surname</Td>";

if($result['pic']!=""){
echo "<Td align='center'><a href='modules/student_main/pic_show.php?student_id=$student_id' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}

echo "<Td align='left'>$class_ar[$class_now]</Td>";
if($room>0){	
echo "<Td align='center'>$room</Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}
echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";

?>
