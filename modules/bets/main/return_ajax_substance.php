<?php
header("Content-type: application/xhtml+xml; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 

require_once("../../../smss_connect.php");
$sql = "select * from bets_substance where group_code='".$_GET['group']."' order by substance_code";
$query = mysqli_query($connect,$sql);
echo "<option value=''>เลือกสาระ</option>";
while($result = mysqli_fetch_array($query)){
	$substance_code = $result['substance_code'];
	$substance_name = $result['substance_name'];
	$substance_no=substr($substance_code, -2); 
		if($substance_no=='01'){
		$substance_no=1;
		}
		else if($substance_no=='02') {
		$substance_no=2;
		}
		else if($substance_no=='03') {
		$substance_no=3;
		}
		else if($substance_no=='04') {
		$substance_no=4;
		}
		else if($substance_no=='05') {
		$substance_no=5;
		}
		else if($substance_no=='06') {
		$substance_no=6;
		}
		else if($substance_no=='07') {
		$substance_no=7;
		}
		else if($substance_no=='08') {
		$substance_no=8;
		}
		else if($substance_no=='09') {
		$substance_no=9;
		}
echo "<option value='$substance_code'>$substance_no $substance_name</option>";
}

?>
