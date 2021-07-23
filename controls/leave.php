<?php

session_start();
if(!isset($_SESSION["id"])){
	
header("location:index.php");	
}
$op=$_POST['op'];

switch($op){
	case "save":
	save_leave();
	break;
	
	case "allocations":
	load_allocations();
	break;
	
	case "status":
	load_leave_status();
	break;
	
	case "history":
	load_leave_history();
	break;
	
	case "search":
	search_leave();
	break;
	
	case "update":
	update_leave();
	break;
	
	case "cancel":
	cancel_leave();
	break;
	
	case "loadbalance":
	load_balance();
	break;
	
	case "staffleave":
	load_staff_leave();
	break;
	
}
function load_balance(){
	
	include "connection.php";
	$user=$_SESSION['id'];
	$type=$_POST['type'];
	$year=date('yy');
	$leavetype="";
	$qry="";
	switch($type){
		case "Annual Leave":
		$qry="SELECT annualbal FROM tblallocation WHERE staffid=$user AND allyear=$year";
		break;
		case "Advance Leave":
		$qry="SELECT annualbal FROM tblallocation WHERE staffid=$user AND allyear=$year";
		break;
		
		case "Maternity":
		$qry="SELECT maternitybal FROM tblallocation WHERE staffid=$user AND allyear=$year";
		break;
		
		case "Medical Leave":
		$qry="SELECT mcbal FROM tblallocation WHERE staffid=$user AND allyear=$year";
		break;
		
		case "In-Lieu":
		$qry="SELECT inlieu FROM tblallocation WHERE staffid=$user AND allyear=$year";
		break;
		
		default:
		$qry="SELECT * FROM tblallocation WHERE staffid=0";
		
	}
	//echo $qry;
	$query=mysqli_query($conn,$qry);
	$result=mysqli_num_rows($query);
	if($result > 0){
		while($row=mysqli_fetch_array($query)){
		  echo $row[0];	
		}
	}
	else{
		echo "0";
	}
	
}
//cancel
function cancel_leave(){
include 'connection.php';
$id=$_POST["id"];
$qry="DELETE FROM tblleave WHERE leaveid=$id";
if(mysqli_query($conn,$qry)>0){
  echo "SUCCESS";	
}	
else{
echo mysqli_error($conn);
}
mysqli_close($conn);
}
//save
function save_leave(){

include 'connection.php';

$userid=$_SESSION["id"];	
$data=$_POST['content'];
$today=date("yy-m-d");
$v1=mysqli_real_escape_string($conn,$data[0]);
$v2=mysqli_real_escape_string($conn,$data[1]);
$v3=mysqli_real_escape_string($conn,$data[2]);
$v4=mysqli_real_escape_string($conn,$data[3]);
$v5=mysqli_real_escape_string($conn,$data[4]);
$v6=mysqli_real_escape_string($conn,$data[5]);
$v7=mysqli_real_escape_string($conn,$data[6]);
$v8=mysqli_real_escape_string($conn,$data[7]);
$v9=mysqli_real_escape_string($conn,$data[8]);
$v10=mysqli_real_escape_string($conn,$data[9]);


$qrystr="INSERT INTO `tblleave`(`dateapplied`, `staffid`, `leavetype`, `startdate`, `starttype`, `enddate`, `endtype`, `daysapplied`, `leavereason`, `relievedby`, `jobspecs`, `jobposition`, `leavestatus`) VALUES ('$today',$userid,'$v1','$v2','$v3','$v4','$v5',$v6,'$v7',$v8,'$v9','$v10','pending')";

$query=mysqli_query($conn,$qrystr);
if($query > 0){
	echo "SUCCESS";
}
else{
echo mysqli_error($conn);
}

mysqli_close($conn);

}
//update
function update_leave(){

include 'connection.php';

$id=$_POST["id"];	
$data=$_POST['content'];

$v1=mysqli_real_escape_string($conn,$data[0]);
$v2=mysqli_real_escape_string($conn,$data[1]);
$startdate=date("d/m/yy",strtotime($v2));
$v3=mysqli_real_escape_string($conn,$data[2]);
$v4=mysqli_real_escape_string($conn,$data[3]);
$enddate=date("d/m/yy",strtotime($v4));
$v5=mysqli_real_escape_string($conn,$data[4]);
$v6=mysqli_real_escape_string($conn,$data[5]);
$v7=mysqli_real_escape_string($conn,$data[6]);
$v8=mysqli_real_escape_string($conn,$data[7]);
$v9=mysqli_real_escape_string($conn,$data[8]);
$v10=mysqli_real_escape_string($conn,$data[9]);
$qrystr="UPDATE `tblleave` SET `leavetype`='$v1', `startdate`='$v2', `starttype`='$v3', `enddate`='$v4', `endtype`='$v5', `daysapplied`=$v6, `leavereason`='$v7', `relievedby`=$v8, `jobspecs`='$v9',`jobposition`='$v10' WHERE leaveid=$id";

$query=mysqli_query($conn,$qrystr);
if($query > 0){
	echo "SUCCESS";
}
else{
echo mysqli_error($conn);
}
mysqli_close($conn);
}

