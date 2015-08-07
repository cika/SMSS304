<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if($result_permission['p2']!=1){
exit();
}

$officer=$_SESSION['login_user_id'];
?>

<script type="text/javascript" src="jquery/jquery-1.5.1.js"></script> 
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(function(){
	$("select#group").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/bets/main/return_ajax_substance.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"group="+$(this).val(), // ส่งตัวแปร GET ชื่อ group ให้มีค่าเท่ากับ ค่าของ proj
			  async: false
		}).responseText;		
		$("select#substance").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});

$(function(){
	$("select#substance").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/bets/main/return_ajax_standard.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"substance="+$(this).val(), // ส่งตัวแปร GET ชื่อ substance
			  async: false
		}).responseText;		
		$("select#standard").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});

$(function(){
	$("select#standard").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/bets/main/return_ajax_indicator.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"standard="+$(this).val()+"&class_code="+frm1.class_code.value, 
			  async: false
		}).responseText;		
		$("select#indicator").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});
</script>

<?php
//ฟังชั่นupload
function file_upload() {
		$uploaddir = 'modules/bets/upload_files/';      //ที่เก็บไไฟล์
		$uploadfile = $uploaddir.basename($_FILES['pic_item']['name']);
		$basename = basename($_FILES['pic_item']['name']);
		
	$timestamp = mktime(date("H"), date("i"),date("s"), date("m") ,date("d"), date("Y"))  ;	
	$rand_number=rand();
	$ref_id = $timestamp."x".$rand_number;

		if (move_uploaded_file($_FILES['pic_item']['tmp_name'],  $uploadfile))
			{
				$before_name  = $uploaddir.$basename;
				$changed_name = $uploaddir.$ref_id.substr($basename,-4) ;
				rename("$before_name" , "$changed_name");
		
		//ลดขนาดภาพ
			if(substr($basename,-3)=="JPG" or substr($basename,-3)=="jpg"){		
				$ori_file=$changed_name;
				$ori_size=getimagesize($ori_file);
				$ori_w=$ori_size[0];
				$ori_h=$ori_size[1];
					if($ori_w>700){
					$new_w=700;
					$new_h=round(($new_w/$ori_w)*$ori_h);
					$ori_img=imagecreatefromjpeg($ori_file);
					$new_img=imagecreatetruecolor($new_w, $new_h);
					imagecopyresized($new_img, $ori_img,0,0, 0,0, $new_w, $new_h, $ori_w, $ori_h);
					$new_file=$ori_file;
					imagejpeg($new_img, $new_file);
					imagedestroy($ori_img);
					imagedestroy($new_img);
					}	
				}						
			return  $changed_name;
			}
}

if(!isset($_REQUEST['group_index'])){
$_REQUEST['group_index']="";
}
if(!isset($_REQUEST['class_index'])){
$_REQUEST['class_index']="";
}

function chkBrowser($nameBroser){  
    return preg_match("/".$nameBroser."/",$_SERVER['HTTP_USER_AGENT']);  
}	

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5) or ($index==5.5) or ($index==7))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>คลังข้อสอบ</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>เพิ่มข้อสอบ</Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table width='90%' Border='0'>";
$sql = "select class_code from bets_item order by id desc limit 1 ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
if($result){
$class_code=$result['class_code'];
}
else{
$class_code="";
} 
echo "<Tr align='left'><Td ></Td><Td align='right'>ชั้น&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='class_code'  id='class_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
if($class_code==1){
echo  "<option value='1' selected>ป.1</option>" ;
}
else{
echo  "<option value='1'>ป.1</option>" ;
}
if($class_code==2){
echo  "<option value='2' selected>ป.2</option>" ;
}
else{
echo  "<option value='2'>ป.2</option>" ;
}
if($class_code==3){
echo  "<option value='3' selected>ป.3</option>" ;
}
else{
echo  "<option value='3'>ป.3</option>" ;
}
if($class_code==4){
echo  "<option value='4' selected>ป.4</option>" ;
}
else{
echo  "<option value='4'>ป.4</option>" ;
}
if($class_code==5){
echo  "<option value='5' selected>ป.5</option>" ;
}
else{
echo  "<option value='5'>ป.5</option>" ;
}
if($class_code==6){
echo  "<option value='6' selected>ป.6</option>" ;
}
else{
echo  "<option value='6'>ป.6</option>" ;
}
if($class_code==7){
echo  "<option value='7' selected>ม.1</option>" ;
}
else{
echo  "<option value='7'>ม.1</option>" ;
}
if($class_code==8){
echo  "<option value='8' selected>ม.2</option>" ;
}
else{
echo  "<option value='8'>ม.2</option>" ;
}
if($class_code==9){
echo  "<option value='9' selected>ม.3</option>" ;
}
else{
echo  "<option value='9'>ม.3</option>" ;
}
if($class_code==10){
echo  "<option value='10' selected>ม.4</option>" ;
}
else{
echo  "<option value='10'>ม.4</option>" ;
}
if($class_code==11){
echo  "<option value='11' selected>ม.5</option>" ;
}
else{
echo  "<option value='11'>ม.5</option>" ;
}
if($class_code==12){
echo  "<option value='12' selected>ม.6</option>" ;
}
else{
echo  "<option value='12'>ม.6</option>" ;
}

echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>กลุ่มสาระ&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='group' id='group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql_curriculum = "select * from bets_curriculum order by curriculum_code desc";
$dbquery_curriculum = mysqli_query($connect,$sql_curriculum);
while($result_curriculum = mysqli_fetch_array($dbquery_curriculum)){
echo"<optgroup label='หลักสูตร$result_curriculum[curriculum_code]'>";
			$sql = "select  * from bets_group where curriculum_code='$result_curriculum[curriculum_code]' order by id";
			$dbquery = mysqli_query($connect,$sql);
			While ($result = mysqli_fetch_array($dbquery)){
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
$sql = "select  * from bets_substance where group_code='$result_ref[group_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
echo  "<option  value = ''>เลือก</option>" ;
While ($result = mysqli_fetch_array($dbquery))
   {
	echo  "<option value=$result[substance_code]>$result[substance_name]</option>" ;
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
	echo  "<option value=$result[standard_code]>$result[short_name]</option>" ;
   }
echo "</select>";
echo "</td></tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวชี้วัด&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='indicator' id='indicator' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>คำถาม&nbsp;&nbsp;</Td>";
echo "<td><input type='text' name='question' size='100'></td></tr>";
echo  "<tr align='left'>";
echo  "<Td ></Td><td align='right'>ไฟล์รูปภาพข้อสอบ&nbsp;&nbsp;</td>";
echo  "<td align='left'><input name = 'pic_item' type = 'file'></td>";
echo  "</tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวเลือกที่ถูก&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='right_answer' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value='1'>ตัวเลือกที่ 1</option>" ;
echo  "<option value='2'>ตัวเลือกที่ 2</option>" ;
echo  "<option value='3'>ตัวเลือกที่ 3</option>" ;
echo  "<option value='4'>ตัวเลือกที่ 4</option>" ;
echo  "<option value='5'>ตัวเลือกที่ 5</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>จำนวนตัวเลือก&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='answer_num' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value='1'>1</option>" ;
echo  "<option value='2'>2</option>" ;
echo  "<option value='3'>3</option>" ;
echo  "<option value='4' selected>4</option>" ;
echo  "<option value='5'>5</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภทข้อสอบ&nbsp;&nbsp;</Td>";
echo "<td><input type='radio' name='remark' value='school' checked>ข้อสอบสถานศึกษา&nbsp;<input type='radio' name='remark' value='private'>ข้อสอบส่วนตัว</td></tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'>";
echo "</form>";
}

if($index==1.5){
//เช็คบราวเซอร์
if(chkBrowser("Chrome")!=1){  
		echo "<script>alert('การเพิ่มข้อสอบประเภทข้อความนี้ ต้องใช้กับบราวเซอร์ Google Chrome');</script>\n";
		echo "<script>document.location.href='?option=bets&task=main/test_item';</script>\n";
}
    
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>เพิ่มข้อสอบ</Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table width='90%' Border='0'>";
$sql = "select class_code from bets_item order by id desc limit 1 ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
if($result){
$class_code=$result['class_code'];
}
else{
$class_code="";
} 
echo "<Tr align='left'><Td ></Td><Td align='right'>ชั้น&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='class_code'  id='class_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
if($class_code==1){
echo  "<option value='1' selected>ป.1</option>" ;
}
else{
echo  "<option value='1'>ป.1</option>" ;
}
if($class_code==2){
echo  "<option value='2' selected>ป.2</option>" ;
}
else{
echo  "<option value='2'>ป.2</option>" ;
}
if($class_code==3){
echo  "<option value='3' selected>ป.3</option>" ;
}
else{
echo  "<option value='3'>ป.3</option>" ;
}
if($class_code==4){
echo  "<option value='4' selected>ป.4</option>" ;
}
else{
echo  "<option value='4'>ป.4</option>" ;
}
if($class_code==5){
echo  "<option value='5' selected>ป.5</option>" ;
}
else{
echo  "<option value='5'>ป.5</option>" ;
}
if($class_code==6){
echo  "<option value='6' selected>ป.6</option>" ;
}
else{
echo  "<option value='6'>ป.6</option>" ;
}
if($class_code==7){
echo  "<option value='7' selected>ม.1</option>" ;
}
else{
echo  "<option value='7'>ม.1</option>" ;
}
if($class_code==8){
echo  "<option value='8' selected>ม.2</option>" ;
}
else{
echo  "<option value='8'>ม.2</option>" ;
}
if($class_code==9){
echo  "<option value='9' selected>ม.3</option>" ;
}
else{
echo  "<option value='9'>ม.3</option>" ;
}
if($class_code==10){
echo  "<option value='10' selected>ม.4</option>" ;
}
else{
echo  "<option value='10'>ม.4</option>" ;
}
if($class_code==11){
echo  "<option value='11' selected>ม.5</option>" ;
}
else{
echo  "<option value='11'>ม.5</option>" ;
}
if($class_code==12){
echo  "<option value='12' selected>ม.6</option>" ;
}
else{
echo  "<option value='12'>ม.6</option>" ;
}
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>กลุ่มสาระ&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='group' id='group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql_curriculum = "select * from bets_curriculum order by curriculum_code desc";
$dbquery_curriculum = mysqli_query($connect,$sql_curriculum);
while($result_curriculum = mysqli_fetch_array($dbquery_curriculum)){
echo"<optgroup label='หลักสูตร$result_curriculum[curriculum_code]'>";
			$sql = "select  * from bets_group where curriculum_code='$result_curriculum[curriculum_code]' order by id";
			$dbquery = mysqli_query($connect,$sql);
			While ($result = mysqli_fetch_array($dbquery)){
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
$sql = "select  * from bets_substance where group_code='$result_ref[group_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
echo  "<option  value = ''>เลือก</option>" ;
While ($result = mysqli_fetch_array($dbquery))
   {
	echo  "<option value=$result[substance_code]>$result[substance_name]</option>" ;
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
	echo  "<option value=$result[standard_code]>$result[short_name]</option>" ;
   }
echo "</select>";
echo "</td></tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวชี้วัด&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='indicator' id='indicator' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>คำถาม&nbsp;&nbsp;</Td>";
?>
                  <td align="left"><textarea cols="50" id="question" name="question" rows="5" ></textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'question',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#CC3366',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
          //  '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <Td></Td><td align="right">ตัวเลือกที่ 1 ::</td>
                  <td align="left"><textarea cols="50" id="answer1" name="answer1" rows="5" ></textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'answer1',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
			//  ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
       //     '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <Td></Td><td align="right">ตัวเลือกที่ 2 ::</td>
                  <td align="left"><textarea cols="50" id="answer2" name="answer2" rows="5" ></textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'answer2',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
      //      '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <Td></Td><td align="right">ตัวเลือกที่ 3 ::</td>
                  <td align="left"><textarea cols="50" id="answer3" name="answer3" rows="5" ></textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'answer3',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
        //    '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <Td></Td><td align="right">ตัวเลือกที่ 4 ::</td>
                  <td align="left"><textarea cols="50" id="answer4" name="answer4" rows="5" ></textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'answer4',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
        //    '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <Td></Td><td align="right">ตัวเลือกที่ 5 ::</td>
                  <td align="left"><textarea cols="50" id="answer5" name="answer5" rows="5" ></textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'answer5',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
       //     '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
<?php
echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวเลือกที่ถูก&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='right_answer' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value='1'>ตัวเลือกที่ 1</option>" ;
echo  "<option value='2'>ตัวเลือกที่ 2</option>" ;
echo  "<option value='3'>ตัวเลือกที่ 3</option>" ;
echo  "<option value='4'>ตัวเลือกที่ 4</option>" ;
echo  "<option value='5'>ตัวเลือกที่ 5</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>จำนวนตัวเลือก&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='answer_num' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value='1'>1</option>" ;
echo  "<option value='2'>2</option>" ;
echo  "<option value='3'>3</option>" ;
echo  "<option value='4' selected>4</option>" ;
echo  "<option value='5'>5</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภทข้อสอบ&nbsp;&nbsp;</Td>";
echo "<td><input type='radio' name='remark' value='school' checked>ข้อสอบสถานศึกษา&nbsp;<input type='radio' name='remark' value='private'>ข้อสอบส่วนตัว</td></tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(2)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=bets&task=main/test_item&index=3&id=$_GET[id]&page=$_REQUEST[page]&group_index=$_REQUEST[group_index]&class_index=$_REQUEST[class_index]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=bets&task=main/test_item&page=$_REQUEST[page]&group_index=$_REQUEST[group_index]&class_index=$_REQUEST[class_index]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from bets_item where id='$_GET[id]' and officer='$officer'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
		
		//เช็คชั้นกับตัวชี้วัด
		$indicator_class=substr($_POST['indicator'],-2);
		if(($indicator_class>$_POST['class_code']) and ($_POST['class_code']<10)){
		echo "<div align='center'>ตัวชี้วัดชั้นปีสูงกว่าระดับชั้นสอบ ตรวจสอบอีกครั้ง</div>";
		exit();
		}
		
		//เช็คคำตัวเลือกถูกกับจำนวนตัวเลือก
		if($_POST['right_answer']>$_POST['answer_num']){
		echo "<div align='center'>ตัวเลือกถูกมากกว่าจำนวนตัวเลือก ตรวจสอบอีกครั้ง</div>";
		exit();
		}
		
		
		$basename = basename($_FILES['pic_item']['name']);
		if(!(substr($basename,-3)=="JPG" or substr($basename,-3)=="jpg")){	
		echo "<div align='center'>อนุญาตให้ Upload เฉพาะไฟล์นามสกุล jpg เท่านั้น</div>";
		exit();
		}	
		if($basename!="")
		{
		$changed_name = file_upload();
		$sql = "insert into bets_item(indicator_code,class_code,item_type,pic_item,answer_num,question,right_answer,remark,officer,rec_date) values ('$_POST[indicator]', '$_POST[class_code]','1','$changed_name','$_POST[answer_num]','$_POST[question]','$_POST[right_answer]','$_POST[remark]','$officer','$rec_date')";
		$dbquery = mysqli_query($connect,$sql);
		}
}

//ส่วนบันทึกข้อมูล
if($index==4.5){
$rec_date = date("Y-m-d");
		
		//เช็คชั้นกับตัวชี้วัด
		$indicator_class=substr($_POST['indicator'],-2);
		if(($indicator_class>$_POST['class_code']) and ($_POST['class_code']<10)){
		echo "<div align='center'>ตัวชี้วัดชั้นปีสูงกว่าระดับชั้นสอบ ตรวจสอบอีกครั้ง</div>";
		exit();
		}
		
		//เช็คคำตัวเลือกถูกกับจำนวนตัวเลือก
		if($_POST['right_answer']>$_POST['answer_num']){
		echo "<div align='center'>ตัวเลือกถูกมากกว่าจำนวนตัวเลือก ตรวจสอบอีกครั้ง</div>";
		exit();
		}
		if($_POST['question']!=""){
		$sql = "insert into bets_item(indicator_code,class_code,item_type,answer_num,question,answer1,answer2,answer3,answer4,answer5,right_answer,remark,officer,rec_date) values ('$_POST[indicator]', '$_POST[class_code]','2','$_POST[answer_num]','$_POST[question]','$_POST[answer1]','$_POST[answer2]','$_POST[answer3]','$_POST[answer4]','$_POST[answer5]','$_POST[right_answer]','$_POST[remark]','$officer','$rec_date')";
		$dbquery = mysqli_query($connect,$sql);
		}
		else{
		echo "<script>alert('ยังไม่ได้กรอกคำถาม ระบบไม่บันทึกข้อมูล');</script>\n";
		}
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_item.id='$_GET[id]' and officer='$officer'";
$dbquery = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery);
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>แก้ไขข้อสอบ</Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table width='90%' Border='0'>";
$select_c1="";$select_c2="";$select_c3="";$select_c4="";$select_c5="";$select_c6="";
$select_c7="";$select_c8="";$select_c9="";$select_c10="";$select_c11="";$select_c12="";
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
else if($result_ref['class_code']==10){
$select_c10="selected";
}
else if($result_ref['class_code']==11){
$select_c11="selected";
}
else if($result_ref['class_code']==12){
$select_c12="selected";
}

echo "<Tr align='left'><Td ></Td><Td align='right'>ชั้น&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='class_code' id='class_code' size='1'>";
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
echo  "<option value='10' $select_c10>ม.4</option>" ;
echo  "<option value='11' $select_c11>ม.5</option>" ;
echo  "<option value='12' $select_c12>ม.6</option>" ;
echo "</select>";
echo "</div></td></tr>";
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

echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวชี้วัด&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='indicator' id='indicator' size='1'>";
$sql = "select  * from bets_indicator where standard_code='$result_ref[standard_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
echo  "<option  value = ''>เลือก</option>" ;
While ($result = mysqli_fetch_array($dbquery))
   {
	$indicator_code = $result['indicator_code'];
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
  		 if($result['indicator_code']==$result_ref['indicator_code']){
		echo  "<option value=$result[indicator_code] selected>$class_code&nbsp;&nbsp;&nbsp;$result[indicator_text]</option>" ;
		 }
		 else{
		echo  "<option value=$result[indicator_code]>$class_code&nbsp;&nbsp;&nbsp;$result[indicator_text]</option>" ;
		 }
	}		 
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>คำถาม&nbsp;&nbsp;</Td>";
echo "<td><input type='text' name='question' size='100' value='$result_ref[question]'></td></tr>";
echo  "<tr align='left'>";
echo  "<Td ></Td><td align='right'>ไฟล์รูปภาพข้อสอบ&nbsp;&nbsp;</td>";
echo  "<td align='left'><input name = 'pic_item' type = 'file'></td>";
echo  "</tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวเลือกที่ถูก&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='right_answer' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
if($result_ref['right_answer']==1){
echo  "<option value='1' selected>ตัวเลือกที่ 1</option>" ;
}
else{
echo  "<option value='1'>ตัวเลือกที่ 1</option>" ;
}
if($result_ref['right_answer']==2){
echo  "<option value='2' selected>ตัวเลือกที่ 2</option>" ;
}
else{
echo  "<option value='2'>ตัวเลือกที่ 2</option>" ;
}
if($result_ref['right_answer']==3){
echo  "<option value='3' selected>ตัวเลือกที่ 3</option>" ;
}
else{
echo  "<option value='3'>ตัวเลือกที่ 3</option>" ;
}
if($result_ref['right_answer']==4){
echo  "<option value='4' selected>ตัวเลือกที่ 4</option>" ;
}
else{
echo  "<option value='4'>ตัวเลือกที่ 4</option>" ;
}
if($result_ref['right_answer']==5){
echo  "<option value='5' selected>ตัวเลือกที่ 5</option>" ;
}
else{
echo  "<option value='5'>ตัวเลือกที่ 5</option>" ;
}
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>จำนวนตัวเลือก&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='answer_num' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
if($result_ref['answer_num']==1){
echo  "<option value='1' selected>1</option>" ;
}
else{
echo  "<option value='1'>1</option>" ;
}
if($result_ref['answer_num']==2){
echo  "<option value='2' selected>2</option>" ;
}
else{
echo  "<option value='2'>2</option>" ;
}
if($result_ref['answer_num']==3){
echo  "<option value='3' selected>3</option>" ;
}
else{
echo  "<option value='3'>3</option>" ;
}
if($result_ref['answer_num']==4){
echo  "<option value='4' selected>4</option>" ;
}
else{
echo  "<option value='4'>4</option>" ;
}
if($result_ref['answer_num']==5){
echo  "<option value='5' selected>5</option>" ;
}
else{
echo  "<option value='5'>5</option>" ;
}
echo "</select>";
echo "</div></td></tr>";
	if($result_ref['remark']=="school"){
	$school_check="checked";
	$private_check="";
	}
	else if($result_ref['remark']=="private"){
	$school_check="";
	$private_check="checked";
	}
	else{
	$school_check="checked";
	$private_check="";
	}
echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภทข้อสอบ&nbsp;&nbsp;</Td>";
echo "<td><input type='radio' name='remark' value='school' $school_check>ข้อสอบสถานศึกษา&nbsp;<input type='radio' name='remark' value='private' $private_check>ข้อสอบส่วนตัว</td></tr>";
echo "<Br>";
echo "<Br>";
echo "<INPUT type=Hidden name='id' value='$_GET[id]'>";
echo "<Input type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Input type=Hidden Name='class_index' Value='$_GET[class_index]'>";
echo "<Input type=Hidden Name='group_index' Value='$_GET[group_index]'>";
echo "<tr><td></td><td></td><td align='left'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'></td></tr>";
echo "</Table>";
echo "</form>";
}

if($index==5.5){
//เช็คบราวเซอร์
if(chkBrowser("Chrome")!=1){  
		echo "<script>alert('การแก้ไขข้อสอบประเภทข้อความนี้ ต้องใช้กับบราวเซอร์ Google Chrome');</script>\n";
		echo "<script>document.location.href='?option=bets&task=main/test_item';</script>\n";
}

$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_item.id='$_GET[id]' and officer='$officer'";
$dbquery = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery);
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>แก้ไขข้อสอบ</Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table width='90%' Border='0'>";
$select_c1="";$select_c2="";$select_c3="";$select_c4="";$select_c5="";$select_c6="";
$select_c7="";$select_c8="";$select_c9="";$select_c10="";$select_c11="";$select_c12="";
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
else if($result_ref['class_code']==10){
$select_c10="selected";
}
else if($result_ref['class_code']==11){
$select_c11="selected";
}
else if($result_ref['class_code']==12){
$select_c12="selected";
}

echo "<Tr align='left'><Td ></Td><Td align='right'>ชั้น&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='class_code' id='class_code' size='1'>";
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
echo  "<option value='10' $select_c10>ม.4</option>" ;
echo  "<option value='11' $select_c11>ม.5</option>" ;
echo  "<option value='12' $select_c12>ม.6</option>" ;
echo "</select>";
echo "</div></td></tr>";
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

echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวชี้วัด&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='indicator' id='indicator' size='1'>";
$sql = "select  * from bets_indicator where standard_code='$result_ref[standard_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
echo  "<option  value = ''>เลือก</option>" ;
While ($result = mysqli_fetch_array($dbquery))
   {
	$indicator_code = $result['indicator_code'];
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
  		 if($result['indicator_code']==$result_ref['indicator_code']){
		echo  "<option value=$result[indicator_code] selected>$class_code&nbsp;&nbsp;&nbsp;$result[indicator_text]</option>" ;
		 }
		 else{
		echo  "<option value=$result[indicator_code]>$class_code&nbsp;&nbsp;&nbsp;$result[indicator_text]</option>" ;
		 }
	}		 
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>คำถาม&nbsp;&nbsp;</Td>";
?>
                  <td align="left"><textarea cols="50" id="question" name="question" rows="4"><?php echo $result_ref['question'] ?></textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'question',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#CC3366',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
          //  '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <Td></Td><td align="right">ตัวเลือกที่ 1 ::</td>
                  <td align="left"><textarea cols="50" id="answer1" name="answer1" rows="3" ><?php echo $result_ref['answer1'] ?></textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'answer1',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
			//  ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
       //     '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <Td></Td><td align="right">ตัวเลือกที่ 2 ::</td>
                  <td align="left"><textarea cols="50" id="answer2" name="answer2" rows="3" ><?php echo $result_ref['answer2'] ?></textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'answer2',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
      //      '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <Td></Td><td align="right">ตัวเลือกที่ 3 ::</td>
                  <td align="left"><textarea cols="50" id="answer3" name="answer3" rows="3" ><?php echo $result_ref['answer3'] ?></textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'answer3',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
        //    '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <Td></Td><td align="right">ตัวเลือกที่ 4 ::</td>
                  <td align="left"><textarea cols="50" id="answer4" name="answer4" rows="3" ><?php echo $result_ref['answer4'] ?></textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'answer4',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
        //    '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <Td></Td><td align="right">ตัวเลือกที่ 5 ::</td>
                  <td align="left"><textarea cols="50" id="answer5" name="answer5" rows="3" ><?php echo $result_ref['answer5'] ?></textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'answer5',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
       //     '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
<?php
echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวเลือกที่ถูก&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='right_answer' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
if($result_ref['right_answer']==1){
echo  "<option value='1' selected>ตัวเลือกที่ 1</option>" ;
}
else{
echo  "<option value='1'>ตัวเลือกที่ 1</option>" ;
}
if($result_ref['right_answer']==2){
echo  "<option value='2' selected>ตัวเลือกที่ 2</option>" ;
}
else{
echo  "<option value='2'>ตัวเลือกที่ 2</option>" ;
}
if($result_ref['right_answer']==3){
echo  "<option value='3' selected>ตัวเลือกที่ 3</option>" ;
}
else{
echo  "<option value='3'>ตัวเลือกที่ 3</option>" ;
}
if($result_ref['right_answer']==4){
echo  "<option value='4' selected>ตัวเลือกที่ 4</option>" ;
}
else{
echo  "<option value='4'>ตัวเลือกที่ 4</option>" ;
}
if($result_ref['right_answer']==5){
echo  "<option value='5' selected>ตัวเลือกที่ 5</option>" ;
}
else{
echo  "<option value='5'>ตัวเลือกที่ 5</option>" ;
}
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>จำนวนตัวเลือก&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='answer_num' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
if($result_ref['answer_num']==1){
echo  "<option value='1' selected>1</option>" ;
}
else{
echo  "<option value='1'>1</option>" ;
}
if($result_ref['answer_num']==2){
echo  "<option value='2' selected>2</option>" ;
}
else{
echo  "<option value='2'>2</option>" ;
}
if($result_ref['answer_num']==3){
echo  "<option value='3' selected>3</option>" ;
}
else{
echo  "<option value='3'>3</option>" ;
}
if($result_ref['answer_num']==4){
echo  "<option value='4' selected>4</option>" ;
}
else{
echo  "<option value='4'>4</option>" ;
}
if($result_ref['answer_num']==5){
echo  "<option value='5' selected>5</option>" ;
}
else{
echo  "<option value='5'>5</option>" ;
}
echo "</select>";
echo "</div></td></tr>";
	if($result_ref['remark']=="school"){
	$school_check="checked";
	$private_check="";
	}
	else if($result_ref['remark']=="private"){
	$school_check="";
	$private_check="checked";
	}
	else{
	$school_check="checked";
	$private_check="";
	}
echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภทข้อสอบ&nbsp;&nbsp;</Td>";
echo "<td><input type='radio' name='remark' value='school' $school_check>ข้อสอบสถานศึกษา&nbsp;<input type='radio' name='remark' value='private' $private_check>ข้อสอบส่วนตัว</td></tr>";
echo "<Br>";
echo "<Br>";
echo "<INPUT TYPE=Hidden name='id' value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Input Type=Hidden Name='class_index' Value='$_GET[class_index]'>";
echo "<Input Type=Hidden Name='group_index' Value='$_GET[group_index]'>";
echo "<Tr align='left'><Td ></Td><td></td><td align='left'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(2)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
		
		//เช็คชั้นกับตัวชี้วัด
		$indicator_class=substr($_POST['indicator'],-2);
		if(($indicator_class>$_POST['class_code']) and ($_POST['class_code']<10)){
		echo "<div align='center'>ตัวชี้วัดชั้นปีสูงกว่าระดับชั้นสอบ ตรวจสอบอีกครั้ง</div>";
		exit();
		}
		
		//เช็คคำตัวเลือกถูกกับจำนวนตัวเลือก
		if($_POST['right_answer']>$_POST['answer_num']){
		echo "<div align='center'>ตัวเลือกถูกมากกว่าจำนวนตัวเลือก ตรวจสอบอีกครั้ง</div>";
		exit();
		}
		
		if(isset($_FILES['pic_item']['name'])){
		$basename = basename($_FILES['pic_item']['name']);
		}
		else{
		$basename = "";
		}
		if($basename!=""){
						if(!(substr($basename,-3)=="JPG" or substr($basename,-3)=="jpg")){	
						echo "<div align='center'>อนุญาตให้ Upload เฉพาะไฟล์นามสกุล jpg เท่านั้น</div>";
						exit();
						}	
		$changed_name = file_upload();
		$sql = "update bets_item set indicator_code='$_POST[indicator]',class_code='$_POST[class_code]', pic_item='$changed_name',answer_num='$_POST[answer_num]',question='$_POST[question]',right_answer='$_POST[right_answer]',remark='$_POST[remark]' where id='$_POST[id]' and officer='$officer'";
		$dbquery = mysqli_query($connect,$sql);
		}
		else{
		$sql = "update bets_item set indicator_code='$_POST[indicator]',class_code='$_POST[class_code]',answer_num='$_POST[answer_num]',question='$_POST[question]',right_answer='$_POST[right_answer]',remark='$_POST[remark]' where id='$_POST[id]' and officer='$officer'";
		$dbquery = mysqli_query($connect,$sql);
		}
}

if ($index==6.5){
$rec_date = date("Y-m-d");
		
		//เช็คชั้นกับตัวชี้วัด
		$indicator_class=substr($_POST['indicator'],-2);
		if(($indicator_class>$_POST['class_code']) and ($_POST['class_code']<10)){
		echo "<div align='center'>ตัวชี้วัดชั้นปีสูงกว่าระดับชั้นสอบ ตรวจสอบอีกครั้ง</div>";
		exit();
		}
		
		//เช็คคำตัวเลือกถูกกับจำนวนตัวเลือก
		if($_POST['right_answer']>$_POST['answer_num']){
		echo "<div align='center'>ตัวเลือกถูกมากกว่าจำนวนตัวเลือก ตรวจสอบอีกครั้ง</div>";
		exit();
		}
		if($_POST['question']!=""){
		$sql = "update bets_item set indicator_code='$_POST[indicator]',class_code='$_POST[class_code]',answer_num='$_POST[answer_num]',question='$_POST[question]',answer1='$_POST[answer1]',answer2='$_POST[answer2]',answer3='$_POST[answer3]',answer4='$_POST[answer4]',answer5='$_POST[answer5]',right_answer='$_POST[right_answer]',remark='$_POST[remark]' where id='$_POST[id]' and officer='$officer'";
		$dbquery = mysqli_query($connect,$sql);
		}
		else{
		echo "<script>alert('ไม่มีคำถาม ระบบไม่บันทึกข้อมูล');</script>\n";
		}
}

if($index==7){
$sql = "select *,bets_item.id,bets_item.class_code,bets_item.officer from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_item.id='$_GET[id]'";
$dbquery_ref = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery_ref);
$class_code=$result_ref ['class_code'];
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>รายละเอียดข้อสอบ</Font>";
echo "</Cener>";
//echo "<Br>";
echo "<Table width='90%' Border='0'>";
echo "<Tr><Td colspan='3' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=bets&task=main/test_item&page=$_GET[page]&group_index=$_REQUEST[group_index]&class_index=$_REQUEST[class_index]\"'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>หลักสูตร&nbsp;&nbsp;</Td>";
echo "<td><font color='#000066'>$result_ref[curriculum_code]</font></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชั้น&nbsp;&nbsp;</Td>";
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
		else if($class_code==10){
		$class_code="ม.4";
		}
		else if($class_code==11){
		$class_code="ม.5";
		}
		else if($class_code==12){
		$class_code="ม.6";
		}
echo "<td><font color='#000066'>$class_code</font></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>กลุ่มสาระ&nbsp;&nbsp;</Td>";
echo "<td>";
$sql = "select  * from bets_group where group_code='$result_ref[group_code]' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo  "<font color='#000066'>$result[group_name]</font>";
echo "</td></tr>";

echo "<Tr align='left'><Td></Td><Td align='right'>สาระ&nbsp;&nbsp;</Td><td align='left'>";
$sql = "select  * from bets_substance where substance_code='$result_ref[substance_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo  "<font color='#000033'>$result[substance_name]</font>" ;
echo "</td></tr>";

echo "<Tr align='left'><Td></Td><Td align='right'>มาตรฐาน&nbsp;&nbsp;</Td><td align='left'>";
$sql = "select  * from bets_standard where standard_code='$result_ref[standard_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo  "<font color='#000066'>$result[short_name]</font>" ;
echo "</td></tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวชี้วัด&nbsp;&nbsp;</Td><td align='left'>";
$sql = "select  * from bets_indicator where indicator_code='$result_ref[indicator_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo  "<font color='#000066'>$result[indicator_text]</font>" ;
echo "</td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>คำถาม&nbsp;&nbsp;</Td>";
echo "<td><font><strong>$result_ref[question]</strong></font></td></tr>";

if($result_ref['item_type']==1){
echo "<Tr align='left'><Td ></Td><Td align='right'></Td><td align='left'>";
echo "<img src='$result_ref[pic_item]' border='0' width='70%'>" ;
echo "</td></tr>";
}

if($result_ref['item_type']==2){
		if($result_ref['answer_num']>=1){
		echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวเลือกที่ 1&nbsp;&nbsp;</Td>";
		echo "<td><font color='#CC3300'><strong>$result_ref[answer1]</strong></font></td></tr>";
		}
		if($result_ref['answer_num']>=2){
		echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวเลือกที่ 2&nbsp;&nbsp;</Td>";
		echo "<td><font color='#CC3300'><strong>$result_ref[answer2]</strong></font></td></tr>";
		}
		if($result_ref['answer_num']>=3){
		echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวเลือกที่ 3&nbsp;&nbsp;</Td>";
		echo "<td><font color='#CC3300'><strong>$result_ref[answer3]</strong></font></td></tr>";
		}
		if($result_ref['answer_num']>=4){
		echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวเลือกที่ 4&nbsp;&nbsp;</Td>";
		echo "<td><font color='#CC3300'><strong>$result_ref[answer4]</strong></font></td></tr>";
		}
		if($result_ref['answer_num']==5){
		echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวเลือกที่ 5&nbsp;&nbsp;</Td>";
		echo "<td><font color='#CC3300'><strong>$result_ref[answer5]</strong></font></td></tr>";
		}
}
echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวเลือกที่ถูก&nbsp;&nbsp;</Td>";
echo "<td>";
echo "<font color='#006666'>ตัวเลือกที่ $result_ref[right_answer]</font>";
echo "</td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>จำนวนตัวเลือก&nbsp;&nbsp;</Td>";
echo "<td>";
echo "<font color='#006666'>$result_ref[answer_num] ตัวเลือก</font>";
echo "</td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภทข้อสอบ&nbsp;&nbsp;</Td>";
			if($result_ref['remark']=="school"){
			$remark="ข้อสอบสถานศึกษา";
			}
			else if($result_ref['remark']=="private"){
			$remark="ข้อสอบส่วนตัว";
			}
			else{
			$remark="";
			}
echo "<td><font color='#006666'>$remark</font></td></tr>";
		$sql = "select * from person_main where person_id='$result_ref[officer]'";
		$query_person = mysqli_query($connect,$sql);
		$result_person = mysqli_fetch_array($query_person);
echo "<Tr align='left'><Td ></Td><Td align='right'>เจ้าหน้าที่&nbsp;&nbsp;</Td>";
echo "<td><font color='#006666'>$result_person[name] $result_person[surname]</font></td></tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==1.5) or ($index==2) or ($index==5) or ($index==5.5) or ($index==7))){

//ส่วนของการแยกหน้า
if(($_REQUEST['class_index']=="") and ($_REQUEST['group_index']=="")){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and (bets_item.officer='$officer' or bets_item.remark='school')";
}
else if(($_REQUEST['class_index']!="") and ($_REQUEST['group_index']!="")){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_indicator.class_code='$_REQUEST[class_index]' and bets_group.group_code='$_REQUEST[group_index]' and (bets_item.officer='$officer' or bets_item.remark='school')";
}
else if($_REQUEST['class_index']!=""){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_indicator.class_code='$_REQUEST[class_index]' and (bets_item.officer='$officer' or bets_item.remark='school') ";
}
else if($_REQUEST['group_index']!=""){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_group.group_code='$_REQUEST[group_index]' and (bets_item.officer='$officer' or bets_item.remark='school') ";
}
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery); //นำไปแยกหน้า

