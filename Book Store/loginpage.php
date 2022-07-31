<?php
include "config.php";
session_start();
if(isset($_POST['submit'])){
	
	$email=$_POST['email'];
	$password=md5($_POST['password']);
	$select_users=mysqli_query($conn,"SELECT * FROM `users` WHERE email='$email' AND password='$password'") or die("query failed");
	if(mysqli_num_rows($select_users)>0){
		$row=mysqli_fetch_assoc($select_users);
		if($row['user_type']=='admin'){
			$_SESSION["admin_name"]=$row['name'];
			$_SESSION["admin_email"]=$row['email'];
			$_SESSION["admin_id"]=$row['id'];
			header('location:adminpage.php');
			
		}
		elseif($row['user_type']=='user'){
			$_SESSION["user_name"]=$row['name'];
			$_SESSION["user_email"]=$row['email'];
			$_SESSION["user_id"]=$row['id'];
			header('location:home.php');
		}
		
	}
	else{
		$message[]="Incorrect email or password";
		
	}
	
	
}


?>




<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<!--font awesome cdn link-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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




<div class="form-container">
<form action="" method="post">
<h3>Login Now</h3>
<input type="email" name="email" placeholder="Enter your Email" required class="box">
<input type="password" name="password" placeholder="Enter your password" required class="box">
<input type="submit" name="submit" value="Login now" class="btn">
<p>Don't have an Account?<a href="register.php">Register now</a></p>



</form>
</div>
</body>
</html>