<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if($result_permission['p2']!=1){
exit();
}
$officer=$_SESSION['login_user_id'];

if(!isset($_REQUEST['group_index'])){
$_REQUEST['group_index']="";
}
if(!isset($_REQUEST['class_index'])){
$_REQUEST['class_index']="";
}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5) or ($index==8) or ($index==9))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ชุดข้อคำถาม</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มชุดข้อคำถาม</Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table width='50%' Border='0' align='center'>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อชุดข้อคำถาม&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='master_name'  Size='50'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>รายละเอียด(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='test_detail'  Size='70'></Td></Tr>";
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
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=bets&task=main/test_master&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=bets&task=main/test_master&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from bets_master_test_2 where master_test_id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
$sql = "delete from bets_master_test where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

if($index==3.2){
$sql = "delete from bets_master_test_2 where id=$_GET[del_id]";
$dbquery = mysqli_query($connect,$sql);
$index=7;
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into bets_master_test(master_name,test_detail,officer,rec_date) values ('$_POST[master_name]','$_POST[test_detail]', '$officer','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
	echo "<script>alert('หลังจากเพิ่มชื่อชุดข้อคำถามแล้ว ลำดับต่อไปต้องไปกำหนดข้อคำถาม'); </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if($index==5){
$sql = "select * from bets_master_test where id='$_GET[id]' and officer='$officer' ";
$dbquery = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery);
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0'>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อชุดข้อคำถาม&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='master_name'  Size='50' value='$result_ref[master_name]'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>รายละเอียด&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='test_detail'  Size='70'  value='$result_ref[test_detail]'></Td></Tr>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='Hidden' name='id' value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "update bets_master_test set master_name='$_POST[master_name]',test_detail='$_POST[test_detail]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

if($index==6.5){
$master_id=$_POST['master_id'];
$sql = "select * from bets_master_test_2 where master_test_id='$master_id' order by item_order desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$max_order=$result['item_order'];
			foreach ($_POST as $item_id=>$item_value){
					if($item_value=='test_item'){
					$max_order=$max_order+1;
					$sql = "insert into bets_master_test_2(master_test_id,item_id,item_order) values ('$master_id','$item_id','$max_order')";
					$dbquery = mysqli_query($connect,$sql);
					}
			}
$index=7;
$_REQUEST['id']=$_POST['master_id'];		
$_REQUEST['page']=$_POST['master_page'];		
}

//เรียงข้อ
if ($index==6.6){
$sql = "select * from bets_master_test_2 where master_test_id='$_GET[id]' order by item_order";
$dbquery = mysqli_query($connect,$sql);
$order_number=1;
While ($result = mysqli_fetch_array($dbquery)){
	if($_GET['item_order_index']==1 and $result['id']==$_GET['item_id']){
	$item_order=($order_number*2)-3;
	}
	else if($_GET['item_order_index']==-1 and $result['id']==$_GET['item_id']){
	$item_order=($order_number*2)+3;
	}
	else{
	$item_order=($order_number*2)	;
	}
	$sql_order="update bets_master_test_2 set  item_order='$item_order' where id='$result[id]'";
	$dbquery_order = mysqli_query($connect,$sql_order);
$order_number++;
	}
$index=7;
$master_page=$_GET['page'];
}

if($index==6.9){

		$sql = "select * from bets_master_test_2 where master_test_id='$_REQUEST[id]'";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery)){
		$item_id=$result['item_id']; 
		mysqli_query($connect,"update bets_master_test_2 set score='$_POST[$item_id]' where master_test_id='$_REQUEST[id]' and item_id='$item_id' ");
		}
echo "<script>alert('ปรับปรุงคะแนนเรียบร้อยแล้ว');</script>\n";
$index=7;
}

