<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if($result_permission['p1']!=1){
exit();
}

$officer=$_SESSION['login_user_id'];

if(!isset($_REQUEST['group_index'])){
$_REQUEST['group_index']="";
}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>สาระ</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มสาระ</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' align='center'>";
echo "<Tr align='left'><Td ></Td><Td align='right'>กลุ่มสาระ&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='group' id='group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql_curriculum = "select * from bets_curriculum order by curriculum_code desc";
$dbquery_curriculum = mysqli_query($connect,$sql_curriculum);
while($result_curriculum = mysqli_fetch_array($dbquery_curriculum)){
echo"<optgroup label='หลักสูตร$result_curriculum[curriculum_code]'>";
			$sql = "select  * from bets_group where curriculum_code='$result_curriculum[curriculum_code]' order by id";
			$dbquery = mysqli_query($connect,$sql);
			While ($result = mysqli_fetch_array($dbquery))
			   {
			$group_code = $result['group_code']; 
			$group_name = $result['group_name'];
			echo  "<option value=$group_code>$group_name</option>" ;
				}
echo"</optgroup>\n";			
}				
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ที่(สาระ)&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='substance_no' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value='01'>สาระที่ 1</option>" ;
echo  "<option value='02'>สาระที่ 2</option>" ;
echo  "<option value='03'>สาระที่ 3</option>" ;
echo  "<option value='04'>สาระที่ 4</option>" ;
echo  "<option value='05'>สาระที่ 5</option>" ;
echo  "<option value='06'>สาระที่ 6</option>" ;
echo  "<option value='07'>สาระที่ 7</option>" ;
echo  "<option value='08'>สาระที่ 8</option>" ;
echo  "<option value='09'>สาระที่ 9</option>" ;
echo  "<option value='10'>สาระที่ 10</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อสาระ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='substance' id='substance' Size='50'></Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'>";
echo "</form>";

}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=bets&task=main/substance&index=3&id=$_GET[id]&page=$_REQUEST[page]&group_index=$_REQUEST[group_index]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=bets&task=main/substance&page=$_REQUEST[page]&group_index=$_REQUEST[group_index]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from bets_substance where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$substance_code=$_POST['group'].$_POST['substance_no'];
$sql = "insert into bets_substance(group_code,substance_code,substance_name) values ('$_POST[group]','$substance_code', '$_POST[substance]')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if($index==5){
$sql = "select * from bets_substance where id='$_GET[id]' ";
$dbquery = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery);
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขสาระ</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0'>";

echo "<Tr align='left'><Td ></Td><Td align='right'>กลุ่มสาระ&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='group' id='group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql_curriculum = "select * from bets_curriculum order by curriculum_code desc";
$dbquery_curriculum = mysqli_query($connect,$sql_curriculum);
while($result_curriculum = mysqli_fetch_array($dbquery_curriculum)){
echo"<optgroup label='หลักสูตร$result_curriculum[curriculum_code]'>";
		$sql = "select  * from bets_group where curriculum_code='$result_curriculum[curriculum_code]' order by id";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
		$group_code = $result['group_code']; 
		$group_name = $result['group_name'];
				if($result['group_code']==$result_ref['group_code']){
				echo  "<option value=$group_code selected>$group_name</option>" ;
				}
				else{
				echo  "<option value=$group_code>$group_name</option>" ;
				}
			}
echo"</optgroup>\n";			
}				
echo "</select>";
echo "</div></td></tr>";

$substance_no=substr($result_ref['substance_code'], -2); 
$select1="";$select2="";$select3="";$select4="";$select5="";$select6="";$select7="";$select8="";$select9="";$select10="";
if($substance_no=='01'){
$select1="selected";
}
else if($substance_no=='02'){
$select2="selected";
}
else if($substance_no=='03'){
$select3="selected";
}
else if($substance_no=='04'){
$select4="selected";
}
else if($substance_no=='05'){
$select5="selected";
}
else if($substance_no=='06'){
$select6="selected";
}
else if($substance_no=='07'){
$select7="selected";
}
else if($substance_no=='08'){
$select8="selected";
}
else if($substance_no=='09'){
$select9="selected";
}
else if($substance_no=='10'){
$select10="selected";
}

echo "<Tr align='left'><Td ></Td><Td align='right'>ที่(สาระ)&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='substance_no' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value='01' $select1>สาระที่ 1</option>" ;
echo  "<option value='02' $select2>สาระที่ 2</option>" ;
echo  "<option value='03' $select3>สาระที่ 3</option>" ;
echo  "<option value='04' $select4>สาระที่ 4</option>" ;
echo  "<option value='05' $select5>สาระที่ 5</option>" ;
echo  "<option value='06' $select6>สาระที่ 6</option>" ;
echo  "<option value='07' $select7>สาระที่ 7</option>" ;
echo  "<option value='08' $select8>สาระที่ 8</option>" ;
echo  "<option value='09' $select9>สาระที่ 9</option>" ;
echo  "<option value='10' $select10>สาระที่ 10</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อสาระ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='substance' id='substance' Size='50' value='$result_ref[substance_name]'></Td></Tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='Hidden' name='id' value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Input Type=Hidden Name='group_index' Value='$_GET[group_index]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$substance_code=$_POST['group'].$_POST['substance_no'];
$sql = "update bets_substance set group_code='$_POST[group]',substance_code='$substance_code', substance_name='$_POST[substance]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

