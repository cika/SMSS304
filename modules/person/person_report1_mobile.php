<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$officer=$_SESSION['login_user_id'];
$sql = "select * from  person_position order by position_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$position_ar[$result['position_code']]=$result['position_name'];
}

echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>ข้อมูลครูและบุคลากร</strong></font></td></tr>";
echo "</table>";

$sql = "select * from person_main where status='0' order by position_code";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='98%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td>ที่</Td><Td>ชื่อ</Td><Td>ตำแหน่ง</Td><Td>รูป</Td></Tr>";
$N=1;
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$person_id = $result['person_id'];
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$position_code= $result['position_code'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
echo "<Tr  bgcolor=$color align=center class=style1><Td>$N</Td><Td align='left'>$prename&nbsp;$name&nbsp;&nbsp;$surname</Td><Td align='left'>$position_ar[$position_code]</Td>";
if($result['pic']!=""){
echo "<Td align='center'><a href='modules/person/pic_show.php?person_id=$person_id' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}
		
echo "</Tr>";
$M++;
$N++;
	}
echo "</Table>";

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=person&task=person");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณากรอกเลขประจำตัวประชาชน");
		}else if(frm1.prename.value==""){
			alert("กรุณากรอกคำนำหน้าชื่อ");
		}else if(frm1.name.value==""){
			alert("กรุณากรอกชื่อ");
		}else if(frm1.surname.value==""){
			alert("กรุณากรอกนามสกุล");
		}else if(frm1.position_code.value==""){
			alert("กรุณาเลือกตำแหน่ง");
		}else{
			callfrm("?option=person&task=person&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=person&task=person");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณากรอกเลขประจำตัวประชาชน");
		}else if(frm1.prename.value==""){
			alert("กรุณากรอกคำนำหน้าชื่อ");
		}else if(frm1.name.value==""){
			alert("กรุณากรอกชื่อ");
		}else if(frm1.surname.value==""){
			alert("กรุณากรอกนามสกุล");
		}else if(frm1.position_code.value==""){
			alert("กรุณาเลือกตำแหน่ง");
		}else{
			callfrm("?option=person&task=person&index=6");   //page ประมวลผล
		}
	}
}
</script>
