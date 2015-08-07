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
<h2>คะแนนสอบ NT</h2>
<h3>ชั้นประถมศึกษาปีที่ 3</h3>
<?php
$strXML = "<graph xaxisname='' yaxisname='Score' hovercapbg='DEDEBE' hovercapborder='889E6D' rotateNames='0' yAxisMaxValue='100' numdivlines='9' divLineColor='CCCCCC' divLineAlpha='80' decimalPrecision='0' showAlternateHGridColor='1' AlternateHGridAlpha='30' AlternateHGridColor='CCCCCC' caption='' subcaption='' >";
   $strXML .= "<categories font='Arial' fontSize='11' fontColor='000000'>";
      $strXML .= "<category name='ความสามารถด้านภาษา' />";
      $strXML .= "<category name='ความสามารถด้านคำนวณ' />";
      $strXML .= "<category name='ความสามารถด้านเหตุผล' />";
      $strXML .= "<category name='เฉลี่ย' />";
   $strXML .= "</categories>";
   
   //ตั้งค่าสีกราฟ
   $color[1]='B3AA00';
   $color[2]='008ED6';
   $color[3]='9D080D';
   $color[4]='A186BE';
 
  //ส่วนของปีการศึกษา 
 	$strQuery = "select distinct ed_year from achievement_main where  test_type='2' and test_class='3' order by ed_year desc limit 4";
	$result = mysqli_query($connect,$strQuery);
	$year_num=1;
	while($ors = mysqli_fetch_array($result)) {
	$ed_year_ar[$year_num]=$ors['ed_year'];
	$year_num++;
	}
$year_num=$year_num-1;  //จำนวนปีที่แสดง
  
  for($x=$year_num;$x>0;$x--){
	$strQuery = "select thai, math, science, score_avg from achievement_main where test_type='2' and test_class='3' and ed_year='$ed_year_ar[$x]' and level='1' ";
			$result = mysqli_query($connect,$strQuery);
			$ors = mysqli_fetch_array($result);  
			if($ors['score_avg']>0){
		   	$strXML .= "<dataset seriesname='ปีการศึกษา $ed_year_ar[$x]' color='$color[$x]'>";
			$strXML .= "<set value='$ors[thai]' />";
			$strXML .= "<set value='$ors[math]' />";
			$strXML .= "<set value='$ors[science]' />";
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
		callfrm("?option=achievement&task=main/report4"); 
		}
}
</script>