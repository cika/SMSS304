<script language='javascript'>
//<!–
function printContentDiv(content){
var printReady = document.getElementById(content);
//var txt= 'nn';
var txt= '';

if (document.getElementsByTagName != null){
var txtheadTags = document.getElementsByTagName('head');
if (txtheadTags.length > 0){
var str=txtheadTags[0].innerHTML;
txt += str; // str.replace(/funChkLoad();/ig, ” “);
}
}
//txt += 'nn';
if (printReady != null){
txt += printReady.innerHTML;
}
//txt +='nn';
var printWin = window.open();
printWin.document.open();
printWin.document.write(txt);
printWin.document.close();
printWin.print();
}
// –>
</script>

<div id="lblPrint">
<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
 
include "modules/$_REQUEST[option]/inc.php";

if(!isset($_GET['datepicker'])){
$_GET['datepicker']="";
}

if($num_period=="" or $num_period==0){
echo "<br>";
echo "<div align='center'>ยังไม่ได้กำหนดคาบเรียน ยกเลิกการประมวลผล<div>";
exit();
}

echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='99%' border='0' align='center'>";
echo "<tr align='center'><td colspan=2><font color='#006666' size='3'><strong>สถิติการเข้าเรียนของนักเรียน</strong></font></td></tr>";
?>
	<link rel="stylesheet" href="./jquery/themes/ui-lightness/jquery.ui.all.css">
	<script src="./jquery/jquery-1.5.1.js"></script>
	<script src="./jquery/ui/jquery.ui.core.js"></script>
	<script src="./jquery/ui/jquery.ui.widget.js"></script>
	<script src="./jquery/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			showButtonPanel: true,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
			dayNamesMin: ['อา','จ','อ','พ','พฤ','ศ','ส'],
			onSelect:function(dateText){  document.frmSearchDate.submit();}
		});
	});
	</script>
<tr align='center'>
	<td  align=left>
	<font color='#006666' size='3'><strong>ประจำ<?php echo ($_GET['datepicker'])?thai_date(strtotime($_GET['datepicker'])):thai_date(time());?></strong></font>
	</td>
	<td align=right  id=no_print>
<FORM name=frmSearchDate METHOD=GET ACTION="?option=<?php echo $_GET['option'];?>&task=main/report_today">
<INPUT TYPE="hidden" name=option value="<?php echo $_GET['option'];?>">
<INPUT TYPE="hidden" name=task value="main/report_today">
เลือกวันที่ <input type="text" id="datepicker" name=datepicker value=<?php echo ($_GET['datepicker']!="")?$_GET['datepicker']:date("d-m-Y");?>  readonly Size=10> <INPUT TYPE="image" src="./modules/<?php echo "$_GET[option]";?>/images/b_search.png">
</FORM>
	</td>
