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

$(function(){
	$("select#substance").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/bets/main/return_ajax_standard.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"substance="+$(this).val(), // ส่งตัวแปร GET ชื่อ proj ให้มีค่าเท่ากับ ค่าของ proj
			  async: false
		}).responseText;		
		$("select#standard").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 ที่ชื่อ pj_activity
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});
</script>

<?php
if(!isset($_REQUEST['group_index'])){
$_REQUEST['group_index']="";
}
if(!isset($_REQUEST['class_index'])){
$_REQUEST['class_index']="";
}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ตัวชี้วัดการเรียนรู้</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
$sql = "select * from bets_indicator,bets_standard,bets_substance,bets_group where  bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code order by bets_indicator.id desc limit 1 ";
$dbquery = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery);
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>เพิ่มตัวชี้วัดการเรียนรู้</Font>";
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

echo "<Tr align='left'><Td></Td><Td align='right'>มาตรฐาน&nbsp;&nbsp;</Td><td align='left'>";
echo "<Select name='standard' id='standard' size='1' >";
$sql = "select  * from bets_standard where substance_code='$result_ref[substance_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
echo  "<option  value = ''>เลือก</option>" ;
While ($result = mysqli_fetch_array($dbquery))
   {
  		 if($result['standard_code']==$result_ref['standard_code']){
		echo  "<option value=$result[standard_code] selected>$result[short_name]</option>" ;
		 }
		 else{
		echo  "<option value=$result[standard_code]>$result[short_name]</option>" ;
		 }
   }
echo "</select>";
echo "</td></tr>";

$select_c1="";$select_c2="";$select_c3="";$select_c4="";$select_c5="";$select_c6="";
$select_c7="";$select_c8="";$select_c9="";$select_c13="";
if($result_ref['class_code']==1){
$select_c1="selected";
}
else if($result_ref['class_code']==2){
$select_c2="selected";
}
else if($result_ref['class_code']==3){
$select_c3="selected";
}
else if($result_ref['class_code']==4){
$select_c4="selected";
}
else if($result_ref['class_code']==5){
$select_c5="selected";
}
else if($result_ref['class_code']==6){
$select_c6="selected";
}
else if($result_ref['class_code']==7){
$select_c7="selected";
}
else if($result_ref['class_code']==8){
$select_c8="selected";
}
else if($result_ref['class_code']==9){
$select_c9="selected";
}
else if($result_ref['class_code']==13){
$select_c13="selected";
}

echo "<Tr align='left'><Td ></Td><Td align='right'>ชั้น&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='class_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value='1' $select_c1>ป.1</option>" ;
echo  "<option value='2' $select_c2>ป.2</option>" ;
echo  "<option value='3' $select_c3>ป.3</option>" ;
echo  "<option value='4' $select_c4>ป.4</option>" ;
echo  "<option value='5' $select_c5>ป.5</option>" ;
echo  "<option value='6' $select_c6>ป.6</option>" ;
echo  "<option value='7' $select_c7>ม.1</option>" ;
echo  "<option value='8' $select_c8>ม.2</option>" ;
echo  "<option value='9' $select_c9>ม.3</option>" ;
echo  "<option value='13' $select_c13>ม.4-6</option>" ;
echo "</select>";
echo "</div></td></tr>";

$indicator_no=substr($result_ref['indicator_code'], -4); 
$indicator_no=substr($indicator_no,0,2);
$indicator_no=$indicator_no+1;
$select1="";$select2="";$select3="";$select4="";$select5="";$select6="";$select7="";$select8="";$select9="";$select10="";$select11="";$select12="";$select13="";$select14="";$select15="";$select16="";$select17="";$select18="";$select19="";$select20="";
$select21="";$select22="";$select23="";$select24="";$select25="";
if($indicator_no=='01'){
$select1="selected";
}
else if($indicator_no=='02'){
$select2="selected";
}
else if($indicator_no=='03'){
$select3="selected";
}
else if($indicator_no=='04'){
$select4="selected";
}
else if($indicator_no=='05'){
$select5="selected";
}
else if($indicator_no=='06'){
$select6="selected";
}
else if($indicator_no=='07'){
$select7="selected";
}
else if($indicator_no=='08'){
$select8="selected";
}
else if($indicator_no=='09'){
$select9="selected";
}
else if($indicator_no=='10'){
$select10="selected";
}
else if($indicator_no=='11'){
$select11="selected";
}
else if($indicator_no=='12'){
$select12="selected";
}
else if($indicator_no=='13'){
$select13="selected";
}
else if($indicator_no=='14'){
$select14="selected";
}
else if($indicator_no=='15'){
$select15="selected";
}
else if($indicator_no=='16'){
$select16="selected";
}
else if($indicator_no=='17'){
$select17="selected";
}
else if($indicator_no=='18'){
$select18="selected";
}
else if($indicator_no=='19'){
$select19="selected";
}
else if($indicator_no=='20'){
$select20="selected";
}
else if($indicator_no=='21'){
$select21="selected";
}
else if($indicator_no=='22'){
$select22="selected";
}
else if($indicator_no=='23'){
$select23="selected";
}
else if($indicator_no=='24'){
$select24="selected";
}
else if($indicator_no=='25'){
$select25="selected";
}

echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวชี้วัดที่&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='indicator_no' size='1'>";
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
echo  "<option value='11' $select11>11</option>" ;
echo  "<option value='12' $select12>12</option>" ;
echo  "<option value='13' $select13>13</option>" ;
echo  "<option value='14' $select14>14</option>" ;
echo  "<option value='15' $select15>15</option>" ;
echo  "<option value='16' $select16>16</option>" ;
echo  "<option value='17' $select17>17</option>" ;
echo  "<option value='18' $select18>18</option>" ;
echo  "<option value='19' $select19>19</option>" ;
echo  "<option value='20' $select20>20</option>" ;
echo  "<option value='21' $select21>21</option>" ;
echo  "<option value='22' $select22>22</option>" ;
echo  "<option value='23' $select23>23</option>" ;
echo  "<option value='24' $select24>24</option>" ;
echo  "<option value='25' $select25>25</option>" ;
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td width='30'></Td><Td align='right'>รายละเอียดตัวชี้วัด&nbsp;&nbsp;</Td><Td><textarea Name='indicator_text' rows='5' cols='70'></textarea></Td></Tr>";
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
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=bets&task=main/indicator&index=3&id=$_GET[id]&page=$_REQUEST[page]&group_index=$_REQUEST[group_index]&class_index=$_REQUEST[class_index]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=bets&task=main/indicator&page=$_REQUEST[page]&group_index=$_REQUEST[group_index]&class_index=$_REQUEST[class_index]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from bets_indicator where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$class_code=$_POST['class_code'];
if($class_code==1){
$class_code="01";
}
else if($class_code==2){
$class_code="02";
}
else if($class_code==3){
$class_code="03";
}
else if($class_code==4){
$class_code="04";
}
else if($class_code==5){
$class_code="05";
}
else if($class_code==6){
$class_code="06";
}
else if($class_code==7){
$class_code="07";
}
else if($class_code==8){
$class_code="08";
}
else if($class_code==9){
$class_code="09";
}

$indicator_code=$_POST['standard'].$_POST['indicator_no'].$class_code;
$sql = "insert into bets_indicator(standard_code,class_code,indicator_code,indicator_text) values ('$_POST[standard]', '$_POST[class_code]','$indicator_code','$_POST[indicator_text]')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
$sql = "select * from bets_indicator,bets_standard,bets_substance,bets_group where  bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_indicator.id='$_GET[id]' ";
$dbquery = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery);
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>แก้ไขตัวชี้วัดการเรียนรู้</Font>";
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

echo "<Tr align='left'><Td></Td><Td align='right'>มาตรฐาน&nbsp;&nbsp;</Td><td align='left'>";
echo "<Select name='standard' id='standard' size='1' >";
$sql = "select  * from bets_standard where substance_code='$result_ref[substance_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
echo  "<option  value = ''>เลือก</option>" ;
While ($result = mysqli_fetch_array($dbquery))
   {
  		 if($result['standard_code']==$result_ref['standard_code']){
		echo  "<option value=$result[standard_code] selected>$result[short_name]</option>" ;
		 }
		 else{
		echo  "<option value=$result[standard_code]>$result[short_name]</option>" ;
		 }
    
   }
echo "</select>";
echo "</td></tr>";

$select_c1="";$select_c2="";$select_c3="";$select_c4="";$select_c5="";$select_c6="";
$select_c7="";$select_c8="";$select_c9="";$select_c13="";
if($result_ref['class_code']==1){
$select_c1="selected";
}
else if($result_ref['class_code']==2){
$select_c2="selected";
}
else if($result_ref['class_code']==3){
$select_c3="selected";
}
else if($result_ref['class_code']==4){
$select_c4="selected";
}
else if($result_ref['class_code']==5){
$select_c5="selected";
}
else if($result_ref['class_code']==6){
$select_c6="selected";
}
else if($result_ref['class_code']==7){
$select_c7="selected";
}
else if($result_ref['class_code']==8){
$select_c8="selected";
}
else if($result_ref['class_code']==9){
$select_c9="selected";
}
else if($result_ref['class_code']==13){
$select_c13="selected";
}