$pagelen=20 ; // 1.กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/test_item&class_index=$_REQUEST[class_index]&group_index=$_REQUEST[group_index]";  // 2_กำหนดลิงค์ฺ
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

///
echo  "<table width='95%' border='0' align='center'>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อสอบแบบอัพโหลดรูปภาพ' onclick='location.href=\"?option=bets&task=main/test_item&index=1\"'><INPUT TYPE='button' name='smb' value='เพิ่มข้อสอบแบบพิมพ์ข้อความ' onclick='location.href=\"?option=bets&task=main/test_item&index=1.5\"'></Td>";
echo "<td align='right'>";
		echo "<form id='frm1' name='frm1'>";
		echo "<div align='right'>";
		echo "<Select  name='class_index' size='1'>";
$select_class_1=""; $select_class_2=""; $select_class_3=""; $select_class_4=""; $select_class_5=""; $select_class_6=""; $select_class_7=""; $select_class_8=""; $select_class_9=""; $select_class_10="";  $select_class_11="";  $select_class_12=""; 
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
				else if($_REQUEST['class_index']=='10'){
				$select_class_10="selected";
				}
				else if($_REQUEST['class_index']=='11'){
				$select_class_11="selected";
				}
				else if($_REQUEST['class_index']=='12'){
				$select_class_12="selected";
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
		echo  "<option value =10 $select_class_10>ม.4</option>";
		echo  "<option value =11 $select_class_11>ม.5</option>";
		echo  "<option value =12 $select_class_12>ม.6</option>";
		echo "</select>";
		
	//เลือก	กลุ่มสาระ
			echo "<Select  name='group_index' size='1'>";
			echo  "<option  value = ''>ทุกกลุ่มสาระ</option>" ;
			$sql_curriculum = "select * from bets_curriculum order by curriculum_code desc";
			$dbquery_curriculum = mysqli_query($connect,$sql_curriculum);
			while($result_curriculum = mysqli_fetch_array($dbquery_curriculum)){
			 echo"<optgroup label='หลักสูตร$result_curriculum[curriculum_code]'>";
						$sql_grp = "select * from bets_group where curriculum_code='$result_curriculum[curriculum_code]' order by id";
						$dbquery_grp = mysqli_query($connect,$sql_grp);
						While ($result_grp = mysqli_fetch_array($dbquery_grp))
					   {
								if($result_grp['group_code']==$_REQUEST['group_index']){
								echo  "<option value = $result_grp[group_code] selected>$result_grp[group_name]</option>";
								}
								else{
								echo  "<option value = $result_grp[group_code]>$result_grp[group_name]</option>";
								}
						}
			echo"</optgroup>\n";			
			}	
			echo "</select>";
		
		echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_index(1)'>";
		echo "</div>";
		echo "</form>";
		echo "</td></Tr></Table>";
///	

if(($_REQUEST['class_index']=="") and ($_REQUEST['group_index']=="")){
$sql = "select *,bets_item.id,bets_item.class_code,bets_item.officer from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and (bets_item.officer='$officer' or bets_item.remark='school') order by bets_item.id limit $start,$pagelen ";
}
else if(($_REQUEST['class_index']!="") and ($_REQUEST['group_index']!="")){
$sql = "select *,bets_item.id,bets_item.class_code,bets_item.officer from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_indicator.class_code='$_REQUEST[class_index]' and bets_group.group_code='$_REQUEST[group_index]' and (bets_item.officer='$officer' or bets_item.remark='school') order by bets_item.id limit $start,$pagelen ";
}
else if($_REQUEST['class_index']!=""){
$sql = "select *,bets_item.id,bets_item.class_code,bets_item.officer from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_indicator.class_code='$_REQUEST[class_index]' and (bets_item.officer='$officer' or bets_item.remark='school') order by bets_item.id limit $start,$pagelen ";
}
else if($_REQUEST['group_index']!=""){
$sql = "select *,bets_item.id,bets_item.class_code,bets_item.officer from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_group.group_code='$_REQUEST[group_index]' and (bets_item.officer='$officer' or bets_item.remark='school') order by bets_item.id limit $start,$pagelen ";
}
$dbquery = mysqli_query($connect,$sql);

echo  "<table width='95%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td><td width='60'>ชั้น</td><td>คำถาม</td><Td width='50' align='center'>ประเภท</td><Td width='250'>ตัวชี้วัด</Td><Td width='60'>มาตรฐาน</Td><Td width='100'>สาระ</Td><Td width='80'>กลุ่มสาระ</Td><Td width='60' align='center'>หลักสูตร</Td><Td width='50' align='center'>รายละเอียด</Td><td width='50' align='center'>ลบ</td><Td width='50' align='center'>แก้ไข</Td></Tr>";

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
		else if($class_code==10){
		$class_code="ม.4";
		}
		else if($class_code==11){
		$class_code="ม.5";
		}
		else if($class_code==12){
		$class_code="ม.6";
		}

		if(($M%2) == 0)
		$color="#FFFFC";
		else  	$color="#FFFFFF";
		
		if($result['item_type']==1){
		$item_type="ภาพ";
		}
		else{
		$item_type="ข้อความ";
		}
		
		echo "<Tr bgcolor='$color' align='center' valign='top'><Td >$N</Td><td>$class_code</td><td align='left'>($id) $result[question]</td><td align='center'>$item_type</td><td align='left'>$result[indicator_text]</td><Td align='center'>$short_name</Td><Td align='left'>$substance_name</Td><Td align='left'>$group_name</Td><Td align='center'>$result[curriculum_code]</Td>";
		echo "<td><a href=?option=bets&task=main/test_item&id=$id&index=7&page=$page&group_index=$_REQUEST[group_index]&class_index=$_REQUEST[class_index]><img src=./images/browse.png border='0'></a></td>";
		if($result['officer']==$officer){
			echo "<td><a href=?option=bets&task=main/test_item&id=$id&index=2&page=$page&group_index=$_REQUEST[group_index]&class_index=$_REQUEST[class_index]><img src=./images/drop.png border='0'></a></td>";
			if($result['item_type']==1){
			echo "<td><a href=?option=bets&task=main/test_item&id=$id&index=5&page=$page&group_index=$_REQUEST[group_index]&class_index=$_REQUEST[class_index]><img src=./images/edit.png border='0'></a></div></Td";
			}
			if($result['item_type']==2){
			echo "<td><a href=?option=bets&task=main/test_item&id=$id&index=5.5&page=$page&group_index=$_REQUEST[group_index]&class_index=$_REQUEST[class_index]><img src=./images/edit.png border='0'></a></div></Td";
			}
		}
		else{
		echo "<td></td><td></td>";
		}
		echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
}
?>