</tr>
<?php
echo "</table>";
}
//ส่วนแสดงผล List รายชื่อห้อง
if(!(($index==1) or ($index==2) or ($index==5))){
$sql="SELECT `student_main`.`class_now` FROM student_main where status='0' ";
$sql=$sql."GROUP BY `student_main`.`class_now`   ";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width=100% border=0 align=center margin=0 padding=0>";
echo "<Tr bgcolor='#FFCCCC'>
			<Td  align='center' style='font-weight:bold' rowspan=2 width='25'>ที่</Td>
				<Td  align='center' style='font-weight:bold' rowspan=2 width='120'>ห้องเรียน</Td>
				<Td  align='center' style='font-weight:bold' rowspan=2 width='50'>จำนวน<BR>นักเรียน</Td>
				<Td  align='center' style='font-weight:bold' colspan=$num_period>คาบที่</Td>
				<Td  align='center' style='font-weight:bold' colspan=$num_period>ร้อยละ</Td>
				<Td  align='center' style='font-weight:bold' rowspan=2 width='25' id='no_print'><img src=images/browse.png border='0' title='รายละเอียด' alt='รายละเอียด'></Td>
			</Tr>";
?>
<TR bgcolor='#FFCCCC'>
<?php	for($t=0;$t<$num_period;$t++)
		{
			echo "<TD align=center width='50'><B>".($t+1)."<BR><font size=1>เข้า:<font color=red>ไม่เข้า</font></font></B></TD>\n";
		}
		?>
<?php	for($t=0;$t<$num_period;$t++)
		{
			echo "<TD align=center width='50'><B>".($t+1)."<BR><font size=1>เข้า:<font color=red>ไม่เข้า</font></font></B></TD>\n";
		}
		?>
</TR>
<?php

$N=1;
$M=1;
$student_totals=0;
if(@mysqli_num_rows($dbquery)>0){
While ($result = mysqli_fetch_array($dbquery))
	{
		$class_now= $result['class_now'];
		$edu_name=$edu_level[$result['class_now']];

	for($t=0;$t<$num_period;$t++)
		{
			$Cnums_class[$class_now][$t]=0;
			$Lnums_class[$class_now][$t]=0;
		}

	$sub_sql="SELECT `student_main`.`class_now` , `student_main`.`room` FROM student_main  ";
	$sub_sql=$sub_sql." where  `student_main`.`class_now`=$class_now ";
	$sub_sql=$sub_sql." GROUP BY `student_main`.`class_now` , `student_main`.`room` ";
	$sub_query = mysqli_query($connect,$sub_sql);
	$student_nums=0;
	While ($sub_result = mysqli_fetch_array($sub_query))
			{
		$room_now=$sub_result['room'];
		$rn=($room_now=="" || $room_now==0)?"":"/".$room_now;
$check_date=($_GET['datepicker']=="")?date("d-m-Y"):$_GET['datepicker'];
$d=explode("-",$check_date);		$save_pic="";
$check_date=$d[2]."-".$d[1]."-".$d[0];

#task=main/report_room&index=2&class_now=10&room_now=1&datepicker=2011-07-21
		#$report_pic="<a href=?option=student_check&task=main/report_room&index=2&class_now=$class_now&room_now=$room_now&datepicker=".$check_date."><img src=images/browse.png border='0' title='ดูรายงานข้อมูลการเข้าเรียนของห้องเรียนนี้' alt='ดูรายงานข้อมูลการเข้าเรียนของห้องเรียนนี้'></a>";
#เรียกจำนวนนักเรียน
$sql_count="SELECT COUNT(student_id) AS STD_NUMS FROM student_main where status='0' AND `student_main`.`class_now`=$class_now  and `student_main`.`room`=$room_now"; 
$result_conut = mysqli_fetch_array(mysqli_query($connect,$sql_count));
				$color=(($M%2) == 0)?" class='even'":" class='odd'";
				echo "<Tr $color>
				<Td align='center' width='35'>$N</Td>
				<Td  align='center'>$edu_name$rn</Td>
				<Td  align='center'>$result_conut[STD_NUMS]</Td>";
#		$a_val=array("0" => "C", "1" => "W", "2" => "S", "3" => "L");
$check_date=($_GET['datepicker']=="")?date("d-m-Y"):$_GET['datepicker'];
$d=explode("-",$check_date);
$check_date=$d[2]."-".$d[1]."-".$d[0];
$per=array();
$per="";
/*for($q=0;$q<count($a_val);$q++){
	$sql_="Select * from student_check_main Where check_date='$check_date' and class_now=$class_now and room_now=$room_now and check_val='".$a_val[$q]."'";
	$nums=mysqli_num_rows(mysqli_query($connect,$dbname,$sql_));
	$per[]=$nums;
	echo "<Td  align='right'> $nums  &nbsp;</Td>";
}
for($p=0;$p<count($per);$p++){
	echo "<Td  align='right'> ".number_format(round(($per[$p]/$result_conut[STD_NUMS])*100,2),2)."&nbsp;</Td>";
}*/

$sql_val="Select * from student_inclass_main Where check_date='$check_date' and class_now=$class_now and room_now=$room_now AND student_check_year='$year_active'";
$query_val=mysqli_query($connect,$sql_val);
	/*for($count_val=0;$count_val<count($a_val);$count_val++)
			{
				$$a_val[$count_val]=0;
			}*/
				#$rNums=mysqli_num_rows($query_val);
	for($t=0;$t<=$num_period;$t++)
		{
			#echo "<TD>$Cnums[$t]:$Lnums[$t]</TD>\n";
			$Cnums[$t]=0;
			$Lnums[$t]=0;
		}

				while($rsNums =mysqli_fetch_array($query_val))
						{
						$tmp="";
#						$Cnums=0;
#						$Lnums=0;
						$tmp=explode(",",$rsNums['check_val']);
						for($countTmp=0;$countTmp<count($tmp);$countTmp++)
							{
								$tmpC=explode(":",$tmp[$countTmp]);
								@$Cnums[$countTmp]=($tmpC[1]=="C")?$Cnums[$countTmp]+1:$Cnums[$countTmp]+0;
								@$Lnums[$countTmp]=($tmpC[1]!="C" && $tmpC[1]!="T")?$Lnums[$countTmp]+1:$Lnums[$countTmp]+0;
						@$Cnums_class[$class_now][$t]=($tmpC[1]=="C")?$Cnums[$countTmp]+1:$Cnums[$countTmp]+0;
						@$Lnums_class[$class_now][$t]=($tmpC[1]!="C" && $tmpC[1]!="T")?$Lnums[$countTmp]+1:$Lnums[$countTmp]+0;
							}
						}


#$sql_val="Select * from student_inclass_main Where student_id='$result[student_id]' AND student_check_year='$year_active'";

	for($t=0;$t<$num_period;$t++)
		{
			echo "<TD><CENTER><B><FONT COLOR=DARKGREEN>$Cnums[$t]</FONT>:<FONT COLOR=red>$Lnums[$t]</FONT></B></CENTER></TD>\n";
			$percentC[$t]=number_format(round(($Cnums[$t]/$result_conut['STD_NUMS'])*100,2),2);
			$percentL[$t]=number_format(round(($Lnums[$t]/$result_conut['STD_NUMS'])*100,2),2);
			$Cnums_class[$class_now][$t]+=$Cnums[$t];
			$Lnums_class[$class_now][$t]+=$Lnums[$t];
		}

	for($t=0;$t<$num_period;$t++)
		{
			echo "<TD title='นักเรียนเข้าเรียนคาบนี้ร้อยละ $percentC[$t]  นักเรียนไม่เข้าเรียนคาบนี้ร้อยละ $percentL[$t]'><CENTER>$percentC[$t]:$percentL[$t]</CENTER></TD>\n";
		}

				//echo"<Td align='center' id='no_print'>			$save_pic 			$report_pic			</Td>	</Tr>";
				echo"<Td align='center' id='no_print'>$save_pic</Td>	</Tr>";

			unset($percentC);#[$t]=round(($Cnums[$t]/$result_conut)*100,2);
			unset($percentL);#[$t]=round(($Lnums[$t]/$result_conut)*100,2);
$student_nums=$student_nums+$result_conut['STD_NUMS'];
		$M++;
		$N++;  //
		}
#รวมแต่ละระดับชั้น
				echo "<Tr bgcolor=#CCFFFF>
				<Td  align='right' colspan=2><B>รวม $edu_name &nbsp;&nbsp;</B></Td>
				<Td  align='center'><B>$student_nums &nbsp;</B></Td>";
/*$per="";
for($q=0;$q<count($a_val);$q++){
	$sql_="Select * from student_check_main Where check_date='$check_date' and class_now=$class_now and check_val='".$a_val[$q]."'";
	$nums=mysqli_num_rows(mysqli_query($connect,$sql_));
	$per[]=$nums;
	echo "<Td  align='right' style='font-weight:bold'> $nums &nbsp;  </Td>";
}
for($p=0;$p<count($per);$p++){
	echo "<Td  align='right' style='font-weight:bold'> ".number_format(round(($per[$p]/$student_nums)*100,2),2)."&nbsp;</Td>";
}*/
//	$aCnums_class=Array();
//	$aLnums_class=Array();
	for($t=0;$t<$num_period;$t++)
		{
			echo "<TD><B><CENTER>".$Cnums_class[$class_now][$t]." : ".$Lnums_class[$class_now][$t]."</CENTER></B></TD>\n";
			@$aCnums_class[$t]+=			$Cnums_class[$class_now][$t];
			@$aLnums_class[$t]+=			$Lnums_class[$class_now][$t];

			$percentC_class[$t]=number_format(round(($Cnums_class[$class_now][$t]/$student_nums)*100,2),2);
			$percentL_class[$t]=number_format(round(($Lnums_class[$class_now][$t]/$student_nums)*100,2),2);
		}

	for($t=0;$t<$num_period;$t++)
		{
			echo "<TD title='นักเรียนเข้าเรียนคาบนี้ร้อยละ $percentC_class[$t]  นักเรียนไม่เข้าเรียนคาบนี้ร้อยละ $percentL_class[$t]'><CENTER>$percentC_class[$t]:$percentL_class[$t]</CENTER></TD>\n";
		}

				echo "<Td align='center' id='no_print'></Td>
			</Tr>";
unset($percentC_class);
unset($percentL_class);
$student_totals=$student_totals+$student_nums;
	}
				echo "<Tr  bgcolor=#6666FF>
				<Td  align='right' colspan=2><B>รวมทั้งหมด&nbsp;&nbsp;</B></Td>
				<Td  align='center'><B>".number_format($student_totals,0)." </B>&nbsp;</Td>";
/*$per="";
for($t=0;$t<count($a_val);$t++){
	$sql_="Select COUNT(student_id) as tnums from student_check_main Where check_date='$check_date' and check_val='".$a_val[$t]."'";
	$nums=mysqli_fetch_assoc(mysqli_query($connect,$sql_));
	$per[]=$nums[tnums];
	echo "<Td  align='right' style='font-weight:bold'> $nums[tnums] &nbsp;</Td>";
}
for($p=0;$p<count($per);$p++){
	echo "<Td  align='right' style='font-weight:bold'> ".number_format(round(($per[$p]/$student_totals)*100,2),2)."&nbsp;</Td>";
}*/
	for($t=0;$t<$num_period;$t++)
		{
			echo "<TD><B><CENTER>".$aCnums_class[$t]." : ".$aLnums_class[$t]."</CENTER></B></TD>\n";

			$percentC_class_all[$t]=number_format(round(($aCnums_class[$t]/$student_totals)*100,2),2);
			$percentL_class_all[$t]=number_format(round(($aLnums_class[$t]/$student_totals)*100,2),2);
		}

	for($t=0;$t<$num_period;$t++)
		{
			echo "<TD title='นักเรียนเข้าเรียนคาบนี้ร้อยละ $percentC_class_all[$t]  นักเรียนไม่เข้าเรียนคาบนี้ร้อยละ $percentL_class_all[$t]'><CENTER>$percentC_class_all[$t]:$percentL_class_all[$t]</CENTER></TD>\n";
		}

				echo "<Td align='center' id='no_print'></Td>
			</Tr>";
echo "</Table>";
unset($percentC_class_all);
unset($percentL_class_all);

}else
	{
echo "
<tr>
	<td colspan=11 align=center><B><FONT SIZE=3 COLOR=RED>ไม่มีข้อมูลนักเรียน</FONT></B>
	</td>
</tr>
</Table>";
	}
}
?>
</div>