if($index==7){
$sql = "select * from bets_master_test where id='$_REQUEST[id]' and officer='$officer'";
$dbquery = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery);
echo "<br><Center>";
echo "<Font color='#006666' Size=3><B>รายการข้อคำถาม : ชุดข้อคำถาม$result_ref[master_name]</Font>";
echo "</Cener>";
echo "<form id='frm1' name='frm1'>";
echo  "<table width='95%' border='0' align='center'>";
$sql = "select *,bets_master_test_2.id,bets_item.id as id2 from bets_master_test_2,bets_item,bets_indicator,bets_standard,bets_substance,bets_group where bets_master_test_2.item_id=bets_item.id and bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_master_test_2.master_test_id='$_REQUEST[id]' order by bets_master_test_2.item_order,bets_master_test_2.id";
$dbquery = mysqli_query($connect,$sql);
$num_effect = mysqli_num_rows($dbquery );  // จำนวนข้อมูลในหน้านี้
echo "<Tr><Td colspan='3' align='left'>";
if($result_ref['officer']==$officer){
echo "<INPUT TYPE='button' name='smb' value='เพิ่มข้อคำถาม' onclick='location.href=\"?option=bets&task=main/test_master&index=8&master_id=$_REQUEST[id]&master_page=$_REQUEST[page]\"'>";
}
echo "</Td>";
echo "<td colspan='10' align='right'><a href=?option=bets&task=main/test_master&page=$_REQUEST[page]><<กลับ</a></td>";
echo "</Tr>";
echo "<Tr bgcolor='#66FFFF' align='center'><Td width='50'>ข้อที่</Td><td>คำถาม</td><td width='60'>ชั้น</td><Td width='50' align='center'>ประเภท</td><Td width='50'>คะแนน</Td><Td width='250'>ตัวชี้วัด</Td><Td width='60'>มาตรฐาน</Td><Td width='100'>สาระ</Td><Td width='80'>กลุ่มสาระ</Td><Td width='50' align='center'>หลักสูตร</Td><Td width='50' align='center'>รายละเอียด</Td><td width='50' align='center'>ลบ</td><td width='50' align='center'>เรียง</td></Tr>";

$M=1;
$score=0;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id2 = $result['id2'];
		$group_name= $result['group_name'];
		$substance_name= $result['substance_name'];
		$short_name= $result['short_name'];
		$class_code= $result['class_code'];
		$score=$score+$result['score'];
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
		
		echo "<Tr bgcolor='$color' align='center' valign='top'><Td>$M</Td><td align='left'>($id2) $result[question]</td><td>$class_code</td><td align='center'>$item_type</td><Td align='center'><input type='text' name='$result[item_id]' size='2' value='$result[score]'></Td><td align='left'>$result[indicator_text]</td><Td align='center'>$short_name</Td><Td align='left'>$substance_name</Td><Td align='left'>$group_name</Td><Td align='center'>$result[curriculum_code]</Td>";
		echo "<td><a href=?option=bets&task=main/test_master&index=9&id=$_REQUEST[id]&item_id=$result[item_id]&page=$_REQUEST[page]><img src=./images/browse.png border='0'></a></td>";
		if($result_ref['officer']==$officer){
			echo "<td><a href=?option=bets&task=main/test_master&del_id=$result[id]&id=$_REQUEST[id]&index=3.2&page=$_REQUEST[page]><img src=./images/drop.png border='0'></a></td>";
			echo "<Td align='center'>";
			if(!($M==1)){
			echo "<a href=?option=bets&task=main/test_master&index=6.6&id=$_REQUEST[id]&item_id=$result[id]&item_order_index=1&page=$_REQUEST[page]><img src=./images/uparrow.png border='0' alt='ขึ้นด้านบน'></a>";
			}
			if(!($M==$num_effect)){
			echo "<a href=?option=bets&task=main/test_master&id=$_REQUEST[id]&index=6.6&item_id=$result[id]&item_order_index=-1&page=$_REQUEST[page]><img src=./images/downarrow.png border='0' alt='ลงด้านล่าง'></a>";
			}
		}
		else{
		echo "<td></td><td></td>";
		}
		echo "</Td>";
		echo "</Tr>";
$M++;
	}
	echo "<tr bgcolor='#66FFFF'><td colspan='4'></td><td align='center'>รวม $score</td><td colspan='8'></td></tr>";
	if($result_ref['officer']==$officer){
	echo "<tr bgcolor='#66FFFF'><td colspan='4'></td><td><INPUT TYPE='button' name='smb' value='ปรับปรุง' onclick='goto_url2()'></td><td colspan='8'></td></tr>";
	}
	echo "</table>";
	echo "<INPUT TYPE='Hidden' name='id' value='$_REQUEST[id]'>";
	echo "<Input Type=Hidden Name='page' Value='$_REQUEST[page]'>";
	echo  "</form>";
}

if($index==8){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เลือกข้อคำถาม</strong></font></td></tr>";
echo "</table>";
//ส่วนของการแยกหน้า
if(($_REQUEST['class_index']=="") and ($_REQUEST['group_index']=="")){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and (bets_item.officer='$officer' or bets_item.remark='school')";
}
else if(($_REQUEST['class_index']!="") and ($_REQUEST['group_index']!="")){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_item.class_code='$_REQUEST[class_index]' and bets_group.group_code='$_REQUEST[group_index]' and (bets_item.officer='$officer' or bets_item.remark='school')";
}
else if($_REQUEST['class_index']!=""){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_item.class_code='$_REQUEST[class_index]' and (bets_item.officer='$officer' or bets_item.remark='school')";
}
else if($_REQUEST['group_index']!=""){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_group.group_code='$_REQUEST[group_index]' and (bets_item.officer='$officer' or bets_item.remark='school')";
}
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery); //นำไปแยกหน้า

