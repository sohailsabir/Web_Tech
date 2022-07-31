<?php
include "config.php";
session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
	header('location:loginpage.php');
}


if(isset($_POST['order_btn'])){
	$name=$_POST['name'];
	$number=$_POST['number'];
	$email=$_POST['email'];
	$address=$_POST['address'];
	$method=$_POST['method'];
	$placed_on=date('d-M-Y');
	$cart_total=0;
	$cart_product[]='';
	
if(!preg_match("|^[a-zA-Z ]{3,25}$|",$name))
{
	$message[]="Name must contain at least 3 characters";
}
elseif(!preg_match("|^([0-9]{11})$|",$number)){
	$message[]="Phone number length must be 11";
}
else{
	$cart_query=mysqli_query($conn,"SELECT * FROM `cart` WHERE user_id='$user_id'")or die('Query failed');
	if(mysqli_num_rows($cart_query)>0){
		while($cart_item=mysqli_fetch_assoc($cart_query)){
			$cart_product[]=$cart_item['name'].'('.$cart_item['quantity'].')';
			$sub_total=($cart_item['price']*$cart_item['quantity']);
			$cart_total+=$sub_total;
		}
	}
	$total_products=implode(',',$cart_product);
	$order_query=mysqli_query($conn,"SELECT * FROM `orders` WHERE name='$name' AND number='$number' AND email='$email' AND method='$method' AND address='$address' AND total_products='$total_products' AND total_price='$cart_total'")or die("Query failed");
	if($cart_total==0)
	{
		$message[]='Your cart is empty!';
		
	}
	else{
		if(mysqli_num_rows($order_query)>0){
			$message[]='Order alredy placed!';
		}
		else{
						
			mysqli_query($conn,"INSERT INTO `orders`(user_id,name,number,email,method,address,total_products,total_price,placed_on)VALUES('$user_id','$name','$number','$email','$method','$address','$total_products','$cart_total','$placed_on')")or die("Query failed");
			$message[]='Order place successfully!';
			mysqli_query($conn,"DELETE FROM `cart` WHERE user_id='$user_id'")or die("Query failed");
		}
	}
	}
	
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   <!--font awesome cdn link-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<!-- custom  css file link-->
<link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include "header.php";?>

<div class="heading">
<h3>Checkout</h3>
<p><a href="home.php">Home</a> / Checkout</p>
</div>



<section class="display-order">
<?php
$grand_total=0;
$select_cart=mysqli_query($conn,"SELECT * FROM `cart` where user_id='$user_id'")or die("Query failed");
if(mysqli_num_rows($select_cart)>0){
	while($fetch_cart=mysqli_fetch_assoc($select_cart)){
			$total_price=($fetch_cart['price']*$fetch_cart['quantity']);
			$grand_total+=$total_price;
			?>
			<p><?php echo $fetch_cart['name'].' '  ?><span>(<?php echo 'Rs '.$fetch_cart['price'].'x'.$fetch_cart['quantity'];?>)</span></p>
			<?php
	}
}
else{
	echo "<p class='empty'>Nothing to show</p>";
}
?>
<div class="grand-total">
Grand total:  
<span>
Rs
<?php

echo $grand_total;


?>
/-
</span>
</div>



</section>








<section class="checkout">

<form action=""   method="post">
<h3>Place Your Order</h3>
<div class="flex">


<div class="inputbox">
<span>
Your name: </span><br>
<input type="text" name="name" placeholder="Enter your name" required>
</div>



<div class="inputbox">
<span>
Your number: </span><br>
<input type="number" name="number" placeholder="Enter your number" required>
</div>



<div class="inputbox">
<span>
Your Email: </span><br>
<input type="email" name="email" placeholder="Enter your email" required>
</div>



<div class="inputbox">
<span>
Payment method: </span><br>
<select name="method" required>
<option value="cash on delivery">cash on delivery</option>
</select>
</div>


<div class="inputbox">
<span>
Your Address: </span><br>
<input type="text" name="address" placeholder="Enter your address" required>
</div>



</div>


<input type="submit" value="Order now" class="btn" name="order_btn">
</form>

</section>






<?php include "footer.php";?>

<script src="js/script.js"></script>
</body>
</html>