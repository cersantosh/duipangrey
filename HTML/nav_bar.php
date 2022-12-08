<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../CSS/nav_bar.css?v=<?php echo time(); ?>">

</head>
<body>
    

<nav class="nav_bar">
            <div class="logo_image">
                <img src="../Images/logo.png" alt="" class="logo">
            </div>

            <ul class="links">
                <li><a href="index.php">Home</a></li>

                <li><a href="sellbikes.php">Sell Bikes</a></li>
                <li><a href="sellscooters.php">Sell Scooters</a></li>
                <?php
                if (isset($_SESSION['login_successful'])) {

                ?>
                    <li><a href="view_add_to_cart_bikes.php">Add To Cart</a></li>
                <?php
                }
                ?>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="login.php">Login</a></li>
                <?php
                if (isset($_SESSION['login_successful'])) {

                ?>
                    <li><a href="my_products.php" class="product nav">My Products</a></li>
                    <li><a href="profile.php" class="profile nav">Profile</a></li>
                    <li><a href="logout.php" class="logout nav">Log Out</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    
</body>
</html>



