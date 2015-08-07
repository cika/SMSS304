<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<?php
echo "<br />";

if($index==3){
$student_id=$_SESSION['login_user_id'];
$sql = "select * from bets_sch_test where id='$_GET[sch_test_id]'";
$dbquery_name = mysqli_query($connect,$sql);
$result_name = mysqli_fetch_array($dbquery_name);

$sql = "select * from student_main where student_id='$student_id' order by id desc limit 0,1";
$dbquery_student = mysqli_query($connect,$sql);
$result_student = mysqli_fetch_array($dbquery_student);
		
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายงานผลการสอบ</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>$result_name[sch_test_name]</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>$result_student[prename]$result_student[name] $result_student[surname]</strong></font></td></tr>";
echo "</table>";

	// หากลุ่มสาระ	
		$sql = "select * from bets_test left join bets_group on bets_test.s_group=bets_group.group_code where bets_test.id='$result_name[test_id]' ";
		$dbquery = mysqli_query($connect,$sql);
		$result = mysqli_fetch_array($dbquery);
		$g1=$result['g1']; 
		$g2=$result['g2']; 
		
		// หาคะแนนเต็ม
		$sql_full_score = "select sum(item_score) as full_score from bets_answer where sch_test_id='$_GET[sch_test_id]' and person_id='$student_id' ";
		$dbquery_full_score = mysqli_query($connect,$sql_full_score);
		$result_full_score = mysqli_fetch_array($dbquery_full_score);
		$full_score=$result_full_score['full_score'];
	
		//หาคะแนนที่ได้
		$sql_right = "select sum(score) as score from bets_answer where sch_test_id='$_GET[sch_test_id]' and person_id='$student_id' ";
		$dbquery_right = mysqli_query($connect,$sql_right );
		$result_score = mysqli_fetch_array($dbquery_right);		
		$total_right=$result_score['score'];

		$total_percent="";
		if($full_score!=0){
		$total_percent=($total_right/$full_score)*100;
		$total_percent=number_format($total_percent,2);
		}
		
		//หาจำนวนข้อ
		$sql_item =  "select id from bets_answer where sch_test_id='$_GET[sch_test_id]' and person_id='$student_id' ";
		$dbquery_item = mysqli_query($connect,$sql_item);
		$item_num=mysqli_num_rows($dbquery_item);

echo "<Table width='90%' Border='0' align='center'>";		
echo "<tr><td align='right'>[<a href=?option=bets&task=main/student_report_1&sch_test_id=$_GET[sch_test_id]&page=$_REQUEST[page]><<กลับ</a>]</td></tr>";	
echo "</table>";		
echo "<Table width='90%' Border='0' align='center'>";
echo "<tr align='center' bgcolor='#FBD562'><td width='150'><b>กลุ่มสาระ</b></td><td width='150'><b>สาระ</b></td><td width='70'><b>มาตรฐาน</b></td><td width='350'><b>ตัวชี้วัด</b></td><td width='80'><b>ร้อยละ</b></td><td width='80'><b>ประเมินผล</b></td></tr>";
echo "<tr bgcolor='#CCFF66'><td colspan='4'><b>กลุ่มสาระ$result[group_name] ข้อสอบ(ที่ทำ) : $item_num ข้อ</b></td><td width='100' align='center'><b>$total_percent [$total_right/$full_score]</b></td><td width='100' align='center'>";
//
if($total_percent<=$g2){
$bgcolor="#FF0000";
}
else if($total_percent>$g2 and $total_percent<$g1){
$bgcolor="#FFFF00";
}
else if($total_percent>=$g1){
$bgcolor="#66FF00";
}
else{
$bgcolor="#FFFFFF";
}
 echo "<table  border='0' cellspacing='0' cellpadding='0' width='20' height='15'>";
echo "<tr><td bgcolor='$bgcolor'></td></tr>";
 echo "</table>";
 //
echo "</td></tr>";
	//
		$sql_2 = "select * from bets_substance where group_code='$result[group_code]' order by id ";
		$dbquery_2 = mysqli_query($connect,$sql_2);
		while($result_2 = mysqli_fetch_array($dbquery_2)){
		
		//หาคะแนนสาระ
		$substance_percent="";
		$sql_2_1 = "select sum(item_score) as full_score from bets_answer,bets_item,bets_indicator,bets_standard,bets_substance where  bets_answer.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_answer.sch_test_id='$_GET[sch_test_id]' and bets_substance.substance_code='$result_2[substance_code]' and person_id='$student_id' ";
		$dbquery_2_1 = mysqli_query($connect,$sql_2_1);
		$result_2_1 = mysqli_fetch_array($dbquery_2_1);
		$substance_total=$result_2_1['full_score'];
		
		$sql_2_2 = "select sum(score) as score from bets_answer,bets_item,bets_indicator,bets_standard,bets_substance where  bets_answer.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_answer.sch_test_id='$_GET[sch_test_id]' and bets_substance.substance_code='$result_2[substance_code]' and person_id='$student_id' ";
		$dbquery_2_2 = mysqli_query($connect,$sql_2_2);
		$result_2_2 = mysqli_fetch_array($dbquery_2_2);		
		$substance_right=$result_2_2['score'];

		if($substance_total!=0){
		$substance_percent=($substance_right/$substance_total)*100;
		$substance_percent=number_format($substance_percent,2);
		}
		//
		echo "<tr bgcolor='#66FFFF'><td></td><td colspan='3'><b>สาระ$result_2[substance_name]</b></td><td align='center'>$substance_percent ";
		if($substance_percent!=""){
		echo "[$substance_right/$substance_total]";
		}
		echo "</td><td align='center'>";
//
if($substance_percent<=$g2){
$bgcolor="#FF0000";
}
else if($substance_percent>$g2 and $substance_percent<$g1){
$bgcolor="#FFFF00";
}
else if($substance_percent>=$g1){
$bgcolor="#66FF00";
}
else{
$bgcolor="#FFFFFF";
}
if($substance_percent!=""){
 echo "<table  border='0' cellspacing='0' cellpadding='0' width='13' height='13'>";
echo "<tr><td bgcolor='$bgcolor'></td></tr>";
 echo "</table>";
 }
 //
		echo "</td></tr>";
					$sql_3 = "select * from bets_standard where substance_code='$result_2[substance_code]' order by id ";
					$dbquery_3 = mysqli_query($connect,$sql_3);
					while($result_3 = mysqli_fetch_array($dbquery_3)){
					//
					
					//หาคะแนนมาตรฐาน
					$standard_percent="";
					$sql_3_1 = "select sum(item_score) as full_score from bets_answer,bets_item,bets_indicator,bets_standard where  bets_answer.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_answer.sch_test_id='$_GET[sch_test_id]' and bets_standard.standard_code='$result_3[standard_code]' and person_id='$student_id' ";
					$dbquery_3_1 = mysqli_query($connect,$sql_3_1);
					$result_3_1 = mysqli_fetch_array($dbquery_3_1);		
					$standard_total=$result_3_1['full_score'];

					$sql_3_2 = "select sum(score) as score from bets_answer,bets_item,bets_indicator,bets_standard where  bets_answer.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_answer.sch_test_id='$_GET[sch_test_id]' and bets_standard.standard_code='$result_3[standard_code]' and person_id='$student_id' ";
					$dbquery_3_2 = mysqli_query($connect,$sql_3_2);
					$result_3_2 = mysqli_fetch_array($dbquery_3_2);		
					$standard_right=$result_3_2['score'];

					if($standard_total!=0){
					$standard_percent=($standard_right/$standard_total)*100;
					$standard_percent=number_format($standard_percent,2);
					}
					//
					echo "<tr bgcolor='#FFCCCC'><td></td><td></td><td colspan='2'><b>มาตรฐาน $result_3[short_name]</b> $result_3[standard_text]</td><td align='center'>$standard_percent ";
					if($standard_percent!=""){
					echo "[$standard_right/$standard_total]";
					}
					echo "</td><td align='center'>";
//
if($standard_percent<=$g2){
$bgcolor="#FF0000";
}
else if($standard_percent>$g2 and $standard_percent<$g1){
$bgcolor="#FFFF00";
}
else if($standard_percent>=$g1){
$bgcolor="#66FF00";
}
else{
$bgcolor="#FFFFFF";
}
if($standard_percent!=""){
 echo "<table  border='0' cellspacing='0' cellpadding='0' width='13' height='13'>";
echo "<tr><td bgcolor='$bgcolor'></td></tr>";
 echo "</table>";
 }
 //
					echo "</td></tr>";
								$class_room=$result['class_room']-3; //แปลงรหัสห้อง
								$sql_4 = "select * from bets_indicator where standard_code='$result_3[standard_code]' and class_code='$class_room' order by id ";
								$dbquery_4 = mysqli_query($connect,$sql_4);
								$M=1;
								while($result_4 = mysqli_fetch_array($dbquery_4)){
								
								//หาคะแนนตัวชี้วัด
								$indicator_percent="";
								$sql_4_1 = "select sum(item_score) as full_score from bets_answer,bets_item,bets_indicator where  bets_answer.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_answer.sch_test_id='$_GET[sch_test_id]' and bets_indicator.indicator_code='$result_4[indicator_code]' and person_id='$student_id' ";
								$dbquery_4_1 = mysqli_query($connect,$sql_4_1);
								$result_4_1 = mysqli_fetch_array($dbquery_4_1);		
								$indicator_total=$result_4_1['full_score'];

								$sql_4_2 = "select sum(score) as score from bets_answer,bets_item,bets_indicator where  bets_answer.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_answer.sch_test_id='$_GET[sch_test_id]' and bets_indicator.indicator_code='$result_4[indicator_code]' and person_id='$student_id' ";
								$dbquery_4_2 = mysqli_query($connect,$sql_4_2);
								$result_4_2 = mysqli_fetch_array($dbquery_4_2);		
								$indicator_right=$result_4_2['score'];

								if($indicator_total!=0){
								$indicator_percent=($indicator_right/$indicator_total)*100;
								$indicator_percent=number_format($indicator_percent,2);
								}
								//
								if(($M%2) == 0)
								$color="#FFFFC";
								else $color="#FFFFFF";

								$indicator_text=substr($result_4['indicator_text'],0,150);
								echo "<tr><td></td><td></td><td></td><td bgcolor=$color><b>ตัวชี้วัด</b> $result_4[indicator_text]</td><td bgcolor=$color align='center'>$indicator_percent ";
								if($indicator_percent!=""){
								echo "[$indicator_right/$indicator_total]";
								}
								echo "</td><td bgcolor=$color align='center'>";
//
if($indicator_percent<=$g2){
$bgcolor="#FF0000";
}
else if($indicator_percent>$g2 and $indicator_percent<$g1){
$bgcolor="#FFFF00";
}
else if($indicator_percent>=$g1){
$bgcolor="#66FF00";
}
else{
$bgcolor="#FFFFFF";
}
if($indicator_percent!=""){
 echo "<table  border='0' cellspacing='0' cellpadding='0' width='13' height='13'>";
echo "<tr><td bgcolor='$bgcolor'></td></tr>";
 echo "</table>";
 }
 //
								echo "</td></tr>";
								$M++;
								}
					}
		}
	//
echo "</table>";
echo "<hr>";
echo "<div align='left'>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>คำอธิบาย</b> สีเขียวค่าคะแนนมากกว่าหรือเท่ากับร้อยละ $g1  สีเหลืองมากกว่าร้อยละ $g2 แต่น้อยกว่าร้อยละ $g1  สีแดงน้อยกว่าหรือเท่ากับร้อยละ $g2 ";
echo "</div>";
}

