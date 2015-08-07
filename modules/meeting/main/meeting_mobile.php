<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!($_SESSION['login_status']<=4)){
exit();
}

require_once "modules/meeting/time_inc.php";	
?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script> 
<?php

$user=$_SESSION['login_user_id'];


//กรณีเลือกแสดงเฉพาะห้องประชุม
if(isset($_REQUEST['room_index'])){
$room_index=$_REQUEST['room_index'];
}else{
	$room_index = "";
	}
//ส่วนหัว
if(!(($index==1) or ($index==2))){
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>ทะเบียนจองห้องประชุม</strong></font></td></tr>";
echo "</table>";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2))){

//ส่วนของการแยกหน้า
if($room_index>=1){
$sql="select id from meeting_main where room='$room_index' ";
}
else{
$sql="select id from meeting_main";
}

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery);

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=meeting&task=main/meeting_mobile&room_index=$room_index";  // 2_กำหนดลิงค์ฺ
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
echo "</div>";  }					
//จบแยกหน้า

$sql_room = "select * from meeting_room where active='1' order by id";
$dbquery_room = mysqli_query($connect,$sql_room);
While ($result_room = mysqli_fetch_array($dbquery_room))
{
$room_ar[$result_room['room_code']]=$result_room['room_name'];
}

if($room_index>=1){
$sql="select meeting_main.id, meeting_main.room, meeting_main.book_date, meeting_main.start_time, meeting_main.finish_time, meeting_main.objective, meeting_main.person_num, meeting_main.other, meeting_main.book_person, meeting_main.rec_date, meeting_main.approve, meeting_main.reason, person_main.name ,person_main.surname from meeting_main left join person_main on meeting_main.book_person = person_main.person_id where meeting_main.room='$room_index' order by meeting_main.book_date,meeting_main.room,meeting_main.start_time limit $start,$pagelen";
}
else{
$sql="select meeting_main.id, meeting_main.room, meeting_main.book_date, meeting_main.start_time, meeting_main.finish_time, meeting_main.objective, meeting_main.person_num,  meeting_main.other, meeting_main.book_person, meeting_main.rec_date, meeting_main.approve, meeting_main.reason, person_main.name ,person_main.surname from meeting_main left join person_main on meeting_main.book_person = person_main.person_id order by meeting_main.book_date,meeting_main.room,meeting_main.start_time limit $start,$pagelen";
}

$dbquery = mysqli_query($connect,$sql);

echo  "<table width='100%' border='0' align='center'>";
echo "<Tr>";
echo "<Td colspan='8' align='right'>";
echo "<form  name='frm1'>";
echo "&nbsp;<Select  name='room_index' size='1' onchange='goto_url2(1)'>";
echo  '<option value ="" >ทุกห้องประชุม</option>' ;
		$sql_room = "SELECT *  FROM meeting_room where active='1' order by room_code";
		$dbquery_room = mysqli_query($connect,$sql_room);
				While ($result_room = mysqli_fetch_array($dbquery_room ))
				{ 
						if ($room_index==$result_room ['room_code']){
						echo "<option value=$result_room[room_code]  selected>$result_room[room_name]</option>"; 
						} 
						else{
						echo "<option value=$result_room[room_code]>$result_room[room_name]</option>"; 
						}
				}
					echo "</select>";
echo "</form>";

echo "</Td>";
echo "</Tr>";

echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='80'>วันที่</Td><Td width='100'>ห้องประชุม</Td><Td  width='60'>ตั้งแต่เวลา</Td><Td width='60'>ถึงเวลา</Td><Td>วัตถุประสงค์</Td><Td width='100'>ผู้จอง</Td><Td width='40'>อนุมัติ</Td></Tr>";

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id= $result['id'];
		$room= $result['room'];
		$start_time=$result['start_time'];
		$start_time=number_format($start_time,2);
		$finish_time=$result['finish_time'];
		$finish_time=number_format($finish_time,2);
		$book_date = $result['book_date'];
		$rec_date = $result['rec_date'];
		$name= $result['name'];
		$surname = $result['surname'];
		
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
echo "<Tr bgcolor='$color'>";
echo "<Td align='left'>";
echo thai_date_3($book_date);
echo "</Td>";
echo "<Td align='left'>";
if(isset($room_ar[$room])){
echo $room_ar[$room];
}
echo "</Td>";
echo "<Td align='center'>$start_time น.</Td><Td align='center' >$finish_time น.</Td>";
echo "<td>$result[objective]</td>";
echo "<Td>$name&nbsp;&nbsp;$surname</Td>";

if($result['approve']==1){
echo "<Td align='center'><img src=images/yes.png border='0' alt='อนุมัติ'></Td>";
}
else if($result['approve']==2){
echo "<Td align='center'><img src=images/no.png border='0' alt='ไม่อนุมัติ'></Td>";
}
else {
echo "<td></td>";
} 
echo "</Tr>";

$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}	
echo "</Table>";
}

if(!(($index==1) or ($index==2) or ($index==3))) {
echo "<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<img src=images/yes.png border='0'> หมายถึง อนุมัติให้ใช้ห้องประชุม&nbsp;&nbsp;<img src=images/no.png border='0'> หมายถึง ไม่อนุมัติให้ใช้ห้องประชุม";
}
?>

<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=meeting&task=main/meeting_mobile");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.room.value == ""){
			alert("กรุณาเลือกห้องประชุม");
		}else if(frm1.objective == ""){
			alert("กรุณาระบุวัตถุประสงค์ของการใช้");
		}else{
			callfrm("?option=meeting&task=main/meeting_mobile&index=4");   //page ประมวลผล
		}
	}
}

function goto_url2(val){
callfrm("?option=meeting&task=main/meeting_mobile"); 		
}

</script>