$pagelen=20 ; // 1.กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/test_master&index=8&master_id=$_REQUEST[master_id]&master_page=$_REQUEST[master_page]&class_index=$_REQUEST[class_index]&group_index=$_REQUEST[group_index]";  // 2_กำหนดลิงค์ฺ
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
echo "<Tr>";
echo "<td align='left'>";
		echo "<form id='frm1' name='frm1'>";
		echo "<div align='left'>";
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
		
		echo "&nbsp;<INPUT TYPE='button' name='grp' value='เลือก' onclick='goto_url_update_2(0)'>";
		echo "</div>";
	//	echo "</form>";
		echo "</td><td align='right'><a href=?option=bets&task=main/test_master&index=7&id=$_REQUEST[master_id]&page=$_REQUEST[master_page]><<กลับ</a></td></Tr></Table>";
///	

echo  "<table width='95%' border='0' align='center'>";
if(($_REQUEST['class_index']=="") and ($_REQUEST['group_index']=="")){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and (bets_item.officer='$officer' or bets_item.remark='school') order by bets_item.id limit $start,$pagelen ";
}
else if(($_REQUEST['class_index']!="") and ($_REQUEST['group_index']!="")){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_item.class_code='$_REQUEST[class_index]' and bets_group.group_code='$_REQUEST[group_index]' and (bets_item.officer='$officer' or bets_item.remark='school') order by bets_item.indicator_code limit $start,$pagelen ";
}
else if($_REQUEST['class_index']!=""){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_item.class_code='$_REQUEST[class_index]' and (bets_item.officer='$officer' or bets_item.remark='school') order by bets_item.indicator_code limit $start,$pagelen ";
}
else if($_REQUEST['group_index']!=""){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_group.group_code='$_REQUEST[group_index]' and (bets_item.officer='$officer' or bets_item.remark='school') order by bets_item.indicator_code limit $start,$pagelen ";
}
$dbquery = mysqli_query($connect,$sql);
echo "<Tr bgcolor='#CC66FF' align='center'><Td width='50'>ที่</Td><td width='50'>เลือก<br><input type='checkbox' name='allchk' id='allchk' onclick='CheckAll()'><br>ทั้งหมด</td><td width='60'>ชั้น</td><td>คำถาม</td><Td width='50' align='center'>ประเภท</td><Td width='250'>ตัวชี้วัด</Td><Td width='60'>มาตรฐาน</Td><Td width='100'>สาระ</Td><Td  width='80'>กลุ่มสาระ</Td><Td width='60'>หลักสูตร</Td></Tr>";

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
		echo "<Tr bgcolor='$color' align='center' valign='top'><Td >$N</Td><td><input type='checkbox' name='$id' value='test_item'></td><td>$class_code</td><td align='left'>($id) $result[question]</td><td align='center'>$item_type</td><td align='left'>$result[indicator_text]</td><Td align='center'>$short_name</Td><Td align='left'>$substance_name</Td><Td align='left'>$group_name</Td><Td align='center'>$result[curriculum_code]</Td></tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</table>";	
echo "<Br>";
echo "<div align='center'>";
echo "<INPUT TYPE='Hidden' name='master_id' value='$_REQUEST[master_id]'>";
echo "<INPUT TYPE='Hidden' name='master_page' value='$_REQUEST[master_page]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update_2(1)'>";
echo "</div>";		
echo "</form>";
}

if($index==9){
$sql = "select *,bets_item.id,bets_item.class_code from bets_item,bets_indicator,bets_standard,bets_substance,bets_group,bets_curriculum where bets_item.indicator_code=bets_indicator.indicator_code and bets_indicator.standard_code=bets_standard.standard_code and bets_standard.substance_code=bets_substance.substance_code and bets_substance.group_code=bets_group.group_code and bets_group.curriculum_code=bets_curriculum.curriculum_code and bets_item.id='$_GET[item_id]'";
$dbquery_ref = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery_ref);
$class_code=$result_ref ['class_code'];
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>รายละเอียดข้อคำถาม</Font>";
echo "</Cener>";
//echo "<Br>";
echo "<Table width='80%' Border='0'>";
echo "<Tr><Td colspan='3' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=bets&task=main/test_master&index=7&id=$_GET[id]&page=$_GET[page]\"'></Td></Tr>";
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
echo "<td><font color='#006666'>$class_code</font></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>กลุ่มสาระ&nbsp;&nbsp;</Td>";
echo "<td>";
$sql = "select  * from bets_group where group_code='$result_ref[group_code]' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo  "<font color='#006666'>$result[group_name]</font>";
echo "</td></tr>";

echo "<Tr align='left'><Td></Td><Td align='right'>สาระ&nbsp;&nbsp;</Td><td align='left'>";
$sql = "select  * from bets_substance where substance_code='$result_ref[substance_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo  "<font color='#006666'>$result[substance_name]</font>" ;
echo "</td></tr>";

