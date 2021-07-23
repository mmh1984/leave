<?php
session_start();
if(!isset($_SESSION["username"])){
  header("location:index.html");	
}
$username=$_SESSION["username"];


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--<meta http-equiv="refresh" content="900;url=logout.php" />-->
<title>Leave Application</title>
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/Footer-Basic.css">
<link rel="stylesheet" href="assets/css/Footer-Clean.css">
<link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
<link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<div class="container-fluid" style="background:#003;margin-bottom:30px;">
  <div class="row">
    <div class="col-sm-6 col-md-9 col-lg-9" style="padding-top:15px;padding-bottom:15px;">
    <img class="img-fluid float-left" src="assets/img/logo.png" width="8%">
      <h2 class="text-white" style="margin-top:20px;">
      
      Leave Application</h2>
    </div>
    <div class="col-sm-6 col-md-3 col-lg-3" style="padding-top:15px;padding-bottom:15px;">
      <div class="dropdown">
        <button class="btn btn-danger btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button" style='font-size:.8em;margin-top:20px;'><?php echo $username?></button>
        <div class="dropdown-menu" role="menu" style="width:100%;" ><a class="dropdown-item text-center" role="presentation" href="#" style='font-size:.8em'data-target="#changepass" data-toggle="modal">Change Password</a><a class="dropdown-item text-center" role="presentation" href="logout.php" style='font-size:.8em'>Logout</a></div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid" style='border-bottom:1px solid #CCC;margin-bottom:10px;padding-bottom:20px;'>
  <div class="row">
    <div class="col-md-3 col-xl-3 col-sm-12">
      <div class="card">
        <div class="card-header bg-dark text-white">
          <h5 class="text-center mb-0">Menu</h5>
        </div>
        <div class="card-body bg-dark">
          <p class="card-text"></p>
          <button class="btn btn-light btn-block" type="button" style="padding:5px;" data-toggle="modal" onclick="window.location.href='leaveapplication.php'">Leave Application</button>
          <button class="btn btn-light btn-block" type="button" style="padding:5px;" onClick="load_leave_status()" data-target='#status' data-toggle='modal'>Leave Status</button>
          <button
                            class="btn btn-light btn-block" type="button" style="padding:5px;" data-target='#history' data-toggle='modal' onClick="load_leave_history()">Leave History</button>
                            <button
                            class="btn btn-light btn-block" type="button" style="padding:5px;"  onClick="window.location.href='inlieuapplication.php'">In-Lieu Application</button>
                            
                             <button
                            class="btn btn-light btn-block" type="button" style="padding:5px;"  data-toggle="modal" data-target="#inlieu" onClick="load_inlieu()">In-Lieu Status</button>
          <button class="btn btn-light btn-block" type="button" style="padding:5px;" data-toggle='modal' data-target='#allocation' onClick="load_allocation()">Allocations</button>
        </div>
      </div>
    </div>
    <div class="col-md-9 col-xl-9 col-sm-12">
      <div class="card">
        <div class="card-header bg-dark text-white">
          <h5 class="mb-0">Staff on leave</h5>
        </div>
        <div class="card-body" >
          <p class="float-left" style="padding:5px;">Select Date:</p>
          <input class="float-left form-control" type="date" style="width:200px;" id="leavedate" >
          <button class="btn btn-primary btn-sm" type="button" style="margin-left:5px;" onClick="load_staff_leave()">Apply</button>
          <div class="table-responsive" style="height:50vh;overflow-y:auto;">
            <table class="table">
              <thead>
                <tr>
                  <th>Dates</th>
                  <th>Staff Name</th>
                  <th>Leave Type</th>
                  <th>No of Days</th>
                </tr>
              </thead>
              <tbody id="staffonleave">
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container" style="padding-top:30px;padding-bottom:30px;">
  <div class="row">
    <div class="col">
      <h3 class="text-center text-secondary">Public Holidays (2020)</h3>
      Select Month: <select id="holmonth" style='padding:5px;margin:px;width:200px' onChange="load_today_holiday()">
      <option value='1'>January</option>
      <option value='2'>February</option>
      <option value='3'>March</option>
      <option value='4'>April</option>
      <option value='5'>May</option>
      <option value='6'>June</option>
      <option value='7'>July</option>
      <option value='8'>August</option>
      <option value='9'>September</option>
      <option value='10'>October</option>
      <option value='11'>November</option>
      <option value='12'>December</option>
      </select>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Name</th>
            </tr>
          </thead>
          <tbody id='tblholiday'>
            
           
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="footer-basic bg-light">
  <footer>
    <p class="copyright"><a href="www.kemudainstitute.com">Kemuda Institute © 2020</a></p>
  </footer>