//ส่วนการแสดงผล
if(!($index==3)){
$student_id=$_SESSION['login_user_id'];

$sql = "select * from student_main where student_id='$student_id' order by id desc limit 0,1";
$dbquery_student = mysqli_query($connect,$sql);
$result_student = mysqli_fetch_array($dbquery_student);
		
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายงานผลการสอบ</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>$result_student[prename]$result_student[name] $result_student[surname]</strong></font></td></tr>";
echo "</table>";

$sql_page = "select *,bets_sch_test.id from bets_sch_test left join bets_schtest_testuser on bets_sch_test.id=bets_schtest_testuser.sch_test_id where bets_schtest_testuser.person_id='$_SESSION[login_user_id]' and bets_schtest_testuser.stop_test='1' ";
$dbquery_page = mysqli_query($connect,$sql_page);
$num_rows=mysqli_num_rows($dbquery_page);

$pagelen=20; // กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/student_report_1";
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
$sql = "select *,bets_sch_test.id from bets_sch_test left join bets_schtest_testuser on bets_sch_test.id=bets_schtest_testuser.sch_test_id where bets_schtest_testuser.person_id='$_SESSION[login_user_id]' and bets_schtest_testuser.stop_test='1' order by bets_sch_test.id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='100%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td>ที่</Td><Td>ชื่อการสอบ</Td><Td>คะแนน(%)</Td><Td>ผลประเมิน</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$sch_test_name= $result['sch_test_name'];
		
		if(($M%2) == 0)
		$color="#FFFFC";
		else  	$color="#FFFFFF";
		
		//หาเกณฑ์การสอบ		
		$sql_g = "select * from bets_test where bets_test.id='$result[test_id]'";
		$dbquery_g = mysqli_query($connect,$sql_g);
		$result_g = mysqli_fetch_array($dbquery_g);
		$g1=$result_g['g1']; 
		$g2=$result_g['g2']; 
		
		//ประมวลผลการสอบ
		$total_percent="";
		$sql_full_score = "select sum(item_score) as full_score, sum(score) as score from bets_answer where sch_test_id='$id' and person_id='$_SESSION[login_user_id]'";
		$dbquery_full_score = mysqli_query($connect,$sql_full_score);
		$result_full_score = mysqli_fetch_array($dbquery_full_score);
		$full_score=$result_full_score['full_score'];
		$total_right=$result_full_score['score'];
		if($full_score!=0){
		$total_percent=($total_right/$full_score)*100;
		$total_percent=number_format($total_percent,2);
		}

echo "<Tr bgcolor=$color align='center'><Td>$N</Td><Td align='left'>$sch_test_name</Td>";
		echo "<td>$total_percent</td><td>";
		if($total_percent<=$g2){
		$bgcolor="#FF0000";
		}
		else if($total_percent>$g2 and $total_percent<$g1){
		$bgcolor="#FFFF00";
		}
		else if($total_percent>=$g1){
		$bgcolor="#66FF00";
		}
		else{
		$bgcolor="#FFFFFF";
		}
		if($total_percent!=""){
		 echo "<table  border='0' cellspacing='0' cellpadding='0' width='13' height='13'>";
		echo "<tr><td bgcolor='$bgcolor'></td></tr>";
		 echo "</table>";
		 }
		echo "</td>";
echo "</Tr>";
$M++;
$N++;
	}
echo "</Table>";
echo "</form>";
}
?>
