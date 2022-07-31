<?php
include "config.php";
session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){
	header('location:loginpage.php');
}
if(isset($_POST['update_order'])){
	$order_update_id=$_POST['order_id'];
	$update_status=$_POST['update_payment'];
	mysqli_query($conn,"UPDATE `orders` SET payment_status='$update_status' where id='$order_update_id'")or die('Query Failed');
	$message[]="Payment status Update!";
}
if(isset($_GET['delete'])){
	$delete_id=$_GET['delete'];
	mysqli_query($conn,"DELETE FROM `orders` WHERE id='$delete_id'")or die("Query failed");
	header('location:admin_orders.php');
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>
   <!--font awesome cdn link-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<!-- custom admin css file link-->
<link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include "admin_header.php";?>
<section class="order">
<h1 class="title">Placed Orders</h1>
<div class="box-container">
<?php 
$select_orders=mysqli_query($conn,"SELECT * FROM `orders`")or die("Query failed");
if(mysqli_num_rows($select_orders)>0){
	while($fetch_orders=mysqli_fetch_assoc($select_orders)){
	?>	
	<div class="box">
	<p>User Id: <span><?php echo $fetch_orders['user_id']; ?></span></p>
	<p>Placed on: <span><?php echo $fetch_orders['placed_on']; ?></span></p>
	<p>Name: <span><?php echo $fetch_orders['name']; ?></span></p>
	<p>Number: <span><?php echo $fetch_orders['number']; ?></span></p>
	<p>Email: <span><?php echo $fetch_orders['email']; ?></span></p>
	<p>Address: <span><?php echo $fetch_orders['address']; ?></span></p>
	<p>Total Products: <span><?php echo $fetch_orders['total_products']; ?></span></p>
	<p>Total Price: <span>Rs <?php echo $fetch_orders['total_price']; ?>/-</span></p>
	<p>Payment Method: <span><?php echo $fetch_orders['method']; ?></span></p>
	<form action="" method="post">
	<input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
	<select name="update_payment" required>
	<option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
	<option value="pending">Pending</option>
	<option value="completed">Completed</option>
	</select>
	<input type="submit" value="Update" name="update_order" class="option-btn">
	<a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Delete this order?');" class="delete-btn">Delete</a>
	</form>
	
	</div>
	<?php
	}
}
else{
	echo '<p class="empty">No orders placed yet!</p>';
}
?>

</div>
</section>


















<script src="js/admin_script.js">

</script>
</body>
</html>