echo "<Tr align='left'><Td ></Td><Td align='right'>ชั้น&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='class_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value='1' $select_c1>ป.1</option>" ;
echo  "<option value='2' $select_c2>ป.2</option>" ;
echo  "<option value='3' $select_c3>ป.3</option>" ;
echo  "<option value='4' $select_c4>ป.4</option>" ;
echo  "<option value='5' $select_c5>ป.5</option>" ;
echo  "<option value='6' $select_c6>ป.6</option>" ;
echo  "<option value='7' $select_c7>ม.1</option>" ;
echo  "<option value='8' $select_c8>ม.2</option>" ;
echo  "<option value='9' $select_c9>ม.3</option>" ;
echo  "<option value='13' $select_c13>ม.4-6</option>" ;
echo "</select>";
echo "</div></td></tr>";

$indicator_no=substr($result_ref['indicator_code'], -4); 
$indicator_no=substr($indicator_no,0,2);
$select1="";$select2="";$select3="";$select4="";$select5="";$select6="";$select7="";$select8="";$select9="";$select10="";$select11="";$select12="";$select13="";$select14="";$select15="";$select16="";$select17="";$select18="";$select19="";$select20="";
$select21="";$select22="";$select23="";$select24="";$select25="";
if($indicator_no=='01'){
$select1="selected";
}
else if($indicator_no=='02'){
$select2="selected";
}
else if($indicator_no=='03'){
$select3="selected";
}
else if($indicator_no=='04'){
$select4="selected";
}
else if($indicator_no=='05'){
$select5="selected";
}
else if($indicator_no=='06'){
$select6="selected";
}
else if($indicator_no=='07'){
$select7="selected";
}
else if($indicator_no=='08'){
$select8="selected";
}
else if($indicator_no=='09'){
$select9="selected";
}
else if($indicator_no=='10'){
$select10="selected";
}
else if($indicator_no=='11'){
$select11="selected";
}
else if($indicator_no=='12'){
$select12="selected";
}
else if($indicator_no=='13'){
$select13="selected";
}
else if($indicator_no=='14'){
$select14="selected";
}
else if($indicator_no=='15'){
$select15="selected";
}
else if($indicator_no=='16'){
$select16="selected";
}
else if($indicator_no=='17'){
$select17="selected";
}
else if($indicator_no=='18'){
$select18="selected";
}
else if($indicator_no=='19'){
$select19="selected";
}
else if($indicator_no=='20'){
$select20="selected";
}
else if($indicator_no=='21'){
$select21="selected";
}
else if($indicator_no=='22'){
$select22="selected";
}
else if($indicator_no=='23'){
$select23="selected";
}
else if($indicator_no=='24'){
$select24="selected";
}
else if($indicator_no=='25'){
$select25="selected";
}

echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวชี้วัดที่&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='indicator_no' size='1'>";
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
echo  "<option value='11' $select11>11</option>" ;
echo  "<option value='12' $select12>12</option>" ;
echo  "<option value='13' $select13>13</option>" ;
echo  "<option value='14' $select14>14</option>" ;
echo  "<option value='15' $select15>15</option>" ;
echo  "<option value='16' $select16>16</option>" ;
echo  "<option value='17' $select17>17</option>" ;
echo  "<option value='18' $select18>18</option>" ;
echo  "<option value='19' $select19>19</option>" ;
echo  "<option value='20' $select20>20</option>" ;
echo  "<option value='21' $select21>21</option>" ;
echo  "<option value='22' $select22>22</option>" ;
echo  "<option value='23' $select23>23</option>" ;
echo  "<option value='24' $select24>24</option>" ;
echo  "<option value='25' $select25>25</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td width='30'></Td><Td align='right'>รายละเอียดตัวชี้วัด&nbsp;&nbsp;</Td><Td><textarea Name='indicator_text' rows='5' cols='70'>$result_ref[indicator_text]</textarea></Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='Hidden' name='id' value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Input Type=Hidden Name='class_index' Value='$_GET[class_index]'>";
echo "<Input Type=Hidden Name='group_index' Value='$_GET[group_index]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$class_code=$_POST['class_code'];
if($class_code==1){
$class_code="01";
}
else if($class_code==2){
$class_code="02";
}
else if($class_code==3){
$class_code="03";
}
else if($class_code==4){
$class_code="04";
}
else if($class_code==5){
$class_code="05";
}
else if($class_code==6){
$class_code="06";
}
else if($class_code==7){
$class_code="07";
}
else if($class_code==8){
$class_code="08";
}
else if($class_code==9){
$class_code="09";
}
$indicator_code=$_POST['standard'].$_POST['indicator_no'].$class_code;
$sql = "update bets_indicator set standard_code='$_POST[standard]',class_code='$_POST[class_code]', indicator_code='$indicator_code',indicator_text='$_POST[indicator_text]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

