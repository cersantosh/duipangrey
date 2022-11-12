<?php
session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
// for next and previous button
$value_popular_bikes = -1;
$value_popular_scooters = -1;
$value = -1;
include "../connection.php";


// used to delete image if signup is incomplete because in signup section image is uploaded before verification
// if(isset($_SESSION['signup_complete']) && $_SESSION['signup_complete'] != "true"){
//     $profile_picture_name = $_SESSION['profile_picture_name'];
//     $destination = "../uploaded_images/profile_picture/$profile_picture_name";
//     if(file_exists($destination)){

//         unlink($destination);
//     }
// }

$login = isset($_SESSION['login_successful']);
if (isset($_SESSION['login_successful'])) {
    $email = $_SESSION['login_email'];
    $sql = "select * from signup where email = '$email'";
    $result = mysqli_query($con, $sql) or die("Query Failed !");
    $rows = mysqli_fetch_assoc($result);
    // for displaying profile details
    $name = $rows['full_name'];
    $image_name = $rows['profile_picture'];
    // print($image_name);

    // only showing the products that is not uploaded by this user

    $sql_bikes = "select * from sell_bikes where email != '$email'";
    $sql_scooters = "select * from sell_scooters where email != '$email'";
} else {
    $sql_bikes = "select * from sell_bikes";
    $sql_scooters = "select * from sell_scooters";
}

// end
// showing all the listed company name in the company_name filter section
$sql_company_name_bikes = "select distinct company_name from sell_bikes";
$sql_company_name_scooters = "select distinct company_name from sell_scooters";
$result_company_bikes = mysqli_query($con, $sql_company_name_bikes) or die("Query Failed !");
$result_company_scooters = mysqli_query($con, $sql_company_name_scooters) or die("Query Failed !");

// showing all the listed lot number in the lot number filter section
$sql_lot_no_bikes = "select distinct lot_number from sell_bikes";
$sql_lot_no_scooters = "select distinct lot_number from sell_scooters";
$result_lot_no_bikes = mysqli_query($con, $sql_lot_no_bikes) or die("Query Failed !");
$result_lot_no_scooters = mysqli_query($con, $sql_lot_no_scooters) or die("Query Failed !");

// showing all the listed district in the district filter section
$sql_district_bikes = "select distinct district from sell_bikes";
$sql_district_scooters = "select distinct district from sell_scooters";
$result_district_bikes = mysqli_query($con, $sql_district_bikes) or die("Query Failed !");
$result_district_scooters = mysqli_query($con, $sql_district_scooters) or die("Query Failed !");


// working on mobile filter section
// showing all the listed company name in the company_name filter section
$sql_company_name_bikes_mobile = "select distinct company_name from sell_bikes";
$sql_company_name_scooters_mobile = "select distinct company_name from sell_scooters";
$result_company_bikes_mobile = mysqli_query($con, $sql_company_name_bikes) or die("Query Failed !");
$result_company_scooters_mobile = mysqli_query($con, $sql_company_name_scooters) or die("Query Failed !");

// showing all the listed lot number in the lot number filter section
$sql_lot_no_bikes_mobile = "select distinct lot_number from sell_bikes";
$sql_lot_no_scooters_mobile = "select distinct lot_number from sell_scooters";
$result_lot_no_bikes_mobile = mysqli_query($con, $sql_lot_no_bikes) or die("Query Failed !");
$result_lot_no_scooters_mobile = mysqli_query($con, $sql_lot_no_scooters) or die("Query Failed !");

// showing all the listed district in the district filter section
$sql_district_bikes_mobile = "select distinct district from sell_bikes";
$sql_district_scooters_mobile = "select distinct district from sell_scooters";
$result_district_bikes_mobile = mysqli_query($con, $sql_district_bikes) or die("Query Failed !");
$result_district_scooters_mobile = mysqli_query($con, $sql_district_scooters) or die("Query Failed !");


//showing popular bikes and scooters that is not uploaded by this user
if ($login) {
    $sql_popular_bikes = "select * from sell_bikes join popular_bikes on sell_bikes.id = popular_bikes.bikes_id where count >= 5 and email != '$email'";
    $sql_popular_scooters = "select * from sell_scooters join popular_scooters on sell_scooters.id = popular_scooters.scooters_id where count >= 5 and email != '$email'";
} else {
    $sql_popular_bikes = "select * from sell_bikes join popular_bikes on sell_bikes.id = popular_bikes.bikes_id where count >= 5";
    $sql_popular_scooters = "select * from sell_scooters join popular_scooters on sell_scooters.id = popular_scooters.scooters_id where count >= 5";
}

