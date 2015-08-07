<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$officer=$_SESSION['login_user_id'];
$budget_status['1']="รับเงินสด";
$budget_status['2']="รับเช็ค/เงินฝากธนาคาร";
$budget_status['3']="จ่ายเงินสด";
$budget_status['4']="จ่ายเช็ค/เงินฝากธนาคาร";
$budget_status['5']="นำเงินสดฝากธนาคาร";
$budget_status['6']="นำเงินสดฝากส่วนราชการผู้เบิก";
$budget_status['7']="ถอนเงินฝากธนาคารเป็นเงินสด";
$budget_status['8']="ถอนเงินฝากธนาคารไปฝากส่วนราชการผู้เบิก";
$budget_status['9']="รับคืนเงินฝากส่วนราชการผู้เบิกมาเป็นเงินสด";
$budget_status['10']="รับคืนเงินฝากส่วนราชการมาเป็นเงินฝากธนาคาร";

$t_month['01']="มค";
$t_month['02']="กพ";
$t_month['03']="มีค";
$t_month['04']="เมย";
$t_month['05']="พค";
$t_month['06']="มิย";
$t_month['07']="กค";
$t_month['08']="สค";
$t_month['09']="กย";
$t_month['10']="ตค";
$t_month['11']="พย";
$t_month['12']="ธค";

$th_month['1']="มกราคม";
$th_month['2']="กุมภาพันธ์";
$th_month['3']="มีนาคม";
$th_month['4']="เมษายน";
$th_month['5']="พฤษภาคม";
$th_month['6']="มิถุนายน";
$th_month['7']="กรกฎาคม";
$th_month['8']="สิงหาคม";
$th_month['9']="กันยายน";
$th_month['10']="ตุลาคม";
$th_month['11']="พฤศจิกายน";
$th_month['12']="ธันวาคม";

//ปีงบประมาณ
$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['budget_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีงบประมาณ</div>";
exit();
}

if(isset($_POST['year_index'])){
$year_index=$_POST['year_index'];
}
else{
$year_index="";
}
	//กรณีเลือกปี
if($year_index!=""){
$year_active_result['budget_year']=$year_index;
}

//ส่วนของการคำนวณ
$total_cash=0;  //รวมเงินสดทุกรายการ
$total_bank=0;  //รวมเงินฝากธนาคารทุกรายการ
$total_office=0;  //รวมเงินฝากส่วนราชการทุกรายการ
$total=0; //รวมทั้งหมด
$receive_total=0;   //ตรวจสอบอีกครั้ง
$pay_total=0;  //ตรวจสอบอีกครั้ง

