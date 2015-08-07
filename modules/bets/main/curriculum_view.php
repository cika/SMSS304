<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if($result_permission['p1']!=1){
exit();
}

//ส่วนเพิ่มกลุ่มสาระ
if($index==1){
$sql = "select * from bets_curriculum where id='$_GET[cid]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);	

echo "<Br>";
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มกลุ่มสาระ</Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8' align='center'>";
echo "<Tr align='left'><Td ></Td><Td align='right'>หลักสูตรแกนกลาง&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='curriculum_name' Size='50' value='$ref_result[curriculum_name]' disabled='disabled'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ที่(กลุ่มสาระ)&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='group_no' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value='01'>กลุ่มสาระที่ 1</option>" ;
echo  "<option value='02'>กลุ่มสาระที่ 2</option>" ;
echo  "<option value='03'>กลุ่มสาระที่ 3</option>" ;
echo  "<option value='04'>กลุ่มสาระที่ 4</option>" ;
echo  "<option value='05'>กลุ่มสาระที่ 5</option>" ;
echo  "<option value='06'>กลุ่มสาระที่ 6</option>" ;
echo  "<option value='07'>กลุ่มสาระที่ 7</option>" ;
echo  "<option value='08'>กลุ่มสาระที่ 8</option>" ;
echo  "<option value='09'>กลุ่มสาระที่ 9</option>" ;
echo  "<option value='10'>กลุ่มสาระที่ 10</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อกลุ่มสาระ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='group_name' Size='50'></Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='Hidden' name='cid' value='$_GET[cid]'>";
echo "<INPUT TYPE='Hidden' name='c_code' value='$ref_result[curriculum_code]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)'>";
echo "</form>";
}

