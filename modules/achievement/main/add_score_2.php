<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if(isset($_REQUEST['ed_year'])){
$ed_year=$_REQUEST['ed_year'];
}else{
$ed_year="";
}

if(isset($_REQUEST['test_class'])){
	$test_class=$_REQUEST['test_class'];
}else{
	$test_class="";
}

if(!($result_permission['p2']==1)) {
exit();
}

$officer=$_SESSION['login_user_id'];
$class_ar[3]="ชั้นประถมศึกษาปีที่ 3";

echo "<br>";
//ส่วนฟอร์มกำหนดปีการศึกษา
if($ed_year==""){
echo "<br />";
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>กำหนดปีการศึกษา และชั้นสอบ NT</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='300' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr><Td align='right'>ปีการศึกษา&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='ed_year'  id='ed_year' Size='4' maxlength='4' onkeydown='integerOnly()'></Td></Tr>";
echo "<Tr><Td align='right'>ชั้น&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='test_class'  id='test_class' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value = '3' selected>ประถมศึกษาปีที่ 3</option>";
echo "</select>";
echo "</div></td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url2(1)'  ></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date=date("Y-m-d");
		for($M=1;$M<4;$M++){
		$thai=$_POST[$M][1];
		$math=$_POST[$M][2];
		$science=$_POST[$M][3];
		$score_avg=$_POST[$M][9];			
		$test_level=$_POST[$M][11];			
				
						$sql_select = "select * from  achievement_main  where  level='$M' and ed_year='$ed_year' and test_class='$_REQUEST[test_class]' and test_type='2' ";
						$dbquery_select = mysqli_query($connect,$sql_select);
						$data_num=mysqli_num_rows($dbquery_select);
									if($data_num>0){
									$sql_update = "update  achievement_main set thai='$thai',
									math='$math',
									science='$science',
									score_avg='$score_avg',									
									officer='$officer',
									rec_date='$rec_date' 
									where  test_type='2' and test_class='$_REQUEST[test_class]' and ed_year='$ed_year' and level='$test_level' ";
									$dbquery_update = mysqli_query($connect,$sql_update);
									}
									else {
													if($score_avg>0){
													$sql_insert = "insert into achievement_main (test_type, test_class, ed_year, level, thai, math, science, score_avg, officer, rec_date) values ('2', '$_REQUEST[test_class]', '$ed_year', '$test_level', '$thai', '$math', '$science', '$score_avg', '$officer', '$rec_date')";
													$dbquery_insert = mysqli_query($connect,$sql_insert);
													}
									}
		}	
	echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); </script>\n";
}
//ส่วนแสดงหลัก
if($index==1 or $index==4 or $index==5 ){
$test_class=$test_class;
echo "<br />";
echo "<table width='99%' border='0' align='center'>";
echo "<tr align='center'>
	<td align=center><font color='#990000' size='3'><strong>บันทึกคะแนน NT $class_ar[$test_class]  ปีการศึกษา $ed_year </strong></font>
<font color='#006666' size='3'><strong></strong></font>
</td></tr>";
echo "</table>";
echo "<br />";

echo "<form id='frm1' name='frm1'>";
echo  "<table width='75%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td>";
echo "<Td>ระดับ</Td><Td>ความสามารถด้านภาษา</Td><Td>ความสามารถด้านคำนวณ</Td><Td>ความสามารถด้านเหตุผล</Td><Td>เฉลี่ย</Td></Tr>";
for($M=1;$M<4;$M++){
			if(($M%2) == 0){
			$color="#FFFFC";
			}
			else {
			$color="#FFFFFF";
			}
						$sql_select = "select * from  achievement_main  where  level='$M' and ed_year='$ed_year' and test_class='$_REQUEST[test_class]' and test_type='2' ";
						$dbquery_select = mysqli_query($connect,$sql_select);
						$result_select  = mysqli_fetch_array($dbquery_select);

echo "<Tr  bgcolor='$color' align='center'><Td>$M</Td>";
echo "</Td><Td align='left'>";
				if($M==1){
				echo "คะแนนเฉลี่ยโรงเรียน";
				}
				else if($M==2){
				echo "คะแนนเฉลี่ย สพท.";
				}
				else if($M==3){
				echo "คะแนนเฉลี่ยประเทศ";
				}
echo "</Td>";
$M_['M']=$M;
echo "<Td><input type='text' name='$M_[M][1]'  id='$M_[M][1]'  size= 6 value='$result_select[thai]' ></Td>";
echo "<Td><input type='text' name='$M_[M][2]' id='$M_[M][2]'  size= 6 value='$result_select[math]'></Td>";
echo "<Td><input type='text' name='$M_[M][3]' id='$M_[M][3]'  size= 6 value='$result_select[science]' ></Td>";
echo "<Td><input type='text' name='$M_[M][9]' id='$M_[M][9]'  size= 6 value='$result_select[score_avg]'></Td>";
echo "<input type='hidden' name='$M_[M][11]'  id='$M_[M][11]'  value='$M'>";   //ระดับการสอบ รร สพท ประเทศ
}
echo  "<input type='hidden' name='ed_year'  id='ed_year'    value='$ed_year'>";
echo  "<input type='hidden' name='test_class'  id='test_class'    value='$_REQUEST[test_class]'>";
echo "</Table>";
echo "<Br>";
echo "<div align='center'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton></div>";
echo "</form>";
}
?>

<script>
function goto_url2(val){
	 if(val==1){
			if(frm1.ed_year.value == ""){
			alert("กรุณากรอกปีการศึกษา");
			}else if(frm1.test_class.value == ""){
			alert("กรุณาเลือกชั้น");
			}else{
			callfrm("?option=achievement&task=main/add_score_2&index=1");   
			}
	}
}

function goto_url(val){
	if(val==1){
			if(frm1.ed_year.value == ""){
			alert("ปีการศึกษาไม่ได้ระบุ โประบุปีการศึกษา");
			}else{
			callfrm("?option=achievement&task=main/add_score_2&index=4");  
			} 
	}
}

</script>

