<?php
function DBfieldQuery($QueryString){ 
global $connect;
$Result = mysqli_query($connect,$QueryString);
return $Result;
}
?>