//allocations
function load_allocations(){

$userid=$_SESSION["id"];
$year=$_POST["year"];
include "connection.php";
$qrystr="SELECT * FROM tblallocation WHERE staffid=$userid AND allyear=$year";
$query=mysqli_query($conn,$qrystr);
$data="";
if (mysqli_num_rows($query)){
	while ($row=mysqli_fetch_array($query)){
	  $data.="<tr>";
	  $data.="<td>Annual Leave</td>";
	  $data.="<td>$row[3]</td>";
	  $data.="<td>$row[4]</td>";
	  $data.="</tr>";
	  
	  $data.="<tr>";
	  $data.="<td>Medical Leave</td>";
	  $data.="<td>$row[5]</td>";
	  $data.="<td>$row[6]</td>";
	  $data.="</tr>";
	  
	  $data.="<tr>";
	  $data.="<td>In Lieu</td>";
	  $data.="<td>$row[7] (hours)</td>";
	  $data.="<td>$row[7] (hours)</td>";
	  $data.="</tr>";
	  
	  $data.="<tr>";
	  $data.="<td>Medical</td>";
	  $data.="<td>$row[8]</td>";
	  $data.="<td>$row[9]</td>";
	  $data.="</tr>";
	  
	    $data.="<tr>";
	  $data.="<td>Maternity</td>";
	  $data.="<td>$row[10]</td>";
	  $data.="<td>$row[11]</td>";
	  $data.="</tr>";
	}
	echo $data;
	
}
else{
   echo "NONE";	
}	
mysqli_close($conn);
}