//ส่วนของการแยกหน้า
			if(($_REQUEST['class_index']=="") and ($_REQUEST['group_index']=="")){
			$sql = "select *,bets_indicator.id from bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code ";	
			}
			else if(($_REQUEST['class_index']!="") and ($_REQUEST['group_index']!="")){
			$sql = "select *,bets_indicator.id from bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_indicator.class_code='$_REQUEST[class_index]' and bets_group.group_code='$_REQUEST[group_index]' ";	
			}
			else if($_REQUEST['class_index']!=""){
			$sql = "select *,bets_indicator.id from bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_indicator.class_code='$_REQUEST[class_index]' ";	
			}
			else if($_REQUEST['group_index']!=""){
			$sql = "select *,bets_indicator.id from bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_group.group_code='$_REQUEST[group_index]' ";	
			}
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery); //นำไปแยกหน้า

$pagelen=20 ; // 1.กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/indicator&class_index=$_REQUEST[class_index]&group_index=$_REQUEST[group_index]";  // 2_กำหนดลิงค์
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
 		//เลือกชั้น
		echo  "<table width='90%' border='0' align='center'>";
		echo "<Tr><Td align='left'><INPUT TYPE='button' name='smb' value='เพิ่มตัวชี้วัด' onclick='location.href=\"?option=bets&task=main/indicator&index=1\"'></Td><td align='right'>";
		echo "<form id='frm1' name='frm1'>";
		echo "<div align='right'>";
		echo "<Select  name='class_index' size='1'>";
$select_class_1=""; $select_class_2=""; $select_class_3=""; $select_class_4=""; $select_class_5=""; $select_class_6=""; $select_class_7=""; $select_class_8=""; $select_class_9=""; $select_class_13=""; 
				if($_REQUEST['class_index']=='1'){
				$select_class_1="selected";
				}
				else if($_REQUEST['class_index']=='2'){
				$select_class_2="selected";
				}
				else if($_REQUEST['class_index']=='3'){
				$select_class_3="selected";
				}
				else if($_REQUEST['class_index']=='4'){
				$select_class_4="selected";
				}
				else if($_REQUEST['class_index']=='5'){
				$select_class_5="selected";
				}
				else if($_REQUEST['class_index']=='6'){
				$select_class_6="selected";
				}
				else if($_REQUEST['class_index']=='7'){
				$select_class_7="selected";
				}
				else if($_REQUEST['class_index']=='8'){
				$select_class_8="selected";
				}
				else if($_REQUEST['class_index']=='9'){
				$select_class_9="selected";
				}
				else if($_REQUEST['class_index']=='13'){
				$select_class_13="selected";
				}
	
		echo  "<option  value = ''>ทุกชั้น</option>" ;
		echo  "<option value =1 $select_class_1>ป.1</option>";
		echo  "<option value =2 $select_class_2>ป.2</option>";
		echo  "<option value =3 $select_class_3>ป.3</option>";
		echo  "<option value =4 $select_class_4>ป.4</option>";
		echo  "<option value =5 $select_class_5>ป.5</option>";
		echo  "<option value =6 $select_class_6>ป.6</option>";
		echo  "<option value =7 $select_class_7>ม.1</option>";
		echo  "<option value =8 $select_class_8>ม.2</option>";
		echo  "<option value =9 $select_class_9>ม.3</option>";
		echo  "<option value =13 $select_class_13>ม.4-6</option>";
		echo "</select>";
		
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