$sql_ex_bud = "select  * from  budget_type order by category_id,type_id";
$dbquery_ex_bud = mysqli_query($connect,$sql_ex_bud);
While ($result_ex_bud = mysqli_fetch_array($dbquery_ex_bud))
{
$type_index=$result_ex_bud['type_id'];
$cash_tank=0;  //เงินสด
$bank_tank=0;  //เงินฝากธนาคาร
$office_tank=0;	 //เงินฝากส่วนราชการ 	
if(!$_POST){
$sql = "select  * from budget_main where budget_year='$year_active_result[budget_year]' and type_id='$result_ex_bud[type_id]' order by rec_date, id";
}
else{
$select_year=$_POST['select_year']-543;
$date_index=$select_year."-".$_POST['select_month']."-".$_POST['select_date'];

$sql = "select  * from budget_main where budget_year='$year_active_result[budget_year]' and type_id='$result_ex_bud[type_id]' and rec_date<='$date_index' order by rec_date, id";
}
			$dbquery = mysqli_query($connect,$sql);
			While ($result = mysqli_fetch_array($dbquery))
				{
				$id = $result['id'];
				$receive_amount = $result['receive_amount'];
				$pay_amount = $result['pay_amount'];
				$change_amount = $result['change_amount'];
				$status = $result['status'];
				$rec_date = $result['rec_date'];
		
						if($status==1){
						$cash_tank=$cash_tank+$receive_amount;
						$receive_total=$receive_total+$receive_amount;
						}	
						else if($status==2){
						$bank_tank=$bank_tank+$receive_amount;
						$receive_total=$receive_total+$receive_amount;
						}
						else if($status==3){
						$cash_tank=$cash_tank-$pay_amount;
						$pay_total=$pay_total+$pay_amount;
						}
						else if($status==4){
						$bank_tank=$bank_tank-$pay_amount;
						$pay_total=$pay_total+$pay_amount;
						}
						else if($status==5){
						$cash_tank=$cash_tank-$change_amount;
						$bank_tank=$bank_tank+$change_amount;
						}
						else if($status==6){
						$cash_tank=$cash_tank-$change_amount;
						$office_tank=$office_tank+$change_amount;
						}
						else if($status==7){
						$bank_tank=$bank_tank-$change_amount;
						$cash_tank=$cash_tank+$change_amount;
						}
						else if($status==8){
						$bank_tank=$bank_tank-$change_amount;
						$office_tank=$office_tank+$change_amount;
						}
						else if($status==9){
						$office_tank=$office_tank-$change_amount;
						$cash_tank=$cash_tank+$change_amount;
						}
						else if($status==10){
						$office_tank=$office_tank-$change_amount;
						$bank_tank=$bank_tank+$change_amount;
						}
				}
$cash_ar[$type_index]=$cash_tank;
$bank_ar[$type_index]=$bank_tank;
$office_ar[$type_index]=$office_tank;
$sum_type[$type_index]=$cash_ar[$type_index]+$bank_ar[$type_index]+$office_ar[$type_index]; //รวมเงินในแต่ละรายการ
$total_cash=$total_cash+$cash_ar[$type_index];
$total_bank=$total_bank+$bank_ar[$type_index];
$total_office=$total_office+$office_ar[$type_index];
}	
$total=$total+$total_cash+$total_bank+$total_office;

//ส่วนหัว
echo "<br />";
echo "<div align='center'>";
echo "<font color='#006666' size='3'><strong>รายงานเงินคงเหลือประจำวัน</strong></font><br />";
echo "<font  color='#006666' size='3'>$_SESSION[school_name]</font>";
echo "</div>";

echo "<form id='frm1' name='frm1'>";
echo "<Table align='center' width='70%' Border='0'>";
$today_date=date("d/m/Y");
list($today_day,$today_month,$today_year) = explode("/",$today_date);
$last_year=$today_year+542;
$today_year=$today_year+543;
$next_year=$today_year+1;	
echo "<Tr><Td align='center'>วันที่&nbsp;&nbsp;<Select  name='select_date'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

for($x=1;$x<=31;$x++){
	if($_POST['select_date']==""){
			if($today_day==$x){
			echo  "<option value =$x selected>$x</option>" ;
			}
			else{
			echo  "<option value =$x>$x</option>" ;
			}
	}
	else{
			if($_POST['select_date']==$x){
			echo  "<option value =$x selected>$x</option>" ;
			}
			else{
			echo  "<option value =$x>$x</option>" ;
			}
	}	
}
echo "</select>";

echo "&nbsp;&nbsp;เดือน&nbsp;&nbsp;<Select  name='select_month' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
for($x=1;$x<=12;$x++){
	if($_POST['select_month']==""){
			if($today_month==$x){
			echo  "<option value =$x selected>$th_month[$x]</option>" ;
			}
			else{
			echo  "<option value =$x>$th_month[$x]</option>" ;
			}
	}
	else{
			if($_POST['select_month']==$x){
			echo  "<option value =$x selected>$th_month[$x]</option>" ;
			}
			else{
			echo  "<option value =$x>$th_month[$x]</option>" ;
			}
	}	
}
echo "</select>";

