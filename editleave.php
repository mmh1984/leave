<?php
session_start();
if(!isset($_SESSION["username"])){
  header("location:index.html");	
}
$username=$_SESSION["username"];
$leaveid=$_GET['leaveid'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Leave Application</title>
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/Footer-Basic.css">
<link rel="stylesheet" href="assets/css/Footer-Clean.css">
<link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
<link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<div class="container">
  <div class="row">
    <div class="col-sm-9" style="padding-top:15px;padding-bottom:15px;">
      <h2 class="text-left text-secondary"><a href="dashboard.php">Leave Application</a></h2>
    </div>
    <div class="col-sm-3" style="padding-top:15px;padding-bottom:15px;"> </div>
  </div>
</div>
</div>
<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header" style="background-color:rgba(4,29,65,0.89);">
          <h5 class="text-white mb-0">Leave Application</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td>*Leave Type
                    <input type='hidden' id='leaveid' value="<?php echo $leaveid?>"/></td>
                  <td><select style="padding:8px;" id="leavetype">
                      <option value="Annual Leave" selected="">Annual Leave</option>
                      <option value="Advance Leave">Advance Leave</option>
                      <option value="Unpaid Leave">Unpaid Leave</option>
                      <option value="Compassionate Leave">Compassionate Leave</option>
                      <option value="Maternity Leave">Maternity Leave</option>
                      <option value="Medical Leave">Medical Leave</option>
                      <option value="In-Lieu">In-Lieu</option>
                      <option value="Others">Others</option>
                    </select></td>
                </tr>
                <tr>
                  <td>*Start Date (dd/MM/yyyy)</td>
                  <td>
                  <select id="sDD" style="padding:8px;">
                    <?php
					  for ($x=1;$x<=31;$x++){
						echo "<option value='$x'>$x</option>";  
					  }
					?>
                  </select>
                  <select id="sMM" style="padding:8px;">
                    <?php
					  for ($x=1;$x<=12;$x++){
						echo "<option value='$x'>$x</option>";  
					  }
					?>
                  </select>
                  <select id="sYY" style="padding:8px;">
                    <?php
					  $y=date("yy");
					  for ($x=$y;$x<=$y+1;$x++){
						echo "<option value='$x'>$x</option>";  
					  }
					?>
                  </select>
                    &nbsp;Time:
                    <select style="padding:8px;" id="starttype">
                      <option value="Full-Day">Full-Day</option>
                      <option value="Half-Day (AM)">Half-Day (AM)</option>
                      <option value="Half-Day (PM)">Half-Day (PM)</option>
                    </select></td>
                </tr>
                <tr>
                  <td>*End Date</td>
                  <td><select id="eDD" style="padding:8px;">
                    <?php
					  for ($x=1;$x<=31;$x++){
						echo "<option value='$x'>$x</option>";  
					  }
					?>
                  </select>
                  <select id="eMM" style="padding:8px;">
                    <?php
					  for ($x=1;$x<=12;$x++){
						echo "<option value='$x'>$x</option>";  
					  }
					?>
                  </select>
                  <select id="eYY" style="padding:8px;">
                    <?php
					  $y=date("yy");
					  for ($x=$y;$x<=$y+1;$x++){
						echo "<option value='$x'>$x</option>";  
					  }
					?>
                  </select>
                    Time:
                    <select style="padding:8px;margin-left:5px;" id="endtype">
                      <option value="Full-Day">Full-Day</option>
                      <option value="Half-Day (AM)">Half-Day (AM)</option>
                      <option value="Half-Day (PM)">Half-Day (PM)</option>
                    </select></td>
                </tr>
                <tr>
                  <td>*Days Applied</td>
                  <td><input type="text" maxlength="4" id="days"></td>
                </tr>
                <tr>
                  <td>*Reason</td>
                  <td><textarea rows="3" style="width:100%;" id="reason" maxlength="128"></textarea></td>
                </tr>
                <tr>
                  <td>*Person Relieving</td>
                  <td><select style="padding:8px;width:350px;"id="relieving">
                    </select>
                    Position
                    <select style="padding:8px;margin-left:5px;width:200px;" id="position">
                      <option value="lecturer" selected="">lecturer</option>
                      <option value="admin">admin</option>
                    </select></td>
                </tr>
                <tr>
                  <td>Job Specifications</td>
                  <td><textarea rows="2" style="width:100%;" id="jobspecs"></textarea></td>
                </tr>
                <tr>
                  <td></td>
                  <td><button class="btn btn-primary" type="button" style="margin:5px;" onClick="update_leave()">Update</button>
                    <button class="btn btn-warning" type="button" style="margin:5px;" onclick="cancel_leave()">Cancel Leave</button>
                    <button class="btn btn-light" type="button" onClick="window.location.href='dashboard.php'">Back</button>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="footer-basic">
  <footer>
    <p class="copyright"><a href="www.kemudainstitute.com">Kemuda Institute ?? 2020</a></p>
  </footer>
</div>
<div class="modal fade modal lg" role="dialog" tabindex="-1" id="leavemodal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Leave Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">??</span></button>
      </div>
      <div class="modal-body">
        <p>The content of your modal.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="button">Save</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(e) {
    load_staff();
	load_leave();
	
});