$result_popular_bikes = mysqli_query($con, $sql_popular_bikes) or die("Query Failed !");
$result_popular_scooters = mysqli_query($con, $sql_popular_scooters) or die("Query Failed !");
$no_of_popular_bikes = mysqli_num_rows($result_popular_bikes);
$no_of_popular_scooters = mysqli_num_rows($result_popular_scooters);

$repeat_div_popular_bikes = $no_of_popular_bikes / 8;
$repeat_div_popular_scooters = $no_of_popular_scooters / 8;
if (is_float($repeat_div_popular_bikes)) {
    $repeat_div_popular_bikes = intval($repeat_div_popular_bikes) + 1;
} else {
    $repeat_div_popular_bikes = $repeat_div_popular_bikes;
}

if (is_float($repeat_div_popular_scooters)) {
    $repeat_div_popular_scooters = intval($repeat_div_popular_scooters) + 1;
} else {
    $repeat_div_popular_scooters = $repeat_div_popular_scooters;
}

// to count no of products remain to display
$actual_popular_bikes_records = $no_of_popular_bikes;
$actual_popular_scooters_records = $no_of_popular_scooters;


// sql command is in login_email section (see above)

$result_bikes = mysqli_query($con, $sql_bikes) or die("Query Failed !");
$result_scooters = mysqli_query($con, $sql_scooters) or die("Query Failed !");
$no_of_bikes = mysqli_num_rows($result_bikes);
$no_of_scooters = mysqli_num_rows($result_scooters);
$total_records = $no_of_bikes + $no_of_scooters;
// print($total_records);

// to make group of products of 8
$repeat_div = $total_records / 8;
if (is_float($repeat_div)) {
    $repeat_div = intval($repeat_div) + 1;
} else {
    $repeat_div = $repeat_div;
}

// to count no of products remain to display
$actual_records = $total_records;
// print($repeat_div);



// print("no of bikes : $no_of_bikes");
// print("no of scooters : $no_of_scooters");

