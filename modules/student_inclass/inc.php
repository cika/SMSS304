<?php
function get_vals($check_date,$id,$period,$chkyear){
	include"smss_connect.php";
	$sql="Select * From student_inclass_main where student_id='$id' and check_date='$check_date' and student_check_year='$chkyear'";
	$query=mysqli_query($connect,$sql);
	$return_vals=mysqli_fetch_assoc($query);
	
	$ival=explode(',',$return_vals['check_val']);
	if($period==999 && $return_vals!=""){
		$r=0;
		for($i=0;$i<(count($ival));$i++){
			$ivals=explode(':',$ival[$i]);
				///
				if(!isset($ivals[1])){
				$ivals[1]="";
				}

			if($ivals[1]=="-"){
				$r=$r+1;
			}
		} //for
		if($r==0){
				return "C";
			}elseif($r>=1 && $r<(count($ival)-2)){
				return "N";
			}else{
				return "";
			}
	}else{
		if(isset($ival[$period])){
		$ivals=explode(':',$ival[$period]);
		}
		if(isset($ivals[1])){
		return $ivals[1];
		}
	}
} 

function get_vals2($ival,$period){
		$r=0;
		for($i=0;$i<(count($ival));$i++){
			$ivals=explode(':',$ival[$i]);
				///
					if(!isset($ivals[1])){
					$ivals[1]="";
					}
					else if(!($ivals[1]=="-" or $ivals[1]=="T") ){
						$r=$r+1;
					}
			}
		/*
		if($r==0){
				return "C";
		}else{
				return "";
		}
		*/
		return $r;
}

$thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
$thai_month_arr=array(
	"0"=>"",
	"1"=>"มกราคม",
	"2"=>"กุมภาพันธ์",
	"3"=>"มีนาคม",
	"4"=>"เมษายน",
	"5"=>"พฤษภาคม",
	"6"=>"มิถุนายน",	
	"7"=>"กรกฎาคม",
	"8"=>"สิงหาคม",
	"9"=>"กันยายน",
	"10"=>"ตุลาคม",
	"11"=>"พฤศจิกายน",
	"12"=>"ธันวาคม"					
);
function thai_date($time){
	global $thai_day_arr,$thai_month_arr;
	$thai_date_return="วัน".$thai_day_arr[date("w",$time)];
	$thai_date_return.=	"ที่ ".date("j",$time);
	$thai_date_return.=" เดือน".$thai_month_arr[date("n",$time)];
	$thai_date_return.=	" พ.ศ.".(date("Y",$time)+543);
	#$thai_date_return.=	"  ".date("H:i",$time)." น.";
	return $thai_date_return;
}
if(isset($_GET['index'])){
$index=$_GET['index'];
}
else{
$index="";
}
#ระดับการศึกษา
$sql_edu_level="Select * from student_main_class";
$query_edu_level=mysqli_query($connect,$sql_edu_level);
$edu_level=array();
while($e=mysqli_fetch_assoc($query_edu_level))
{
	$edu_level[$e['class_code']]=$e['class_name'];
}

$a_val=array("0" => "C", "1" => "W", "2" => "S", "3" => "L", "4" => "V");
$a_val_txt=array("0" => "มา", "1" => "ลา", "2" => "ป่วย", "3" => "ขาด", "4" => "ไม่เข้าเรียน");

if(isset($_SERVER['HTTP_REFERER'])){
$refer=$_SERVER['HTTP_REFERER'];
}
else{
$refer="";
}

$check_person_id=$_SESSION['login_user_id'];

#เรียกปีการศึกษาปัจจบัน และคาบ
$sql_y="select * from student_inclass_year where year_active=1";
$ry=mysqli_query($connect,$sql_y);
$yactive=mysqli_fetch_assoc($ry);
$year_active=$yactive['student_check_year'];
$txtyear_active=($year_active=="")?"<a href=?option=student_inclass&task=set/year><FONT SIZE=3 COLOR=red>คุณยังไม่ได้ตั้งค่าปีการศึกษาปัจจุบัน</FONT></a>":$year_active;
$num_period=$yactive['num_period'];
$lunch_period=($yactive['lunch_period'])-1;

#####เช็คว่ามีสิทธิ์บันทึกห้องใดได้บ้าง
$year_active=($year_active=="")?0:$year_active;
//$ses='admin_'.$_GET['option'];
if($_SESSION[$ses]==$_GET['option']){
//if($_SESSION['admin_student_check']=="student_check"){
	$sql_chk="SELECT `student_main`.`class_now` , `student_main`.`room` as room_now FROM student_main GROUP BY `student_main`.`class_now` , `student_main`.`room`  ";
}else{
	$sql_chk="Select * from student_inclass_permission where person_id='$check_person_id'";
}
	$sql_chk="Select * from student_inclass_permission where person_id='$check_person_id' and student_check_year=$year_active";
$r_chk=mysqli_query($connect,$sql_chk);
$r_list=array();#echo $sql_chk;
if(mysqli_num_rows($r_chk)<1){}else{
while($rs_chk=mysqli_fetch_assoc($r_chk)){
	$r_list[]=$rs_chk['class_now'].",".$rs_chk['room_now'];
	}
}

/**
* Simple function to replicate PHP 5 behaviour
*/
function microtime_float()
{
list($usec, $sec) = explode(" ", microtime());
return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();

?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo "./modules/$_GET[option]/css.css";?>" />