var daysapplied=0;
$("#days").val(daysapplied);

$("#enddate").change(function(e) {
    update_days();
	
});

function load_staff(){
	$.ajax({
	type:"POST",
	url:"controls/staff.php",
	data:{
	op:"loadstaff"	
	},
	success:function(result){
		$("#relieving").append(result);
	}
	});
	
}

function update_days(){
	daysapplied=0;
	$.ajax({
	
	  type:"POST",
			url:"controls/functions.php",
			data:{
			op:"noofdays",
			date1:$("#startdate").val(),
			date2:$("#enddate").val()	
			},	
	  success:function(result){
		  
		  if(isNaN(result)){
			alert("End date must be greater than start date");  
		  }
		  else{
			  daysapplied=parseInt(result);
			  daysapplied++;
			  $("#days").val(daysapplied);
		  }
		  //daysapplied+=parseInt(result)
      }
    });
} 
function load_leave(){
   id=$("#leaveid").val();
   $.ajax({
	type:"POST",
	url:"controls/leave.php",
	data:{
	  op:"search",
	  id:id	
	},
	success:function(result){
		
		var json=JSON.parse(result);
		
		$("#leavetype").val(json.type);
		$("#sDD").val(parseInt(json.sDD));
		$("#sMM").val(parseInt(json.sMM));
		$("#sYY").val(json.sYY);
		$("#starttype").val(json.stype);
		$("#eDD").val(parseInt(json.eDD));
		$("#eMM").val(parseInt(json.eMM));
		$("#eYY").val(json.eYY);
		$("#endtype").val(json.etype);
		$("#days").val(json.days);
		$("#reason").val(json.reason);
		$("#relieving").val(json.relieved);
		$("#position").val(json.position);
		$("#jobspecs").val(json.job);
		
	}
	   
	   
   });	
	
}
function cancel_leave(){
    id=$("#leaveid").val();	
	$.ajax({
		  type:"POST",
		  url:"controls/leave.php",
		  data:{
			op:"cancel",
			id:id,
			
		  },
		  success:function(result){
				if (result=="SUCCESS"){
				alert("Your leave has been cancelled");
				window.location.href='dashboard.php';	
				}
		  }	
			
		});
}
function update_leave(){
	id=$("#leaveid").val();
	var type=$("#leavetype").val();
	var start=$("#sYY").val() + "-" + $("#sMM").val() + "-" + $("#sDD").val()
	var starttype=$("#starttype").val();
	var end=$("#eYY").val() + "-" + $("#eMM").val() + "-" + $("#eDD").val()
	var endtype=$("#endtype").val();
    var days=$("#days").val();
	var reason=$("#reason").val();
	var reliever=$("#relieving").val();
	var job=$("#jobspecs").val();
	var position=$("#position").val();
	if (reason.length==0){
	 	 $("#reason").after("<span class='text-danger'>Please enter reason for applying</span>");
	}
	else{
		$("#reason").next("span").remove();
		var vdata=[];
		vdata.push(type);
		vdata.push(start);
		vdata.push(starttype);
		vdata.push(end);
		vdata.push(endtype);
		vdata.push(days);
		vdata.push(reason);
		vdata.push(reliever);
		vdata.push(job);
		vdata.push(position);
		$.ajax({
		  type:"POST",
		  url:"controls/leave.php",
		  data:{
			op:"update",
			id:id,
			content:vdata  
		  },
		  success:function(result){
				if (result=="SUCCESS"){
				alert("Your leave has been updated");
				window.location.href='dashboard.php';	
				}
		  }	
			
		});
	}
	
}

</script>