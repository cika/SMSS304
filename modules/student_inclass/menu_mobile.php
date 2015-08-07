<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$sql_permission = "select * from student_inclass_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(isset($_SESSION['admin_student_inclass'])){
	$admin_student_inclass=$_SESSION['admin_student_inclass'];
}else{
	$admin_student_inclass=null;
	}


echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	
if(isset($ses)){
$ses='admin_'.$_GET['option'];
}	
else{
$ses="";
}
if(!isset($_SESSION[$ses])){
$_SESSION[$ses]="";
}

if($_SESSION['login_status']<=4 ){	
	echo "<li><a href='?option=".$_GET['option']."&task=main/teach_check_mobile' class='dir'>บันทึกการเข้าเรียน(ผู้สอน)</a></li>";
} 
echo "</ul>";
?>
</td></tr>
</table>