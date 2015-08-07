<?php
header("Content-type: application/xhtml+xml; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate"); 

require_once("../../../smss_connect.php");
$sql = "select * from bets_standard where substance_code='".$_GET['substance']."' order by standard_code";
$query = mysqli_query($connect,$sql);
echo "<option value=''>เลือกมาตรฐาน</option>";
while($result = mysqli_fetch_array($query)){
	$standard_code = $result['standard_code'];
	$short_name = $result['short_name'];
echo "<option value='$standard_code'>$short_name</option>";
}
?>
