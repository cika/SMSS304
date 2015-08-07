<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

echo "<tr><td colspan='6'>";
if(!($_SESSION['login_status']==5)){
echo "<br>";
echo "<table border='0' width='98%' align='center'>";
	$sql_workgroup = "select  * from system_workgroup order by workgroup_order";
	$dbquery_workgroup = mysqli_query($connect,$sql_workgroup);
	While ($result_workgroup = mysqli_fetch_array($dbquery_workgroup)) {	
	echo "<tr bgcolor='#006666'><td colspan='3' class='tagline' align='left'>$result_workgroup[workgroup_desc]</td></tr>";
			$sql_module = "select  * from system_module where workgroup='$result_workgroup[workgroup]' and module_active='1' and (web_link != '1' or web_link is NULL) order by module_order";
			$dbquery_module = mysqli_query($connect,$sql_module);
			While ($result_module = mysqli_fetch_array($dbquery_module)){
					if($_SESSION['login_status']<=4 and $result_module['where_work']<=1){
							echo "<tr><td width='5%'></td><td align='left' width='50'><a href='?option=$result_module[module]'><img width='40' src='modules/$result_module[module]/images/$result_module[module]_logo.jpg' /></a></td><td align='left' class='tagline'><a href='?option=$result_module[module]'>$result_module[module_desc]</a></td></tr>";
							if(!isset($_SESSION['module_name_'.$result_module['module']])){
							$_SESSION['module_name_'.$result_module['module']]=$result_module['module_desc'];
							}
					}
					else if(($_SESSION['login_status']==6) and ($result_module['where_work']==1)){
							echo "<tr><td width='5%'></td><td align='left' width='50'><a href='?option=$result_module[module]'><img width='40' src='modules/$result_module[module]/images/$result_module[module]_logo.jpg' /></a></td><td align='left' class='tagline'><a href='?option=$result_module[module]'>$result_module[module_desc]</a></td></tr>";
							if(!isset($_SESSION['module_name_'.$result_module['module']])){
							$_SESSION['module_name_'.$result_module['module']]=$result_module['module_desc'];
							}
					}
			}
	}	
echo "</table>";		
} 
echo "</td></tr>";
?>	

<tr>
<td colspan="6">
		<table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr bgcolor="#26354A">
			<td height="30"  class="user" align="center"><a href=change_os.php>SMSS for Desktop</a></td>
		</tr></table>
</td></tr>