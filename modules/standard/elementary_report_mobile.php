<?php
//ตรวจปีมาตรฐาน
$sql = "select distinct sd_year from standard_elementary_sd order by sd_year desc";
$dbquery = mysqli_query($connect,$sql);
$result_sdyear = mysqli_fetch_array($dbquery);

echo "<br />";
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>มาตรฐานการศึกษาปฐมวัย</strong></font></td></tr>";
echo "</table>";


//เลือกปีมาตรฐาน
		echo "<form id='frm1' name='frm1'>";
		echo  "<table width='100%' border='0' align='center'>";
		echo "<Tr>";
		echo "<Td align='right'>";
		echo "<Select  name='sdyear_index' size='1' onchange='goto_type(1)'>";
		$sql_sdyear_index ="select distinct sd_year from standard_elementary_sd order by sd_year desc";
		$dbquery_sdyear_index = mysqli_query($connect,$sql_sdyear_index);
		While ($result_sdyear_index = mysqli_fetch_array($dbquery_sdyear_index))
		   {
		$sd_year = $result_sdyear_index['sd_year']; 
				if($sd_year ==$_REQUEST['sdyear_index']){
				$sd_year_select="selected";
				}
				else {
				$sd_year_select="";
				}
		echo  "<option value = $sd_year $sd_year_select>มาตรฐานปี $sd_year</option>";
			}
		echo "</select>";
		echo "</td></Tr></Table>";
		echo "</form>";
		//จบส่วนเลือกปี


if($_POST){
$sql = "select * from standard_elementary_sd where sd_year='$_REQUEST[sdyear_index]' order by sd_id ";
}
else{
$sql = "select * from standard_elementary_sd where sd_year='$result_sdyear[sd_year]' order by sd_id";
}

$dbquery = mysqli_query($connect,$sql);
echo  "<table width='100%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='70'>มาตรฐานที่</Td> <Td width='80'>มาตรฐานปี</Td><Td>ชื่อมาตรฐาน</Td></Tr>";
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$sd_year= $result['sd_year'];
		$sd_id = $result['sd_id'];
		$sd_name = $result['sd_name'];

		echo "<Tr  bgcolor='#FFFFC' align=center class=style1><Td>$sd_id</Td> <Td>$sd_year</Td><Td align='left'>$sd_name</Td>
	</Tr>";
	
		if($_POST){
		$sql_indicator = "select * from standard_elementary_indicator where sd_id= '$sd_id' and sd_year='$_REQUEST[sdyear_index]' order by id_indicator";
		}
		else{
		$sql_indicator = "select * from standard_elementary_indicator where sd_id= '$sd_id' and sd_year='$result_sdyear[sd_year]' order by id_indicator";
		}		
		$dbquery_indicator = mysqli_query($connect,$sql_indicator);
		
		While ($result_indicator = mysqli_fetch_array($dbquery_indicator))
		{
		$id_indicator= $result_indicator['id_indicator'];
		$indicator_name = $result_indicator['indicator_name'];
		echo "<Tr align='center'><Td></Td><Td></Td><Td align='left'>$indicator_name</Td></Tr>";
		}
	}
echo "</Table>";

?>
<script>
function goto_type(val){
	if(val==1){
		callfrm("?option=standard&task=elementary_report_mobile");   // page ย้อนกลับ 
		}
}
</script>
