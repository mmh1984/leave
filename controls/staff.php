<?php


$operation=$_POST['op'];

switch($operation){
	
  case 'login':
  login_user();
  break;
  
  case 'loadstaff':
  load_staff();
  break;
  
  case 'changepass':
  change_pass();
  break;		
	
}
function login_user(){
 include 'connection.php';
  $email=mysqli_real_escape_string($conn,$_POST['email']);
  $pass=mysqli_real_escape_string($conn,$_POST['pass']);
  $qrystr="SELECT * FROM tblstaff WHERE username='$email' and userpass='$pass' AND (userposition='admin' or userposition='lecturer') and userstatus='active'";
  $query=mysqli_query($conn,$qrystr);
  session_start();
  if (mysqli_num_rows($query) !=0){
	 
	 while($row=mysqli_fetch_array($query)){
		 $_SESSION['id']=$row[0];
		 $_SESSION['username']=$row[1];
		 
	  }
	echo "OK";  
  }
  else{
	 echo "ERROR";
	
  }
	mysqli_close($conn);
}
function load_staff(){
include 'connection.php';
$qrystr="SELECT * FROM tblstaff WHERE userposition='lecturer' or userposition='admin' or userposition='NA'";
$query=mysqli_query($conn,$qrystr);
$data="";
while($row=mysqli_fetch_array($query)){
   	$data.="<option value=$row[0]>$row[2]</option>";
}	
mysqli_close($conn);
echo $data;

}
function change_pass(){
include 'connection.php';
session_start();
$id=$_SESSION["id"];
$newpass=$_POST["newpass"];
$qry="UPDATE tblstaff set userpass='$newpass' WHERE staffid=$id";
if(mysqli_query($conn,$qry)){
   echo "Password Updated!";	
}
else{
   echo mysqli_error($conn);	
}	
mysqli_close($conn);
}
?>