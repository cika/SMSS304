<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<?php
echo "<br />";

//ส่วนแสดงภาพรวมสถานศึกษา
if($index==1){
$sql = "select * from bets_sch_test where id='$_GET[sch_test_id]'";
$dbquery_name = mysqli_query($connect,$sql);
$result_name = mysqli_fetch_array($dbquery_name);
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายงานผลการสอบ</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>$result_name[sch_test_name]</strong></font></td></tr>";
echo "</table>";

	// หากลุ่มสาระ	
		$sql = "select * from bets_test left join bets_group on bets_test.s_group=bets_group.group_code where bets_test.id='$result_name[test_id]' ";
		$dbquery = mysqli_query($connect,$sql);
		$result = mysqli_fetch_array($dbquery);
		$g1=$result['g1']; 
		$g2=$result['g2']; 
		
		// หาคะแนนเต็ม หาคะแนนที่ได้
		$sql_full_score = "select sum(item_score) as full_score, sum(score) as score from bets_answer where sch_test_id='$_GET[sch_test_id]' ";
		$dbquery_full_score = mysqli_query($connect,$sql_full_score);
		$result_full_score = mysqli_fetch_array($dbquery_full_score);
		$full_score=$result_full_score['full_score'];
		$total_right=$result_full_score['score'];
		$total_percent="";
		if($full_score!=0){
		$total_percent=($total_right/$full_score)*100;
		$total_percent=number_format($total_percent,2);
		}
		
		//หาจำนวนผู้สอบ
		$sql_student = "select distinct person_id from bets_answer where sch_test_id='$_GET[sch_test_id]' ";
		$dbquery_student = mysqli_query($connect,$sql_student);
		$student_num=mysqli_num_rows($dbquery_student);
		
echo "<Table width='90%' Border='0' align='center'>";		
echo "<tr><td align='left'>จำนวนผู้สอบ : $student_num คน</td><td align='right'>[<a href=?option=bets&task=main/sch_report_2_mobile&page=$_REQUEST[page]><<กลับ</a>]</td></tr>";	
echo "</table>";		
echo "<Table width='90%' Border='0' align='center'>";
echo "<tr align='center' bgcolor='#FBD562'><td width='150'><b>กลุ่มสาระ</b></td><td width='150'><b>สาระ</b></td><td width='70'><b>มาตรฐาน</b></td><td width='350'><b>ตัวชี้วัด</b></td><td width='80'><b>ร้อยละ</b></td><td width='80'><b>ประเมินผล</b></td></tr>";
echo "<tr bgcolor='#CCFF66'><td colspan='4'><b>กลุ่มสาระ$result[group_name]</b> [ผลรวมทั้งฉบับ]</td><td width='100' align='center'>$total_percent</td><td width='100' align='center'>";
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
		$sql_2_1 = "select sum(item_score) as full_score, sum(score) as score from bets_answer,bets_item,bets_indicator,bets_standard,bets_substance where  bets_answer.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_answer.sch_test_id='$_GET[sch_test_id]' and bets_substance.substance_code='$result_2[substance_code]' ";
		$dbquery_2_1 = mysqli_query($connect,$sql_2_1);
		$result_2_1 = mysqli_fetch_array($dbquery_2_1);
		$substance_total=$result_2_1['full_score'];
		$substance_right=$result_2_1['score'];

		if($substance_total!=0){
		$substance_percent=($substance_right/$substance_total)*100;
		$substance_percent=number_format($substance_percent,2);
		}
		//
		echo "<tr bgcolor='#66FFFF'><td></td><td colspan='3'><b>สาระ$result_2[substance_name]</b></td><td align='center'>$substance_percent";
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
					$sql_3_1 = "select sum(item_score) as full_score, sum(score) as score from bets_answer,bets_item,bets_indicator,bets_standard where  bets_answer.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_answer.sch_test_id='$_GET[sch_test_id]' and bets_standard.standard_code='$result_3[standard_code]' ";
					$dbquery_3_1 = mysqli_query($connect,$sql_3_1);
					$result_3_1 = mysqli_fetch_array($dbquery_3_1);		
					$standard_total=$result_3_1['full_score'];
					$standard_right=$result_3_1['score'];
				
					if($standard_total!=0){
					$standard_percent=($standard_right/$standard_total)*100;
					$standard_percent=number_format($standard_percent,2);
					}
					//
					echo "<tr bgcolor='#FFCCCC'><td></td><td></td><td colspan='2'><b>มาตรฐาน $result_3[short_name]</b> $result_3[standard_text]</td><td align='center'>$standard_percent</td><td align='center'>";
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
								$sql_4_1 = "select sum(item_score) as full_score, sum(score) as score from bets_answer,bets_item,bets_indicator where  bets_answer.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_answer.sch_test_id='$_GET[sch_test_id]' and bets_indicator.indicator_code='$result_4[indicator_code]' ";
								$dbquery_4_1 = mysqli_query($connect,$sql_4_1);
								$result_4_1 = mysqli_fetch_array($dbquery_4_1);		
								$indicator_total=$result_4_1['full_score'];
								$indicator_right=$result_4_1['score'];
								
								if($indicator_total!=0){
								$indicator_percent=($indicator_right/$indicator_total)*100;
								$indicator_percent=number_format($indicator_percent,2);
								}
								//
								if(($M%2) == 0)
								$color="#FFFFC";
								else $color="#FFFFFF";

								$indicator_text=substr($result_4['indicator_text'],0,150);
								echo "<tr><td></td><td></td><td></td><td bgcolor=$color><b>ตัวชี้วัด</b> $result_4[indicator_text]</td><td bgcolor=$color align='center'>$indicator_percent";
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

//ส่วนแสดงรายชื่อนักเรียนที่สอบ
if($index==2) {
$sql = "select * from bets_sch_test where id='$_GET[sch_test_id]'";
$dbquery_name = mysqli_query($connect,$sql);
$result_name = mysqli_fetch_array($dbquery_name);
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายงานผลการสอบนักเรียนรายบุคคล</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>$result_name[sch_test_name]</strong></font></td></tr>";
echo "</table>";

	// หาเกณฑ์	
		$sql = "select * from bets_test left join bets_group on bets_test.s_group=bets_group.group_code where bets_test.id='$result_name[test_id]' ";
		$dbquery = mysqli_query($connect,$sql);
		$result = mysqli_fetch_array($dbquery);
		$g1=$result['g1']; 
		$g2=$result['g2']; 
		$full_score=$result['test_score']; 

		echo  "<table width='85%' border='0' align='center'>";
		echo "<Tr align='center'><Td colspan='4' align='left'></Td><td colspan='6' align='right'>[<a href=?option=bets&task=main/sch_report_2_mobile&page=$_GET[page]><<กลับ</a>]</td></Tr>";
		echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td><Td width='120'>เลขประจำตัว<br>นักเรียน</Td><Td>ชื่อ</Td><Td width='150'>ชั้น</Td><Td width='40'>ห้อง</Td><Td width='90'>คะแนน[เต็ม$full_score] </Td><Td width='90'>จำนวนข้อ(ทำ)</Td><Td width='90'>ร้อยละ</Td><Td width='80'>ผลประเมิน</Td>";
		echo "</Tr>";
		
		$sql = "select *,bets_schtest_testuser.id,bets_schtest_testuser.room from bets_schtest_testuser left join student_main on bets_schtest_testuser.person_id=student_main.student_id where bets_schtest_testuser.sch_test_id='$_GET[sch_test_id]' order by bets_schtest_testuser.id";
		$dbquery = mysqli_query($connect,$sql);
		$N=1;
		While ($result=mysqli_fetch_array($dbquery)){
					if(($N%2) == 0)
					$color="#FFFFC";
					else  	$color="#FFFFFF";
		
		//ประมวลผลการสอบ
		$total_percent="";
		$person_score="";
		$sql_person = "select sum(score) as score from bets_answer where sch_test_id='$_GET[sch_test_id]' and person_id='$result[student_id]' ";
		$dbquery_person = mysqli_query($connect,$sql_person);
		$result_person=mysqli_fetch_array($dbquery_person);
		$person_score=$result_person['score'];
		if(($person_score!="") and ($full_score!=0)){
		$total_percent=($person_score/$full_score)*100;
		$total_percent=number_format($total_percent,2);
		}
		//
		echo "<Tr bgcolor='$color' align='center'><Td>$N</Td><Td>$result[student_id]</Td><Td align='left'>$result[prename]$result[name] $result[surname]</Td><Td align='left'>$result[class_name]</Td><Td>";
		if($result['room']>0){
		echo $result['room'];
		}
		echo "</Td>";
		echo "<td align='center'>";
		if($person_score!=""){
		echo $person_score;
		}
		echo "</td>";
		echo "<td align='center'>";
				//หาจำนวนข้อ
				$sql_item_num = "select  id from bets_answer where sch_test_id='$_GET[sch_test_id]' and person_id='$result[student_id]' ";
				$dbquery_item_num = mysqli_query($connect,$sql_item_num);
				$item_num=mysqli_num_rows($dbquery_item_num);
				if($item_num>0){
				echo $item_num;
				}
				//
		echo "</td>";
		echo "<td align='center'>";
		if($total_percent!=""){
		echo $total_percent;
		}
		echo "</td>";
		echo "	<td>";
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
		$N++;
		}
		echo "</table>";
}

if($index==3){
$sql = "select * from bets_sch_test where id='$_GET[sch_test_id]'";
$dbquery_name = mysqli_query($connect,$sql);
$result_name = mysqli_fetch_array($dbquery_name);

$sql = "select * from student_main where student_id='$_GET[person_id]' order by id desc limit 0,1";
$dbquery_student = mysqli_query($connect,$sql);
$result_student = mysqli_fetch_array($dbquery_student);

echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายงานผลการสอบ</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>$result_name[sch_test_name]</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>$result_student[prename]$result_student[name] $result_student[surname]</strong></font></td></tr>";
echo "</table>";

	// หาเกณฑ์		
		$sql = "select * from bets_test left join bets_group on bets_test.s_group=bets_group.group_code where bets_test.id='$result_name[test_id]' ";
		$dbquery = mysqli_query($connect,$sql);
		$result = mysqli_fetch_array($dbquery);
		$g1=$result['g1']; 
		$g2=$result['g2']; 
		
		// หาคะแนนเต็ม หาคะแนนที่ได้
		$sql_full_score = "select sum(item_score) as full_score, sum(score) as score from bets_answer where sch_test_id='$_GET[sch_test_id]' and person_id='$_GET[person_id]' ";
		$dbquery_full_score = mysqli_query($connect,$sql_full_score);
		$result_full_score = mysqli_fetch_array($dbquery_full_score);
		$full_score=$result_full_score['full_score'];
		$total_right=$result_full_score['score'];
		$total_percent="";
		if($full_score!=0){
		$total_percent=($total_right/$full_score)*100;
		$total_percent=number_format($total_percent,2);
		}
echo "<Table width='90%' Border='0' align='center'>";		
echo "<tr><td align='left'>*คำนวณเฉพาะข้อที่ผู้สอบทำข้อสอบเท่านั้น</td><td align='right'>[<a href=?option=bets&task=main/sch_report_2_mobile&index=2&sch_test_id=$_GET[sch_test_id]&page=$_REQUEST[page]><<กลับ</a>]</td></tr>";	
echo "</table>";		
echo "<Table width='90%' Border='0' align='center'>";
echo "<tr align='center' bgcolor='#FBD562'><td width='150'><b>กลุ่มสาระ</b></td><td width='150'><b>สาระ</b></td><td width='70'><b>มาตรฐาน</b></td><td width='350'><b>ตัวชี้วัด</b></td><td width='80'><b>% [คะแนน]</b></td><td width='80'><b>ประเมินผล</b></td></tr>";
echo "<tr bgcolor='#CCFF66'><td colspan='4'><b>กลุ่มสาระ$result[group_name]</b></td><td width='100' align='center'>$total_percent [$total_right/$full_score]</td><td width='100' align='center'>";
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
		$sql_2_1 = "select sum(item_score) as full_score, sum(score) as score from bets_answer,bets_item,bets_indicator,bets_standard,bets_substance where  bets_answer.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_answer.sch_test_id='$_GET[sch_test_id]' and bets_substance.substance_code='$result_2[substance_code]' and person_id='$_GET[person_id]' ";
		$dbquery_2_1 = mysqli_query($connect,$sql_2_1);
		$result_2_1 = mysqli_fetch_array($dbquery_2_1);
		$substance_total=$result_2_1['full_score'];
		$substance_right=$result_2_1['score'];

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
					$sql_3_1 = "select sum(item_score) as full_score, sum(score) as score from bets_answer,bets_item,bets_indicator,bets_standard where  bets_answer.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_answer.sch_test_id='$_GET[sch_test_id]' and bets_standard.standard_code='$result_3[standard_code]' and person_id='$_GET[person_id]' ";
					$dbquery_3_1 = mysqli_query($connect,$sql_3_1);
					$result_3_1 = mysqli_fetch_array($dbquery_3_1);		
					$standard_total=$result_3_1['full_score'];
					$standard_right=$result_3_1['score'];
					
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
								$sql_4_1 = "select sum(item_score) as full_score, sum(score) as score from bets_answer,bets_item,bets_indicator where  bets_answer.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_answer.sch_test_id='$_GET[sch_test_id]' and bets_indicator.indicator_code='$result_4[indicator_code]' and person_id='$_GET[person_id]' ";
								$dbquery_4_1 = mysqli_query($connect,$sql_4_1);
								$result_4_1 = mysqli_fetch_array($dbquery_4_1);		
								$indicator_total=$result_4_1['full_score'];
								$indicator_right=$result_4_1['score'];

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
if(!($index==1 or $index==2 or $index==3)){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายงานผลการสอบ</strong></font></td></tr>";
echo "</table>";
$sql_page = "select *,bets_sch_test.id,bets_sch_test.officer from bets_sch_test left join bets_test on bets_sch_test.test_id=bets_test.id where bets_sch_test.officer='$_SESSION[login_user_id]'";
$dbquery_page = mysqli_query($connect,$sql_page);
$num_rows=mysqli_num_rows($dbquery_page);

$pagelen=20; // กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/sch_report_2_mobile";
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
$sql = "select *,bets_sch_test.id,bets_sch_test.test_id,bets_sch_test.officer from bets_sch_test left join bets_test on bets_sch_test.test_id=bets_test.id where bets_sch_test.officer='$_SESSION[login_user_id]' order by bets_sch_test.id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='100%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='70'>ลำดับที่</Td><Td>ชื่อการสอบ</Td><Td>ผู้ดำเนินการสอบ</Td><Td width='100'>ชั้น</Td><Td width='100'>คะแนน(%)</Td><Td width='100'>ผลประเมิน</Td><Td width='100'>นักเรียน<br>รายบุคคล</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$sch_test_name= $result['sch_test_name'];
		//
		$sql_person = "select  * from person_main where person_id='$result[officer]' ";
		$dbquery_person = mysqli_query($connect,$sql_person);
		$result_person = mysqli_fetch_array($dbquery_person);
		$teacher_name=$result_person['prename'].$result_person['name']." ".$result_person['surname'];
		//
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
		
		//หาเกณฑ์การสอบ		
		$sql_g = "select * from bets_test  where bets_test.id='$result[test_id]'";
		$dbquery_g = mysqli_query($connect,$sql_g);
		$result_g = mysqli_fetch_array($dbquery_g);
		$g1=$result_g['g1']; 
		$g2=$result_g['g2']; 
		
		//ประมวลผลการสอบ
		$total_percent="";
		$sql_full_score = "select sum(item_score) as full_score, sum(score) as score from bets_answer where sch_test_id='$id' ";
		$dbquery_full_score = mysqli_query($connect,$sql_full_score);
		$result_full_score = mysqli_fetch_array($dbquery_full_score);
		$full_score=$result_full_score['full_score'];
		$total_right=$result_full_score['score'];
		if($full_score!=0){
		$total_percent=($total_right/$full_score)*100;
		$total_percent=number_format($total_percent,2);
		}
		
echo "<Tr bgcolor=$color align='center'><Td>$N</Td><Td align='left'>$sch_test_name <font color='#006666'>[รหัส$result[test_id]]</font><td align='left'>$teacher_name</td></Td><td>$class_text</td>";
		
		echo "<td align='center'>$total_percent</td><td>";
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
if($full_score>0){
echo "<td><a href=?option=bets&task=main/sch_report_2_mobile&sch_test_id=$result[id]&index=2&page=$page><img src=images/admin/user.gif border='0'></a></td>";
}
else{
echo "<td></td>";
}
echo "</Tr>";
$M++;
$N++;
	}
echo "</Table>";
echo "</form>";
}
?>
