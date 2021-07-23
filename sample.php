<?php
//$server='108.167.189.71';
//$user='maynardm_maynard';
//$pass='KEMUDA2020?';
//$db='maynardm_kileavedb';
$server='locahost';
$user='root';
$pass='';
$db='kemuda';
if (mysqli_connect('108.167.189.71','maynardm_maynard','KEMUDA2020?','maynardm_kileavedb')) {
	echo "OK";
	
}
else{
	echo mysqli_error();	
}


?>