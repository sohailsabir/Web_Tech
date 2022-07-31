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
   <title>About</title>
   <!--font awesome cdn link-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<!-- custom  css file link-->
<link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include "header.php";?>



<div class="heading">
<h3>About us</h3>
<p><a href="home.php">Home</a> / About</p>
</div>


<section class="about">

   <div class="flex">

      <div class="image">
         <img src="img/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>About us</h3>
         <p>We work to connect readers with independent booksellers all over the world. We believe local bookstores are essential community hubs that foster culture, curiosity, and a love of reading, and we're committed to helping them survive and thrive. Our platform gives independent bookstores tools to compete online and financial support to help them maintain their presence in local communities. </p>
         
      </div>

   </div>

</section>





<?php include "footer.php";?>

<script src="js/script.js"></script>
</body>
</html>