<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
include("FusionCharts/FusionCharts.php");
include("FusionCharts/Fc_Colors.php");

if(isset($_REQUEST['ed_year'])){
$ed_year=$_REQUEST['ed_year'];
}else{
$ed_year="";
}
?>
	<SCRIPT LANGUAGE="Javascript" SRC="FusionCharts/FusionCharts.js"></SCRIPT>
	<style type="text/css">
	<!--
	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	.text{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	-->
	</style>

<CENTER>
<h3>คะแนนสอบ LAS และผลการประเมิน</h3>
<?php
$sql = "select distinct test_class from achievement_main where  test_type='3' order by test_class limit 1";
$qury = mysqli_query($connect,$sql);
$result=mysqli_fetch_array($qury);
if(!isset($_REQUEST['class_index'])){
$_REQUEST['class_index']=$result['test_class'];
}
   //ค่าระดับการสอบ
   $test_level_ar[1]="ระดับโรงเรียน";
   $test_level_ar[2]="ระดับสพท.";
 //  $test_level_ar[3]="ระดับประเทศ";

echo "<form id='frm1' name='frm1'>";
echo "<table width='100%' align='center'><tr><td align='right'>";
echo "<Select  name='class_index' size='1' onchange='goto_display(1)'>";
				if($_REQUEST['class_index']=='1'){
				$select_class_1="selected";
				}
				else if($_REQUEST['class_index']=='2'){
				$select_class_2="selected";
				}
				else if($_REQUEST['class_index']=='4'){
				$select_class_4="selected";
				}
				else if($_REQUEST['class_index']=='5'){
				$select_class_5="selected";
				}
				else if($_REQUEST['class_index']=='7'){
				$select_class_7="selected";
				}
				else if($_REQUEST['class_index']=='8'){
				$select_class_8="selected";
				}
echo  "<option value =1 $select_class_1>ชั้น ป.1</option>";
echo  "<option value =2 $select_class_2>ชั้น ป.2</option>";
echo  "<option value =4 $select_class_4>ชั้น ป.4</option>";
echo  "<option value =5 $select_class_5>ชั้น ป.5</option>";
echo  "<option value =7 $select_class_7>ชั้น ม.1</option>";
echo  "<option value =8 $select_class_8>ชั้น ม.2</option>";
echo "</select>";
echo "<Select  name='ed_year' size='1' onchange='goto_display(1)'>";
$sql = "select distinct ed_year from achievement_main where  test_type='3' and test_class='$_REQUEST[class_index]' order by ed_year desc ";
$dbquery = mysqli_query($connect,$sql);
$year=1;
if(mysqli_num_rows($dbquery)>0){
While ($result_year = mysqli_fetch_array($dbquery)){
			$year_ar[$year]=$result_year['ed_year'];
			if($ed_year==""){
			echo "<option value=$result_year[ed_year]>ปีการศึกษา $result_year[ed_year]</option>"; 
			}
			else{
					if($ed_year==$result_year['ed_year']){
					echo "<option value=$result_year[ed_year] selected>ปีการศึกษา $result_year[ed_year]</option>"; 
					}
					else{
					echo "<option value=$result_year[ed_year]>ปีการศึกษา $result_year[ed_year]</option>"; 
					}
			}		
$year++;			
}
}else{
$year_ar=null;
echo "<option value=''> ไม่พบข้อมูล </option>"; 
}

	echo "</select>";
	//echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_display(1)'>";
echo "</td></tr></table>";
echo "</form>";

echo "<Table width='100%' Border='0' Bgcolor='#Fcf9d8'>";
  echo "<Tr bgcolor='#FFCCCC'><Td  align='center'>ระดับ</Td><Td align='center'>เฉลี่ย</Td><Td align='center' >ผลการประเมิน</Td></Tr>";
  
for($x=1;$x<3;$x++){
			if($ed_year==""){
			$strQuery = "select thai, math, science, social, english, health, art, vocation, score_avg from achievement_main where test_type='3' and test_class='$_REQUEST[class_index]' and ed_year='$year_ar[1]' and level='$x' ";
			}
			else{
			$strQuery = "select thai, math, science, social, english, health, art, vocation, score_avg from achievement_main where test_type='3' and test_class='$_REQUEST[class_index]' and ed_year='$ed_year' and level='$x' ";
			}
			$result = mysqli_query($connect,$strQuery);
			$ors = mysqli_fetch_array($result);  
			if(($x%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		
			$thai=number_format($ors['thai'],2);
			$math=number_format($ors['math'],2);
			$science=number_format($ors['science'],2);
			$social=number_format($ors['social'],2);
			$english=number_format($ors['english'],2);
			$health=number_format($ors['health'],2);
			$art=number_format($ors['art'],2);
			$vocation=number_format($ors['vocation'],2);
			$score_avg=number_format($ors['score_avg'],2);			
							
		if($score_avg>0){
		 echo "<Tr bgcolor=$color><Td  align='left' >$test_level_ar[$x]</Td><Td align='center' >$score_avg</Td><Td align='left' >";
		 //คะแนนจุดตัด
		$a=60;
		$b=30;
		$color[2]="#00CC00";
        echo "<table  border='0' cellspacing='0' cellpadding='0'>";
        echo "<tr><td></td>";
				$score_ceil=$score_avg/2;
				if($score_ceil>50){
				$score_ceil=0;   //error
				}
				for($j=0;$j<=$score_ceil;$j++){
						 		if ($j<=($b/2)){
	  							$cl='#FF0000';
						  		}
						 		else if (($j>($b/2)) and ($j<($a/2))){
						  		$cl='#FFFF00';
						  		}
						   		else if ($j>=($a/2)){
						  		$cl='#00CC00';
						  		}
          	 echo "<td bgcolor='$cl' width='1' >&nbsp;</td>";
			 }
          	echo "</tr>";
         	echo "</table>";
	echo "</Td></Tr>";
	 }
}	 
echo "</Table>";		
?>
</CENTER>

<script>
function goto_display(val){
	if(val==1){
		callfrm("?option=achievement&task=main/report6_2_mobile"); 
		}
}
</script>

