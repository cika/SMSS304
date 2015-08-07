<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<?php
require_once("modules/bets/time_inc.php");
$officer=$_SESSION['login_user_id'];
echo "<br />";

//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
$sql_test = "select * from bets_sch_test,bets_test where bets_sch_test.test_id=bets_test.id and bets_sch_test.id='$_GET[sch_test_id]'";
$dbquery_test = mysqli_query($connect,$sql_test);
$result_test=mysqli_fetch_array($dbquery_test);
		echo "<table width='90%' border='0' align='center'>";	
		echo "<tr><td align='right' width='150'><Font color='#006666'>ชื่อการสอบ :</Font></td><td align='left'>&nbsp;&nbsp;$result_test[sch_test_name]</td></tr>";
		echo "<tr><td align='right'><Font color='#006666'>จำนวนข้อสอบ :</Font></td><td align='left'>&nbsp;&nbsp;$result_test[item_num]&nbsp;&nbsp;ข้อ</td></tr>";
		echo "<tr><td align='right'><Font color='#006666'>คะแนนเต็ม :</Font></td><td align='left'>&nbsp;&nbsp;$result_test[test_score]&nbsp;&nbsp;คะแนน</td></tr>";
		echo "<tr><td align='right'><Font color='#006666'>เวลาสอบ :</Font></td><td align='left'>&nbsp;&nbsp;$result_test[test_time]&nbsp;&nbsp;นาที</td></tr>";
		echo "<tr><td align='right'><Font color='#006666'>คำชี้แจง :</Font></td><td align='left'>&nbsp;&nbsp;$result_test[statement]</td></tr>";
		echo "</table>";
		echo "<br>";
echo "<hr>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>กรอกรหัสการสอบ</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table width='60%' Border='0' align='center'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'><b>รหัสการสอบ</b>&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='sch_test_code' Size='10'></Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "<input type='hidden' name='sch_test_id' value='$_GET[sch_test_id]'>";	
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>";

echo "</form>";
}

//จบการสอบ
if($index==2){
		$sql = "update bets_schtest_testuser set stop_test='1' where sch_test_id='$_SESSION[bets_sch_test_id]' and person_id='$_SESSION[login_user_id]' ";
		$dbquery = mysqli_query($connect,$sql);
		unset($_SESSION['bets_sch_test_id']);
		unset($_SESSION['bets_test_id']);
		unset($_SESSION['bets_master_test']);
		unset($_SESSION['bets_item_num']);
		echo "<script>alert('ออกจากการสอบแล้ว');</script>\n";
		echo "<script>document.location.href='index.php';</script>\n";
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$rec_date = date("Y-m-d H:i:s");
		if($_POST['answer']==$_POST['right_answer']){
		$score=$_POST['item_score'];
		}
		else{
		$score=0;
		}
		$sql = "select * from bets_answer where test_id='$_SESSION[bets_test_id]' and sch_test_id='$_SESSION[bets_sch_test_id]' and person_id='$_SESSION[login_user_id]' and item_id='$_POST[item_id]' ";
		$dbquery = mysqli_query($connect,$sql);
		$result = mysqli_fetch_array($dbquery);
		
		if($result){
		$sql_2 = "update bets_answer set answer='$_POST[answer]',score='$score',rec_date='$rec_date' where id='$result[id]'";
		$dbquery_2 = mysqli_query($connect,$sql_2);
		}
		else{
					if(isset($_POST['item_id'])){
					$sql_insert = "insert into bets_answer(test_id,sch_test_id,person_id,item_id,answer,score,item_score,rec_date) values ('$_SESSION[bets_test_id]','$_SESSION[bets_sch_test_id]','$_SESSION[login_user_id]','$_POST[item_id]','$_POST[answer]','$score','$_POST[item_score]','$rec_date')";
					$dbquery_insert  = mysqli_query($connect,$sql_insert);
					}
		}
		
$index=8;	
}

if($index==7){
$sql_test = "select * from bets_sch_test,bets_test where bets_sch_test.test_id=bets_test.id and bets_sch_test.id='$_POST[sch_test_id]'";
$dbquery_test = mysqli_query($connect,$sql_test);
$result_test=mysqli_fetch_array($dbquery_test);
		if($_POST['sch_test_code']==$result_test['sch_test_code']){
		$_SESSION['bets_sch_test_id']=$_POST['sch_test_id'];
		$_SESSION['bets_test_id']=$result_test['test_id'];
		$_SESSION['bets_master_test']=$result_test['master_test'];
		$_SESSION['bets_item_num']=$result_test['item_num'];
		}
		else{
				echo "<script>alert('รหัสการสอบไม่ถูกต้อง');</script>\n";
				echo "<script>document.location.href='?option=bets&task=main/test_student&index=1&sch_test_id=$_POST[sch_test_id]';</script>\n";
		}
$index=8;		
}

