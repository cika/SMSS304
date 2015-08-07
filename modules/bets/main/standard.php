<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if($result_permission['p1']!=1){
exit();
}

$officer=$_SESSION['login_user_id'];
?>

<script type="text/javascript" src="jquery/jquery-1.5.1.js"></script> 
<script type="text/javascript">

$(function(){
	$("select#group").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/bets/main/return_ajax_substance.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"group="+$(this).val(), // ส่งตัวแปร GET ชื่อ proj ให้มีค่าเท่ากับ ค่าของ proj
			  async: false
		}).responseText;		
		$("select#substance").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 ที่ชื่อ pj_activity
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});

</script>

<?php
if(!isset($_REQUEST['group_index'])){
$_REQUEST['group_index']="";
}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>มาตรฐานการเรียนรู้</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>เพิ่มมาตรฐานการเรียนรู้</Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table width='70%' Border='0'>";
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
echo "<Tr align='left'><Td></Td><Td align='right'>สาระ&nbsp;&nbsp;</Td><td align='left'>";
echo "<Select name='substance' id='substance' size='1' >";
echo  "<option  value = ''>เลือก</option>" ;
echo "</select>";
echo "</td></tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>มาตรฐานที่&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='standard_no' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value='01'>1</option>" ;
echo  "<option value='02'>2</option>" ;
echo  "<option value='03'>3</option>" ;
echo  "<option value='04'>4</option>" ;
echo  "<option value='05'>5</option>" ;
echo  "<option value='06'>6</option>" ;
echo  "<option value='07'>7</option>" ;
echo  "<option value='08'>8</option>" ;
echo  "<option value='09'>9</option>" ;
echo  "<option value='10'>10</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td width='30'></Td><Td align='right'>ชื่อย่อ(มาตรฐาน)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='standard_short' Size='30'></Td></Tr>";
echo "<Tr align='left'><Td width='30'></Td><Td align='right'>รายละเอียดมาตรฐาน&nbsp;&nbsp;</Td><Td><textarea Name='standard_text' rows='10' cols='70'></textarea></Td></Tr>";
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
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=bets&task=main/standard&index=3&id=$_GET[id]&page=$_REQUEST[page]&group_index=$_REQUEST[group_index]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=bets&task=main/standard&page=$_REQUEST[page]&group_index=$_REQUEST[group_index]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from bets_standard where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$standard_code=$_POST['substance'].$_POST['standard_no'];
$sql = "insert into bets_standard(substance_code,standard_code,short_name,standard_text) values ('$_POST[substance]','$standard_code', '$_POST[standard_short]','$_POST[standard_text]')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
$sql = "select * from bets_standard,bets_substance,bets_group where bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_standard.id='$_GET[id]' ";
$dbquery = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery);
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>แก้ไขมาตรฐานการเรียนรู้</Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table width='70%' Border='0'>";
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
							else {
							echo  "<option value=$group_code>$group_name</option>" ;
							}
					}
echo"</optgroup>\n";			
}				
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td></Td><Td align='right'>สาระ&nbsp;&nbsp;</Td><td align='left'>";
echo "<Select name='substance' id='substance' size='1' >";
$sql = "select  * from bets_substance where group_code='$result_ref[group_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
echo  "<option  value = ''>เลือก</option>" ;
While ($result = mysqli_fetch_array($dbquery))
   {
  		 if($result['substance_code']==$result_ref['substance_code']){
		echo  "<option value=$result[substance_code] selected>$result[substance_name]</option>" ;
		 }
		 else{
		echo  "<option value=$result[substance_code]>$result[substance_name]</option>" ;
		 }
    
   }
echo "</select>";
echo "</td></tr>";

$standard_no=substr($result_ref['standard_code'], -2); 
$select1="";$select2="";$select3="";$select4="";$select5="";$select6="";$select7="";$select8="";$select9="";$select10="";
if($standard_no=='01'){
$select1="selected";
}
else if($standard_no=='02'){
$select2="selected";
}
else if($standard_no=='03'){
$select3="selected";
}
else if($standard_no=='04'){
$select4="selected";
}
else if($standard_no=='05'){
$select5="selected";
}
else if($standard_no=='06'){
$select6="selected";
}
else if($standard_no=='07'){
$select7="selected";
}
else if($standard_no=='08'){
$select8="selected";
}
else if($standard_no=='09'){
$select9="selected";
}
else if($standard_no=='10'){
$select10="selected";
}
echo "<Tr align='left'><Td ></Td><Td align='right'>มาตรฐานที่&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='standard_no' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value='01' $select1>1</option>" ;
echo  "<option value='02' $select2>2</option>" ;
echo  "<option value='03' $select3>3</option>" ;
echo  "<option value='04' $select4>4</option>" ;
echo  "<option value='05' $select5>5</option>" ;
echo  "<option value='06' $select6>6</option>" ;
echo  "<option value='07' $select7>7</option>" ;
echo  "<option value='08' $select8>8</option>" ;
echo  "<option value='09' $select9>9</option>" ;
echo  "<option value='10' $select10>10</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td width='30'></Td><Td align='right'>ชื่อย่อ(มาตรฐาน)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='standard_short' Size='30' value='$result_ref[short_name]'></Td></Tr>";
echo "<Tr align='left'><Td width='30'></Td><Td align='right'>รายละเอียดมาตรฐาน&nbsp;&nbsp;</Td><Td><textarea Name='standard_text' rows='10' cols='70'>$result_ref[standard_text]</textarea></Td></Tr>";
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
$standard_code=$_POST['substance'].$_POST['standard_no'];
$sql = "update bets_standard set substance_code='$_POST[substance]',standard_code='$standard_code', short_name='$_POST[standard_short]',standard_text='$_POST[standard_text]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