//ส่วนของการแยกหน้า
if($_REQUEST['group_index']!=""){
$sql = "select *,bets_substance.id from bets_substance,bets_group,bets_curriculum where bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_group.group_code='$_REQUEST[group_index]' order by bets_substance.substance_code";
}
else{
$sql = "select *,bets_substance.id from bets_substance,bets_group,bets_curriculum where bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code order by bets_substance.id";
}
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery); //นำไปแยกหน้า

$pagelen=20 ; // 1.กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/substance&group_index=$_REQUEST[group_index]";  // 2_กำหนดลิงค์ฺ
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

		echo  "<table width='70%' border='0' align='center'>";
		echo "<Tr><Td align='left'><INPUT TYPE='button' name='smb' value='เพิ่มสาระ' onclick='location.href=\"?option=bets&task=main/substance&index=1\"'></Td><td align='right'>";
		echo "<form id='frm1' name='frm1'>";
		echo "<div align='right'>";
	//เลือก	กลุ่มสาระ
			echo "<Select  name='group_index' size='1'>";
			echo  "<option  value = ''>ทุกกลุ่มสาระ</option>" ;
			$sql_curriculum = "select * from bets_curriculum order by curriculum_code desc";
			$dbquery_curriculum = mysqli_query($connect,$sql_curriculum);
			while($result_curriculum = mysqli_fetch_array($dbquery_curriculum)){
			 echo"<optgroup label='หลักสูตร$result_curriculum[curriculum_code]'>";
						$sql = "select * from bets_group where curriculum_code='$result_curriculum[curriculum_code]' order by id";
						$dbquery = mysqli_query($connect,$sql);
						While ($result = mysqli_fetch_array($dbquery))
						   {
									if($result['group_code']==$_REQUEST['group_index']){
									echo  "<option value = $result[group_code] selected>$result[group_name]</option>";
									}
									else{
									echo  "<option value = $result[group_code]>$result[group_name]</option>";
									}
							}
			echo"</optgroup>\n";			
			}	
		echo "</select>";
		
		echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_index(1)'>";
		echo "</div>";
		echo "</form>";
		echo "</td></Tr></Table>";

echo  "<table width='70%' border='0' align='center'>";
if($_REQUEST['group_index']!=""){
$sql = "select *,bets_substance.id from bets_substance,bets_group,bets_curriculum where bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_group.group_code='$_REQUEST[group_index]' order by bets_substance.substance_code limit $start,$pagelen ";
}
else{
$sql = "select *,bets_substance.id from bets_substance,bets_group,bets_curriculum where bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code order by bets_substance.id limit $start,$pagelen ";
}
$dbquery = mysqli_query($connect,$sql);
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>ที่</Td><Td width='70'>สาระที่</Td><Td>สาระ</Td><Td width='250'>กลุ่มสาระ</Td><Td width='60'>หลักสูตร</Td><td width='50' align='center'>ลบ</td><Td width='50' align='center'>แก้ไข</Td></Tr>";

$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$group_name= $result['group_name'];
		$substance_code= $result['substance_code'];
		$substance_name= $result['substance_name'];
		$substance_no=substr($substance_code, -2); 
		if($substance_no=='01'){
		$substance_no=1;
		}
		else if($substance_no=='02') {
		$substance_no=2;
		}
		else if($substance_no=='03') {
		$substance_no=3;
		}
		else if($substance_no=='04') {
		$substance_no=4;
		}
		else if($substance_no=='05') {
		$substance_no=5;
		}
		else if($substance_no=='06') {
		$substance_no=6;
		}
		else if($substance_no=='07') {
		$substance_no=7;
		}
		else if($substance_no=='08') {
		$substance_no=8;
		}
		else if($substance_no=='09') {
		$substance_no=9;
		}
		
		if(($M%2) == 0)
		$color="#FFFFC";
		else  	$color="#FFFFFF";
		
		echo "<Tr bgcolor='$color' align='center' valign='top'><Td >$N</Td><Td align='center'>$substance_no</Td><Td align='left'>$substance_name</Td><Td align='left'>$group_name</Td><Td align='center' valign='top'>$result[curriculum_code]</Td>";
		echo "<td><a href=?option=bets&task=main/substance&id=$id&index=2&page=$page&group_index=$_REQUEST[group_index]><img src=./images/drop.png border='0'></a></td>";
		echo "<td><a href=?option=bets&task=main/substance&id=$id&index=5&page=$page&group_index=$_REQUEST[group_index]><img src=./images/edit.png border='0'></a></div></Td</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
}
?>

<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=bets&task=main/substance");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.group.value == ""){
			alert("กรุณาเลือกกลุ่มสาระ");
		}else if(frm1.substance_no.value==""){
			alert("กรุณาเลือกที่สาระ");
		}else if(frm1.substance.value==""){
			alert("กรุณากรอกสาระ");
		}else{
			callfrm("?option=bets&task=main/substance&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=bets&task=main/substance");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.group.value == ""){
			alert("กรุณาเลือกกลุ่มสาระ");
		}else if(frm1.substance_no.value==""){
			alert("กรุณาเลือกที่สาระ");
		}else if(frm1.substance.value==""){
			alert("กรุณากรอกสาระ");
		}else{
			callfrm("?option=bets&task=main/substance&index=6");   //page ประมวลผล
		}
	}
}

function goto_index(val){
	if(val==1){
		callfrm("?option=bets&task=main/substance");  
		}
}
</script>
