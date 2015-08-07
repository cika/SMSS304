<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr bgcolor="#26354A">
	
	<td height="50" colspan="3" class="logo" nowrap="nowrap">&nbsp;SMSS<span class="tagline">&nbsp;ระบบสนับสนุนการบริหารจัดการสถานศึกษา</span></td>
	<td colspan="3" align="right" class="user" nowrap="nowrap">
<?php	
echo $_SESSION['school_name'];
		if(isset($system_office_code)){
		echo " [".$system_office_code."]";
		}
?>	
	&nbsp;&nbsp;</td>
	</tr>
	<tr bgcolor="#26354A"><td colspan="6" align="right"><font color="#FFFFFF">
<?php 
if(isset($_SESSION['login_user_id'])){
echo "ผู้ใช้ : $_SESSION[login_name]&nbsp;$_SESSION[login_surname]";
		if($_SESSION['login_status']==5){
		echo "&nbsp;(สิทธิ์เบื้องต้น)";
		}
echo "&nbsp;&nbsp;";
echo "<a href=logout.php>[ออกจากระบบ]</a>";
}
?>
 	&nbsp;&nbsp;<font></td></tr>
	
<?php 	
if(isset($system_warning_1)){	
		if($system_warning_1==1){
		echo "<script>alert('การ Login ด้วยเลขประจำตัวประชาชน จะได้รับสิทธิ์เพื่อการลงทะเบียนเท่านั้น ให้ไปที่เมนูผู้ใช้(User) แล้วลงทะเบียน หลังจากนั้นออกจากระบบ แล้ว Login ด้วย Username และ Password ใหม่อีกครั้ง');</script>\n";
		}
}

if(isset($alert)){	
		if($alert==1){
		echo "<script>alert('$alert_content');</script>\n";
		}
}

	if($_GET['option']!=""){
	echo "<tr bgcolor='#FFCC00'>";
	echo "<td colspan='6'>";
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr bgcolor='#6699FF'>";
	echo "<td align='left' nowrap='nowrap' class=stylemenu height='24'>&nbsp;&nbsp;&nbsp;";
	echo $_SESSION['module_name_'.$_GET['option']];
	echo "</td><td align='right'>";
	echo "<span id='Aclock' ></span>";
	echo "&nbsp;&nbsp;&nbsp;";
date_default_timezone_set('Asia/Bangkok');
			?> <script>
			function tick(){
				dt_now = new Date(<?php echo date("Y"); ?>,<?php echo date("m")-1; ?>,<?php echo date("d"); ?>);
				montharrayz = new Array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
				daysarrayz = new Array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");

				dateString = "วัน"+daysarrayz[dt_now.getDay()]  + "ที่ ";
				dateString+= dt_now.getDate() + " ";
				dateString+= montharrayz[dt_now.getMonth() ]+ " ";
				dateString+= dt_now.getFullYear()+543 ;
				
				Aclock.style.color="FFFFFF";
				Aclock.style.fontFamily = "Tahoma";
				Aclock.style.fontSize  = "11px";
				Aclock.style.fontWeight  = "Bold";
				Aclock.innerHTML=dateString;	
			} 
			tick()
			</script> 
			<?php 
			
	echo "</td></tr>";
	echo "</tr>";
	echo "</table>";
	echo "</td></tr>";
	}
	else{
	require_once("menu.php");
	}
	  ?>
	<tr>
	<td colspan="6">
	<!-- Content -->
	
		<?php require_once("".$MODPATHFILE."");?>
	
	<!-- End Content -->
	</td>
	</tr>
</table>
