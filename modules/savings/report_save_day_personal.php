<?php 
 include "./modules/savings/tab.php";
	 if(isset($_REQUEST['dateInput'])){
		     $dateInput=$_REQUEST['dateInput'];
				list($day_S,$month_S,$year_S)=explode("/",$dateInput);
				$day_S;
				$month_S;
				$year_S;
	 }
				$dy= date('d');  //สำหรับแสดงที่หน้า page
				$my= date('m');  //สำหรับแสดงที่หน้า page
				$tt= date('Y');  //สำหรับแสดงที่หน้า page
				$yr=$tt+543; //สำหรับแสดงที่หน้า page
				
	 //สำหรับแสดงที่หน้า page		 
    if($month_S=="01"){
		$date_show="มกราคม";
		}else if($month_S=="02"){
			$date_show="กุมภาพันธ์";
			}else if($month_S=="03"){
			$date_show="มีนาคม";
			}else if($month_S=="04"){
			$date_show="เมษายน";
			}else if($month_S=="05"){
			$date_show="พฤษภาคม";
			}else if($month_S=="06"){
			$date_show="มิถุนายน";
			}else if($month_S=="07"){
			$date_show="กรกฎาคม";
			}else if($month_S=="08"){
			$date_show="สิงหาคม";
			}else if($month_S=="09"){
			$date_show="กันยายน";
			}else if($month_S=="10"){
			$date_show="ตุลาคม";
			}else if($month_S=="11"){
			$date_show="พฤศจิกายน";
			}else if($month_S=="12"){
				$date_show="ธันวาคม";
			}else{}
	 if(isset($_REQUEST['student_id'])){
						$student_id=$_REQUEST['student_id'];
                        $room=$_REQUEST['room'];
                        $level=$_REQUEST['level'];
			
						$sqlCK="SELECT* FROM student_main  WHERE student_id='$student_id'";
						$resultCK=mysqli_query($connect,$sqlCK); 
						$recordCK=mysqli_fetch_array($resultCK);	 
	 }
	?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='stylesheet' href='./modules/savings/config_color.css'> 