//ส่วนของการแยกหน้า
if($_REQUEST['group_index']!=""){
$sql = "select *,bets_standard.id from bets_standard,bets_substance,bets_group,bets_curriculum where bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_group.group_code='$_REQUEST[group_index]' ";
}
else{
$sql = "select *,bets_standard.id from bets_standard,bets_substance,bets_group,bets_curriculum where bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code ";
}
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery); //นำไปแยกหน้า

$pagelen=20 ; // 1.กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/standard&group_index=$_REQUEST[group_index]";  // 2_กำหนดลิงค์ฺ
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

		echo  "<table width='90%' border='0' align='center'>";
		echo "<Tr><Td align='left'><INPUT TYPE='button' name='smb'value='เพิ่มมาตรฐาน' onclick='location.href=\"?option=bets&task=main/standard&index=1\"'></Td><td align='right'>";
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
		//จบ
if($_REQUEST['group_index']!=""){
$sql = "select *,bets_standard.id from bets_standard,bets_substance,bets_group,bets_curriculum where bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_group.group_code='$_REQUEST[group_index]' order by bets_substance.group_code,bets_substance.substance_code,bets_standard.standard_code  limit $start,$pagelen ";
}
else{
$sql = "select *,bets_standard.id from bets_standard,bets_substance,bets_group,bets_curriculum where bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code order by bets_substance.group_code,bets_substance.substance_code,bets_standard.standard_code  limit $start,$pagelen ";
}
echo  "<table width='90%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>ที่</Td><Td>มาตรฐาน</Td><Td width='200'>สาระ</Td><Td width='150'>กลุ่มสาระ</Td><Td width='60'>หลักสูตร</Td><td width='50' align='center'>ลบ</td><Td width='50' align='center'>แก้ไข</Td></Tr>";
$dbquery = mysqli_query($connect,$sql);

$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$group_name= $result['group_name'];
		$substance_name= $result['substance_name'];
		$short_name= $result['short_name'];
		$standard_text= $result['standard_text'];
		if(($M%2) == 0)
		$color="#FFFFC";
		else  	$color="#FFFFFF";
		echo "<Tr bgcolor='$color' align='center' valign='top'><Td>$N</Td><Td align='left'>$short_name&nbsp;&nbsp;$standard_text</Td><Td align='left'>$substance_name</Td><Td align='left'>$group_name</Td><Td align='center'>$result[curriculum_code]</Td>";
		echo "<td><a href=?option=bets&task=main/standard&id=$id&index=2&page=$page&group_index=$_REQUEST[group_index]><img src=./images/drop.png border='0'></a></td>";
		echo "<td><a href=?option=bets&task=main/standard&id=$id&index=5&page=$page&group_index=$_REQUEST[group_index]><img src=./images/edit.png border='0'></a></div></Td</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
}
?>

<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=bets&task=main/standard");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.group.value == ""){
			alert("กรุณาเลือกกลุ่มสาระ");
		}else if(frm1.substance.value==""){
			alert("กรุณาเลือกสาระ");
		}else if(frm1.standard_no.value==""){
			alert("กรุณาเลือกมาตรฐานที่");
		}else if(frm1.standard_short.value==""){
			alert("กรุณากรอกชื่อย่อมาตรฐาน");
		}else if(frm1.standard_text.value == ""){
			alert("กรุณากรอกรายละเอียดมาตรฐาน");
		}else{
			callfrm("?option=bets&task=main/standard&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=bets&task=main/standard");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.group.value == ""){
			alert("กรุณาเลือกกลุ่มสาระ");
		}else if(frm1.substance.value==""){
			alert("กรุณาเลือกสาระ");
		}else if(frm1.standard_no.value==""){
			alert("กรุณาเลือกมาตรฐานที่");
		}else if(frm1.standard_short.value==""){
			alert("กรุณากรอกชื่อย่อมาตรฐาน");
		}else if(frm1.standard_text.value == ""){
			alert("กรุณากรอกรายละเอียดมาตรฐาน");
		}else{
			callfrm("?option=bets&task=main/standard&index=6");   //page ประมวลผล
		}
	}
}

function goto_index(val){
	if(val==1){
		callfrm("?option=bets&task=main/standard");  
		}
}
</script>