function load_leave_status(){
include "connection.php";

$userid=$_SESSION["id"];
$qry="SELECT * FROM tblleave WHERE staffid=$userid AND (leavestatus='pending' or leavestatus='approved' or leavestatus='rejected') ORDER BY startdate DESC";
$query=mysqli_query($conn,$qry);
$data="";
if (mysqli_num_rows($query) >0){
	while($row=mysqli_fetch_array($query)){
	  $data.="<tr>";
	  $data.="<td>$row[1]</td>";
	  $data.="<td>$row[3]</td>";
	  $startdate=date("d/m/yy",strtotime($row[4]));
	  $enddate=date("d/m/yy",strtotime($row[6]));
	  $data.="<td><span class='badge badge-info'>$startdate($row[5]) </span>  <br/> <span class='badge badge-secondary'>$enddate($row[7])</span> </td>";
	  $data.="<td class='text-center'>$row[8]</td>";
	  if($row[13]=="approved"){
		$data.="<td><span class='badge badge-success'>$row[13]</span></td>
		
		";  
	  }
	  elseif ($row[13]=="rejected"){
	  $data.="<td><span class='badge badge-danger'>$row[13]</span></td>
	  <td><button onclick='edit_leave(". $row[0].")' class='btn btn-primary btn-sm'>Edit</button>
	  ";
	   $data.="</td>";
	  }
	  else{
	  $data.="<td><span class='badge badge-warning'>$row[13]</span></td>
	  <td><button onclick='edit_leave(". $row[0].")' class='btn btn-primary btn-sm'>Edit</button>
	  ";
	   $data.="</td>";
	  }
	 
	  
	
	  $data.="</tr>";
		
	}
	echo $data;
}
else{
  echo "NONE";	
}
	mysqli_close($conn);
	
}
function load_leave_history(){
include "connection.php";

$userid=$_SESSION["id"];
$today=$_POST['year'];
$qry="SELECT * FROM tblleave WHERE staffid=$userid AND (leavestatus='finished' AND YEAR(enddate)<=$today) ORDER BY startdate DESC";
$query=mysqli_query($conn,$qry);
$data="";
if (mysqli_num_rows($query) >0){
	while($row=mysqli_fetch_array($query)){
	  $data.="<tr>";
	  $data.="<td>$row[1]</td>";
	  $data.="<td>$row[3]</td>";
	  $data.="<td><span class='badge badge-info'>$row[4]($row[5]) </span>  <br/> <span class='badge badge-secondary'>$row[6]($row[7])</span> </td>";
	  $data.="<td class='text-center'>$row[8]</td>";
	  
	  $data.="<td><span class='badge badge-warning'>$row[13]</span></td>";
	 
	  $data.="</tr>";
		
	}
	echo $data;
}
else{
  echo "NONE";	
}
	mysqli_close($conn);
	
}

function load_staff_leave(){
include "connection.php";

$userid=$_SESSION["id"];
$today=date('yy-m-d',strtotime($_POST['date']));
$qry="select tblleave.startdate,tblleave.starttype,tblleave.enddate,tblleave.endtype,tblstaff.fullname,tblleave.leavetype,tblleave.daysapplied FROM tblstaff,tblleave WHERE tblstaff.staffid=tblleave.staffid AND (DATE(tblleave.startdate)>=DATE('$today') OR DATE(tblleave.enddate)>=DATE('$today') ) AND leavestatus='approved' ORDER BY startdate";
$query=mysqli_query($conn,$qry);
$data="";
if (mysqli_num_rows($query) >0){
	while($row=mysqli_fetch_array($query)){
	  $data.="<tr>";
	 
	  $startdate=date("d/m/yy",strtotime($row[0]));
	  $enddate=date("d/m/yy",strtotime($row[2]));
	  $data.="<td><span class='badge badge-info'>$startdate($row[1]) </span>  <br/> <span class='badge badge-secondary'>$enddate($row[3])</span> </td>";
	  $data.="<td>$row[4]</td>";
	  
	  $data.="<td><span class='badge badge-warning'>$row[5]</span></td>";
	  $data.="<td>$row[6]</td>";
	  $data.="</tr>";
		
	}
	echo $data;
}
else{
  echo "NONE";	
}

	mysqli_close($conn);
	
}

function search_leave(){
include "connection.php";
$id=$_POST["id"];
$qry="SELECT * FROM tblleave WHERE leaveid=$id";
$query=mysqli_query($conn,$qry);
$result=array();
while ($row=mysqli_fetch_array($query)){
	$result['type']=$row[3];
	$result['sDD']=date('d',strtotime($row[4]));
	$result['sMM']=date('m',strtotime($row[4]));;
	$result['sYY']=date('yy',strtotime($row[4]));;
	$result['stype']=$row[5];
	$result['eDD']=date('d',strtotime($row[6]));
	$result['eMM']=date('m',strtotime($row[6]));
	$result['eYY']=date('yy',strtotime($row[6]));
	$result['etype']=$row[7];
	$result['days']=$row[8];
	$result['reason']=$row[9];
	$result['relieved']=$row[10];
	$result['job']=$row[11];
	$result['position']=$row[12];
}  	
	echo json_encode($result);
	mysqli_close($conn);
}
?>