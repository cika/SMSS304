<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<script type="text/javascript" src="./css/js/calendarDateInput2.js"></script> 
<?php
require_once("modules/bets/time_inc.php");
$officer=$_SESSION['login_user_id'];
echo "<br />";
echo "<table width='90%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายการทดสอบผู้เรียน</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>(เป็นรายการที่เปิดให้ใช้ทดสอบผู้เรียน โดยคุณครูต้องกำหนดการสอบและผู้สอบต่อไป)</strong></font></td></tr>";

echo "</table>";
echo "<br>";	
$sql_page = "select * from bets_test  left join bets_test_schuser on bets_test.id=bets_test_schuser.test_id where bets_test_schuser.teacher='$_SESSION[login_user_id]' and bets_test.test_active='1' ";
$dbquery_page = mysqli_query($connect,$sql_page);
$num_rows=mysqli_num_rows($dbquery_page);

$pagelen=20; // กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/test_sch";
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
echo "<table width='95%' align='center'><tr><Td align='left'><INPUT TYPE='button' name='smb' value='คุณครูกำหนดการสอบ' onclick='location.href=\"?option=bets&task=main/test_sch_2&index=1&page=999\"'></Td><td align='right'>";
echo "</td></tr></table>";
$sql = "select *,bets_test.id,bets_test.officer from bets_test  left join bets_test_schuser on bets_test.id=bets_test_schuser.test_id where bets_test_schuser.teacher='$_SESSION[login_user_id]' and bets_test.test_active='1' order by bets_test.id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='95%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>ลำดับที่</Td><Td>ชื่อการทดสอบ</Td><Td>ผู้สร้าง</Td><Td width='100'>ชั้น</Td><Td width='100'>จำนวนข้อ</Td><Td width='100'>คะแนนเต็ม</Td><Td width='100'>เวลาสอบ<br>นาที</Td><Td width='170'>วันเวลา<br>เริ่มสอบได้</Td><Td width='170'>วันเวลา<br>สิ้นสุดการสอบ</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
$date_now=date("Y-m-d H:i:s");
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$test_name= $result['test_name'];
		$start_date=thai_date_4($result['start_date']);
		$stop_date=thai_date_4($result['stop_date']);
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		if($result['stop_date']>$date_now){
		$new="<img src=modules/bets/images/new.GIF border='0'>";
		}
		else{
		$new="";
		}
		echo "<Tr bgcolor=$color align='center'><Td>$N</Td><Td align='left'>$test_name <font color='#006666'>[รหัส$result[id]]</font>$new</Td>";
echo "<td align='left'>";
$sql_person = "select  * from person_main where person_id='$result[officer]' ";
$dbquery_person = mysqli_query($connect,$sql_person);
$result_person = mysqli_fetch_array($dbquery_person);
echo $result_person['prename'].$result_person['name']." ".$result_person['surname'];
echo "</td>";		
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
echo "<td align='center'>$result[item_num]</td><td align='center'>$result[test_score]</td><td align='center'>$result[test_time]</td>";
echo "<td align='left'>$start_date</td><td align='left'>$stop_date</td>";
echo "</Tr>";
$M++;
$N++;
	}
echo "</Table>";
?>
