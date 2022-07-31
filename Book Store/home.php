<?php
include "config.php";
session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
	header('location:loginpage.php');
}

if(isset($_POST['add_to_cart']))
{
	$product_name=$_POST['product_name'];
	$product_price=$_POST['product_price'];
	$product_image=$_POST['product_image'];
	$product_quantity=$_POST['product_quantity'];
	$check_cart_numbers=mysqli_query($conn,"SELECT * FROM `cart` WHERE  name='$product_name' AND user_id='$user_id'")or die("query failed");
	if(mysqli_num_rows($check_cart_numbers)>0){
		$message[]='Already added to cart!';
	}
	else{
		mysqli_query($conn,"INSERT INTO `cart`(user_id,name,price,quantity,image)VALUES('$user_id','$product_name','$product_price','$product_quantity','$product_image')")or die("query failed");
		$message[]='Added to cart!';
	}
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home Page</title>
   <!--font awesome cdn link-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<!-- custom  css file link-->
<link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include "header.php";?>


<section class="home">
<div class="content">
<h3>Hand Picked Book To Your Door</h3>
<a href="about.php" class="white-btn">Discover more</a>
</div>
</section>
















<section class="product">
<h1 class="title">Latest Products</h1>
<div class="box-container">
<?php 
$select_products=mysqli_query($conn,"SELECT * FROM `products` ORDER BY id DESC LIMIT 6")or die("Query failed");
if(mysqli_num_rows($select_products)>0){
	while($fetch_products=mysqli_fetch_assoc($select_products)){
		?>
		<form action="" method="POST" class="box">
		<img src="uploaded_img/<?php echo $fetch_products['image'];?>" alt="">
		<div class="name">
		<?php echo $fetch_products['name'];?>
		</div>
		<div class="price">Rs 
		<?php echo $fetch_products['price'];?>/-
		</div>
		<input type="number" min="1" name="product_quantity" value="1" class="qty">
		<input type="hidden" name="product_name" value="<?php echo $fetch_products['name'];?>">
		<input type="hidden" name="product_price" value="<?php echo $fetch_products['price'];?>">
		<input type="hidden" name="product_image" value="<?php echo $fetch_products['image'];?>">
		<input type="submit" value="add to cart" name="add_to_cart" class="btn">
		</form>
	<?php
	}
}
else{
	echo '<p class="empty">No product add yet!</p>';
}
?>
</div>

<div class="load-more" style="margin-bottom:1.5rem;text-align:center">
<a href="shop.php" class="option-btn">load more</a>
</div>

</section>




<section class="about">

   <div class="flex">

      <div class="image">
         <img src="img/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>About us</h3>
         <p>We work to connect readers with independent booksellers all over the world. We believe local bookstores are essential community hubs that foster culture, curiosity, and a love of reading, and we're committed to helping them survive and thrive. </p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>








<?php include "footer.php";?>

<script src="js/script.js"></script>
</body>
</html>