</div>

<!--modals--> 
<!--allocation-->
<div role="dialog" tabindex="-1" class="modal fade" id="allocation">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Leave Allocation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <label>Year </label>
        <select id="allyear" style="padding:5px;" onChange="load_allocation()">
          <option value="<?php echo date('yy')?>" selected><?php echo date('yy')?></option>
          <option value="<?php echo date('yy') + 1?>"><?php echo date('yy') + 1?></option>
        </select>
        <div class="table-responsive">
          <table class="table" >
            <thead>
              <tr>
                <th>Type</th>
                <th>Allocation</th>
                <th>Balance</th>
              </tr>
            </thead>
            <tbody id="tblallocation">
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="button">Save</button>
      </div>
    </div>
  </div>
</div>
<!--end of allocation--> 
<!--leave status-->
<div role="dialog" tabindex="-1" class="modal fade" id="status">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Leave Status</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <div class="table-responsive">
            <table class="table table-sm table-striped" >
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Leave Type</th>
                  <th>Dates</th>
                  <th>No of Days</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id='tblleavestatus'>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="button">Save</button>
      </div>
    </div>
  </div>
</div>
<!--end of leave--> 
<!--leave status-->
<div role="dialog" tabindex="-1" class="modal fade" id="history">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Leave History</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <label>Year </label>
        <select id="historyyear" style="padding:5px;" onChange="load_leave_history()">
        <option value="<?php echo date('yy')- 1?>"><?php echo date('yy') - 1?></option>
          <option value="<?php echo date('yy')?>" selected><?php echo date('yy')?></option>
        
        </select>
        <div class="table-responsive">
          <div class="table-responsive">
            <table class="table table-sm table-striped" >
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Leave Type</th>
                  <th>Dates</th>
                  <th>No of Days</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody id='tblleavehistory'>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="button">Save</button>
      </div>
    </div>
  </div>
</div>
<!--end of leave history-->
<!--in lieu-->
<div role="dialog" tabindex="-1" class="modal fade" id="inlieu">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Leave History</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
       
        <div class="table-responsive">
          <div class="table-responsive">
            <table class="table table-sm table-striped" >
              <thead>
                <tr>
                  <th>Date Applied<input type='hidden' id='dateselected'/></th>
                  <th>No of hours</th>
                   <th>Claim Type</th>
                  <th>Status</th>
                  <th>Action</th>
                 
                </tr>
              </thead>
              <tbody id='tblinlieu'>
              </tbody>
            </table>
            <div id="claimdetails" class="table-responsive">
            
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="button">Save</button>
      </div>
    </div>
  </div>
</div>
<!--end of in-lieu-->
<!--change pass-->

<div role="dialog" tabindex="-1" class="modal fade" id="changepass">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Change Password</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
       
        <div class="table-responsive">
          <div class="table-responsive">
            <table class="table table-sm" >
             <tr>
               <td>*New Password:</td>
               <td><input type='password' class='form-control' id='pass' placeholder="new password" maxlength="16"/></td>
             </tr>
               <tr>
               <td>*Confirm Password:</td>
               <td><input type='password' class='form-control' id='confirmpass' placeholder="new password" maxlength="16"/></td>
             </tr>
              
            </table>
            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="button" onClick="update_password()">Submit</button>
      </div>
    </div>
  </div>
</div>
<!--change pass-->
</body>
</html>
<script src="scripts/dashboard.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(e) {
	var currentdate=new Date();
	document.getElementById('leavedate').valueAsDate = new Date();
	var today=new Date();
	var month=today.getMonth()+1;
	$("#holmonth").val(month)
	load_today_holiday();
    load_staff_leave();
	setTimeout(load_staff_leave,60000);
});


</script>