<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page 

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ชื่อและประเภทสถานศึกษา</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==5){

echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3>ชื่อสถานศึกษา</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0'>";
$sql = "select  * from system_school_name";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);

echo "<Tr><Td align='right'>ชื่อสถานศึกษา&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='school_name' Size='50' maxlength='50' value='$result[school_name]'></Td></Tr>";
echo "<Tr><Td align='right'>ประเภทสถานศึกษา&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td align='left'><Select  name='school_type'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
		if($result['school_type']==1){
		echo  "<option value = '0'>สถานศึกษาของรัฐ</option>" ;
		echo  "<option value = '1' selected>สถานศึกษาเอกชน</option>" ;
		}
		else{
		echo  "<option value = '0' selected>สถานศึกษาของรัฐ</option>" ;
		echo  "<option value = '1'>สถานศึกษาเอกชน</option>" ;
		}
echo "</select></td></Tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td>&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
	if(isset($_POST['school_name'])){
		$school_name=$_POST['school_name'];
		$sql = "update system_school_name set school_name='$school_name',school_type='$_POST[school_type]'";
		$dbquery = mysqli_query($connect,$sql);
			
			$sql_school_name = "select * from system_school_name";
			$dbquery_school_name = mysqli_query($connect,$sql_school_name);
			$result_school_name = mysqli_fetch_array($dbquery_school_name);
			$_SESSION['school_name'] =$result_school_name['school_name'];		
			$_SESSION['school_type'] =$result_school_name['school_type'];		
			echo "<script>document.location.href='index.php?file=school_name';</script>\n";
	}
}

//ส่วนแสดงผล
if(!($index==5)){
echo "<br />";
echo  "<table width='50%' border='1' cellpadding='0' cellspacing='0' align='center'>";
$sql = "select  * from system_school_name";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo "<Tr bgcolor='#FFCCCC'><Td align='center'>ชื่อสถานศึกษา</Td><Td align='center'>ประเภทสถานศึกษา</Td><Td align='center' width='50'>แก้ไข</Td></Tr>";
echo "<Tr><Td align='center'>$result[school_name]</Td>";
echo "<td align='center'>";
		if($result['school_type']==1){
		echo "สถานศึกษาเอกชน";
		}
		else{
		echo "สถานศึกษาของรัฐ";
		}
echo "</td>";
echo "<Td align='center'><a href=?file=school_name&index=5><img src=../images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?file=school_name");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.school_name.value == ""){
			alert("กรุณากรอกชื่อสถานศึกษา");
		}else{
			callfrm("?file=school_name&index=6");   //page ประมวลผล
		}
	}
}

</script>
