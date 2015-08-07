<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!($_SESSION['login_status']<=4)){
exit();
}

require_once "modules/permission/time_inc.php";	

$user=$_SESSION['login_user_id'];

//ส่วนหัว
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7) or ($index==8))){

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
echo "<tr align='center'><td><font color='#006666'><strong>ทะเบียนขออนุญาตไปราชการ</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666'>$full_name</font></td></tr>";
echo "</table>";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7) or ($index==8))){

//ส่วนของการแยกหน้า
$sql="select id from permission_main where person_id='$user'";
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=permission&task=main/permission_main";  // 2_กำหนดลิงค์ฺ
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

$sql="select * from permission_main where person_id='$user' order by id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width='100%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td>ที่</Td><Td>วันขออนุญาต</Td><Td>เรื่องราชการ</Td><Td>สถานที่</Td><Td>วันไปราชการ</Td><Td>อนุมัติ/คำสั่ง</Td></Tr>";

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['id'];
		$subject = $result['subject'];
		$place = $result['place'];
		$vehicle = $result['vehicle'];
		$ref_id = $result['ref_id'];
		$file = $result['document'];
		$comment_person = $result['comment_person'];
		$grant = $result['grant_x'];
		$grant_comment = $result['grant_comment'];
		$report = $result['report'];
		$rec_date = $result['rec_date'];
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
echo "<Tr bgcolor='$color'><Td valign='top' align='center'>$id</Td><Td valign='top' align='left'>";
echo thai_date_3($rec_date);
echo "</Td><Td valign='top' align='left'>$subject</Td><Td valign='top' align='left' >$place</Td><Td valign='top' align='left'>";

	$sql_date="select * from permission_date where ref_id='$ref_id' and person_id='$user' order by date";
	$dbquery_date = mysqli_query($connect,$sql_date);
	While ($result_date = mysqli_fetch_array($dbquery_date)){
		$date = $result_date['date'];
		echo thai_date_3($date);
		echo "<br />";
	}
echo "<Td valign='top' align='center'>";
if($grant==1){
echo "<img src=images/yes.png border='0'><br><font color='#339900'>$grant_comment</font>";
}
else if($grant==2){
echo "<img src=images/no.png border='0'><br><font color='#990000'>$grant_comment</font>";
}
else{
echo "รออนุมัติ";
}
echo "</Td>";
echo "</Tr>";

$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}	
echo "</Table>";
}

?>
