$("#btnlogin").click(function(e) {
    var email=$("#email").val();
	var pass=$("#pass").val();
	
	if(email.length==0){
	   $("#email").after("<span class='text-danger'>Please enter your email</span>");	
    }
	else if(pass.length==0){
	   $("#pass").after("<span class='text-danger'>Please enter your password</span>");	
    }
	else{
		$("#email").next("span").remove();
		$("#pass").next("span").remove();
		$.ajax({
			type:"POST",
			url:"controls/staff.php",
			data:{
			op:"login",
			email:email,
			pass:pass	
			},
		success:function(result){
			if (result=="OK"){
				
				
				alert("Login successful");
				window.location.href='dashboard.php';
				
			}
			else{
				alert("Invalid credentials");
			}
		}
			
		});
		
	}
}); 
