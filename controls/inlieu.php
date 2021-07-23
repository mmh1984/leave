<?php
session_start();
if(!isset($_SESSION["id"])){
	
header("location:index.php");	
}
$op=$_POST['op'];

switch($op){
   case "save":
   save_record();
   break;
   case "inlieu":
   load_inlieu();
   break;	
    
   case "claims":
   load_claims();
   break;
   
   case "deleteclaims":
   delete_claims();
   break;		
	
}

function save_record(){
	
include 'connection.php';

$id=$_SESSION["id"];
$list=$_POST["list"];
$size=count($list);
$type=$_POST["type"];
$today=date("yy-m-d");	
$error="";
for($x=0;$x<$size;$x++){
$d=$list[$x]["date"];
$t1=$list[$x]["time1"];
$t2=$list[$x]["time2"];
$w=$list[$x]["work"];
$h=$list[$x]["hours"];
$qry="INSERT INTO tblinlieu(staffid,dateapplied,worktype,startdate,starttime,endtime,workdesc,hours,leavestatus)";	
$qry.=" VALUES($id,'$today','$type','$d','$t1','$t2','$w',$h,'pending')";

if(!mysqli_query($conn,$qry)){
	$error.=mysqli_error($conn);
}
	
}
if ($error==""){
  echo "OK";	
}
else{
  echo $error;	
}
mysqli_close($conn);

}
function load_inlieu(){
include 'connection.php';
$id=$_SESSION["id"];
$qry="SELECT dateapplied,SUM(hours),leavestatus,worktype from tblinlieu WHERE staffid=$id GROUP BY dateapplied";	
$query=mysqli_query($conn,$qry);
if(mysqli_num_rows($query)!=0){
	$data="";
	$x=0;
	while($row=mysqli_fetch_array($query)){
    $date=date("d/m/yy",strtotime($row[0]));
	$data.="<tr>";
	$data.="<td>$date <input type='hidden' name='claimdate[]' value='$row[0]'/></td>";	
	$data.="<td>$row[1]</td>";
	$data.="<td>$row[3]</td>";
	if($row[2]=="pending"){
		$data.="<td><span class='badge badge-warning'>$row[2]</span></td>";
	}
	else{
		$data.="<td><span class='badge badge-success'>$row[2]</span></td>";	
	}
	$data.="<td><button class='btn btn-primary btn-sm' onclick='view_claim($x)'>View details</button></td>";
	$data.="<tr>";	
	$x++;
	}
	echo $data;
}
else{
 echo "NONE";
}
	
}

function load_claims(){
include "connection.php";
$id=$_SESSION["id"];
$claimdate=$_POST["claimdate"];
$qry="SELECT * FROM tblinlieu WHERE staffid=$id AND dateapplied='$claimdate'";
$query=mysqli_query($conn,$qry);
$data="<table class='table table-sm table-striped' >
              <thead>
                <tr>
				  <th>Action</th>
                  <th>Date</th>
                  <th>Start Time</th>
                  <th>End Time</th>
                  <th>Work Description</th>
                  <th>Hours</th>
                </tr>
              </thead>
              <tbody id='tblinlieu'>";
while($row=mysqli_fetch_array($query)){
  	$data.="<tr>";
	if($row[9]=="approved"){
	$data.="<td><span class='badge badge-success'>Approved</span></td>";	
		
	}
	else{
	$data.="<td><button onclick='delete_claim($row[0])'>Delete</button></td>";	
	}
	
		$data.=	"	  
                  <td>$row[4]</td>
                  <td>$row[5]</td>
                  <td>$row[6]</td>
                  <td>$row[7]</td>
                  <td>$row[8]</td>
                </tr>";
}	
	$data.="</tbody></table>";
	echo $data;
	mysqli_close($conn);
}

function delete_claims(){
include 'connection.php';
$id=$_POST["claimid"];
$qry="DELETE FROM tblinlieu WHERE id=$id";
if(mysqli_query($conn,$qry)){
	echo "OK";
}
else{
	echo mysqli_error($conn);
}
	mysqli_close($conn);
}
?>