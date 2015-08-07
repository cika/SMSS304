<?php
@ini_set('display_errors', '0');
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
include "modules/$_REQUEST[option]/inc.php";
if(!isset($_GET['class_now'])){
$_GET['class_now']="";
}
if(!isset($_GET['kw'])){
$_GET['kw']="";
}
if(!isset($_GET['room_now'])){
$_GET['room_now']="";
}

function make_time($date){
		if(!isset($date)){
		return;
		}
	$f_date=explode("-", $date);
	$time=mktime(0, 0, 0, $f_date[1], $f_date[2], $f_date[0]);
	return $time;
}

//part
		$sql_part = "select * from student_inclass_part where ed_year='$year_active' ";
		$dbquery_part = mysqli_query($connect,$sql_part);
		While ($result_part = mysqli_fetch_array($dbquery_part)){
		$part_start[$result_part['part']]=$result_part['start_date'];  //วันเปิดเทอม
		$part_stop[$result_part['part']]=$result_part['stop_date'];  //วันปิดเทอม
		}
		
//subject
		$sql_subject = "select * from student_inclass_subject where id='$_GET[id]'";
		$dbquery_subject = mysqli_query($connect,$sql_subject);
		$result_subject = mysqli_fetch_array($dbquery_subject);
		$subject_part=$result_subject['part'];  //ภาคเรียนที่รายวิชาสอน
		$ref_id=$result_subject['ref_id'];

#ส่วนหัว
echo "<br /><table width='95%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>สถิติการเข้าเรียนของนักเรียนตามรายวิชา  ปีการศึกษา $txtyear_active</strong></font></td></tr>";
echo "</table>";
echo "<table width='40%' border='0' align='center'>
<TR>
	<TD width='50%' valign='top'>
	<fieldset>
    <legend>&nbsp; <B>เลือกรายวิชา</B>: &nbsp;</legend>";
/*	
 '.$changeRoom.'</fieldset>
 */
$sql = "select *,student_inclass_subject.id from student_inclass_subject left join student_main_class on student_inclass_subject.std_class=student_main_class.class_code where student_inclass_subject.officer='$_SESSION[login_user_id]' and student_inclass_subject.ed_year='$year_active' order by student_inclass_subject.ed_year,student_inclass_subject.part,student_inclass_subject.std_class,student_inclass_subject.room";
$dbquery = mysqli_query($connect,$sql);
$num_row=mysqli_num_rows($dbquery);
		if($num_row==0){
		echo "<script>alert('ไม่มีรายวิชาใด ๆ ต้องไปที่เมนูรายวิชา แล้วกำหนดรายวิชาที่สอน');</script>\n";
		exit();
		}
echo "<B>รายวิชา</B>  <select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
echo "<option  value = ''>เลือก</option>";
While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['id'];
		$ref_id = $result['ref_id'];
		$subject = $result['subject'];
		$class_name = $result['class_name'];
		$std_class = $result['std_class'];
		$room = $result['room'];
			if($room!=0){ 
			$class_txt=$class_name."/".$room;
			}
			else{
			$class_txt=$class_name;
			}
if($_GET['id']==$id){
$select="selected";
}
else{
$select="";
}
echo "<option  value=?option=student_inclass&task=main/report_subject&id=$id&class_now=$std_class&room_now=$room $select>$subject $class_txt</option>";
}
echo "</select>";
echo "</fieldset>";
echo "</TD></TR></TABLE>";


$kw=str_replace("%"," ",$_GET['kw']);
$kw=str_replace(" ","",$kw);
if($_GET['class_now']!="" OR ($_GET['kw']!="" && $_GET['kw']!='%')){

	if($_GET['class_now']!=""){
	$class_now=$_GET['class_now'];
	$room_now=($_GET['room_now']=="")?0:$_GET['room_now'];
	$sql="SELECT *  FROM `student_main` where status='0' AND `class_now` = $class_now AND `room` = $room_now  ";
	$url_link="option=student_inclass&task=main/report_subject&class_now=$class_now&room_now=$room_now";  // 2_กำหนดลิงค์
	}
#Order by id
	if($kw!="" && $kw!='%'){
	$sql="SELECT *  FROM `student_main` where status='0' AND name like'%$kw%' or surname like'%$kw%' or student_id like'%$kw%' or person_id like'%$kw%'";
	$url_link="option=student_inclass&task=main/report_subject&kw=$kw";  // 2_กำหนดลิงค์
	}
	
$pagelen=50;  // 1_กำหนดแถวต่อหน้า

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );  
$totalpages=ceil($num_rows/$pagelen);