echo "<Tr align='left'><Td></Td><Td align='right'>มาตรฐาน&nbsp;&nbsp;</Td><td align='left'>";
$sql = "select  * from bets_standard where standard_code='$result_ref[standard_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo  "<font color='#006666'>$result[short_name]</font>" ;
echo "</td></tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวชี้วัด&nbsp;&nbsp;</Td><td align='left'>";
$sql = "select  * from bets_indicator where indicator_code='$result_ref[indicator_code]' order by id";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo  "<font color='#006666'>$result[indicator_text]</font>" ;
echo "</td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>คำถาม&nbsp;&nbsp;</Td>";
echo "<td><font color='#006666'>$result_ref[question]</font></td></tr>";

if($result_ref['item_type']==1){
echo "<Tr align='left'><Td ></Td><Td align='right'></Td><td align='left'>";
echo "<img src='$result_ref[pic_item]' border='0' width='70%'>" ;
echo "</td></tr>";
}
echo "<Tr align='left'><Td ></Td><Td align='right'>ตัวเลือกที่ถูก&nbsp;&nbsp;</Td>";
echo "<td>";
echo "<font color='#006666'>ตัวเลือกที่ $result_ref[right_answer]</font>";
echo "</td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>จำนวนตัวเลือก&nbsp;&nbsp;</Td>";
echo "<td>";
echo "<font color='#006666'>$result_ref[answer_num] ตัวเลือก</font>";
echo "</td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>หมายเหตุ&nbsp;&nbsp;</Td>";
echo "<td><font color='#006666'>$result_ref[remark]</font></td></tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7) or ($index==8) or ($index==9))){

//ส่วนของการแยกหน้า
$sql = "select * from bets_master_test where officer='$officer' ";
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery); //นำไปแยกหน้า

$pagelen=20 ; // 1.กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/test_master";  // 2_กำหนดลิงค์ฺ
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
$sql = "select *,bets_master_test.id,bets_master_test.officer from bets_master_test left join person_main on bets_master_test.officer=person_main.person_id where bets_master_test.officer='$officer' order by bets_master_test.id limit $start,$pagelen ";
$dbquery = mysqli_query($connect,$sql);
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มชุดข้อคำถาม' onclick='location.href=\"?option=bets&task=main/test_master&index=1\"'></Td>";
echo "</Tr>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>ที่</Td><Td>ชื่อ</Td><Td>รายละเอียด</Td><Td width='150'>เจ้าหน้าที่</Td><Td width='80'>ข้อ<br>คำถาม</Td><td width='50' align='center'>ลบ</td><Td width='50' align='center'>แก้ไข</Td></Tr>";

$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$master_name= $result['master_name'];
		$test_detail= $result['test_detail'];
		if(($M%2) == 0)
		$color="#FFFFC";
		else  	$color="#FFFFFF";
		
		echo "<Tr bgcolor='$color' align='center'><Td >$N</Td><Td align='left'>$master_name</Td><Td align='left'>$test_detail</Td>";
		echo "<td align='left'>$result[name] $result[surname]</td>";
		echo "<td><a href=?option=bets&task=main/test_master&id=$id&index=7&page=$page><img src=./images/b_browse.png border='0'></a></td>";
		if($result['officer']==$officer){
			echo "<td><a href=?option=bets&task=main/test_master&id=$id&index=2&page=$page><img src=./images/drop.png border='0'></a></td>";
			echo "<td><a href=?option=bets&task=main/test_master&id=$id&index=5&page=$page><img src=./images/edit.png border='0'></a></div></Td>";
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
		callfrm("?option=bets&task=main/test_master");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.master_name.value == ""){
			alert("กรุณากรอกชื่อชุดข้อคำถาม");
		}else{
			callfrm("?option=bets&task=main/test_master&index=4");   //page ประมวลผล
		}
	}
}

function goto_url2(){
callfrm("?option=bets&task=main/test_master&index=6.9");   //page ประมวลผล
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=bets&task=main/test_master");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.master_name.value == ""){
			alert("กรุณากรอกชื่อชุดข้อคำถาม");
		}else{
			callfrm("?option=bets&task=main/test_master&index=6");   //page ประมวลผล
		}
	}
}

function goto_url_update_2(val){
	if(val==0){
		callfrm("?option=bets&task=main/test_master&index=8");   // page ย้อนกลับ 
	}else if(val==1){
	callfrm("?option=bets&task=main/test_master&index=6.5");   //page ประมวลผล
	}
}

function CheckAll() {
	for (var i = 0; i < document.frm1.elements.length; i++)
	{
	var e = document.frm1.elements[i];
	if (e.name != "allchk")
		e.checked = document.frm1.allchk.checked;
	}
}

</script>
