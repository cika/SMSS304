  <?php 
       	  		$sqlmenu="SELECT* FROM savings_personal WHERE personal_code='$_SESSION[login_user_id]'";
				$resultmenu=mysqli_query($connect,$sqlmenu); 
				$rowmenu=mysqli_fetch_array($resultmenu);
				?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#FFCC00"><td>
<ul id="nav" class="dropdown dropdown-horizontal">
	<li><a href="./">รายการหลัก</a></li>
        <?php  if($rowmenu['per_status']==1) {?>
		<li><a href="?option=savings&task=add_save_day_mobile">ฝาก</a></li>
        <li><a href="?option=savings&task=to_draw_mobile" class="dir">ถอน</a></li> 
         <?php  } ?>
		<li><a href="?option=savings&task=report_all_mobile">รายงาน</a></li>
	</ul>
</td>
</td>
</tr>
</table>