//แสดงข้อสอบ
if($index==8){
echo "<form id='frm1' name='frm1'>";

if(isset($_POST['item_display_index'])){
$item_display=$_POST['item_display_index']+1;
}
else if(isset($_REQUEST['page'])){
$item_display=$_REQUEST['page']-1;
}
else{
$item_display=0;
}

if($item_display==$_SESSION['bets_item_num']){
$item_display=0;
}

$_REQUEST['page']=$item_display+1;


$pagelen=1; // กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/test_student&index=8";
$totalpages=$_SESSION['bets_item_num'];
if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
if($_REQUEST['page']==""){
$page=1;
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
echo "ข้อที่	";
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
			echo "<<a href=$PHP_SELF?$url_link&page=1>ข้อแรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>ข้อก่อน </a>";
			}
			else {
			echo "ข้อที่	";
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
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> ข้อถัดไป</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> ข้อสุดท้าย</a>>";
			}
			echo " <select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
			echo "<option  value=\"\">ข้อที่</option>";
				for($p=1;$p<=$totalpages;$p++){
				echo "<option  value=\"?$url_link&page=$p\">$p</option>";
				}
			echo "</select>";
echo "</div>";  
}					
//จบแยกหน้า
echo "<hr>";
$sql_test = "select *,bets_item.id from bets_sch_test,bets_test,bets_master_test,bets_master_test_2,bets_item where bets_sch_test.test_id=bets_test.id and bets_test.master_test=bets_master_test.id and bets_master_test.id=bets_master_test_2.master_test_id and bets_master_test_2.item_id=bets_item.id and bets_master_test_2.master_test_id='$_SESSION[bets_master_test]' and bets_sch_test.sch_test_active='1' and bets_sch_test.id='$_SESSION[bets_sch_test_id]' order by bets_master_test_2.item_order,bets_master_test_2.id limit $item_display,1";
$dbquery_test = mysqli_query($connect,$sql_test);
$result = mysqli_fetch_array($dbquery_test);

if($result['item_type']==1){ 
echo "<table width='75%' border='0' align='center'>";
echo "<tr></td><td align='center'>";
echo "<img src='$result[pic_item]' border='0'>";
echo "</td></tr>";
echo "</table>";
}
if($result['item_type']==2){ 
echo "<table width='75%' border='0' align='center'>";
echo "<tr><td align='right' width='100'><font size='4' color='#000066'><b>คำถาม :</b></font></td><td><font size='3'>$result[question]</font></td></tr>";
		if($result['answer_num']>=1){
		echo "<tr><td align='right'><font size='3' color='#000066'><b>1. </b></font></td><td><font size='3'>$result[answer1]</font></td></tr>";
		}
		if($result['answer_num']>=2){
		echo "<tr><td align='right'><font size='3' color='#000066'><b>2. </b></font></td><td><font size='3'>$result[answer2]</font></td></tr>";
		}
		if($result['answer_num']>=3){
		echo "<tr><td align='right'><font size='3' color='#000066'><b>3. </b></font></td><td><font size='3'>$result[answer3]</font></td></tr>";
		}
		if($result['answer_num']>=4){
		echo "<tr><td align='right'><font size='3' color='#000066'><b>4. </b></font></td><td><font size='3'>$result[answer4]</font></td></tr>";
		}
		if($result['answer_num']==5){
		echo "<tr><td align='right'><font size='3' color='#000066'><b>5. </b></font></td><td><font size='3'>$result[answer5]</font></td></tr>";
		}
echo "</table>";
}
echo "<Input Type=Hidden Name='item_display_index' Value='$item_display'>";
echo "<Input Type=Hidden Name='item_id' Value='$result[id]'>";
echo "<Input Type=Hidden Name='right_answer' Value='$result[right_answer]'>";
echo "<Input Type=Hidden Name='item_score' Value='$result[score]'>";
echo "<hr>";