echo "&nbsp;&nbsp;ปี&nbsp;&nbsp;<Select  name='select_year' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
if($_POST['select_year']==""){
echo  "<option value =$last_year>$last_year</option>" ;
echo  "<option value =$today_year selected>$today_year</option>" ;
echo  "<option value =$next_year>$next_year</option>" ;
}
else{
		if($_POST['select_year']==$last_year){
		echo  "<option value =$last_year selected>$last_year</option>" ;
		echo  "<option value =$today_year>$today_year</option>" ;
		echo  "<option value =$next_year>$next_year</option>" ;
		}
		else if($_POST['select_year']==$next_year){
		echo  "<option value =$last_year>$last_year</option>" ;
		echo  "<option value =$today_year>$today_year</option>" ;
		echo  "<option value =$next_year selected>$next_year</option>" ;
		}
		else{
		echo  "<option value =$last_year>$last_year</option>" ;
		echo  "<option value =$today_year selected>$today_year</option>" ;
		echo  "<option value =$next_year>$next_year</option>" ;
		}
}
echo "</select>";
echo "</Td>";
echo "<td>";

echo "ปีงบประมาณ&nbsp";
	echo "<Select  name='year_index' size='1'>";
	echo  '<option value ="" >เลือก</option>' ;
	$sql_year = "SELECT *  FROM  budget_year order by budget_year";
	$dbquery_year = mysqli_query($connect,$sql_year);
	While ($result_year = mysqli_fetch_array($dbquery_year)){
			 if($year_index==""){
					if($result_year['year_active']==1){
					echo "<option value=$result_year[budget_year]  selected>$result_year[budget_year]</option>"; 
					}
					else{
					echo "<option value=$result_year[budget_year]>$result_year[budget_year]</option>"; 
					}
			 }
			 else{
					if($year_index==$result_year['budget_year']){
					echo "<option value=$result_year[budget_year]  selected>$result_year[budget_year]</option>"; 
					}
					else{
					echo "<option value=$result_year[budget_year]>$result_year[budget_year]</option>"; 
					}
			}	
	}
echo "</select>";
echo "&nbsp;&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_url(1)' class=entrybutton>";
echo "</Td>";
echo"</Tr>";
echo "</table>";
echo "</form>";

//ส่วนแสดงผล
echo  "<table width='95%' border='0' align='center'>";
 echo "<tr bgcolor='#FFCCCC' align='center'>
    <td rowspan='2'>รายการ</td>
    <td colspan='3'>คงเหลือ</td>
    <td rowspan='2' width='120'>รวม</td>
  </tr>
  <tr bgcolor='#CC9900' align='center'>
    <td width='120'>เงินสด</td>
    <td width='120'>เงินฝากธนาคาร</td>
    <td width='120'>เงินฝากส่วนราชการ</td>
  </tr>";
 echo "<tr>
    <td  bgcolor='#FFCCCC'>เงินนอกงบประมาณ</td>
    <td></td>
    <td></td>
    <td></td>
	<td></td>	
  </tr>";
$sql= "select  * from  budget_type where category_id='1' order by type_id";
$dbquery = mysqli_query($connect,$sql);
$M=1;
//ตัวแปรเงินนอกงบประมาณ
$ex_cash=0;
$ex_bank=0;
$ex_office=0;
$ex_total=0;

$income_cash=0;
$income_bank=0;
$income_office=0;
$income_total=0;

While ($result1 = mysqli_fetch_array($dbquery))
	{
	$type_id1=$result1['type_id'];
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
			
			if($type_id1==118){
			$color="#FFCC00";	
			}
			
$ex_cash=$ex_cash+$cash_ar[$type_id1];
$ex_bank=$ex_bank+$bank_ar[$type_id1];
$ex_office=$ex_office+$office_ar[$type_id1];
$ex_total=$ex_total+$sum_type[$type_id1];

$cash_ar2[$type_id1]=number_format($cash_ar[$type_id1],2);			
$bank_ar2[$type_id1]=number_format($bank_ar[$type_id1],2);					
$office_ar2[$type_id1]=number_format($office_ar[$type_id1],2);		
$sum_type2[$type_id1]=number_format($sum_type[$type_id1],2);					
		echo "<Tr bgcolor=$color><Td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$result1[type_name]</Td><td align='right'>$cash_ar2[$type_id1]</td><td align='right'>$bank_ar2[$type_id1]</td><td align='right'>$office_ar2[$type_id1]</td><td align='right'>$sum_type2[$type_id1]</td></Tr>";
$M++;
	}

