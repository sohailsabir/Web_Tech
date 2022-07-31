<?php
include "config.php";
if(isset($_POST['submit'])){
	$name=$_POST['name'];
	$email=$_POST['email'];
	$password=($_POST['password']);
	$cpassword=($_POST['cpassword']);
	$user_type=$_POST['user_type'];
	
if(!preg_match("|^[a-zA-Z ]{3,25}$|",$name))
{
	$message[]="Name must contain at least 3 characters";
}
elseif(!preg_match("|^(?=.*[@])(?=.*[$]).{8,}$|",$password))
{
	$message[]="Password must contain @ $ and minimum length 8";
}
else{
	
	
	$select_users=mysqli_query($conn,"SELECT * FROM `users` WHERE email='$email' ") or die("query failed");
	if(mysqli_num_rows($select_users)>0){
		$message[]="User aleardy Exist!";
		
	}
	else{
		if($password==$cpassword){
			mysqli_query($conn,"INSERT INTO `users` (name,email,password,user_type)VALUES('$name','$email',md5('$cpassword'),'$user_type')") or die("query failed");
			$message[]="Register Successfully!";
			header('location:loginpage.php');
		}
		else{
			$message[]="Comfirm password not matched!";
		}
		
}
	
}


	
	
	
	
	
}


?>



<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>register</title>
<!--font awesome cdn link-->

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- custom css file link-->
<link rel="stylesheet" href="css/style.css">
<style>
body {
  background-image: url('img/bg2.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;
}
</style>
</head>




<body>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>




<center>
<div class="form-container">
<form action="" method="post" autocomplete="on">
<h3>Register Now</h3>
<input type="text" name="name" placeholder="Enter your name" required class="box">
<input type="email" name="email" placeholder="Enter your Email" required class="box">
<input type="password" name="password" placeholder="Enter your password" required class="box">
<input type="password" name="cpassword" placeholder="Comfirm your password" required class="box">
<select name="user_type" class="box">
<option value="user">User</option>
<option value="admin">Admin</option>

</select>
<input type="submit" name="submit" value="Register now" class="btn">
<p>Already have an Account?<a href="loginpage.php">Login now</a></p>



</form>
</div>
</center>
</body>
</html>