//ส่วนเพิ่มกลุ่มสาระ
if($index==2){
$_GET['cid']=$_POST['cid'];
$g_code=$_POST['c_code'].$_POST['group_no'];
$sql = "insert into bets_group(curriculum_code,group_code,group_name) values ('$_POST[c_code]','$g_code','$_POST[group_name]')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from bets_group where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแก้ไขข้อมูล
if($index==5){
$sql = "select * from bets_group where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);	
echo "<Br>";
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขกลุ่มสาระ</Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8' align='center'>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อกลุ่มสาระ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='group_name' Size='50' value='$ref_result[group_name]'></Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='Hidden' name='cid' value='$_GET[cid]'>";
echo "<INPUT TYPE='Hidden' name='id' value='$_GET[id]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'>";
echo "</form>";
}

//ส่วนแก้ไขข้อมูล
if($index==6){
$_GET['cid']=$_POST['cid'];
$sql = "update bets_group set group_name='$_POST[group_name]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

echo "<br>";
if(isset($_GET['cid']) && !isset($_GET['action'])){
	$sql = "select * from bets_curriculum where id='$_GET[cid]'";
	$dbquery = mysqli_query($connect,$sql);
	if(mysqli_num_rows($dbquery)==0){
		echo "<br /><center><h2><font color=red>ไม่พบข้อมูลหลักสูตร</font></h2></center>";
	}else{		
		$ref_result = mysqli_fetch_array($dbquery);	
		echo "<table width='90%' align='center'><tr><td>";
		echo "<br />&nbsp;&nbsp;<font color='#006666' size=4><b>หลักสูตร ". $ref_result[2] . "</b></font>";
		
		
if(isset($_GET['gcode'])){
$sql_list_sub='SELECT bets_curriculum . * , bets_group . * , bets_substance . * 
FROM bets_curriculum, bets_group, bets_substance
WHERE (bets_curriculum.curriculum_code=bets_group.curriculum_code 
and bets_group.group_code = bets_substance.group_code
and bets_substance.group_code =  "'.$_GET['gcode'].'")';

$data_gcode="";
$qry=mysqli_query($connect,$sql_list_sub);
if(mysqli_num_rows($qry)==0){
		$data_gcode= "<li>ไม่มีข้อมูลสาระการเรียนรู้</li>";		
		//echo "Select * from bets_group where group_code =  '".$_GET['gcode']."'";
		$g_name=mysqli_fetch_array(mysqli_query($connect,"Select * from bets_group where group_code =  '".$_GET['gcode']."'"));
		$g_name=$g_name['group_name'];
}else{
	$txt_show_header="";
	while($data_substance=mysqli_fetch_array($qry)){
		$data_gcode.= "<li><a href='?option=bets&task=main/curriculum_view&cid=".$_GET['cid']."&gcode=".$_GET['gcode']."&scode=".$data_substance['substance_code']."'>".$data_substance['substance_name']."</a>&nbsp;&nbsp; <img src='images/b_edit.png' border=0> &nbsp;&nbsp;<img src='images/b_drop.png' border=0></li>";
		$g_name=$data_substance['group_name'];
		$txt_show_header=($data_substance['substance_code']==@$_GET['scode'])?$data_substance['substance_name']:$txt_show_header;
	}	
}
$data_gcode="<a href='?option=bets&task=main/curriculum_view&cid=".$_GET['cid']."&gcode=".$_GET['gcode']."'><b><font color=green>ข้อมูลสาระการเรียนรู้</font></b></a><hr>".$data_gcode.'<hr><strong><a href="?option=bets&task=main/curriculum_view&cid='.$_GET['cid'].'&gcode='.$_GET['gcode'].'&action=addsubstance"><img src="images/add.gif" width=12 border=0> เพิ่มข้อมูลสาระการเรียนรู้</a></strong>';
}		
?>
<br />
<!-- cid -->
    <fieldset style="background-color:#eef">
    	<legend>
        <font size=3>&nbsp; <a href="?option=bets&task=main/curriculum_view&cid=<?php echo $_GET['cid'];?>">กลุ่มสาระการเรียนรู้</a> : &nbsp;
        <?php if(isset($_GET['gcode'])){ echo "&nbsp;".$g_name."&nbsp;";} ?> </font>
        &nbsp; <strong><a href="?option=bets&task=main/curriculum_view&cid=<?php echo $_GET['cid'];?>&index=1"><img src="images/add.gif" width=12 border=0> เพิ่มข้อมูลกลุ่มสาระการเรียนรู้</a></strong>&nbsp; 
        </legend>
        <ul>
          <?php
if(isset($_GET['gcode'])){	echo $data_gcode;	}else{
$sq_list_cc="SELECT  `bets_curriculum`. * ,  `bets_group`. * , `bets_group`.id  FROM  `bets_curriculum` ,  `bets_group` WHERE bets_group.curriculum_code = bets_curriculum.curriculum_code AND (bets_curriculum.id =".$_GET['cid'].");";

$qry=mysqli_query($connect,$sq_list_cc);
if(mysqli_num_rows($qry)<=0){
	echo "<h3 style='color:red;'>ไม่มีข้อมูลกลุ่มสาระการเรียนรู้</h3>";
}else{
	//echo $_GET['gcode']."ss";
	while($c_list=mysqli_fetch_array($qry)){
		if((@$_GET['gcode'])==$c_list['group_code']){
			$group_x_name=$c_list['group_name'];
			echo "<li><B>".$c_list['group_name']."</B></li>\n";
		}else{
			echo "<li><a href='?option=bets&task=main/curriculum_view&cid=".$_GET['cid']."&gcode=".$c_list['group_code']."'>".$c_list['group_name']."</a> <<a href='?option=bets&task=main/curriculum_view&index=5&id=$c_list[id]&cid=$_GET[cid]'><font color=green>แก้ไข</font></a>> <<a href='?option=bets&task=main/curriculum_view&index=3&id=$c_list[id]&cid=$_GET[cid]'><font color=red>ลบ</font></a>></li>\n";
		}
	}
?>
          <!--li>ภาษาไทย</li-->            
<?php
	}
}
?>
        </ul>
        
	</fieldset>
<!-- cid -->    


<!-- sid -->   
<?php
if(isset($_GET['scode'])){
	$sql_list_standard="SELECT bets_curriculum . * , bets_group . * , bets_substance . * , bets_standard.*";
	$sql_list_standard.=" FROM bets_standard, bets_curriculum, bets_group, bets_substance";
	$sql_list_standard.=" WHERE bets_curriculum.curriculum_code = bets_group.curriculum_code";
	$sql_list_standard.=" AND bets_group.group_code = bets_substance.group_code";
	$sql_list_standard.=" AND bets_substance.substance_code = bets_standard.substance_code";
	$sql_list_standard.=" AND bets_standard.substance_code =  '".$_GET['scode']."'";	
	//echo $sql_list_standard;
	$URI=explode("&sdcode",$_SERVER['REQUEST_URI']);
	$URI=$URI[0];	$qry_scode = mysqli_query($connect,$sql_list_standard);
	$sd_in_indicator="";
	if(mysqli_num_rows($qry_scode)<=0){
		$txt_showlist="<li>ไม่มีข้อมูลมาตรฐานการเรียนรู้</li>";
	}else{
		$txt_showlist="";
		while($data_show_scode = mysqli_fetch_array($qry_scode))
		{

			$txt_showlist.= "<li><a href='".$URI."&sdcode=".$data_show_scode['standard_code']."'>".$data_show_scode['short_name']."</a> ".$data_show_scode['standard_text']."</li>\n";
			$sd_in_indicator = ($data_show_scode['standard_code']==@$_GET['sdcode'])?$data_show_scode['short_name']:$sd_in_indicator;
			
		}
	}
		$txt_showlist=$txt_showlist.'<hr><strong><a href="?option=bets&task=main/curriculum_view&cid='.$_GET['cid'].'&gcode='.$_GET['gcode'].'&scode='.$_GET['scode'].'&action=addstandard"><img src="images/add.gif" width=12 border=0> เพิ่มมาตรฐานการเรียนรู้</a></strong>';	
?> 
<fieldset>
        	<legend>&nbsp; <B>มาตรฐานการเรียนรู้ </em></B>: <?php echo $txt_show_header;?>&nbsp;</legend>
        <ul>
        	<?php echo $txt_showlist;?>
        </ul>  
        
        
<!-- sdcode -->
<?php
if(isset($_GET['sdcode'])){
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="250"  valign="top">
    <fieldset>
    	<legend><B>&nbsp; ตัวชี้วัดระดับชั้น : &nbsp;</B></legend>
<?php
$URI=explode("&clcode",$_SERVER['REQUEST_URI']);
$URI=$URI[0];
?>        
        <ul>
        	<li><a href="<?php echo $URI;?>&clcode=ป.๑">ประถมศึกษาปีที่ ๑ (ป.๑)</a></li>
        	<li><a href="<?php echo $URI;?>&clcode=ป.๒">ประถมศึกษาปีที่ ๒ (ป.๒)</a></li>
        	<li><a href="<?php echo $URI;?>&clcode=ป.๓">ประถมศึกษาปีที่ ๓ (ป.๓)</a></li>
        	<li><a href="<?php echo $URI;?>&clcode=ป.๔">ประถมศึกษาปีที่ ๔ (ป.๔)</a></li>
        	<li><a href="<?php echo $URI;?>&clcode=ป.๕">ประถมศึกษาปีที่ ๕ (ป.๕)</a></li>
        	<li><a href="<?php echo $URI;?>&clcode=ป.๖">ประถมศึกษาปีที่ ๖ (ป.๖)</a></li>
        	<li><a href="<?php echo $URI;?>&clcode=ม.๑">มัธยมศึกษาปีที่ ๑ (ม.๑)</a></li>
        	<li><a href="<?php echo $URI;?>&clcode=ม.๒">มัธยมศึกษาปีที่ ๒ (ม.๒)</a></li>
        	<li><a href="<?php echo $URI;?>&clcode=ม.๓">มัธยมศึกษาปีที่ ๓ (ม.๓)</a></li>
        	<li><a href="<?php echo $URI;?>&clcode=ม.๔-๖">มัธยมศึกษาปีที่ ๔-๖ (ม.๔-๖)</li>
        </ul>
          <!--form id="form1" name="form1" method="post" action="">          	
            <br />
            <b>เพิ่มระดับชั้น</b> : <br />&nbsp;&nbsp;<input type="text" name="d" /> <br />
            &nbsp;&nbsp;<input type="submit" value="บันทึก" />
            <input type="reset" value="Reset" />
        </form-->
	</fieldset>
</td>
    <td valign="top">    <fieldset>
    	<legend>
        <B>&nbsp; รายละเอียดตัวชี้วัด : &nbsp; <?php echo $sd_in_indicator."&nbsp;&nbsp;";echo isset($_GET['clcode'])?$_GET['clcode']:"";?>&nbsp;</B></legend>
<?php
$txt_show_indicator="";
if(isset($_GET['clcode'])){
	$sql_list_indicator="Select * from bets_indicator where standard_code='".$_GET['sdcode']."' and class_code='".$_GET['clcode']."'";
	$qry_indicator=mysqli_query($connect,$sql_list_indicator);
	if(mysqli_num_rows($qry_indicator)<=0){
		$txt_show_indicator = "<h3 style='color:red'>ไม่มีขัอมูลตัวชี้วัด</h3>";	
	}else{
		while($data_indicator=mysqli_fetch_array($qry_indicator)){
			$txt_show_indicator .= "<li style='list-style:none'>".$data_indicator['indicator_text']."</li>\n";	
		}
	}
}else{
	$txt_show_indicator = "<h3 style='color:green'><< == โปรดเลือกระดับชั้น</h3>";
}
?>
        <ul>
        <?php echo $txt_show_indicator;?>
        	<!--li style="list-style:none">๑. เปรียบเทียบความแตกต่างระหว่างสิ่งมีชีวิตกับสิ่งไม่มีชีวิต</li-->
        </ul>
<?php
if(isset($_GET['clcode'])){
?>        
        <form id="form1" name="form1" method="post" action="">          	
            <br />
            <input name="class_code" type="hidden" value="<?php echo @$_GET['clcode'];?>" />
            <input name="standard_code" type="hidden" value="<?php echo @$_GET['sdcode'];?>" />
            <b>เพิ่มตัวชี้วัด</b> : <br />&nbsp;&nbsp;<textarea name="indicator_txt" cols="50" rows="3" wrap="virtual" autofocus="autofocus"></textarea> <br />
            &nbsp;&nbsp;<input type="submit" value="บันทึก" />
            <input type="reset" value="Reset" />
        </form>
	</fieldset>
<?php
}
?>
    </td>
  </tr>
</table>

<?php
}
?>              
</fieldset>   
<?php
}//end of if scode
?>
<!-- sid -->

<?php
	//echo "</td></tr></table>";
	
	}
}
?>
<?php
if(isset($_GET['cid']) && isset($_GET['action']) &&!isset($_POST['save_addC'])){
	if($_GET['action']=='add')
	{
		$sql="Select * from bets_curriculum where id =".$_GET['cid'];	
		$qry=mysqli_query($connect,$sql);
		if(mysqli_num_rows($qry)<=0){
			echo "<center><br><br> <h2 style='color:#ff0000;'>ข้อมูลที่รับมาไม่ถูกต้อง...กรุณาตรวจสอบรายการอีกครั้ง</h2></center>";
		}else{
		$data_qry=mysqli_fetch_assoc($qry);
		?>
		<form action="" method="post">
		<table width="500" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td colspan="2" align="center"><Font color="#006666" Size="3">เพิ่มข้อมูลกลุ่มสาระการเรียนรู้</Font></td>
		  </tr>
		  <tr>
			<td>กลุ่มสาระ : </td>
			<td><input type=text name=gname size=55 autofocus="autofocus" value= /></td>
		  </tr>
		  <tr>
			<td colspan="2" align="center">
				<input type="submit" name="save_addC" value="บันทึกข้อมูล"/>&nbsp;&nbsp;
				<input type="reset" name="reset" value="ยกเลิก" onclick="javascript:history.back(1);"/>
			</td>
		  </tr>
		</table>
		</form>
<?php	
		}	//end of select data
   }	//end of if($_GET['action']=='add')
   
?>
<?php   
	if($_GET['action']=='addsubstance')
	{
		$sql="SELECT `bets_curriculum`.*, `bets_group`.* FROM `bets_curriculum`, `bets_group` where group_code='".$_GET['gcode']."'";
		/*echo $sql;*/
		$qry=mysqli_query($connect,$sql);
		if(mysqli_num_rows($qry)<=0){
			echo "<center><br><br> <h2 style='color:#ff0000;'>ข้อมูลที่รับมาไม่ถูกต้อง...กรุณาตรวจสอบรายการอีกครั้ง</h2></center>";
		}else{
		$data_qry=mysqli_fetch_assoc($qry);
		?>
		<form action="" method="post">
		<table width="500" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td colspan="2" align="center">เพิ่มข้อมูลกลุ่มสาระการเรียนรู้</td>
		  </tr>
		  <tr>
			<td>หลักสูตร : </td>
			<td>
            <input type=text name=cname size=55 disabled="disabled" value="<?php echo $data_qry['curriculum_code'];?> : <?php echo $data_qry['curriculum_name'];?>"/>
            <input type="hidden" name="cid" value="<?php echo $_GET['cid'];?>" />
            <input type="hidden" name="ccid" value="<?php echo $data_qry['group_code'];?>" /></td>
		  </tr>
		  <tr>
			<td>กลุ่มสาระ : </td>
			<td><input type=text name=gname size=55 value="<?php echo $data_qry['group_code'];?> : <?php echo $data_qry['group_name'];?>" disabled="disabled"/></td>
		  </tr>
          
		  <tr>
			<td>สาระการเรียนรู้ : </td>
			<td><input type=text name=substance_name size=55 autofocus="autofocus" /><input type="hidden" name="ccid" value="<?php echo $data_qry['group_code'];?>" /></td>
		  </tr>          
		  <tr>
			<td colspan="2" align="center">
				<input type="submit" name="save_addS" value="บันทึกข้อมูล"/>&nbsp;&nbsp;
				<input type="reset" name="reset" value="ยกเลิก" onclick="javascript:history.back(1);"/>
			</td>
		  </tr>
		</table>
		</form>
<?php	
		}	//end of select data
   }	//end of if($_GET['action']=='addsubstance')   
?>

<?php   
	if($_GET['action']=='addstandard' && !isset($_POST['save_addSD']))
	{
		$sql="SELECT bets_curriculum. * , bets_group. * , bets_substance. * ";
		$sql.=" FROM bets_curriculum, bets_group, bets_substance";
		$sql.=" WHERE bets_curriculum.curriculum_code = bets_group.curriculum_code";
		$sql.=" AND bets_group.group_code = bets_substance.group_code";
		$sql.=" AND substance_code =  '".$_GET['scode']."'";
		
		//echo $sql;
		$qry=mysqli_query($connect,$sql);
		if(mysqli_num_rows($qry)<=0){
			echo "<center><br><br> <h2 style='color:#ff0000;'>ข้อมูลที่รับมาไม่ถูกต้อง...กรุณาตรวจสอบรายการอีกครั้ง</h2></center>";
		}else{
		$data_qry=mysqli_fetch_assoc($qry);
		?>
		<form action="" method="post">
		<table width="500" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td colspan="2" align="center"><h2>เพิ่มมาตรฐานการเรียนรู้</h2></td>
		  </tr>
		  <tr>
			<td>หลักสูตร : </td>
			<td>
            <input type=text name=cname size=55 disabled="disabled" value="<?php echo $data_qry['curriculum_code'];?> : <?php echo $data_qry['curriculum_name'];?>"/>
            <input type="hidden" name="cid" value="<?php echo $_GET['cid'];?>" />
            <input type="hidden" name="ccid" value="<?php echo $data_qry['group_code'];?>" /></td>
		  </tr>
		  <tr>
			<td>กลุ่มสาระ : </td>
			<td><input type=text name=gname size=55 value="<?php echo $data_qry['group_code'];?> : <?php echo $data_qry['group_name'];?>" disabled="disabled"/></td>
		  </tr>
          
		  <tr>
			<td>สาระการเรียนรู้ : </td>
			<td><input type=text name=substance_name size=55 disabled="disabled" value="<?php echo $data_qry['substance_name'];?>" /></td>
		  </tr>   
		  <tr>
			<td>ชื่อย่อ : </td>
			<td><input type=text name=short_name size=15 autofocus="autofocus" /><input type="hidden" name="scode" value="<?php echo $data_qry['substance_code'];?>" /></td>
		  </tr> 
		  <tr>
			<td>มาตรฐานการเรียนรู้ : </td>
			<td><textarea name="standard_txt" cols="35" rows="3" wrap="virtual"></textarea></td>
		  </tr>                            
		  <tr>
			<td colspan="2" align="center">
				<input type="submit" name="save_addSD" value="บันทึกข้อมูล"/>&nbsp;&nbsp;
				<input type="reset" name="reset" value="ยกเลิก" onclick="javascript:history.back(1);"/>
			</td>
		  </tr>
		</table>
		</form>
<?php	
		}	//end of select data
   }	//end of if($_GET['action']=='addsubstance')   
?>

<?php   
}	
?>
<?php
//Save bets_group
if(isset($_POST['save_addC'])){
	$curriculum_code=($_POST['cid']);
	$group_code=mysqli_fetch_assoc(mysqli_query($connect,"SELECT max(group_code) as x FROM bets_group where curriculum_code='$_POST[cid]'"));
	$group_code=$group_code['x']+1;
	$group_name=($_POST['gname']);
	$sql="Insert into bets_group(curriculum_code,group_code,group_name) Values('$curriculum_code','$group_code','$group_name')";
	
//	echo $sql;
if(mysqli_query($connect,$sql))
{
	echo "<center><br><br> <h2 style='color:GREEN;'>บันทึกข้อมูลสำเร็จ</h2></center>";
	echo '<META HTTP-EQUIV="Refresh" CONTENT="1;URL=?option=bets&task=main/curriculum_view&cid='.$_POST['ccid'].'">';
}else{
	echo "<center><br><br> <h2 style='color:#ff0000;'>ไม่สามารถบันทึกข้อมูลได้...กรุณาตรวจสอบรายการอีกครั้ง</h2></center>";	
}
}
?>
<?php
/*Save substance*/

if(isset($_POST['save_addS'])){
	$curriculum_code=($_POST['cid']);
	$group_code=($_POST['ccid']);
	$substance_code=mysqli_fetch_assoc(mysqli_query($connect,"SELECT max(substance_code) as x FROM bets_substance where group_code='$_POST[ccid]'"));
	$substance_code = $substance_code['x']==0?$group_code."01":$substance_code['x']+1;
	$substance_name = htmlspecialchars($_POST['substance_name']);
	$sql="Insert into bets_substance Values('','$group_code','$substance_code','$substance_name')";
	
	//echo $sql;
	//echo '<META HTTP-EQUIV="Refresh" CONTENT="1;URL=?option=bets&task=main/curriculum_view&cid='.$_POST['cid'].'&gcode='.$_POST['ccid'].'">';
if(mysqli_query($connect,$sql))
{
	echo "<center><br><br> <h2 style='color:GREEN;'>บันทึกข้อมูลสำเร็จ</h2></center>";
	echo '<META HTTP-EQUIV="Refresh" CONTENT="1;URL=?option=bets&task=main/curriculum_view&cid='.$_POST['cid'].'&gcode='.$_POST['ccid'].'">';
}else{
	echo "<center><br><br> <h2 style='color:#ff0000;'>ไม่สามารถบันทึกข้อมูลได้...กรุณาตรวจสอบรายการอีกครั้ง</h2></center>";	
}
}

?>

<?php
/*Save substance*/

if(isset($_POST['save_addSD'])){
	$curriculum_code = ($_POST['cid']);
	$group_code = ($_POST['ccid']);
	$substance_code = ($_POST['scode']);
	$standard_code = "";
	$standard_code=mysqli_fetch_assoc(mysqli_query($connect,"SELECT max(standard_code) as x FROM bets_standard where substance_code='$_POST[scode]'"));
	$standard_code=$standard_code['x']==0?$substance_code."01":$standard_code['x']+1;	
	$short_name = htmlspecialchars($_POST['short_name']);
	$standard_text = htmlspecialchars($_POST['standard_txt']);
	$sql="Insert into bets_standard Values('','$substance_code','$standard_code','$short_name','$standard_text')";

	//echo $sql;
	//echo '<META HTTP-EQUIV="Refresh" CONTENT="1;URL=?option=bets&task=main/curriculum_view&cid='.$_POST['cid'].'&gcode='.$_POST['ccid'].'">';
if(mysqli_query($connect,$sql))
{
	echo "<center><br><br> <h2 style='color:GREEN;'>บันทึกข้อมูลสำเร็จ</h2></center>";
	echo '<META HTTP-EQUIV="Refresh" CONTENT="1;URL=?option=bets&task=main/curriculum_view&cid='.$_POST['cid'].'&gcode='.$_POST['ccid'].'&scode='.$_POST['scode'].'">';
}else{
	echo "<center><br><br> <h2 style='color:#ff0000;'>ไม่สามารถบันทึกข้อมูลได้...กรุณาตรวจสอบรายการอีกครั้ง</h2></center>";	
}
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=bets&task=main/curriculum_view&cid=<?php echo $_GET['cid'] ?>");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.group_no.value == ""){
			alert("กรุณาเลือกที่กลุ่มสาระ");
		}else if(frm1.group_name.value==""){
			alert("กรุณากรอกชื่อกลุ่มสาระ");
		}else{
			callfrm("?option=bets&task=main/curriculum_view&index=2");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=bets&task=main/curriculum_view&cid=<?php echo $_GET['cid'] ?>");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.group_name.value == ""){
			alert("กรุณากรอกชื่อกลุ่มสาระ");
		}else{
			callfrm("?option=bets&task=main/curriculum_view&index=6");   //page ประมวลผล
		}
	}
}

</script>
