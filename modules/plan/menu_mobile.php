<TABLE BORDER="0" CELLSPACING="0" WIDTH="100%" >
<tr bgcolor="#FFCC00"><td>
<?php
	require_once("./modules/plan/planproject/plan_authen.php");
	require_once("./modules/plan/planproject/plan_person.php");
	require_once("./modules/plan/planproject/plan_default.php");

if(!isset($_SESSION['admin_plan'])){
$_SESSION['admin_plan']="";
}

echo "<ul id=\"nav\" class=\"dropdown dropdown-horizontal\">";
	echo "<li><a href=\"./\">รายการหลัก</a></li>";

echo "</ul>";
?>
</td></tr>
</table>