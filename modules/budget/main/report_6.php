<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
require_once "modules/budget/time_inc.php";	
$user=$_SESSION['login_user_id'];
echo "<br />";

if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เอกสารการเงินและบัญชี</strong></font></td></tr>";
echo "</table>";
}
//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>เพิ่มเอกสาร</B></Font><br />";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table  width='50%' >";
echo "<Tr align='left'><Td align='right'>ชื่อเอกสาร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='doc_subject'  Size='70'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>เอกสาร&nbsp;&nbsp;</Td><Td><input type='file' name='myfile1' size='26'></Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='800' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=budget&task=main/report_6&index=3&id=$_REQUEST[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=budget&task=main/report_6&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql_unlink = "select * from budget_document where  id='$_REQUEST[id]' ";
$dbquery_unlink = mysqli_query($connect,$sql_unlink);
$result_unlink  = mysqli_fetch_array($dbquery_unlink );
			//ป้องกันการลบที่ไม่ใช่เจ้าของ
			if($result_unlink['officer']==$user){
			$sql = "delete from budget_document where  id='$_REQUEST[id]'";
			$dbquery = mysqli_query($connect,$sql);
			unlink("modules/budget/upload_files/$result_unlink[file_name]");
			}
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$sizelimit = 2000*1024 ;  //ขนาดไฟล์ที่ให้แนบ 2 Mb.
/// file
$myfile1 = $_FILES ['myfile1'] ['tmp_name'] ;
$myfile1_name = $_FILES ['myfile1'] ['name'] ;
$myfile1_size = $_FILES ['myfile1'] ['size'] ;
$myfile1_type = $_FILES ['myfile1'] ['type'] ;
 $array_last1 = explode("." ,$myfile1_name) ;
 $c1 =count ($array_last1) - 1 ;
 $lastname1 = strtolower ($array_last1 [$c1] ) ;
 if  ($myfile1<>"") {
			 if ($lastname1 =="doc" or $lastname1 =="docx" or $lastname1 =="rar" or $lastname1 =="pdf" or $lastname1 =="xls" or $lastname1 =="xlsx" or $lastname1 =="zip" or $lastname1 =="jpg" or $lastname1 =="gif") { 
			 $upfile1 = "" ; 
			  }else {
				 $upfile1 = "-ไม่อนุญาตให้ทำการแนบไฟล์ $myfile1_name<BR> " ;
			  } 

		  If ($myfile1_size>$sizelimit) {
			  $sizelimit1 = "-ไฟล์ $myfile1_name มีขนาดใหญ่กว่าที่กำหนด (2 MB)<BR>" ;
		  }else {
				$sizelimit1 = "" ;
		  }
 }

// check file size  file name
if ($upfile1<> "" || $sizelimit1<> "") {
echo "<div align='center'>";
echo "<B><FONT SIZE=2 COLOR=#990000>มีข้อผิดพลาดเกี่ยวกับไฟล์ของคุณ ดังรายละเอียด</FONT></B><BR>" ;
echo "<FONT SIZE=2 COLOR=#990099>" ;
 echo  $upfile1 ;
 echo  $sizelimit1 ;
 echo "</FONT>" ;
 echo "&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"&nbsp;&nbsp;แก้ไข&nbsp;&nbsp;\" onClick=\"javascript:history.go(-1)\" ></CENTER>" ;
 echo "</div>";
exit () ;
}
					if ($myfile1<>"" ) {
					$timestamp = mktime(date("H"), date("i"),date("s"), date("m") ,date("d"), date("Y"))  ;	
					//timestamp เวลาปัจจุบัน 
					$ref_id = $user.$timestamp ;
					$myfile1name=$ref_id.".".$lastname1 ; 
							if(copy ($myfile1, "modules/budget/upload_files/".$myfile1name)){
							$rec_date=date("Y-m-d");
							$sql = "insert into budget_document (subject, file_name, rec_date, officer) values ('$_POST[doc_subject]', '$myfile1name','$rec_date','$user')";
							$dbquery = mysqli_query($connect,$sql);
					         }
					unlink ($myfile1) ;
					}
echo "<script>document.location.href='?option=budget&task=main/report_6'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
$sql = "select * from budget_document where  id='$_REQUEST[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
echo "<Table  width='50%'>";
echo "<Tr align='left'><Td align='right'>ชื่อเอกสาร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='doc_subject'  Size='70' value='$ref_result[subject]'></Td></Tr>";
echo "</Table>";
echo "<Br />";
echo "<Input Type=Hidden Name='id' Value='$_REQUEST[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_REQUEST[page]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='location.href=\"?option=budget&task=main/report_6&page=$_REQUEST[page]\"'";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "update budget_document set subject='$_POST[doc_subject]' where  id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2)  or ($index==5) or ($index==7))){

//ส่วนของการแยกหน้า
$sql = "select  * from budget_document ";
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );  
$pagelen=20;  // กำหนดแถวต่อหน้า
$url_link="option=budget&task=main/report_6";  //กำหนดลิงค์ฺ
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

////////////////////เลือกลิ้นชักบุคลากร
if(!($_SESSION['login_status']==88)){
echo "<form id='frm1' name='frm1'>";
echo "<table width='70%' align='center'><tr><td align='left'>";
echo "<INPUT TYPE='button' name='smb' value='เพิ่มเอกสาร' onclick='location.href=\"?option=budget&task=main/report_6&index=1\"'>";
echo "</td></tr></table>";
echo "</form>";
}
//////////////////////////////////////////

$sql = "select  * from budget_document order by id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='70%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center' ><Td width='70'>ที่</Td><Td width='120' >วันที่</Td><Td>ชื่อเอกสาร</Td><Td width='60'>ลบ</Td><Td width='60'>แก้ไข</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<tr bgcolor='$color'><td align='center'>$N</td><td align='center'>";
		echo thai_date_3($result['rec_date']);
		echo "</td><td align='left'><A HREF='modules/budget/upload_files/$result[file_name]' title='คลิกเพื่อเปิดไฟล์แนบ' target='_BLANK'>$result[subject]</A></td>";
		if($result['officer']==$user){
		echo "<td align='center'><a href=?option=budget&task=main/report_6&index=2&id=$id&page=$page><img src=images/drop.png border='0' alt='ลบ'></a></td><td align='center'><a href=?option=budget&task=main/report_6&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></td>";
		}
		else{
		echo "<td></td><td></td>";
		}
echo "</tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=budget&task=main/report_6");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.doc_subject.value == ""){
			alert("กรุณากรอกชื่อเอกสาร");
		}else if(frm1.myfile1.value==""){
			alert("กรุณาเลือกเอกสาร");
		}else{
			callfrm("?option=budget&task=main/report_6&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=budget&task=main/report_6");   // page ย้อนกลับ 
	}else if(val==1){
			if(frm1.doc_subject.value == ""){
			alert("กรุณากรอกชื่อเอกสาร");
		}else{
			callfrm("?option=budget&task=main/report_6&index=6");   //page ประมวลผล
		}
	}
}

</script>