echo  "<table width='90%' border='0' align='center'>";

			if(($_REQUEST['class_index']=="") and ($_REQUEST['group_index']=="")){
			$sql = "select *,bets_indicator.id from bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code order by bets_indicator.id limit $start,$pagelen ";	
			}
			else if(($_REQUEST['class_index']!="") and ($_REQUEST['group_index']!="")){
			$sql = "select *,bets_indicator.id from bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_indicator.class_code='$_REQUEST[class_index]' and bets_group.group_code='$_REQUEST[group_index]' order by bets_indicator.class_code,bets_indicator.indicator_code limit $start,$pagelen ";	
			}
			else if($_REQUEST['class_index']!=""){
			$sql = "select *,bets_indicator.id from bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_indicator.class_code='$_REQUEST[class_index]' order by bets_indicator.class_code,bets_indicator.indicator_code limit $start,$pagelen ";	
			}
			else if($_REQUEST['group_index']!=""){
			$sql = "select *,bets_indicator.id from bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_group.group_code='$_REQUEST[group_index]' order by bets_indicator.class_code,bets_indicator.indicator_code limit $start,$pagelen ";	
			}

$dbquery = mysqli_query($connect,$sql);
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>ที่</Td><td width='60'>ชั้น</td><Td align='200'>ตัวชี้วัด</Td><Td width='60'>มาตรฐาน</Td><Td width='150'>สาระ</Td><Td width='150'>กลุ่มสาระ</Td><Td width='60'>หลักสูตร</Td><td width='50' align='center'>ลบ</td><Td width='50' align='center'>แก้ไข</Td></Tr>";

$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$group_name= $result['group_name'];
		$substance_name= $result['substance_name'];
		$short_name= $result['short_name'];
		$class_code= $result['class_code'];
		if($class_code==1){
		$class_code="ป.1";
		}
		else if($class_code==2){
		$class_code="ป.2";
		}
		else if($class_code==3){
		$class_code="ป.3";
		}
		else if($class_code==4){
		$class_code="ป.4";
		}
		else if($class_code==5){
		$class_code="ป.5";
		}
		else if($class_code==6){
		$class_code="ป.6";
		}
		else if($class_code==7){
		$class_code="ม.1";
		}
		else if($class_code==8){
		$class_code="ม.2";
		}
		else if($class_code==9){
		$class_code="ม.3";
		}
		else if($class_code==13){
		$class_code="ม.4-6";
		}
		
		if(($M%2) == 0)
		$color="#FFFFC";
		else  	$color="#FFFFFF";
		
		echo "<Tr bgcolor='$color' align='center' valign='top'><Td >$N</Td><td>$class_code</td><td align='left'>$result[indicator_text]</td><Td align='center'>$short_name</Td><Td align='left'>$substance_name</Td><Td align='left'>$group_name</Td><Td align='center'>$result[curriculum_code]</Td>";
		echo "<td><a href=?option=bets&task=main/indicator&id=$id&index=2&page=$page&group_index=$_REQUEST[group_index]&class_index=$_REQUEST[class_index]><img src=./images/drop.png border='0'></a></td>";
		echo "<td><a href=?option=bets&task=main/indicator&id=$id&index=5&page=$page&group_index=$_REQUEST[group_index]&class_index=$_REQUEST[class_index]><img src=./images/edit.png border='0'></a></div></Td</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
}
?>

<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=bets&task=main/indicator");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.group.value == ""){
			alert("กรุณาเลือกกลุ่มสาระ");
		}else if(frm1.substance.value==""){
			alert("กรุณาเลือกสาระ");
		}else if(frm1.standard.value==""){
			alert("กรุณาเลือกมาตรฐาน");
		}else if(frm1.class_code.value==""){
			alert("กรุณาเลือกชั้น");
		}else if(frm1.indicator_no.value==""){
			alert("กรุณาเลือกลำดับที่ตัวชี้วัด");
		}else if(frm1.indicator_text.value == ""){
			alert("กรุณากรอกรายละเอียดตัวชี้วัด");
		}else{
			callfrm("?option=bets&task=main/indicator&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=bets&task=main/indicator"); 
	}else if(val==1){
		if(frm1.group.value == ""){
			alert("กรุณาเลือกกลุ่มสาระ");
		}else if(frm1.substance.value==""){
			alert("กรุณาเลือกสาระ");
		}else if(frm1.standard.value==""){
			alert("กรุณาเลือกมาตรฐาน");
		}else if(frm1.class_code.value==""){
			alert("กรุณาเลือกชั้น");
		}else if(frm1.indicator_no.value==""){
			alert("กรุณาเลือกลำดับที่ตัวชี้วัด");
		}else if(frm1.indicator_text.value == ""){
			alert("กรุณากรอกรายละเอียดตัวชี้วัด");
		}else{
			callfrm("?option=bets&task=main/indicator&index=6"); 
		}
	}
}

function goto_index(val){
	if(val==1){
		callfrm("?option=bets&task=main/indicator");  
		}
}

</script>