// for showing bikes and scooters randomly
$bikes_or_scooters = array($result_bikes, $result_scooters);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="../CSS/index.css"> -->
    <link rel="stylesheet" href="../../CSS/main/index.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="profile_wrapper">
        <div class="profile_details">
            <img src="../../uploaded_images/profile_picture/<?php print($image_name) ?>" alt="">
            <!-- <img src="../../Images/santosh.jpg" alt=""> -->
            <div>
                <p>Name : <?php print($name) ?></p>
                <p class="email">E-mail : <?php print($email) ?></p>
            </div>
        </div>
    </div>
    <div class="container">
        <?php
        if (!isset($_SESSION['login_successful'])) {

        ?>
            <nav class="nav_bar_home">
                <div>
                    <div class="logo_image_home">
                        <img src="../../Images/logo.png" alt="" class="logo">
                    </div>

                    <ul class="links_home">
                        <li><a href="index.php">Home</a></li>

                        <li><a href="../sell_vehicle/sellbikes.php">Sell Bikes</a></li>
                        <li><a href="../sell_vehicle/sellscooters.php">Sell Scooters</a></li>
                        <li><a href="../signup/signup.php">Sign Up</a></li>
                        <li><a href="../login/login.php">Login</a></li>

                    </ul>
                </div>
            </nav>

        <?php } ?>
        <?php
        if (isset($_SESSION['login_successful'])) {

        ?>
            <nav class="nav_bar">
                <div>
                    <div class="logo_image">
                        <img src="../../Images/logo.png" alt="" class="logo">
                    </div>

                    <ul class="links">
                        <li><a href="index.php">Home</a></li>

                        <li><a href="../sell_vehicle/sellbikes.php">Sell Bikes</a></li>
                        <li><a href="../sell_vehicle/sellscooters.php">Sell Scooters</a></li>
                        <li><a href="../order/view_bikes_order.php">My Orders</a></li>


                        <li><a href="../products_showing/my_products.php" class="product nav">My Products</a></li>
                        <li class="profile">Profile</li>

                        <li><a href="../add_to_cart/view_add_to_cart_bikes.php"><i class="fa-solid fa-cart-plus"></i></a></li>

                        <li><a href="../logout/logout.php" class="logout nav">Log Out</a></li>
                    </ul>
                </div>
            </nav>

        <?php } ?>

        <div class="nav_bar_home_show_hide">
            <div class="nav_bar_icon_home">
                <i class="fa-solid fa-list"></i>
            </div>
        </div>
        <nav class="nav_bar_mobile">
            <div class="nav_bar_icon">
                <!-- <i class="fa-solid fa-list"></i> -->
                <i class="fa-solid fa-xmark"></i>
            </div>
            <ul class="links_mobile">
                <li><a href="index.php">Home</a></li>

                <li><a href="../sell_vehicle/sellbikes.php">Sell Bikes</a></li>
                <li><a href="../sell_vehicle/sellscooters.php">Sell Scooters</a></li>
                <?php
                if (isset($_SESSION['login_successful'])) {

                ?>

                    <li><a href="../order/view_bikes_order.php">My Orders</a></li>
                <?php
                }
                ?>
                <?php

                if (!isset($_SESSION['login_successful'])) {

                ?>
                    <li><a href="../signup/signup.php">Sign Up</a></li>
                    <li><a href="../login/login.php">Login</a></li>
                <?php
                }
                ?>
                <?php
                if (isset($_SESSION['login_successful'])) {

                ?>
                    <li><a href="../products_showing/my_products.php" class="product nav">My Products</a></li>
                    <li class="profile">Profile</li>
                <?php
                }
                ?>

                <?php
                if (isset($_SESSION['login_successful'])) {

                ?>
                    <li><a href="../add_to_cart/view_add_to_cart_bikes.php"><i class="fa-solid fa-cart-plus"></i></a></li>
                    <li><a href="../logout/logout.php" class="logout nav">Log Out</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>

        <div class="search_details">
            <div>
                <input type="search" placeholder="Search Bikes and Scooters" name="search_value" class="search_input">
                <i class="fa-solid fa-magnifying-glass search_icon"></i>
            </div>
        </div>
        <div class="filter_show_hide">
            <button>
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </button>
        </div>
        <div class="filter_details">
            <form action="../filter/filter.php" method="POST">
                <div class="bikes_information_filter">
                    <div class="category_filter">
                        <p>Category</p>
                        <div class="bikes_wrapper">
                            <input type="checkbox" name="category[]" id="bikes" value="bikes">
                            <label for="bikes">Bikes</label>
                        </div>

                        <div class="scooters_wrapper">
                            <input type="checkbox" name="category[]" id="scooters" value="scooters">
                            <label for="scooters">Scooters</label>
                        </div>
                        <div>
                            <button type="button" class="category_both all_button" onclick="select_all('category_filter')">Both</button>

                            <button type="button" class="category_clear clear_button" onclick="clear_all('category_filter')">Clear</button>
                        </div>
                    </div>
                    <div class="price_filter">
                        <p>Price</p>
                        <input type="number" placeholder="Enter Lower Price" class="lower_price" name="lower_price">
                        <input type="number" placeholder="Enter Upper Price" class="upper_price" name="upper_price">
                    </div>

                    <div class="company_filter_bikes">
                        <p>Brand Name (Bikes)</p>

                        <?php

                        while ($rows_brand_bikes = mysqli_fetch_assoc($result_company_bikes)) {

                        ?>

                            <div class="brand_bikes">
                                <input type="checkbox" value="<?php print($rows_brand_bikes['company_name']) ?>" name="brand_name_bikes[]">
                                <label for=""><?php print(ucwords($rows_brand_bikes['company_name'])) ?></label>
                            </div>

                        <?php } ?>

                        <?php
                        if (mysqli_num_rows($result_company_bikes) > 5) {
                        ?>

                            <div>
                                <p class="see_more" onclick="see_more('brand_bikes', this)">Show More</p>

                            </div>

                        <?php } ?>

                        <?php

                        if (mysqli_num_rows($result_company_bikes) >= 2) {

                        ?>
                            <div>
                                <button type="button" class="brand_name_bikes_all all_button" onclick="select_all('company_filter_bikes')">All</button>

                                <button type="button" class="brand_name_bikes_clear clear_button" onclick="clear_all('company_filter_bikes')">Clear</button>
                            </div>

                        <?php } ?>
                    </div>

                    <div class="company_filter_scooters">
                        <p>Brand Name (Scooters)</p>
                        <?php

                        while ($rows_brand_scooters = mysqli_fetch_assoc($result_company_scooters)) {

                        ?>
                            <div class="brand_scooters">
                                <input type="checkbox" value="<?php print($rows_brand_scooters['company_name']) ?>" name="brand_name_scooters[]">
                                <label for=""><?php print(ucwords($rows_brand_scooters['company_name'])) ?></label>
                            </div>

                        <?php } ?>

                        <?php
                        if (mysqli_num_rows($result_company_scooters) > 5) {
                        ?>

                            <div>
                                <p class="see_more" onclick="see_more('brand_scooters', this)">Show More</p>

                            </div>



                        <?php } ?>

                        <?php
                        if (mysqli_num_rows($result_company_scooters) >= 2) {

                        ?>
                            <div>
                                <button type="button" class="brand_name_scooters_all all_button" onclick="select_all('company_filter_scooters')">All</button>

                                <button type="button" class="brand_name_scooters_clear clear_button" onclick="clear_all('company_filter_scooters')">Clear</button>
                            </div>
                        <?php } ?>

                    </div>

                    <div class="lot_number_filter_bikes">
                        <p>Lot Number (Bikes)</p>
                        <?php

                        while ($rows_lot_no_bikes = mysqli_fetch_assoc($result_lot_no_bikes)) {

                        ?>
                            <div class="lot_no_bikes">
                                <input type="checkbox" name="lot_no_bikes[]" id="" value="<?php print($rows_lot_no_bikes['lot_number']) ?>">
                                <label for=""><?php print($rows_lot_no_bikes['lot_number']) ?></label>
                            </div>
                        <?php } ?>

                        <?php
                        if (mysqli_num_rows($result_lot_no_bikes) > 5) {
                        ?>

                            <div>
                                <p class="see_more" onclick="see_more('lot_no_bikes', this)">Show More</p>

                            </div>


                        <?php } ?>
                        <?php
                        if (mysqli_num_rows($result_lot_no_bikes) >= 2) {

                        ?>
                            <div>
                                <button type="button" class="lot_no_bikes_all all_button" onclick="select_all('lot_number_filter_bikes')">All</button>

                                <button type="button" class="lot_no_bikes_clear clear_button" onclick="clear_all('lot_number_filter_bikes')">Clear</button>
                            </div>

                        <?php } ?>
                    </div>

                    <div class="lot_number_filter_scooters">
                        <p>Lot Number (Scooters)</p>
                        <?php

                        while ($rows_lot_no_scooters = mysqli_fetch_assoc($result_lot_no_scooters)) {

                        ?>
                            <div class="lot_no_scooters">
                                <input type="checkbox" name="lot_no_scooters[]" id="" value="<?php print($rows_lot_no_scooters['lot_number']) ?>">
                                <label for=""><?php print($rows_lot_no_scooters['lot_number']) ?></label>
                            </div>
                        <?php } ?>
                        <?php
                        if (mysqli_num_rows($result_lot_no_scooters) > 5) {
                        ?>

                            <div>
                                <p class="see_more" onclick="see_more('lot_no_scooters', this)">Show More</p>

                            </div>



                        <?php } ?>
                        <?php
                        if (mysqli_num_rows($result_lot_no_scooters) >= 2) {

                        ?>
                            <div>
                                <button type="button" class="lot_no_scooters_all all_button" onclick="select_all('lot_number_filter_scooters')">All</button>

                                <button type="button" class="lot_no_scooters_clear clear_button" onclick="clear_all('lot_number_filter_scooters')">Clear</button>
                            </div>

                        <?php } ?>
                    </div>



                    <div class="location_filter_bikes">
                        <div class="district_filter_bikes">
                            <p>District (Bikes)</p>
                            <?php

                            while ($rows_district_bikes = mysqli_fetch_assoc($result_district_bikes)) {

                            ?>
                                <div class="district_bikes">
                                    <input type="checkbox" value="<?php print($rows_district_bikes['district']) ?>" name="district_bikes[]">
                                    <label for=""><?php print(ucwords($rows_district_bikes['district'])) ?></label>
                                </div>

                            <?php } ?>
                            <?php
                            if (mysqli_num_rows($result_district_bikes) > 5) {
                            ?>

                                <p class="see_more" onclick="see_more('district_bikes', this)">Show More</p>

                            <?php } ?>
                            <?php
                            if (mysqli_num_rows($result_district_bikes) >= 2) {

                            ?>
                                <div>
                                    <button type="button" class="district_bikes_all all_button" onclick="select_all('district_filter_bikes')">All</button>

                                    <button type="button" class="district_bikes_clear clear_button" onclick="clear_all('district_filter_bikes')">Clear</button>
                                </div>
                            <?php } ?>
                        </div>

                    </div>

                    <div class="location_filter_scooters">
                        <div class="district_filter_scooters">
                            <p>District (Scooters)</p>
                            <?php

                            while ($rows_district_scooters = mysqli_fetch_assoc($result_district_scooters)) {

                            ?>
                                <div class="district_scooters">
                                    <input type="checkbox" value="<?php print($rows_district_scooters['district']) ?>" name="district_scooters[]">
                                    <label for=""><?php print(ucwords($rows_district_scooters['district'])) ?></label>
                                </div>

                            <?php } ?>

                            <?php
                            if (mysqli_num_rows($result_district_scooters) > 5) {
                            ?>
                                <p class="see_more" onclick="see_more('district_scooters', this)">Show More</p>


                            <?php } ?>
                            <?php
                            if (mysqli_num_rows($result_district_scooters) >= 2) {

                            ?>
                                <div>
                                    <button type="button" class="district_scooters_all all_button" onclick="select_all('district_filter_scooters')">All</button>

                                    <button type="button" class="district_scooters_clear clear_button" onclick="clear_all('district_filter_scooters')">Clear</button>
                                </div>
                            <?php } ?>


                        </div>

                    </div>
                </div>

                <div class="filter_button">
                    <input type="submit" value="Filter" class="filter">
                </div>

        </div>


        </form>
    </div>

    <div class="popular">
        <!-- showing most popular section only if there are most popular products -->
        <?php
        if ($no_of_popular_bikes >= 1 || $no_of_popular_scooters >= 1) {
        ?>
            <p class="popular_text">Most Popular</p>
        <?php } ?>
        <div class="bikes_scooters">
            <?php
            if ($no_of_popular_bikes >= 1) {
            ?>
                <button class="bikes focus_bikes popular_bikes">Bikes</button>
            <?php } ?>
            <?php
            if ($no_of_popular_scooters >= 1) {
            ?>
                <button class="scooters popular_scooters">Scooters</button>
            <?php } ?>
        </div>
        <?php
        // checking there are products or not
        if ($no_of_popular_bikes > 0) {

        ?> <div class="products_wrapper">
                <div class="products_details">
                    <?php
                    $j = 1;
                    // because we have to show only 8 products
                    $condition = 8;
                    // if there are greater than 8 products then we have to only show first 8 products otherwise total no of products on the database
                    if ($actual_popular_bikes_records >= 8) {
                        $condition = 8;
                    } else {
                        $condition = $actual_popular_bikes_records;
                    }

                    while ($j <= $condition) {
                        // for passing index of each products
                        $value++;

                        $rows_popular_bikes = mysqli_fetch_assoc($result_popular_bikes);
                        $id = $rows_popular_bikes['bikes_id'];
                        // print($id);

                        // uploading images details
                        $sql_image_bikes = "select * from bikes_images where bikes_id = '$id'";
                        $result_image_bikes = mysqli_query($con, $sql_image_bikes) or die("Query Failed !");

                        $j++;

                    ?>
                        <div class="products">
                            <div class="image_details">
                                <?php
                                // dsiplaying image slider button if there are greater than 2 images of vehicles
                                if (mysqli_num_rows($result_image_bikes) >= 2) {
                                ?>
                                    <span class="image_prev" onclick="prev_image(<?php print($value) ?>)">&lt;</span>
                                    <span class="image_next" onclick="next_image(<?php print($value) ?>)">&gt;</span>
                                <?php } ?>
                                <a href="../view_details/view_details.php?id=<?php print($rows_popular_bikes['bikes_id']) ?>&vehicle=bikes" class="link_image">
                                    <?php
                                    while ($rows_bikes_images = mysqli_fetch_assoc($result_image_bikes)) {
                                    ?>
                                        <img src="../../uploaded_images/bikes/<?php print($rows_bikes_images['image_name']) ?>" alt="<?php print($folder) ?> image" class="image">

                                    <?php } ?>
                                </a>
                            </div>
                            <div class="model_price">
                                <p>Model : <?php print($rows_popular_bikes['model']) ?></p>
                                <p>Price : <?php print($rows_popular_bikes['new_price']) ?></p>
                            </div>
                            <div>
                                <button><a href="../view_details/view_details.php?id=<?php print($rows_popular_bikes['bikes_id']) ?>&vehicle=bikes">View Details</a></button>
                                <button><a href="../add_to_cart/add_to_cart_bikes.php?id=<?php print($rows_popular_bikes['bikes_id']) ?>&vehicle=bikes&is_clicked">Add To Cart</a></button>

                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>

        <?php
        }  ?>




        <?php
        // checking there are products or not
        if ($no_of_popular_scooters > 0) {

        ?> <div class="products_wrapper">


                <div class="products_details">
                    <?php
                    $j = 1;
                    // because we have to show only 8 products
                    $condition = 8;
                    // if there are greater than 8 products then we have to only show first 8 products otherwise total no of products on the database
                    if ($actual_popular_scooters_records >= 8) {
                        $condition = 8;
                    } else {
                        $condition = $actual_popular_scooters_records;
                    }

                    while ($j <= $condition) {
                        // for passing index of each products
                        $value++;

                        $rows_popular_scooters = mysqli_fetch_assoc($result_popular_scooters);
                        $id = $rows_popular_scooters['scooters_id'];
                        // print($id);

                        // uploading images details
                        $sql_image_scooters = "select * from scooters_images where scooters_id = '$id'";
                        $result_image_scooters = mysqli_query($con, $sql_image_scooters) or die("Query Failed !");

                        $j++;

                    ?>
                        <div class="products">
                            <div class="image_details">
                                <?php
                                // dsiplaying image slider button if there are greater than 2 images of vehicles
                                if (mysqli_num_rows($result_image_scooters) >= 2) {
                                ?>
                                    <span class="image_prev" onclick="prev_image(<?php print($value) ?>)">&lt;</span>
                                    <span class="image_next" onclick="next_image(<?php print($value) ?>)">&gt;</span>
                                <?php } ?>
                                <a href="../view_details/view_details.php?id=<?php print($rows_popular_scooters['scooters_id']) ?>&vehicle=scooters" class="link_image">
                                    <?php
                                    while ($rows_scooters_images = mysqli_fetch_assoc($result_image_scooters)) {
                                    ?>
                                        <img src="../../uploaded_images/scooters/<?php print($rows_scooters_images['image_name']) ?>" class="image">

                                    <?php } ?>
                                </a>
                            </div>
                            <div class="model_price">
                                <p>Model : <?php print($rows_popular_scooters['model']) ?></p>
                                <p>Price : <?php print($rows_popular_scooters['new_price']) ?></p>
                            </div>
                            <div>
                                <button><a href="../view_details/view_details.php?id=<?php print($rows_popular_scooters['scooters_id']) ?>&vehicle=scooters">View Details</a></button>
                                <button><a href="../add_to_cart/add_to_cart_scooters.php?id=<?php print($rows_popular_scooters['scooters_id']) ?>&vehicle=scooters&is_clicked">Add To Cart</a></button>

                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>

        <?php
        } ?>
    </div>



    <div class="products_wrapper_selector">


        <?php
        // checking there are products or not
        if ($total_records > 0) {
            // to track how many bikes and scooters are displayed
            $actual_bikes = 0;
            $actual_scooters = 0;
            $i = 1;
            while ($i <= $repeat_div) {
                $no_of_data_showed = 0;

        ?> <div class="products_wrapper">

                    <div class="products_details">
                        <?php
                        // show slider button only when there are more than 8 products
                        if ($repeat_div > 1) {
                        ?>

                            <span class="previous">&lt;</span>
                            <span class="next">&gt;</span>
                        <?php } ?>
                        <?php
                        $j = 1;
                        // because we have to show only 8 products
                        $condition = 8;
                        // if there are greater than 8 products then we have to only show first 8 products otherwise total no of products on the database
                        if ($actual_records >= 8) {
                            $condition = 8;
                        } else {
                            $condition = $actual_records;
                        }

                        while ($j <= $condition) {
                            // for passing index of each products
                            $value++;
                            $actual_records--;
                            $no_of_data_showed++;
                            // to show bikes and scooters randomly
                            $random_index = rand(0, 1);
                            // print($random_index);
                            // loop upward 0 means bikes
                            if ($random_index == 0) {
                                $folder = "bikes";
                                $actual_bikes++;
                            } else {
                                $actual_scooters++;
                                $folder = "scooters";
                            }
                            // here random index may be scooters and there are no scooters in the database so changing it to bikes
                            if ($actual_scooters > $no_of_scooters) {
                                if ($random_index != 0) {

                                    $actual_bikes++;
                                }
                                $random_index = 0;
                                $folder = "bikes";
                            }
                            if ($actual_bikes > $no_of_bikes) {
                                if ($random_index != 1) {

                                    $actual_scooters++;
                                }
                                $random_index = 1;
                                $folder = "scooters";
                            }
                            // print($random_index);

                            // print("actual bikes : $actual_bikes<br>");
                            // print("actual scooters : $actual_scooters");
                            $rows = mysqli_fetch_assoc($bikes_or_scooters[$random_index]);
                            $id = $rows['id'];
                            $images_table = $folder . "_images";
                            $vehicle_id = $folder . "_id";
                            // print($id);
                            // uploading images details
                            $sql_image = "select * from $images_table where $vehicle_id = '$id'";
                            $result_image = mysqli_query($con, $sql_image) or die("Query Failed !");

                            $j++;

                        ?>
                            <div class="products">
                                <div class="image_details">
                                    <?php
                                    // dsiplaying image slider button if there are greater than 2 images of vehicles
                                    if (mysqli_num_rows($result_image) >= 2) {
                                    ?>
                                        <span class="image_prev" onclick="prev_image(<?php print($value) ?>)">&lt;</span>
                                        <span class="image_next" onclick="next_image(<?php print($value) ?>)">&gt;</span>
                                    <?php } ?>
                                    <a href="../view_details/view_details.php?id=<?php print($rows['id']) ?>&vehicle=<?php print($folder) ?>" class="link_image">
                                        <?php
                                        while ($rows_images = mysqli_fetch_assoc($result_image)) {
                                        ?>
                                            <img src="../../uploaded_images/<?php print($folder) ?>/<?php print($rows_images['image_name']) ?>" alt="<?php print($folder) ?> image" class="image">

                                        <?php } ?>
                                    </a>
                                </div>
                                <div class="model_price">
                                    <p>Model : <?php print($rows['model']) ?></p>
                                    <p>Price : <?php print($rows['new_price']) ?></p>
                                </div>
                                <div>
                                    <button><a href="../view_details/view_details.php?id=<?php print($rows['id']) ?>&vehicle=<?php print($folder) ?>">View Details</a></button>
                                    <button><a href="../add_to_cart/add_to_cart_<?php print($folder) ?>.php?id=<?php print($rows['id']) ?>&vehicle=<?php print($folder) ?>&is_clicked">Add To Cart</a></button>

                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>

        <?php $i++;
            }
        } else {
            print("<div class='no_products_details'><div class='no_products'> No any Products ! </div></div>");
        } ?>
    </div>
    <?php



    // displying products slider if there are greater than 8 products
    if ($repeat_div >= 2) {

    ?>

        <div class="buttons">
            <button class="previous_button"><i class="fa-solid fa-less-than"></i></button>
            <?php
            $i = 1;
            $value = 0;
            // creating button according to products
            while ($i <= $repeat_div) {
            ?>
                <button onclick="change_products(<?php print($value) ?>, this)" class="btn"><?php print($value + 1) ?></button>
            <?php
                $value++;
                $i++;
            }
            ?>
            <button class="next_button"><i class="fa-solid fa-greater-than"></i></button>
        </div>
    <?php }
    mysqli_close($con); ?>
    </div>

    <footer>
        <div>
            <nav class="">
                <ul class="">
                    <li><a href="index.php">Home</a></li>

                    <li><a href="../footer/about_us.php">About Us</a></li>
                    <li><a href="../footer/privacy_policy.php">Privacy Policy</a></li>
                    <li><a href="../footer/contact_us.php">Contact Us</a></li>
                </ul>
            </nav>

            <div class="social_icons">
                <a href="https://www.facebook.com/santoshpoudel300"><i class="fa-brands fa-facebook"></i></a>
                <a href="https://www.instagram.com/__santoshpoudel"><i class="fa-brands fa-square-instagram"></i></a>
                <a href=""><i class="fa-brands fa-linkedin"></i></a>
            </div>
        </div>

        <div>
            <p>&copy; DuiPanGrey.com</p>
        </div>


    </footer>
    <script src="../../JS/main/index.js">
    </script>
</body>

</html>