<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=bets&task=main/test_item");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.class_code.value == ""){
			alert("กรุณาเลือกชั้น");
		}else if(frm1.group.value==""){
			alert("กรุณาเลือกกลุ่มสาระ");
		}else if(frm1.substance.value==""){
			alert("กรุณาเลือกสาระ");
		}else if(frm1.standard.value==""){
			alert("กรุณาเลือกมาตรฐาน");
		}else if(frm1.indicator.value==""){
			alert("กรุณาเลือกตัวชี้วัด");
		}else if(frm1.question.value==""){
			alert("กรุณากรอกคำถาม");
		}else if(frm1.pic_item.value==""){
			alert("กรุณาเลือกไฟล์ภาพข้อสอบ");
		}else if(frm1.right_answer.value == ""){
			alert("กรุณาเลือกตัวเลือกที่ถูก");
		}else if(frm1.answer_num.value == ""){
			alert("กรุณาเลือกจำนวนตัวเลือก");
		}else{
			callfrm("?option=bets&task=main/test_item&index=4");   //page ประมวลผล
		}
	}else if(val==2){
		if(frm1.class_code.value == ""){
			alert("กรุณาเลือกชั้น");
		}else if(frm1.group.value==""){
			alert("กรุณาเลือกกลุ่มสาระ");
		}else if(frm1.substance.value==""){
			alert("กรุณาเลือกสาระ");
		}else if(frm1.standard.value==""){
			alert("กรุณาเลือกมาตรฐาน");
		}else if(frm1.indicator.value==""){
			alert("กรุณาเลือกตัวชี้วัด");
		}else if(frm1.right_answer.value == ""){
			alert("กรุณาเลือกตัวเลือกที่ถูก");
		}else if(frm1.answer_num.value == ""){
			alert("กรุณาเลือกจำนวนตัวเลือก");
		}else{
			callfrm("?option=bets&task=main/test_item&index=4.5");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=bets&task=main/test_item");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.class_code.value == ""){
			alert("กรุณาเลือกชั้น");
		}else if(frm1.group.value==""){
			alert("กรุณาเลือกกลุ่มสาระ");
		}else if(frm1.substance.value==""){
			alert("กรุณาเลือกสาระ");
		}else if(frm1.standard.value==""){
			alert("กรุณาเลือกมาตรฐาน");
		}else if(frm1.indicator.value==""){
			alert("กรุณาเลือกตัวชี้วัด");
		}else if(frm1.right_answer.value == ""){
			alert("กรุณาเลือกตัวเลือกที่ถูก");
		}else if(frm1.answer_num.value == ""){
			alert("กรุณาเลือกจำนวนตัวเลือก");
		}else{
			callfrm("?option=bets&task=main/test_item&index=6");   //page ประมวลผล
		}
	}else if(val==2){
		if(frm1.class_code.value == ""){
			alert("กรุณาเลือกชั้น");
		}else if(frm1.group.value==""){
			alert("กรุณาเลือกกลุ่มสาระ");
		}else if(frm1.substance.value==""){
			alert("กรุณาเลือกสาระ");
		}else if(frm1.standard.value==""){
			alert("กรุณาเลือกมาตรฐาน");
		}else if(frm1.indicator.value==""){
			alert("กรุณาเลือกตัวชี้วัด");
		}else if(frm1.right_answer.value == ""){
			alert("กรุณาเลือกตัวเลือกที่ถูก");
		}else if(frm1.answer_num.value == ""){
			alert("กรุณาเลือกจำนวนตัวเลือก");
		}else{
			callfrm("?option=bets&task=main/test_item&index=6.5");   //page ประมวลผล
		}
	}
}

function goto_index(val){
	if(val==1){
		callfrm("?option=bets&task=main/test_item");  
	}
}
</script>
