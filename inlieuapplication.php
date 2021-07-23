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
    <div class="col-sm-9" style="padding-top:15px;padding-bottom:15px;">
      <h2 class="text-left text-white"><a href="dashboard.php" style="color:#fff"><img src="assets/img/back.png" class="img-fluid" style="width:3%;margin-right:20px"/></a>In-Lieu Application</h2>
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
          <h5 class="text-white mb-0">Details</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td>*Type</td>
                  <td><select style="padding:8px;" id="type">
                      <option value="Task/Job Related">Task/Job Related</option>
                      <option value="Upon Request by the Management">Upon Request by the Management</option>
                      <option value="Public Holiday">Public Holiday</option>
                      <option value="Outstation">Outstation</option>
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
                  </td>
                </tr>
                <tr>
                  <td>*Time</td>
                  <td>Time (Start)
                    <input type="time" style="padding:8px;margin-left:5px" id="starttime"/>
                    Time (End)
                    <input type="time" style="padding:8px;margin-left:5px" id="endtime"/>
                   </td>
                </tr>
                <tr>
                  <td>*Work Description</td>
                  <td><input type="text" class="form-control" id="workdesc"/></td>
                </tr>
                <tr>
                  <td>*Hours Claimed</td>
                  <td><input type="number"  class="form-control" style="width:30%;" id="hours" step="0.5"/></td>
                </tr>
                <tr>
                  <td colspan="2"><button class="btn btn-primary" type="button" id="btnadd">Add</button></td>
                </tr>
                <tr></tr>
              </tbody>
            </table>
          </div>
          <div class="table-responsive" >
            <table class="table">
              <thead>
                <tr>
                  <th>Select</th>
                  <th>Date</th>
                  <th>Start Time</th>
                  <th>End Time</th>
                  <th>Work Description</th>
                  <th>Hours Claimed</th>
                </tr>
              </thead>
              <tbody id="workdetails">
              </tbody >
            </table>
          </div>
          <button class="btn btn-warning float-right" type="button" style="margin:5px;" onClick="window.location.href='dashboard.php'">Cancel</button>
          <button class="btn btn-primary float-right" type="button" style="margin:5px;" onClick="save_inlieu()">Submit</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="footer-basic bg-light">
  <footer>
    <p class="copyright"><a href="www.kemudainstitute.com">Kemuda Institute © 2020</a></p>
  </footer>
</div>

</body>
</html>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(e) {
   
});
var list1=[];

$("#btnadd").click(function(e) {
   
	if($("#starttime").val().length==0){
		$("#starttime").after("<span class='text-danger'>Please enter start time</span>")
	}
	else if($("#endtime").val().length==0){
		$("#endtime").after("<span class='text-danger'>Please enter end time</span>")
	}
	else if($("#workdesc").val().length==0){
		$("#workdesc").after("<span class='text-danger'>Please enter work description</span>")
	}
	else if($("#hours").val().length==0){
		$("#hours").after("<span class='text-danger'>Please enter work hours</span>")
	}
	else{
		
		$("#starttime").next("span").remove();
		$("#endtime").next("span").remove();
		$("#workdesc").next("span").remove();
		$("#hours").next("span").remove();
		
		var start=$("#sYY").val() + "-" + $("#sMM").val() + "-" + $("#sDD").val()
		list1.push({date:start,time1:$("#starttime").val(),time2:$("#endtime").val(),work:$("#workdesc").val(),hours:$("#hours").val()})
		
		
		var data="";
		
		for (x=0;x<list1.length;x++){
		data+="<tr>"
		data+="<td><button onclick='remove_entry("+ x +")'>Remove</button></td>";
		data+="<td>"+ list1[x].date +"</td>";
		data+="<td>"+ list1[x].time1 +"</td>";
		data+="<td>"+ list1[x].time2 +"</td>";
		data+="<td>"+ list1[x].work +"</td>";
		data+="<td>"+ list1[x].hours +"</td>";
		
		data+="</tr>"
		
		}
		
		$("#workdetails").html(data);
		
		$("#starttime").val("");
		$("#endtime").val("");
		$("#workdesc").val("");
		$("#hours").val("");
	}
	
});

function remove_entry(id){
	list1.splice(id,1)
	
	var data="";
		
		for (x=0;x<list1.length;x++){
		data+="<tr>"
		data+="<td><button onclick='remove_entry("+ x +")'>Remove</button></td>";
		data+="<td>"+ list1[x].date +"</td>";
		data+="<td>"+ list1[x].time1 +"</td>";
		data+="<td>"+ list1[x].time2 +"</td>";
		data+="<td>"+ list1[x].work +"</td>";
		data+="<td>"+ list1[x].hours +"</td>";
		
		data+="</tr>"
		
		}
		
		$("#workdetails").html(data);
		
		$("#starttime").val("");
		$("#endtime").val("");
		$("#workdesc").val("");
		$("#hours").val("");
}

function save_inlieu(){
     if (list1.length==0){
	   alert("No claims to save");	 
	 }	
	 else{
	
	  $.ajax({
		url:"controls/inlieu.php",
		type:"POST",
		data:{
		  op:"save",	
		  list:list1,
		  type:$("#type").val()	
		},
		success:function(result){
		  if (result=="OK"){
			alert("Your claim has been submitted!");
			window.location.href='dashboard.php'  
		  }	
		}  
		  
	  });	 
		 
	 }
	
}
</script>