if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
if($_REQUEST['page']==""){
$page=1;//$totalpages;
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
$start=(!$page)?0:($page-1)*$pagelen;

			$changePages="<B>เลือก  </B><select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
			$changePages==$changePages."<option  value=\"\">หน้า</option>";
				for($p=1;$p<=$totalpages;$p++){
					$seled=($p!=$page)?"":"selected";
					$changePages=$changePages."<option  value=\"?$url_link&page=$p\" $seled> หน้า $p </option>\n";
				}
			$changePages=$changePages."</select>";
$changePages=($totalpages<=1)?"":"$changePages";

?>
<TABLE width='95%' align=center>
<TR>
	<TD COLSPAN=3 align=left><B><font color='#006666' size='2'><?php $room=($_GET['room_now']=="" || $_GET['room_now']==0)?"":"/".$_GET['room_now']; echo ($_GET['class_now']!="")?"ชั้น ". $edu_level[$_GET['class_now']].$room."&nbsp;&nbsp;".$changePages:"";?></font></B></TD>
	<TD COLSPAN=5 align=right><?php echo ($_GET['kw']!="")?"<B><font color='#006666' size='2'>ผลการค้นหา '$_GET[kw]' </font></b>&nbsp;&nbsp;".$changePages:"";?></TD>
</TR>
<TR  bgcolor='#FFCCCC'>
	<TD width=40 align=center><B>ที่</B></TD>
	<TD width=100 align=center><B>รหัสประจำตัว</B></TD>
	<TD width=40 align=center><B>เลขที่</B></TD>
	<TD align=center><B>ชื่อ - สกุล</B></TD>
<?php	
		for($i=0;$i<count($a_val_txt);$i++)
				{	
			echo "<TD align=center><B>".$a_val_txt[$i]."</B></TD>";
				}
		?>
	<TD align=center width=60 ><B>รายการ</B></TD>
</TR>
<?php
		$M=1;
		$N=(($page-1)*$pagelen)+1;  //

	
	$sql=$sql."  Order By class_now,room,student_number ASC LIMIT $start,$pagelen";
	$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		{
			$color=(($M%2) == 0)?" class='even'":" class='odd'";
			#$color=($result[status]==0)?"  class='out'":$color;
			$room=($result['room']=="" || $result['room']==0)?"":"/".$result['room'];
			echo"<TR $color>
				<TD align=right>$N</TD>
				<TD align=center>$result[student_id]<INPUT TYPE=hidden name=student_id[] value=$result[student_id]></TD>
				<TD align=center>$result[student_number]</TD>
				<TD><B>$result[prename] $result[name]  $result[surname]</B> &nbsp;&nbsp;(".$edu_level[$result['class_now']]."$room)</TD>";
			#$a_val=array("0" => "C", "1" => "W", "2" => "S", "3" => "L");
			#$a_val_txt=array("0" => "มา", "1" => "ลา", "2" => "ป่วย", "3" => "ขาด");
			$e="";
						#$sql_val="Select COUNT(student_id) AS STD_NUMS from student_check_main Where check_val='$a_val[$i]' and student_id='$result[student_id]' AND student_check_year='$year_active'";
$sql_val="Select * from student_inclass_main Where student_id='$result[student_id]' AND student_check_year='$year_active' and check_date >='$part_start[$subject_part]' and check_date<='$part_stop[$subject_part]' ";
						$query_val=mysqli_query($connect,$sql_val);
						
			for($i=0;$i<count($a_val);$i++)
					{
						$$a_val[$i]=0;
					}
						$rNums=mysqli_num_rows($query_val);
						while($rsNums=$rNums=mysqli_fetch_array($query_val))
								{
/////////////////////////////////////////////////////////////////////								
		/*
								//วันเข้าเรียน
								$check_date=make_time($rNums['check_date']);
								$check_day = getdate($check_date);
								$day=$check_day['weekday'];
								
								$sql_ref = "select * from student_inclass_ref where ref_id='$ref_id'";
								$dbquery_ref = mysqli_query($connect,$sql_ref);
								While ($result_ref = mysqli_fetch_array($dbquery_ref)){
								$ed_day=$result_ref['ed_day'];
								$period=$result_ref['period'];
										$xval=explode(',',$rsNums['check_val']);
										for($i=0;$i<(count($xval));$i++){
											$yval=explode(':',$xval[$i]);
											$it=$i+1;  //คาบที่
												if($ed_day==$day and $period==$it){
														for($x=0;$x<count($a_val);$x++){	
																if($yval[1]==$a_val[$x]){
																$$a_val[$x]=$$a_val[$x]+1;
																}
														}
													}
											}
										}
			*/
				//วันเข้าเรียน ////////////////////////////////////
				$check_date=make_time($rsNums['check_date']);
				$check_day = getdate($check_date);
				$day=$check_day['weekday'];

				$sql_ref = "select * from student_inclass_ref where ref_id='$result_subject[ref_id]' and ed_day='$day' ";
				$dbquery_ref = mysqli_query($connect,$sql_ref);
				$d_num=mysqli_num_rows($dbquery_ref);
									if($d_num>0){
									////////////////////
									$rp=explode(',',$rsNums['check_val']);			
													for($ix=0;$ix<$num_period;$ix++){
													$period_check=0;
													$ixt=$ix+1;  //คาบที่
															$sql_ref2 = "select * from student_inclass_ref where ref_id='$result_subject[ref_id]' and ed_day='$day' ";
															$dbquery_ref2 = mysqli_query($connect,$sql_ref2);
															While ($result_ref2 = mysqli_fetch_array($dbquery_ref2)){
															$ref_period=$result_ref2['period'];
																	if($ref_period==$ixt){
																	$tmp_val=explode(":",$rp[$ix]);
																
																				for($i=0;$i<count($a_val);$i++){
																				
																						if($tmp_val[1]==$a_val[$i]){
																						$period_check=$period_check+1;
																						$$a_val[$i]=$$a_val[$i]+1;
																						}
																				 }
																		 } //if
																}//while	
														if($period_check==0){
														}	
														} //for
									///////////////////	
									} //if
										
///////////////////////////////////////////////////////////////										
								}
			for($i=0;$i<count($a_val);$i++)
					{
						$e=$e. "<TD align=center>".$$a_val[$i]."</TD>";
					}
					echo $e;
			$img_detail="<a href='?option=student_inclass&task=main/report_subject&index=detail&student_id=$result[student_id]&id=$_GET[id]'><img src=./images/browse.png title=รายละเอียด... border=0></a>";

			echo"	<TD align=center>$img_detail</TD>
			</TR>";
			$M++;
			$N++;
		}#while
}
if($index=="detail")
{
$student_id=$_GET['student_id'];
$sql="Select * From student_main where status='0' AND student_id='$student_id' ";
$query=mysqli_query($connect,$sql);
if(mysqli_num_rows($query)!=0)
	{
	$data=mysqli_fetch_assoc($query);
	$room=($data['room']=="" || $data['room']==0)?"":"/".$data['room'];
?>
<table width=95% border=0 align=center>
<TR>
	<TD width=30% valign=top>
	<fieldset>
    <legend>&nbsp; <B>ข้อมูลนักเรียน: </B> &nbsp;</legend>
	<B>รหัสประจำตัวนักเรียน : <FONT COLOR="#003399"><?php echo $student_id."";?></FONT></B> <BR>
	<B>ชื่อ - สกุล : <FONT COLOR="#003399"><?php echo $data['prename'].$data['name']."  ".$data['surname'];?></FONT></B> <BR>
	<B>ห้องเรียน : <FONT COLOR="#003399"><?php echo $edu_level[$data['class_now']].$room;?></FONT> 
	เลขที่ : <FONT COLOR="#003399"><?php echo $data['student_number'];?></FONT></B> 
<BR>
<BR>
		<TABLE width=95% align=center>
		<TR bgcolor='#FFCCCC'>
			<TD align=center><B>สถานะการเข้าชั้นเรียน</B></TD>
			<TD align=center><B>จำนวน (ครั้ง)</B></TD>
			<TD align=center><B>ร้อยละ</B></TD>
		</TR>
<?php
$sql_d="Select * From student_inclass_main where student_id='$student_id' and student_check_year='$year_active' and check_date >='$part_start[$subject_part]' and check_date<='$part_stop[$subject_part]'";
$query_d=mysqli_query($connect,$sql_d);
if(mysqli_num_rows($query_d)==0)
		{
			echo"<TR bgcolor='#F3F3F3'>
			<TD Colspan=3 align=center><B><FONT COLOR='#FF0000'>ยังไม่มีข้อมูล</FONT></B> &nbsp;&nbsp;</TD></TR>";
		}else
		{
$r_val=array();
$all_rows=0;
			while($result_d=mysqli_fetch_assoc($query_d)){
/////////////////////////////////////////////////////////////////////////////								
				//วันเข้าเรียน ////////////////////////////////////
				$check_date=make_time($result_d['check_date']);
				$check_day = getdate($check_date);
				$day=$check_day['weekday'];
								
				$sql_ref = "select * from student_inclass_ref where ref_id='$result_subject[ref_id]' and ed_day='$day' ";
				$dbquery_ref = mysqli_query($connect,$sql_ref);
				$d_num=mysqli_num_rows($dbquery_ref);
									if($d_num>0){
									////////////////////
									$rp=explode(",",$result_d['check_val']);
														
													for($ix=0;$ix<$num_period;$ix++){
													$period_check=0;
													$ixt=$ix+1;  //คาบที่
															$sql_ref2 = "select * from student_inclass_ref where ref_id='$result_subject[ref_id]' and ed_day='$day' ";
															$dbquery_ref2 = mysqli_query($connect,$sql_ref2);
															While ($result_ref2 = mysqli_fetch_array($dbquery_ref2)){
															$ref_period=$result_ref2['period'];
																	if($ref_period==$ixt){
																	$tmp_val=explode(":",$rp[$ix]);
																				for($i=0;$i<count($a_val);$i++){
																						if($tmp_val[1]==$a_val[$i]){
																						$period_check=$period_check+1;
																						$r_val[$i]=$r_val[$i]+1;
																						$all_rows++;
																						}
																				 }
																		 } //if
																}//while	
														if($period_check==0){
														//echo "<td></td>";
														}	
														} //for
									///////////////////	
									} //if
////////////////////////////////////////////////////////////////////////////								
								} //while
						
			for($i=0;$i<count($a_val);$i++)
					{
						$color=(($i%2) == 0)?" class='even'":" class='odd'";
						echo "<TR $color>
							<TD align=right><B>$a_val_txt[$i]</B> &nbsp;&nbsp;</TD>
							<TD align=center>".number_format($r_val[$i])."</TD>
							<TD align=right>".number_format(round(($r_val[$i]/$all_rows)*100,2),2)."&nbsp;&nbsp;&nbsp;</TD>
						</TR>";
					}
?>
		<TR bgcolor='#FFCCCC'>
			<TD align=right><B>รวม</B> &nbsp;&nbsp;</TD>
			<TD align=center><?php echo $all_rows;?></TD>
			<TD align=right><?php echo number_format(round(($all_rows/$all_rows)*100,2),2);?>&nbsp;&nbsp;&nbsp;</TD>
		</TR>
<?php
			}
?>
		</TABLE>
	</fieldset>
	</TD>
	<TD valign=top>
	<fieldset>
    <legend>&nbsp; <B>รายละเอียดการเข้าชั้นเรียน:</B> &nbsp;</legend>
		<TABLE width=95% align=center>
<?php
$pagelen=50;  // 1_กำหนดแถวต่อหน้า
$sql_d="Select * From student_inclass_main where student_id='$student_id' and student_check_year='$year_active' and check_date >='$part_start[$subject_part]' and check_date<='$part_stop[$subject_part]' ";

$url_link="option=student_inclass&task=main/report_subject&index=detail&student_id=$student_id";  // 2_กำหนดลิงค์
$dbquery = mysqli_query($connect,$sql_d);
$num_rows = mysqli_num_rows($dbquery );  
$totalpages=ceil($num_rows/$pagelen);
if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
if($_REQUEST['page']==""){
$page=1;//$totalpages;
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

$start=(!$page)?0:($page-1)*$pagelen;

			$changePages="<B>เลือก  </B><select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
			$changePages==$changePages."<option  value=\"\">หน้า</option>";
				for($p=1;$p<=$totalpages;$p++){
					$seled=($p!=$page)?"":"selected";
					$changePages=$changePages."<option  value=\"?$url_link&page=$p\" $seled> หน้า $p </option>";
				}
			$changePages=$changePages."</select>";
$changePages=($totalpages<=1)?"":"<TR><TD align=right colspan=3 >$changePages</TD></TR>";
echo $changePages;
?>
		<TR bgcolor='#FFCCCC'>
			<TD align=center width=60 rowspan=2><B>ลำดับที่</B></TD>
			<TD align=center rowspan=2><B>วันที่</B></TD>
			<TD align=center  colspan=<?php echo $num_period;?>><B>คาบที่</B></TD>
		</TR>
		<TR bgcolor='#FFCCCC'>
<?php	for($t=0;$t<$num_period;$t++)
		{$Hchk="";
		for($i=0;$i<count($a_val_txt);$i++)
				{	
					//$Hchk=$Hchk."<option value='".$a_val[$i]."' $chked class='".$a_val[$i]."'>".$a_val_txt[$i]."</option>\n";
					$Hchk=$Hchk."<option value='".$a_val[$i]."' class='".$a_val[$i]."'>".$a_val_txt[$i]."</option>\n";
				}
			echo "<TD align=center><B>".($t+1)."</B></TD>";
		}
		?>
</TR>
<?php
		$M=1;
		$N=(($page-1)*$pagelen)+1;  //
		$r=0;  //
$sql_d=$sql_d."  Order By check_date Desc LIMIT $start,$pagelen";

$query_d=mysqli_query($connect,$sql_d);
if(mysqli_num_rows($query_d)==0)
		{
			echo"<TR bgcolor='#F3F3F3'>
			<TD Colspan=".($num_period+3)." align=center><B><FONT COLOR='#FF0000'>ยังไม่มีข้อมูล</FONT></B> &nbsp;&nbsp;</TD></TR>";
		}else
		{
			while($result_d=mysqli_fetch_assoc($query_d)){
				$color=(($M%2) == 0)?" class='even'":" class='odd'";
				
				//วันเข้าเรียน ////////////////////////////////////
				$check_date=make_time($result_d['check_date']);
				$check_day = getdate($check_date);
				$day=$check_day['weekday'];
								
				$sql_ref = "select * from student_inclass_ref where ref_id='$result_subject[ref_id]' and ed_day='$day' ";
				$dbquery_ref = mysqli_query($connect,$sql_ref);
				$d_num=mysqli_num_rows($dbquery_ref);
									if($d_num>0){
									////////////////////
									echo "<TR $color>
									<TD align=center>$N</TD>
									<TD align=left>&nbsp;&nbsp;".thai_date(strtotime($result_d['check_date']))."</TD>";
														
									$rp=explode(",",$result_d['check_val']);
														
													for($ix=0;$ix<$num_period;$ix++){
													$period_check=0;
													$ixt=$ix+1;  //คาบที่
															$sql_ref2 = "select * from student_inclass_ref where ref_id='$result_subject[ref_id]' and ed_day='$day' ";
															$dbquery_ref2 = mysqli_query($connect,$sql_ref2);
															While ($result_ref2 = mysqli_fetch_array($dbquery_ref2)){
															$ref_period=$result_ref2['period'];
																	if($ref_period==$ixt){
																	$tmp_val=explode(":",$rp[$ix]);
																				for($i=0;$i<count($a_val);$i++){
																						if($tmp_val[1]==$a_val[$i]){
																						$period_check=$period_check+1;
																						echo "<TD align=center class=$a_val[$i]><B>$a_val_txt[$i]</B></TD>";
																							}
																				 }
																		 } //if
																}//while	
														if($period_check==0){
														echo "<td></td>";
														}	
														} //for
									echo"</TR>";
									///////////////////	
									} //if
											
				//////////////////////////////////////////
				$M++;
				$N++;
				} //while
		}
?>
		</TABLE>
	</fieldset>
	</TD>
</TR>
</TABLE>
<?php
	}#if !=0
}
?>