<title>ออมทรัพย์นักเรียน</title>
<style>
.menu{background-color:; }
.menu-over{background-color:#22F942;}
</style>
<link rel="stylesheet" type="text/css" href="modules/savings/css/smoothness/jquery-ui-1.7.2.custom.css">
<script type="text/javascript" src="modules/savings/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="modules/savings/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
$(function(){
	// แทรกโค้ต jquery
	$("#dateInput").datepicker();
});
</script>

<link rel="stylesheet" type="text/css" href="modules/savings/css/smoothness/jquery-ui-1.7.2.custom.css">
<script type="text/javascript" src="modules/savings/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="modules/savings/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
$(function(){
	// แทรกโค้ต jquery
	$("#dateInput").datepicker();
});
</script>
<script type="text/javascript">
$(function(){
	// แทรกโค้ต jquery
	$("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });
	// รูปแบบวันที่ที่ได้จะเป็น 2009-08-16
});
</script>
<script type="text/javascript">
$(function(){
	// แทรกโค้ต jquery
	$("#dateInput").datepicker({
		numberOfMonths: 2,
		showButtonPanel: true
	});
});
</script>

<script type="text/javascript">
$(function(){
	// แทรกโค้ต jquery
	$("#dateInput").datepicker({minDate: -20, maxDate: '+1M +10D'});
	// minDate: -20 ไม่สามารถเลือกวันที่ ก่อน 20 วันก่อนหน้าได้
	// maxDate: '+1M +10D' ไม่สามารถเลือก วันที่ถัดจาก อีก 1 เดือนและ 10 วัน ได้
	// หากต้องการให้เลือกวันที่ได้เฉพาะวันปัจจุบันเป็นต้นไป
	// สามารถกำหนด เป็น $("#dateInput").datepicker({minDate: 0});
});
</script>

</head>

<body topmargin="0" bgcolor="#F4FFF4">
<br>
<table width="880" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#99CCFF" bgcolor="#FFFFFF">
<tr>
  <td width="880" height="30" bgcolor="#0066FF"><font color="#FFFFFF"><?php echo $t2;?>ออมทรัพย์นักเรียน</font></td>
</tr>
  <tr>
    <td>
	      <?php  
		  		$sqlmain="SELECT* FROM student_main_class WHERE class_code='$recordCK[class_now]'";
				$resultmain=mysqli_query($connect,$sqlmain); 
   			    $rowbsmain=mysqli_fetch_array($resultmain);
				
				$sqlSM="SELECT SUM(amount_money) AS sumsave FROM savings_money  WHERE std_id='$recordCK[student_id]'&&acc_type='1'";
						$resultSM=mysqli_query($connect,$sqlSM); 
						 $recordSM=mysqli_fetch_array($resultSM);
						 $moneySave=$recordSM['sumsave'];  /*รวมยอดฝาก*/

				$sqlSM2="SELECT SUM(amount_money) AS sumdraw FROM savings_money  WHERE std_id='$recordCK[student_id]'&&acc_type='2'";
						$resultSM2=mysqli_query($connect,$sqlSM2); 
						 $recordSM2=mysqli_fetch_array($resultSM2);
						 $moneysumdraw=$recordSM2['sumdraw']; /*รวมยอดถอน*/
				
						$totalP=$moneySave - $moneysumdraw; /*คงเหลือของแต่ละคน*/
				?>
	<table width="880" border="0">
      <tr>
        <td width="118" rowspan="4" align="center" valign="middle"><?php  if($recordCK['pic']!="") {?><img src='<?php echo $recordCK['pic'];?>' width='65' height='80' border='0'> <?php  }else{?><img src='modules/savings/iconS/logoS.jpg' width='65' height='80' border='0'><?php  }?></td>
        <td colspan="3" align="center"><strong>รายงาน</strong><br></td>
        <td align="center"><a href="?option=savings&task=report_save_day_room&dateInput=<?php echo $dateInput;?>&room=<?php echo $room;?>&level=<?php echo $level;?>" title="ย้อนกลับ"><img src='modules/savings/iconS/bk.gif'  border='0'></a></td>
        </tr>
      <tr>
        <td colspan="3" align="center">ยอดฝาก - ถอน ทั้งหมด</td>
        <td align="right" bgcolor="#C7F8F8">ยอดฝากทั้งหมด : <?php  if($moneySave>=0){?><?php echo number_format($moneySave,'2','.',',');?><?php  }?> บาท</td>
      </tr>  
      <tr>
        <td width="142" align="left">รหัสนักเรียน : <?php echo $recordCK['student_id'];?></td>
        <td width="243" align="left">ชื่อ-สกุล : <?php echo $recordCK['prename'];?><?php echo $recordCK['name'];?>&nbsp;&nbsp;<?php echo $recordCK['surname'];?></td>
        <td width="121" align="left">เลขที่ : <?php echo $recordCK['student_number'];?></td>
        <td align="right" bgcolor="#FCF7DA">ยอดถอนทั้งหมด : <?php  if($moneysumdraw>=0){?><?php echo number_format($moneysumdraw,'2','.',',');?><?php  }?> บาท</td>
      </tr>
      <tr>
        <td colspan="3" align="left">ชั้น :
          <?php echo $rowbsmain['class_name'];?><?php   if($recordCK['room']!=0){ ?>/<?php echo $recordCK['room'];?><?php  } ?><?php echo $t2;?>สถานะ : 
          <?php  if($recordCK['status']==0){ echo"กำลังศึกษา";}
  		else if($recordCK['status']==1){ echo"สำเร็จการศึกษา";}
		else if($recordCK['status']==2){ echo"ย้ายสถานศึกษา";}
		else if($recordCK['status']==3){ echo"ออกกลางคัน";}
		else{}
  ?>         </td>
        <td width="256" align="right" bgcolor="#C7F8F8">ยอดคงเหลือสุทธิ : <?php  if($totalP>=0){?><?php echo number_format($totalP,'2','.',',');?><?php  }?> บาท</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td  valign="top">
    <?php
     if(isset($_REQUEST['page'])){
$page=$_REQUEST['page'];
}else{
$page="";
}
//ส่วนของการแยกหน้า
$sql = "select * from savings_money WHERE std_id='$recordCK[student_id]' ORDER BY  year_past,save_id";
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );
$pagelen=30;
$url_link="option=savings&task=report_save_day_personal";  //กำหนดลิงค์
$url_link2="dateInput=$dateInput&student_id=$student_id&level=$level&room=$room";
$totalpages=ceil($num_rows/$pagelen);
if($page==""){
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
					echo "<a href=$PHP_SELF?$url_link&page=$i&$url_link2>[$i]</a>";
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
			echo "<<a href=$PHP_SELF?$url_link&page=1&$url_link2>หน้าแรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1&$url_link2>หน้าก่อน </a>";
			}
			else {
			echo "หน้า	";
			}					
			for($i=$s_page; $i<=$e_page; $i++){
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i&$url_link2>[$i]</a>";
					}
			}
			if($page<$totalpages)	{
			$f_page2=$page+1;
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2&$url_link2> หน้าถัดไป</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages&$url_link2> หน้าสุดท้าย</a>>";
			}
			echo " <select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
			echo "<option  value=\"\">หน้า</option>";
				for($p=1;$p<=$totalpages;$p++){
				echo "<option  value=\"?$url_link&page=$p&$url_link2\">$p</option>";
				}
			echo "</select>";
