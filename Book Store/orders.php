<?php
include "config.php";
session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
	header('location:loginpage.php');
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
<!-- custom  css file link-->
<link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include "header.php";?>

<div class="heading">
<h3>Placed Orders</h3>
<p><a href="home.php">Home</a> / Orders</p>
</div>

<section class="placed-orders">
<h1 class="title">Placed Orders</h1>


<div class="box-container">
<?php
$order_query=mysqli_query($conn,"SELECT * FROM `orders` WHERE user_id='$user_id'")or die("Query failed");
if(mysqli_num_rows($order_query)>0)
{
	while($fetch_order=mysqli_fetch_assoc($order_query)){
		
		?>
		
		<div class="box">
		<p>Placed on: <span><?php echo $fetch_order['placed_on']?></span></p>
		<p>Name:  <span><?php echo $fetch_order['name']?></span></p>
		<p>Number: <span><?php echo $fetch_order['number']?></span></p>
		<p>Email: <span><?php echo $fetch_order['email']?></span></p>
		<p>Address: <span><?php echo $fetch_order['address']?></span></p>
		<p>Payment method: <span><?php echo $fetch_order['method']?></span></p>
		<p>Your orders: <span><?php echo $fetch_order['total_products']?></span></p>
		<p>Total price: <span>Rs <?php echo $fetch_order['total_price']?>/-</span></p>
		<p>Payment status: <span style="color:<?php if($fetch_order['payment_status']=='pending'){echo 'red';}else{echo 'green';}?>"><?php echo $fetch_order['payment_status']?></span></p></div>
		
		<?php
	}
}
else{
	
	echo "<p class='empty'>Nothing to show</p>";
}
?>

</div>

</section>





<?php include "footer.php";?>

<script src="js/script.js"></script>
</body>
</html>