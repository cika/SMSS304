<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$officer=$_SESSION['login_user_id'];
//ปีงบประมาณ
$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['budget_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีงบประมาณ</div>";
exit();
}

//ส่วนหัว
echo "<br />";
echo "<div align='center'>";
echo "<font color='#006666' size='3'><strong>ตรวจสอบการจัดสรรงบประมาณ ปีงบประมาณ $year_active_result[budget_year]</strong></font><br />";
echo "<font  color='#006666' size='3'>$_SESSION[school_name]</font>";
echo "</div>";

//ส่วนแสดงผล
$total_have=0;
$total_proj=0;
echo  "<table width='95%' border='0' align='center'>";
 echo "<tr bgcolor='#FFCCCC' align='center'>
    <td rowspan='2'>รายการ</td>
    <td colspan='2'>จำนวนเงิน(บาท)</td>
    <td rowspan='2' width='120'>ส่วนต่าง</td>
  </tr>
  <tr bgcolor='#CC9900' align='center'>
    <td width='120'>เงินสถานศึกษา(มี)</td>
    <td width='120'>กิจกรรมในโครงการ</td>
  </tr>";
 echo "<tr>
    <td  bgcolor='#FFCCCC'>เงินนอกงบประมาณ</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>";
$sql= "select  * from  budget_type where category_id='1' order by type_id";
$dbquery = mysqli_query($connect,$sql);
$M=1;
While ($result1 = mysqli_fetch_array($dbquery))
	{
	$type_id1=$result1['type_id'];
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
$have_money=0;		
$proj_money=0;
$different=0;
$sql_have_money= "select  sum(receive_amount) as have_momey  from  budget_main where type_id='$result1[type_id]' and budget_year='$year_active_result[budget_year]'";
$dbquery_have_money = mysqli_query($connect,$sql_have_money);
$result_have_money = mysqli_fetch_array($dbquery_have_money);
$have_money=$result_have_money['have_momey'];
$have_money2=	number_format($have_money,2);	

$sql_proj_money= "select  sum(budget_acti) as proj_money  from  plan_acti  where code_approve='$result1[type_id]' and budget_year='$year_active_result[budget_year]'";
$dbquery_proj_money = mysqli_query($connect,$sql_proj_money);
$result_proj_money = mysqli_fetch_array($dbquery_proj_money);
$proj_money=$result_proj_money['proj_money'];
$proj_money2=number_format($proj_money,2);	

//ส่วนต่างระหว่างเงินที่มีกับที่กำหนดในโครงการ
$different=$have_money-$proj_money;
$different2=number_format($different,2);	
$total_have=$total_have+$have_money;
$total_proj=$total_proj+$proj_money;

		echo "<Tr bgcolor=$color><Td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$result1[type_name]</Td><td align='right'>";
				echo $have_money2;
		echo "</td><td align='right'>";
				echo $proj_money2;
		echo "</td><td align='right'>";
				echo $different2;
		echo "</td></Tr>";
$M++;
	}
	
	 echo "<tr>
    <td  bgcolor='#FFCCCC'>เงินงบประมาณที่ได้รับแจ้งจัดสรร</td>
    <td></td>
    <td></td>
    <td></td>
	<td></td>	
  </tr>";
$bud_receive_amount=0;
$proj_bud=0;
$bud_different=0;
$sql= "select  * from  budget_bud where  budget_year='$year_active_result[budget_year]' and status='1' order by id";
$dbquery = mysqli_query($connect,$sql);
While ($result2 = mysqli_fetch_array($dbquery))
	{
	$bud_receive_amount=$result2['receive_amount'];
	$bud_receive_amount2=number_format($bud_receive_amount,2);	
	$bud_id=$result2['id'];
	$bud_id2=$bud_id+400;
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
			
$sql_proj_money3= "select  sum(budget_acti) as proj_money  from  plan_acti  where code_approve='$bud_id2' and budget_year='$year_active_result[budget_year]'";
$dbquery_proj_money3 = mysqli_query($connect,$sql_proj_money3);
$result_proj_money3= mysqli_fetch_array($dbquery_proj_money3);
$proj_bud=$result_proj_money3['proj_money'];
$proj_bud2=number_format($proj_bud,2);	

$bud_different=$bud_receive_amount-$proj_bud;
$bud_different2=	number_format($bud_different,2);			

$total_have=$total_have+$bud_receive_amount;
$total_proj=$total_proj+$proj_bud;

		echo "<Tr bgcolor=$color><Td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$result2[item]</Td><td align='right'>$bud_receive_amount2</td><td align='right'>$proj_bud2</td><td align='right'>$bud_different2</td></Tr>";
$M++;
	}
//สรุป
$total_have2=number_format($total_have,2);
$total_proj2=number_format($total_proj,2);
$total_deffent=$total_have-$total_proj;
$total_deffent=number_format($total_deffent,2);
echo "<Tr bgcolor='#FFCCCC'><Td align='center'>รวม</Td><td align='center'>$total_have2</td><td align='center'>$total_proj2</td><td align='center'>$total_deffent</td></Tr>";
echo "</Table>";
?>

