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

<header class="header">
<div class="header-1">
<div class="flex">
<div class="share">
<a href="https://web.facebook.com/sohail.sabir.9279" class="fab fa-facebook-f" target="blank"></a>
<a href="#" class="fab fa-twitter"></a>
<a href="https://www.instagram.com/sohailsabir_65/" class="fab fa-instagram" target="blank"></a>

</div>
<p>New <a href="loginpage.php">Login</a> | <a href="register.php">Register</a></p>
</div>
</div>


<div class="header-2">
<div class="flex">
<a href="home.php" class="logo">Bookstore</a>
<nav class="navbar">
<a href="home.php">Home</a>
<a href="about.php">About</a>
<a href="shop.php">Shop</a>
<a href="orders.php">Orders</a>
</nav>
<div class="icons">
<div id="menu-btn" class="fas fa-bars"></div>
<a href="search.php" class="fas fa-search"></a>
<div id="user-btn" class="fas fa-user"></div>
<?php
$select_cart_number=mysqli_query($conn,"SELECT * FROM `cart` WHERE user_id='$user_id'")or die("Query failed");
$cart_rows_number=mysqli_num_rows($select_cart_number);

?>
<a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?php echo $cart_rows_number;?>)</span></a>

</div>
<div class="user-box">
         <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
         <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
		 <a href="logoutpage.php" class="delete-btn">Logout</a>
      
      </div>
</div>
</div>
</header>