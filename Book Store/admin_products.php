<?php
include "config.php";
session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){
	header('location:loginpage.php');
}
if(isset($_POST['add_product']))
{
	$name=$_POST['name'];
	$price=$_POST['price'];
	$catagory_name=$_POST['catagory'];
	$image=$_FILES['image']['name'];
	$image_size=$_FILES['image']['size'];
	$image_tmp_name=$_FILES['image']['tmp_name'];
	$image_folder='uploaded_img/'.$image;
	$select_product_name=mysqli_query($conn,"SELECT name FROM `products` WHERE name='$name'")or die('Query failed');
	if(mysqli_num_rows($select_product_name)>0)
	{
		$message[]='Product name already added';
	}
	else
	{
		$add_product_query=mysqli_query($conn,"INSERT INTO `products`(name,price,image,catagory)VALUES('$name','$price','$image','$catagory_name')")or die("Query failed");
		if($add_product_query)
		{
			if($image_size>2000000)
			{
				$message[]="Image size is too large";
			}
			else{
				move_uploaded_file($image_tmp_name,$image_folder);
			$message[]="Product add successfully!";
			}
			
		}
		else{
			$message[]="Product could not be added";
		}
	}
	
}
if(isset($_GET['delete']))
{
	$delete_id=$_GET['delete'];
	$delete_image_query=mysqli_query($conn,"SELECT image FROM `products` WHERE id='$delete_id'") or die("Query failed");
	$fetch_delete_image=mysqli_fetch_assoc($delete_image_query);
	unlink('uploaded_img/'.$fetch_delete_image['image']);
	mysqli_query($conn,"DELETE FROM `products` WHERE id='$delete_id'")or die("Query failed");
	header('location:admin_products.php');
}
if(isset($_POST['update_product'])){
	$update_p_id=$_POST['update_p_id'];
	$update_name=$_POST['update_name'];
	$update_catagory_name=$_POST['update_catagory'];
	$update_price=$_POST['update_price'];
	mysqli_query($conn,"UPDATE `products` SET name='$update_name',price='$update_price',catagory='$update_catagory_name' WHERE id='$update_p_id'")or die("Query failed");
	$update_image=$_FILES['update_image']['name'];
	$update_image_size=$_FILES['update_image']['size'];
	$update_image_tmp_name=$_FILES['update_image']['tmp_name'];
	$update_folder='uploaded_img/'.$update_image;
	$update_old_image=$_POST['update_old_image'];
	if(!empty($update_image)){
		if($update_image_size>2000000){
			$message[]='Image file size is too Large';
		}
		else{
			mysqli_query($conn,"UPDATE `products` SET image='$update_image' WHERE id='$update_p_id'")or die("Query failed");
			move_uploaded_file($update_image_tmp_name,$update_folder);
			unlink('uploaded_img/'.$update_old_image);
			
			
		}
	}
	$message[]="Product Updated";
	
	
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>
   <!--font awesome cdn link-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<!-- custom admin css file link-->
<link rel="stylesheet" href="css/admin_style.css">

</head>
<body>


<?php include "admin_header.php";?>



<section class="add-product">
<h1 class="title">Shop Products</h1>
<form action="" method="post" enctype="multipart/form-data">
<h3>Add product</h3>
<input type="text" name="name" class="box" placeholder="Enter book name" required>
<input type="number" name="price" min="0" class="box" placeholder="Enter book price" required>
<input type="text" name="catagory" class="box" placeholder="Enter book catagory" required>
<input type="file" name="image" accept="image/jpg,image/jpeg,image/png" class="box" required>
<input type="submit" value="add product" name="add_product" class="btn">

</form>

</section>




<section class="show-products">
<div class="box-container">
<?php
$select_products=mysqli_query($conn,"SELECT * FROM `products`")or die("Query failed");
if(mysqli_num_rows($select_products)>0)
{
	while($fetch_products=mysqli_fetch_assoc($select_products))
	{
	?>
	<div class="box">
	<img src="uploaded_img/<?php echo $fetch_products['image'];?>" alt="">
	<div class="name"><?php echo $fetch_products['name'];?></div>
	<div class="price">Rs<?php echo $fetch_products['price'];?>/-</div>
 <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
	<a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">delete</a>

	</div>
<?php
}	
}
else{
	echo '<p class="empty">No Products added yet!</p>';
}

?>


</div>

</section>



<section class="edit-product-form">
<?php
if(isset($_GET['update']))
{
	$update_id=$_GET['update'];
	$update_query=mysqli_query($conn,"SELECT * FROM `products` WHERE id='$update_id'")or die("Query failed");
	if(mysqli_num_rows($update_query)>0)
	{
	while($fetch_update=mysqli_fetch_assoc($update_query))
	{
		?>
		<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id'];?>">
		<input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image'];?>">
		<img src="uploaded_img/<?php echo $fetch_update['image'];?>" alt="">
		<input type="text" name="update_name" placeholder="Enter book name" value="<?php echo $fetch_update['name'];?>" class="box" required>
		<input type="number" name="update_price" min="0" placeholder="Enter book Price" value="<?php echo $fetch_update['price'];?>" class="box" required >
		<input type="text" name="update_catagory" placeholder="Enter book catagory" value="<?php echo $fetch_update['catagory'];?>" class="box" required>
		<input type="file" class="box" name="update_image" accept="image/jpg,image/jpeg,image/png">
		<input type="submit" value="update" name="update_product"class="btn">
		<input type="reset" value="cancel" id="close-update"class="option-btn">
		
		</form>
		<?php	
	}
	
	

	}
}else{
	echo'<script>
	document.querySelector(".edit-product-form").style.display = "none";
	</script>';
	
}


?>


</section>
<script src="js/admin_script.js">

</script>
</body>
</html>