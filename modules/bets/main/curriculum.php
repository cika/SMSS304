<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if($result_permission['p1']!=1){
exit();
}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>หลักสูตรการศึกษาขั้นพื้นฐาน</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มข้อมูลหลักสูตรการศึกษาขั้นพื้นฐาน</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr><Td align='right'>รหัสหลักสูตร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><input name=curriculum_code type=text size=20 /></td></tr>";
echo "<Tr><Td align='right'>ชื่อหลักสูตร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><input name=curriculum_name type=text size=50 /></td></tr>";
echo "<Tr><Td align='right'>ตั้งเป็นหลักสูตรปัจจุบัน&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><input name=curriculum_status type=radio value=1 /> ใช่ <input name=curriculum_status type=radio value=0 checked /> ไม่ใช่</td></tr>";

echo "<tr><td align='center' colspan=2><INPUT TYPE='button' name='smb' value='บันทึก [Save]' onclick='goto_url(1)' class=entrybutton>	&nbsp;&nbsp;";
echo "<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from bets_curriculum where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=bets&task=main/curriculum'; </script>\n";
}

//ส่วนบันทึกข้อมูล
if($index==4){
if($_POST['curriculum_status']==1){
	$dbquery = mysqli_query($connect,"update bets_curriculum set curriculum_status=0");
}
$sql = "insert into bets_curriculum (curriculum_code, curriculum_name, curriculum_status) values ('$_POST[curriculum_code]', '$_POST[curriculum_name]','$_POST[curriculum_status]')";
echo "<script>alert($sql);</script>";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=bets&task=main/curriculum'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
	
$sql = "select * from bets_curriculum where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);	

echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขข้อมูลหลักสูตรการศึกษาขั้นพื้นฐาน</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr><Td align='right'>รหัสหลักสูตร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><input name=curriculum_code type=text size=20 value=$ref_result[1] /></td></tr>";
echo "<Tr><Td align='right'>ชื่อหลักสูตร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><input name=curriculum_name type=text size=50 value='".$ref_result['curriculum_name']."' /></td></tr>";
echo "<Tr><Td align='right'>ตั้งเป็นหลักสูตรปัจจุบัน&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
$cheked0=($ref_result[3]==0)?"checked":"";
$cheked1=($ref_result[3]==1)?"checked":"";
echo "<td><input name=curriculum_status type=radio value=1 $cheked1 /> ใช่ <input name=curriculum_status type=radio value=0 $cheked0 /> ไม่ใช่</td></tr>";

echo "<tr><td align='center' colspan=2><INPUT TYPE='button' name='smb' value='บันทึก [Save]' onclick='goto_url_update(1)' class=entrybutton>	&nbsp;&nbsp;";
echo "<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
	
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "update bets_curriculum set  curriculum_code='$_POST[curriculum_code]', curriculum_name='$_POST[curriculum_name]',curriculum_status='$_POST[curriculum_status]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){
print'
<style>
table#tb td {vertical-align:top;}
table#tb .toptable {background-color:#FF9933;}
table#tb .even {background-color:#FFDDFF;}
table#tb .odd {background-color:#eeeeee;}
</style>

<table width="75%" border="0" cellspacing="1" cellpadding="1" align="center" id=tb>
<tr>	
	<td><a href="?option=bets&task=main/curriculum&index=1"><img src="./images/add.gif" border=0> เพิ่มหลักสูตร</a></td>
</tr>
</table>
<table width="75%" border="0" cellspacing="1" cellpadding="1" align="center" id=tb>
  <tr class=toptable>
    <td width="30" align="center" valign="center"><strong>ลำดับที่</strong></td>
    <td width="80" align="center" valign="center"><strong>รหัสหลักสูตร</strong></td>
    <td width="400" align="center" valign="center"><strong>ชื่อหลักสูตร</strong></td>
    <td width="70" align="center" valign="center"><strong>กลุ่มสาระ</strong></td>
	<td width="70" align="center" valign="center"><strong>ลบ</strong></td>
    <td width="70" align="center" valign="center"><strong>แก้ไข</strong></td>
  </tr>';
$sql="Select * from bets_curriculum";  
$dbquery = mysqli_query($connect,$sql);
$r=0;
while ($result = mysqli_fetch_array($dbquery)){
$r++;
$rowstyle=($r%2)?"odd":"even";
$b_browse='<a href="?option=bets&task=main/curriculum_view&cid='.$result[0].'"><img src="./images/b_browse.png" border=0 title="รายละเอียดหลักสูตร" alt="รายละเอียดหลักสูตร"></a>';
$edit="<a href='?option=bets&task=main/curriculum&index=5&id=$result[0]'><img src='./images/b_edit.png' border=0></a>";
$del="<a href='?option=bets&task=main/curriculum&index=3&id=$result[0]'><img src='./images/b_drop.png' border=0></a>";
print'  <tr class='.$rowstyle.'>
    <td align="center">'.$r.'</td>
    <td align="center">'.$result[1].'</td>
    <td>'.$result[2].'</td>
    <td align="center">'.$b_browse.'</td>	
	<td align="center">'.$del.'</td>
    <td align="center">'.$edit.'</td>
  </tr>';
}
print'</table>';
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=bets&task=main/curriculum");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.curriculum_code.value == ""){
			alert("กรุณาระบุรหัสหลักสูตร");
			frm1.curriculum_code.focus();
		}else if(frm1.curriculum_name.value == ""){
			alert("กรุณาระบุชื่อหลักสูตร");
			frm1.curriculum_name.focus();
		}else{
			callfrm("?option=bets&task=main/curriculum&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=bets&task=main/curriculum");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.curriculum_code.value == ""){
			alert("กรุณาระบุรหัสหลักสูตร");
			frm1.curriculum_code.focus();
		}else if(frm1.curriculum_name.value == ""){
			alert("กรุณาระบุชื่อหลักสูตร");
			frm1.curriculum_name.focus();
		}else{
			callfrm("?option=bets&task=main/curriculum&index=6");   //page ประมวลผล
		}
	}
}
</script>
