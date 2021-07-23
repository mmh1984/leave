<?php

$op=$_POST['op'];

switch($op){
  case "all":
    all_holiday();
  break;	
  case "today":
    today_holiday();
  break;
	
}
function today_holiday(){
	
include 'connection.php';
$y= date('yy');
$m=$_POST["month"];
$sql="SELECT * FROM tblholiday WHERE holyear=$y AND month(holdate)=$m ORDER BY holdate ASC";
$query=mysqli_query($conn,$sql);
if(mysqli_num_rows($query)>0){
	$data="";
	while($row=mysqli_fetch_array($query)){
	$data.="<tr style='font-size:1.2em;'>
			 <td><span class='badge badge-info text-center'>".date("d-m-yy",strtotime($row[1]))."</span></td>
              <td><span class='badge badge-success text-center'>$row[2]</span></td>
              
            </tr>";
		
	}
	echo $data;
}
else{
  echo "<tr><td colspan='2'><h4 class='text-info'>No holidays on the selected month</h4></td></tr>";	
}
mysqli_close($conn);	
}

function all_holiday(){
	
include 'connection.php';
$y= date('yy');
$sql="SELECT * FROM tblholiday WHERE holyear=$y ORDER BY holdate ASC";
$query=mysqli_query($conn,$sql);
if(mysqli_num_rows($query)>0){
	$data="";
	while($row=mysqli_fetch_array($query)){
	$data.="<tr>
			 <td>".date("d-m-yy",strtotime($row[1]))."</td>
              <td>$row[2]</td>
              
            </tr>";
		
	}
	echo $data;
}
mysqli_close($conn);	
}
?>