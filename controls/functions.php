<?php
if(!isset($_POST["op"])){
header("location:dashboard.php");	
}
else{
	
$op=$_POST["op"];
switch($op){
   case "noofdays":
   calculate_days();
   break;
   
   case "checkdate":
   check_dates();
   break;	
	
}	
	
	
	
}
function calculate_days(){
	/*
 $date1=new DateTime($_POST["date1"]);	
 $date2=new DateTime($_POST["date2"]);
 $interval=$date1->diff($date2);
 echo $interval->days;
 */
 $date1=strtotime($_POST["date1"]);
 $date2=strtotime($_POST["date2"]);
 
 if($date1>$date2){
	 echo "ERROR1";
 }
 
 else{
 $interval=round(abs($date2-$date1)/86400);
 echo $interval;

 }
}

function check_dates(){
$date1=$_POST["date1"];
$today=date('d/m/y');
echo date('d/m/y');
if ($date1==$today){
 //echo "TRUE";	
 
}
else{
 //echo "FALSE";	
}
}

?>