echo "</div>";  
}					
//จบแยกหน้า

	?>
	<table width="880" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="55" align="center" valign="middle" bgcolor="#76CEEB">ลำดับ</td>
        <td width="112" align="center" valign="middle" bgcolor="#76CEEB">ปีการศึกษา</td>
        <td width="188" align="center" valign="middle" bgcolor="#76CEEB">วันเดือนปี ที่ทำรายการ</td>
        <td width="325" align="center" valign="middle" bgcolor="#76CEEB">จำนวนยอดเงินฝาก - ถอน</td>
        <td width="188" align="center" valign="middle" bgcolor="#76CEEB">หมายเหตุ</td>
        </tr>      
         <?php 
		 $sqlLL="SELECT * FROM savings_money  WHERE std_id='$recordCK[student_id]' ORDER BY  year_past,save_id  limit $start,$pagelen";
		$resultLL=mysqli_query($connect,$sqlLL);  
		$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
		$bg="";
	  $num=1;
	while($recordLL=mysqli_fetch_array($resultLL))
		{				
				//............................................................................
				$c1="#DDF4F9";
			 	$c2="#FEE2FC";
				//..............................................................................
				if($bg==$c1){
				$bg=$c2;
				}else{
				$bg=$c1;
				}
				//...................................................................................
			$sqlacc="SELECT* FROM savings_account  WHERE acc_code='$recordLL[acc_type]'";
			$resultacc=mysqli_query($connect,$sqlacc); 
   			$rowacc=mysqli_fetch_array($resultacc);
	  ?>
      <tr bgcolor="<?php echo $bg;?>"   onMouseOver="this.className='menu-over'" onMouseOut="this.className='menu'" class="menu">
        <td  align="center" valign="middle"><?php echo $num;;?></td>
        <td  align="center" valign="middle"><?php echo $recordLL['year_past'];?></td>
        <td align="center" valign="middle"><?php echo $recordLL['day_act'];?>&nbsp;&nbsp;&nbsp; <?php echo $recordLL['timer'];?></td>
        <td align="right" valign="middle"><?php  if($recordLL['acc_type']==1){?><font color="#0000FF">
		<?php  }else if($recordLL['acc_type']==2){?><font color="#CC0000">
        <?php  }else if($recordLL['acc_type']==3){?><font color="#CC00FF">
        <?php  }else if($recordLL['acc_type']==4){?><font color="#990033">
        <?php  }else if($recordLL['acc_type']==5){?><font color="#FFCC00">
        <?php  }else if($recordLL['acc_type']==6){?><font color="#FF0000">
        <?php  }else{}?>
          <?php echo $recordLL['amount_money'];?> &nbsp;</font></td>
        <td align="center" valign="middle">
		<?php  if($recordLL['acc_type']==1){?><font color="#0000FF">
		<?php  }else if($recordLL['acc_type']==2){?><font color="#CC0000">
        <?php  }else if($recordLL['acc_type']==3){?><font color="#CC00FF">
        <?php  }else if($recordLL['acc_type']==4){?><font color="#990033">
        <?php  }else if($recordLL['acc_type']==5){?><font color="#FFCC00">
        <?php  }else if($recordLL['acc_type']==6){?><font color="#FF0000">
        <?php  }else{}?>
		<?php echo $rowacc['description'];?></font></td>
        </tr>
         <?php
	  $num++;
	  $N++;  //*เกี่ยวข้องกับการแยกหน้า
    }
		  ?>
      <tr>
        <td height="35" colspan="5"  align="center" valign="middle">
           <b>
      <font color="#0000FF">  ยอดฝากทั้งหมด : <?php  if($moneySave>=0){?><?php echo number_format($moneySave,'2','.',',');?><?php  }?> บาท<?php echo $t3;?></font>
     <font color="#CC0000">   ยอดถอนทั้งหมด : <?php  if($moneysumdraw >= 0){?><?php echo number_format($moneysumdraw,'2','.',',');?><?php  }?> บาท<?php echo $t3;?></font>
      <font color="#009900">  ยอดคงเหลือสุทธิ : <?php  if($totalP>=0){?><?php echo number_format($totalP,'2','.',',');?><?php  }?> บาท
       </font> </b>
        </td>
        </tr>
     
    </table>

   	</td>
  </tr>
</table>
</body>
</html>