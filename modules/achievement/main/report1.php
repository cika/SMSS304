<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
include("FusionCharts/FusionCharts.php");
include("FusionCharts/Fc_Colors.php");
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
<h2>คะแนนสอบ O-NET</h2>
<?php
$sql = "select distinct test_class from achievement_main where  test_type='1' order by test_class limit 1";
$qury = mysqli_query($connect,$sql);
$result=mysqli_fetch_array($qury);
if(!isset($_REQUEST['class_index'])){
$_REQUEST['class_index']=$result['test_class'];
}

echo "<form id='frm1' name='frm1'>";
echo "<table width='95%' align='center'><tr><td align='center'>";

echo "<Select  name='class_index' size='1'>";
				if($_REQUEST['class_index']=='6'){
				$select_class_6="selected";
				}
				else if($_REQUEST['class_index']=='9'){
				$select_class_9="selected";
				}
				else if($_REQUEST['class_index']=='12'){
				$select_class_12="selected";
				}
	
echo  "<option value =6 $select_class_6>ชั้น ป.6</option>";
echo  "<option value =9 $select_class_9>ชั้น ม.3</option>";
echo  "<option value =12 $select_class_12>ชั้น ม.6</option>";
echo "</select>";
echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_display(1)' class='entrybutton'>";
echo "</td></tr></table>";
echo "</form>";

$strXML = "<graph xaxisname='กลุ่มสาระ' yaxisname='Score' hovercapbg='DEDEBE' hovercapborder='889E6D' rotateNames='0' yAxisMaxValue='100' numdivlines='9' divLineColor='CCCCCC' divLineAlpha='80' decimalPrecision='0' showAlternateHGridColor='1' AlternateHGridAlpha='30' AlternateHGridColor='CCCCCC' caption='' subcaption='' >";
   $strXML .= "<categories font='Arial' fontSize='11' fontColor='000000'>";
      $strXML .= "<category name='ภาษาไทย' />";
      $strXML .= "<category name='คณิตศาสตร์' />";
      $strXML .= "<category name='วิทยาศาสตร์' />";
      $strXML .= "<category name='สังคมศึกษา' />";
      $strXML .= "<category name='ภาษาอังกฤษ' />";
      $strXML .= "<category name='สุขศึกษา' />";
	  $strXML .= "<category name='ศิลปะ' />";
      $strXML .= "<category name='การงาน' />";
      $strXML .= "<category name='เฉลี่ย' />";
   $strXML .= "</categories>";
   
   //ตั้งค่าสีกราฟ
   $color[1]='B3AA00';
   $color[2]='008ED6';
   $color[3]='9D080D';
   $color[4]='A186BE';
 
  //ส่วนของปีการศึกษา 
 	$strQuery = "select distinct ed_year from achievement_main where  test_type='1' and test_class='$_REQUEST[class_index]' order by ed_year desc limit 4";
	$result = mysqli_query($connect,$strQuery);
	$year_num=1;
	while($ors = mysqli_fetch_array($result)) {
	$ed_year_ar[$year_num]=$ors['ed_year'];
	$year_num++;
	}
$year_num=$year_num-1;  //จำนวนปีที่แสดง
  
  for($x=$year_num;$x>0;$x--){
	$strQuery = "select thai, math, science, social, english, health, art, vocation, score_avg from achievement_main where test_type='1' and test_class='$_REQUEST[class_index]' and ed_year='$ed_year_ar[$x]' and level='1' ";
			$result = mysqli_query($connect,$strQuery);
			$ors = mysqli_fetch_array($result);  
			if($ors['score_avg']>0){
		   	$strXML .= "<dataset seriesname='ปีการศึกษา $ed_year_ar[$x]' color='$color[$x]'>";
			$strXML .= "<set value='$ors[thai]' />";
			$strXML .= "<set value='$ors[math]' />";
			$strXML .= "<set value='$ors[science]' />";
			$strXML .= "<set value='$ors[social]' />";
			$strXML .= "<set value='$ors[english]' />";
			$strXML .= "<set value='$ors[health]' />";
			$strXML .= "<set value='$ors[art]' />";
			$strXML .= "<set value='$ors[vocation]' />";
			$strXML .= "<set value='$ors[score_avg]' />";
		   	$strXML .= "</dataset>";
			}
  }
$strXML .= "</graph>";
	echo renderChart("FusionCharts/FCF_MSColumn3D.swf", "", $strXML, "Fc", 1000, 450);
?>
</CENTER>

<script>
function goto_display(val){
	if(val==1){
		callfrm("?option=achievement&task=main/report1"); 
		}
}
</script>