if(isset($office_ar[118])){
$ex_cash2=$ex_cash-$cash_ar[118];
$ex_bank2=$ex_bank-$bank_ar[118];
$ex_office2=$ex_office-$office_ar[118];
$ex_total2=$ex_total-$sum_type[118];

$ex_cash2=number_format($ex_cash2,2);
$ex_bank2=number_format($ex_bank2,2);
$ex_office2=number_format($ex_office2,2);
$ex_total2=number_format($ex_total2,2);
echo "<Tr bgcolor='#FFCC00'><Td align='center'>รวมเงินนอกงบประมาณยกเว้นเงินอาหารกลางวัน</Td><td align='center'>$ex_cash2</td><td align='center'>$ex_bank2</td><td align='center'>$ex_office2</td><td align='center'>$ex_total2</td></Tr>";
}

$ex_cash=number_format($ex_cash,2);
$ex_bank=number_format($ex_bank,2);
$ex_office=number_format($ex_office,2);;
$ex_total=number_format($ex_total,2);

echo "<Tr bgcolor='#FFCC00'><Td align='center'>รวมเงินนอกงบประมาณทั้งหมด</Td><td align='center'>$ex_cash</td><td align='center'>$ex_bank</td><td align='center'>$ex_office</td><td align='center'>$ex_total</td></Tr>";
	 echo "<tr>
    <td  bgcolor='#FFCCCC'>เงินรายได้แผ่นดิน</td>
    <td></td>
    <td></td>
    <td></td>
	<td></td>	
  </tr>";

$sql= "select  * from  budget_type where category_id='3' order by type_id";
$dbquery = mysqli_query($connect,$sql);
While ($result2 = mysqli_fetch_array($dbquery))
	{
	$type_id2=$result2['type_id'];
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
			
$income_cash=$income_cash+$cash_ar[$type_id2];
$income_bank=$income_bank+$bank_ar[$type_id2];
$income_office=$income_office+$office_ar[$type_id2];
$income_total=$income_total+$sum_type[$type_id2];

$cash_ar[$type_id2]=number_format($cash_ar[$type_id2],2);			
$bank_ar[$type_id2]=number_format($bank_ar[$type_id2],2);					
$office_ar[$type_id2]=number_format($office_ar[$type_id2],2);		
$sum_type[$type_id2]=number_format($sum_type[$type_id2],2);					
		echo "<Tr bgcolor=$color><Td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$result2[type_name]</Td><td align='right'>$cash_ar[$type_id2]</td><td align='right'>$bank_ar[$type_id2]</td><td align='right'>$office_ar[$type_id2]</td><td align='right'>$sum_type[$type_id2]</td></Tr>";
$M++;
	}
//สรุป
$total_cash=number_format($total_cash,2);
$total_bank=number_format($total_bank,2);
$total_office=number_format($total_office,2);
$total=number_format($total,2);

$income_cash=number_format($income_cash,2);
$income_bank=number_format($income_bank,2);
$income_office=number_format($income_office,2);
$income_total=number_format($income_total,2);

echo "<Tr bgcolor='#FFCC00'><Td align='center'>รวมเงินรายได้แผ่นดิน</Td><td align='center'>$income_cash</td><td align='center'>$income_bank</td><td align='center'>$income_office</td><td align='center'>$income_total</td></Tr>";
echo "<Tr bgcolor='#FFCC00'><Td align='center'>รวมทั้งหมด (เงินนอกงบประมาณและเงินรายได้แผ่นดิน)</Td><td align='center'>$total_cash</td><td align='center'>$total_bank</td><td align='center'>$total_office</td><td align='center'>$total</td></Tr>";
echo "</Table>";
?>

<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=budget&task=main/today_report");   // page ย้อนกลับ 
	}else if(val==1){
			callfrm("?option=budget&task=main/today_report");   //page ประมวลผล
		}
}

</script>
