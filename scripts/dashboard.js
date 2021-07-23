// JavaScript Document
function load_staff_leave(){
	
	 $.ajax({
	type:"POST",
	url:"controls/leave.php",
	data:{
	   op:"staffleave",
	   date:$("#leavedate").val()	
	},
	success:function(result){
		
		$("#staffonleave").html("");
		if (result=="NONE"){
		$("#staffonleave").append("<h3 class='text-center text-info'>No staff(s) on leave</h3>");
		}
		else{
		$("#staffonleave").append(result);
		}
	} 
	  
  });
	
}
function load_allocation(){
	year=$("#allyear").val()
  $.ajax({
	type:"POST",
	url:"controls/leave.php",
	data:{
	   op:"allocations",
	   year:year	
	},
	success:function(result){
		$("#tblallocation").html("");
		if(result!="NONE"){
		$("#tblallocation").append(result);
		}
		else{
		$("#tblallocation").append("<p class='text-center text-danger'>No allocations for the year selected</p>");	
		}
	} 
	  
  });	
	
}

function load_leave_status(){
	 $.ajax({
	type:"POST",
	url:"controls/leave.php",
	data:{
	   op:"status"
	  	
	},
	success:function(result){
		$("#tblleavestatus").html("");
		if (result=="NONE"){
		$("#tblleavestatus").append("<h3 class='text-center text-info'>No leave(s) applied yet</h3>");
		}
		else{
		$("#tblleavestatus").append(result);
		}
	} 
	  
  });
	
}
function load_leave_history(){
	 $.ajax({
	type:"POST",
	url:"controls/leave.php",
	data:{
	   op:"history",
	    year:$("#historyyear").val() 
	},
	success:function(result){
		$("#tblleavehistory").html("");
		if (result=="NONE"){
		$("#tblleavehistory").append("<h4 class='text-info'>No leave history</h4>");
		}
		else{
		$("#tblleavehistory").append(result);
		}
	} 
	  
  });
	
}
function edit_leave(id){
window.location.href='editleave.php?leaveid=' + id;
}

function load_inlieu(){
$.ajax({
   type:"POST",
   url:"controls/inlieu.php",
   data:{
	op:"inlieu"   
   },
   success:function(result){
	$("#tblinlieu").html("");  
	   
		if (result=="NONE"){
		$("#tblinlieu").append("<h4 class='text-info'>No in-lieu claims</h4>");
		}
		else{
		$("#tblinlieu").html(result);	
		 $("#claimdetails").html("");
		}
   }	
	
});	
	
}


function view_claim(id){
 var d=document.getElementsByName("claimdate[]");
 var date=d[id].value;
 $("#dateselected").val(date);
 $.ajax({
    url:"controls/inlieu.php",
	type:"POST",
	data:{
	  op:"claims",
	  claimdate:date	
	},
	success:function(result){
	 $("#claimdetails").html(result);	
	}	 
	 
 });
}
function delete_claim(id){
	$.ajax({
		url:"controls/inlieu.php",
		type:"POST",
		data:{
	  	  op:"deleteclaims",
	  	  claimid:id	
	},
	success:function(result){
	 if (result=="OK"){
	 alert("Claim removed");
	  $("#claimdetails").html("");
	 load_inlieu();
	
	 }
	 else{
	    alert(result);	 
	 }
	}	
		
	});
}

function load_holiday(){
  $.ajax({
	type:"POST",
	data:{
	  op:"all"	
	},
	url:"controls/holiday.php",
	success:function(result){
	  $("#tblholiday").html(result);
	   	
	}  
	  
   });	
}

function load_today_holiday(){
  $.ajax({
	type:"POST",
	data:{
	  op:"today",
	  month:$("#holmonth").val()	
	},
	url:"controls/holiday.php",
	success:function(result){
	  $("#tblholiday").html(result);
	   	
	}  
	  
   });	
}

function update_password(){
var pass=$("#pass").val();
var cpass=$("#confirmpass").val();
$("#pass").next("span").remove();
$("#confirmpass").next("span").remove();
if (pass.length==0 || pass.length < 8){
	$("#pass").after("<span class='text-warning'>Password must be at least 8 characters long</span>");
}
else if (cpass.length==0 || cpass.length < 8){
	$("#confirmpass").after("<span class='text-warning'>Password must be at least 8 characters long</span>");
}
else if (pass!=cpass){
	$("#confirmpass").after("<span class='text-warning'>Passwords didn't match</span>");
}
else{
	$("#pass").next("span").remove();
$("#confirmpass").next("span").remove();
	$.ajax({
	  type:"POST",
	  url:"controls/staff.php",
	  data:{
		newpass:cpass,
		op:"changepass"  
	  },
	  success:function(result){
		alert(result);  
	  }	
		
	});	
}
	
}