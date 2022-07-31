<?php
include "config.php";
session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){
	header('location:loginpage.php');
}
if(isset($_GET['delete'])){
	$delete_id=$_GET['delete'];
	mysqli_query($conn,"DELETE FROM `users` WHERE id='$delete_id'")or die("Query failed");
	header('location:admin_users.php');
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>
   <!--font awesome cdn link-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<!-- custom admin css file link-->
<link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include "admin_header.php";?>



<section class="user">
<div class="box-container">
<?php
$select_users=mysqli_query($conn,"SELECT * FROM `users`")or die("Query failed");
while($fetch_users=mysqli_fetch_assoc($select_users)){
	?>
	<div class="box">
	<p>User name:<span><?php echo $fetch_users['name']?></span></p>
	<p>Email:<span><?php echo $fetch_users['email']?></span></p>
	<p>User type:<span style="color:<?php if($fetch_users['user_type']=='admin'){echo"red";}?>"><?php echo $fetch_users['user_type']?></span></p>
	
	<a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete user</a>
	</div>
	<?php
};

?>
</div>
</section>




<script src="js/admin_script.js">

</script>
</body>
</html>