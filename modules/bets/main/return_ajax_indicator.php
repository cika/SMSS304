<?php
header("Content-type: application/xhtml+xml; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 

require_once("../../../smss_connect.php");
if($_GET['class_code']>=10){
$_GET['class_code']=13;
}

$sql = "select * from bets_indicator where standard_code='".$_GET['standard']."' and class_code='".$_GET['class_code']."' order by indicator_code";
$query = mysqli_query($connect,$sql);
echo "<option value=''>เลือกตัวชี้วัด</option>";
while($result = mysqli_fetch_array($query)){
	$indicator_code = $result['indicator_code'];
	$indicator_text= $result['indicator_text'];
		$class_code= $result['class_code'];
		if($class_code==1){
		$class_code="ป.1";
		}
		else if($class_code==2){
		$class_code="ป.2";
		}
		else if($class_code==3){
		$class_code="ป.3";
		}
		else if($class_code==4){
		$class_code="ป.4";
		}
		else if($class_code==5){
		$class_code="ป.5";
		}
		else if($class_code==6){
		$class_code="ป.6";
		}
		else if($class_code==7){
		$class_code="ม.1";
		}
		else if($class_code==8){
		$class_code="ม.2";
		}
		else if($class_code==9){
		$class_code="ม.3";
		}
		else if($class_code==13){
		$class_code="ม.4-6";
		}

echo "<option value='$indicator_code'>$class_code&nbsp;&nbsp;&nbsp;$indicator_text</option>";
}
?>
