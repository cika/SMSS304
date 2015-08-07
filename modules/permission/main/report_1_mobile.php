<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!($_SESSION['login_status']<=5)){
exit();
}

require_once "modules/permission/time_inc.php";	

//แปลงรูปแบบ date
if(isset($_GET['datepicker'])){
$f1_date=explode("-", $_GET['datepicker']);
$f2_date=$f1_date[2]."-".$f1_date[1]."-".$f1_date[0];  //ปี เดือน วัน
}
else{
$f2_date=date("Y-m-d");
}

//กรณีกลับหน้าก่อน
if(isset($_GET['datepicker_2'])){
$f2_date=$_GET['datepicker_2'];
}

$thai_date=thai_date($f2_date);

//ส่วนหัว
if(!($index==7)){
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>รายการขออนุญาตไปราชการ</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666'>$thai_date</font></td></tr>";
echo "</table>";
}

//ส่วนแสดงผล
if(!($index==7)){

echo "<table width='99%' border='0' align='center'>";
?>
	<link rel="stylesheet" type="text/css" media="all" href="./modules/work/css.css">
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
	</td>
	<td align=right  id=no_print>
<FORM name=frmSearchDate METHOD=GET>
<INPUT TYPE="hidden" name=option value="permission">
<INPUT TYPE="hidden" name=task value="main/report_1_mobile">
เลือกวันที่ <input type="text" id="datepicker" name=datepicker value=<?php echo (isset($_GET['datepicker']))? $_GET['datepicker']:date("d-m-Y");?>  readonly Size=10>
</FORM>
	</td>
</tr>
</table>
<?php

$sql = "select permission_main.id, permission_main.person_id, permission_main.subject, permission_main.place, permission_main.vehicle, permission_main.ref_id, permission_main.document, permission_main.comment, permission_main.grant_x, permission_main.report,permission_main.rec_date,permission_date.date,permission_main.grant_comment from permission_date left join permission_main on permission_date.ref_id=permission_main.ref_id where permission_date.date='$f2_date' order by permission_main.id ";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width='100%' border='0' align='center'>";

echo "<Tr bgcolor='#FFCCCC' align='center'><Td>ที่</Td><Td>ผู้ขออนุญาต</Td><Td>วันขออนุญาต</Td><Td>เรื่องราชการ</Td><Td>สถานที่</Td><Td>วันไปราชการ</Td><Td>อนุมัติ</Td></Tr>";

$N=1; 
$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['id'];
		$person_id = $result['person_id'];		
		$subject = $result['subject'];
		$place = $result['place'];
		$vehicle = $result['vehicle'];
		$ref_id = $result['ref_id'];
		$file = $result['document'];
		$comment = $result['comment'];
		$grant = $result['grant_x'];
		$report = $result['report'];
		$rec_date = $result['rec_date'];
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";

echo "<Tr bgcolor='$color'><Td valign='top' align='center'>$M</Td>";

$sql_person = "select * from  person_main where person_id='$person_id' ";
$dbquery_person = mysqli_query($connect,$sql_person);
$result_person = mysqli_fetch_array($dbquery_person);
$fullname=$result_person['prename'].$result_person['name']." ".$result_person['surname'];
echo "</Td><Td valign='top' align='left'>$fullname</Td>";
echo "<Td valign='top' align='left'>";
echo thai_date_3($rec_date);
echo "</Td><Td valign='top' align='left'>$subject</Td><Td valign='top' align='left'>$place</Td>";

$date = $result['date'];
$date=thai_date_3($date);
echo "<Td valign='top' align='left'>$date</Td>";

echo "<Td valign='top' align='center'>";
if($grant==1){
echo "<img src=images/yes.png border='0'><br>$result[grant_comment]";
}
else if($grant==2){
echo "<img src=images/no.png border='0'><br>$result[grant_comment]";
}
else{
echo "รออนุมัติ";
}
echo "</Td>";
echo "</Tr>";

$M++;
$N++;  
}	
echo "</Table>";
}

?>