// หาตัวเลือกข้อที่ทำแล้ว
		$sql_check = "select * from bets_answer where sch_test_id='$_SESSION[bets_sch_test_id]' and person_id='$_SESSION[login_user_id]' and item_id='$result[id]' ";
		$dbquery_check = mysqli_query($connect,$sql_check);
		$result_check = mysqli_fetch_array($dbquery_check);
		$check1=""; $check2=""; $check3=""; $check4=""; $check5=""; 
		if($result_check['answer']==1){
		$check1="checked";
		}
		else if($result_check['answer']==2){
		$check2="checked";
		}
		else if($result_check['answer']==3){
		$check3="checked";
		}
		else if($result_check['answer']==4){
		$check4="checked";
		}
		else if($result_check['answer']==5){
		$check5="checked";
		}
//

// หาจำนวนข้อสอบที่ทำแล้ว
		$sql_check_2= "select * from bets_answer where  sch_test_id='$_SESSION[bets_sch_test_id]' and person_id='$_SESSION[login_user_id]' ";
		$dbquery_check_2 = mysqli_query($connect,$sql_check_2);
		$finish_item= mysqli_num_rows($dbquery_check_2);
echo "<div align='right'>";		
echo "ทำแล้ว $finish_item ข้อ จากทั้งหมด $_SESSION[bets_item_num] ข้อ";
if($finish_item>=$_SESSION['bets_item_num']){
echo "&nbsp;&nbsp;&nbsp;";
echo "[<a href=?option=bets&task=main/test_student&index=2>ออกจากการสอบ(คลิก)</a>]";
}
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "</div>";
echo "<hr>";
//

echo "<table width='80%' border='0' align='center'>";
echo "<tr><td align='center'>";
if($result['answer_num']>0){
echo "<b>เลือกคำตอบ</b>";
}
echo "</td></tr>";
echo "<tr><td align='center'>";
if($result['answer_num']>=1){
echo "<input type='radio' name='answer' value='1' $check1>ข้อ 1";
}
if($result['answer_num']>=2){
echo "&nbsp;&nbsp;&nbsp;<input type='radio' name='answer' value='2' $check2>ข้อ 2";
}
if($result['answer_num']>=3){
echo "&nbsp;&nbsp;&nbsp;<input type='radio' name='answer' value='3' $check3>ข้อ 3";
}
if($result['answer_num']>=4){
echo "&nbsp;&nbsp;&nbsp;<input type='radio' name='answer' value='4' $check4>ข้อ 4";
}
if($result['answer_num']>=5){
echo "&nbsp;&nbsp;&nbsp;<input type='radio' name='answer' value='5' $check5>ข้อ 5";
}
echo "</td></tr>";
echo "</table>";
echo "<Br>";
if($result['answer_num']>0){
echo "<div align='center'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url2()'></div>";
}
else{
echo "<div align='center'><Font color='#006666' size='3'>สิ้นสุดการสอบ</font></div>";
}
echo "</form>";
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==2.2) or ($index==3) or ($index==4) or ($index==5.2) or ($index==7) or ($index==8))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายการสอบ</strong></font></td></tr>";
echo "</table>";

echo "<form id='frm1' name='frm1'>";
$sql = "select *,bets_sch_test.id from bets_test_schuser,bets_sch_test,bets_schtest_testuser where bets_test_schuser.id=bets_sch_test.teacher and bets_sch_test.id=bets_schtest_testuser.sch_test_id and bets_sch_test.sch_test_active='1' and bets_schtest_testuser.person_id='$_SESSION[login_user_id]' and bets_test_schuser.start_date<now() and bets_test_schuser.stop_date>now() and bets_schtest_testuser.stop_test='0' ";

$dbquery = mysqli_query($connect,$sql);
echo  "<table width='450' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td><Td width='400'>ชื่อการสอบ</Td></Tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['id'];
		$sch_test_name= $result['sch_test_name'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
			
echo "<Tr bgcolor=$color align='center'><Td>$M</Td><Td align='left'><a href=?option=bets&task=main/test_student&index=1&sch_test_id=$id>$sch_test_name</a></Td>";
echo "</Tr>";
$M++;
	}
echo "</Table>";
echo "</form>";
}

?>
<script>
function goto_url(val){
	if(val==1){
		if(frm1.sch_test_code.value == ""){
			alert("กรุณากรอกรหัสการสอบ");
		}else{
			callfrm("?option=bets&task=main/test_student&index=7"); 
		}
	}
}

function goto_url2(val){
		if(frm1.answer.value == ""){
		alert("ยังไม่ได้เลือกคำตอบ");
		}else{
		callfrm("?option=bets&task=main/test_student&index=4"); 
		}
}

</script>
