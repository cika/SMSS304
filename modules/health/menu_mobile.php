<?php
        $sqlmenu="SELECT* FROM health_personal WHERE personal_code='$_SESSION[login_user_id]'";
		$resultmenu=mysqli_query($connect,$sqlmenu); 
		$rowmenu=mysqli_fetch_array($resultmenu);
			?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#FFCC00"><td>
<ul id="nav" class="dropdown dropdown-horizontal">
	<li><a href="./">รายการหลัก</a></li>
	</ul>
</td>
</tr>
</table>