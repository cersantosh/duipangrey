<?php
session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    die("File Not Found !");
}
unset($_SESSION['signup_access']);
unset($_SESSION['signup_verification']);
// for next and previous button
$value = -1;

// profile picture
include "../connection.php";


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
}

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

// creating array for all the selected options
$array_category = array();
$array_brand_name_bikes = array();
$array_brand_name_scooters = array();
$array_lot_no_bikes = array();
$array_lot_no_scooters = array();
$array_district_bikes = array();
$array_district_scooters = array();

// getting filter values 

if (isset($_POST['category'])) {

    foreach ($_POST['category'] as $category) {
        array_push($array_category, $category);
        // print($category . "<br>");
    }
}

if (isset($_POST['lower_price'])) {
    $lower_price = $_POST['lower_price'];
    // print($_POST['lower_price'] . "<br>");
}

if (isset($_POST['upper_price'])) {
    $upper_price = $_POST['upper_price'];

    // print($_POST['upper_price'] . "<br>");
}


if (isset($_POST['brand_name_bikes'])) {

    foreach ($_POST['brand_name_bikes'] as $brand_name_bikes) {
        array_push($array_brand_name_bikes, $brand_name_bikes);
        // print($brand_name_bikes . "<br>");
    }
}

if (isset($_POST['brand_name_scooters'])) {

    foreach ($_POST['brand_name_scooters'] as $brand_name_scooters) {
        array_push($array_brand_name_scooters, $brand_name_scooters);
        // print($brand_name_scooters . "<br>");
    }
}

if (isset($_POST['lot_no_bikes'])) {

    foreach ($_POST['lot_no_bikes'] as $lot_no_bikes) {
        array_push($array_lot_no_bikes, $lot_no_bikes);
        // print($lot_no_bikes . "<br>");
    }
}

if (isset($_POST['lot_no_scooters'])) {

    foreach ($_POST['lot_no_scooters'] as $lot_no_scooters) {
        array_push($array_lot_no_scooters, $lot_no_scooters);
        // print($lot_no_scooters . "<br>");
    }
}

if (isset($_POST['district_bikes'])) {

    foreach ($_POST['district_bikes'] as $district_bikes) {
        array_push($array_district_bikes, $district_bikes);
        // print($district_bikes . "<br>");
    }
}

if (isset($_POST['district_scooters'])) {

    foreach ($_POST['district_scooters'] as $district_scooters) {
        array_push($array_district_scooters, $district_scooters);
        // print($district_scooters . "<br>");
    }
}

// print("<pre>");
// print_r($array_category);
// print("</pre>");
// print("<pre>");
// print_r($array_brand_name_bikes);
// print("</pre>");

// print("<pre>");

// print_r($array_brand_name_scooters);
// print("</pre>");

// print("<pre>");

// print_r($array_lot_no_bikes);
// print("</pre>");

// print("<pre>");

// print_r($array_lot_no_scooters);
// print("</pre>");

// print("<pre>");

// print_r($array_district_bikes);
// print("</pre>");

// print("<pre>");

// print_r($array_district_scooters);
// print("</pre>");

// these two lines are used to remove error and make previous code work for it


//  whether to add where or not on the sql command
$sql_bikes_change = false;
$sql_scooters_change = false;
$bikes_options_selected = false;
$scooters_options_selected = false;

if ($login) {
    $sql_bikes = "select * from sell_bikes where email != '$email'";
    $sql_scooters = "select * from sell_scooters where email != '$email'";
    $sql_bikes_change = true;
    $sql_scooters_change = true;
} else {

    $sql_bikes = "select * from sell_bikes";
    $sql_scooters = "select * from sell_scooters";
}




$bikes_selected = false;
$scooters_selected = false;

// assign sql of search value if user input is other than bikes and scooters
if ((isset($_SESSION['search_value']) && $_SESSION['search_value'] != "") && ($_SESSION['search_value'] != "bikes" && $_SESSION['search_value'] != 'bike' && $_SESSION['search_value'] != "scooters" && $_SESSION['search_value'] != 'scooter')) {
    $sql_bikes_change = true;
    $sql_scooters_change = true;
    $sql_bikes = $_SESSION['sql_bikes'];
    $sql_scooters = $_SESSION['sql_scooters'];

    print($sql_bikes . "<br><br>");
    print($sql_scooters . "<br><br>");
}


// if both bikes and scooters selected
if (count($array_category) == 2) {
    $bikes_selected = true;
    $scooters_selected = true;
}

// if user select bikes
if (count($array_category) == 1 && $array_category[0] == "bikes") {
    $bikes_selected = true;
    //  this is done to prevent showing information of scooters
    $sql_scooters = "select * from sell_scooters where tole = 'JKkj8998*&'";
    $sql_scooters_change = true;
}

// if user select scooters
if (count($array_category) == 1 && $array_category[0] == "scooters") {
    $scooters_selected = true;
    //  this is done to prevent showing information of bikes
    $sql_bikes = "select * from sell_bikes where tole = 'jkllfd*(77'";
    $sql_bikes_change = true;
}

// if one of price value is given
if ($lower_price != "" || $upper_price != "") {
    if ($sql_bikes_change) {

        $sql_bikes = $sql_bikes . " and (new_price between $lower_price and $upper_price)";
    } else {
        $sql_bikes = $sql_bikes . " where (new_price between $lower_price and $upper_price)";
        $sql_bikes_change = true;
    }

    if ($sql_scooters_change) {
        $sql_scooters = $sql_scooters . " and (new_price between $lower_price and $upper_price)";
    } else {
        $sql_scooters = $sql_scooters . " where (new_price between $lower_price and $upper_price)";
        $sql_scooters_change = true;
    }
}

// creating sql command 
if (count($array_brand_name_bikes) != 0) {
    $bikes_options_selected = true;
    $or = "";
    $company_name = "";
    if ($sql_bikes_change) {
        $sql_bikes = $sql_bikes . " and (company_name = ";
    } else {

        $sql_bikes = $sql_bikes . " where (company_name = ";
        $sql_bikes_change = true;
    }

    foreach ($array_brand_name_bikes as $bikes) {
        $sql_bikes = $sql_bikes . $or . $company_name . "'$bikes'";
        // adding or if there are more than 1 products
        $or = " or ";
        $company_name = "company_name = ";
    }
    // adding ) at end of the sql command
    $sql_bikes = $sql_bikes . ")";
    // print($sql_bikes);
}

if (count($array_brand_name_scooters) != 0) {
    $scooters_options_selected = true;
    $or = "";
    $company_name = "";

    if ($sql_scooters_change) {
        $sql_scooters = $sql_scooters . " and (company_name = ";
    } else {

        $sql_scooters = $sql_scooters . " where (company_name = ";
        $sql_scooters_change = true;
    }

    foreach ($array_brand_name_scooters as $scooters) {
        $sql_scooters = $sql_scooters . $or . $company_name . "'$scooters'";
        $or = " or ";
        $company_name = "company_name = ";
    }
    $sql_scooters = $sql_scooters . ")";
    // print($sql_bikes);
}


if (count($array_lot_no_bikes) != 0) {
    $bikes_options_selected = true;
    $or = "";
    $lot_number = "";

    if ($sql_bikes_change) {
        $sql_bikes = $sql_bikes . " and (lot_number = ";
    } else {

        $sql_bikes = $sql_bikes . " where (lot_number = ";
        $sql_bikes_change = true;
    }

    foreach ($array_lot_no_bikes as $lot_no) {
        $sql_bikes = $sql_bikes . $or . $lot_number . "'$lot_no'";
        $or = " or ";
        $lot_number = "lot_number = ";
    }
    $sql_bikes = $sql_bikes . ")";
    // print($sql_bikes);
}

if (count($array_lot_no_scooters) != 0) {
    $scooters_options_selected = true;
    $or = "";
    $lot_number = "";

    if ($sql_scooters_change) {
        $sql_scooters = $sql_scooters . " and (lot_number = ";
    } else {

        $sql_scooters = $sql_scooters . " where (lot_number = ";
        $sql_scooters_change = true;
    }

    foreach ($array_lot_no_scooters as $lot_no) {
        $sql_scooters = $sql_scooters . $or . $lot_number . "'$lot_no'";
        $or = " or ";
        $lot_number = "lot_number = ";
    }
    $sql_scooters = $sql_scooters . ")";
    // print($sql_bikes);
}

if (count($array_district_bikes) != 0) {
    $bikes_options_selected = true;
    $or = "";
    $district = "";

    if ($sql_bikes_change) {
        $sql_bikes = $sql_bikes . " and (district = ";
    } else {

        $sql_bikes = $sql_bikes . " where (district = ";
        $sql_bikes_change = true;
    }

    foreach ($array_district_bikes as $dist) {
        $sql_bikes = $sql_bikes . $or . $district . "'$dist'";
        $or = " or ";
        $district = "district = ";
    }
    $sql_bikes = $sql_bikes . ")";
    // print($sql_bikes);
}


if (count($array_district_scooters) != 0) {
    $scooters_options_selected = true;
    $or = "";
    $district = "";

    if ($sql_scooters_change) {
        $sql_scooters = $sql_scooters . " and (district = ";
    } else {

        $sql_scooters = $sql_scooters . " where (district = ";
        $sql_scooters_change = true;
    }

    foreach ($array_district_scooters as $dist) {
        $sql_scooters = $sql_scooters . $or . $district . "'$dist'";
        $or = " or ";
        $district = "district = ";
    }
    $sql_scooters = $sql_scooters . ")";
    // print($sql_bikes);
}

// this is for if both bikes and scooters are not selected but user clicks one of the options related to bikes
if (!$bikes_selected && $bikes_options_selected && !$scooters_options_selected) {
    $sql_scooters = "select * from sell_scooters where tole = 'jkllfd*(77'";
}

if (!$scooters_selected && $scooters_options_selected && !$bikes_options_selected) {
    $sql_bikes = "select * from sell_bikes where tole = 'jkllfd*(77'";
}


// print($sql_bikes . "<br>");
// print($sql_scooters);
// $sql_scooters = "select * from sell_scooters";
// $sql_bikes = "select * from sell_bikes";

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="../CSS/index.css"> -->
    <link rel="stylesheet" href="../../CSS/main/index.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="profile_wrapper">
        <div class="profile_details">
            <img src="../../uploaded_images/profile_picture/<?php print($image_name) ?>" alt="">
            <!-- <img src="../Images/profile.jpg" alt=""> -->
            <p>Name : <?php print($name) ?></p>
            <p>E-mail : <?php print($email) ?></p>
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
                        <li><a href="../main/index.php">Home</a></li>

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
                        <li><a href="../main/index.php">Home</a></li>

                        <li><a href="../sell_vehicle/sellbikes.php">Sell Bikes</a></li>
                        <li><a href="../sell_vehicle/sellscooters.php">Sell Scooters</a></li>
                        <li><a href="../order/view_bikes_order.php">My Orders</a></li>


                        <li><a href="../products_showing/my_products.php" class="product nav">My Products</a></li>
                        <li class="profile">Profile</li>
                        <li><a href="../logout/logout.php" class="logout nav">Log Out</a></li>

                        <li><a href="../add_to_cart/view_add_to_cart_bikes.php"><i class="fa-solid fa-cart-plus"></i></a></li>

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
                <li><a href="../main/index.php">Home</a></li>

                <li><a href="../sell_vehicle/sellbikes.php">Sell Bikes</a></li>
                <li><a href="../sell_vehicle/sellscooters.php">Sell Scooters</a></li>
                <?php
                if (isset($_SESSION['login_successful'])) {

                ?>

                    <li><a href="../order/view_bikes_order.php">My Orders</a></li>
                <?php
                }
                ?>
                <li><a href="../signup/signup.php">Sign Up</a></li>
                <li><a href="../login/login.php">Login</a></li>
                <?php
                if (isset($_SESSION['login_successful'])) {

                ?>
                    <li><a href="../products_showing/my_products.php" class="product nav">My Products</a></li>
                    <li class="profile">Profile</li>
                    <li><a href="../logout/logout.php" class="logout nav">Log Out</a></li>
                <?php
                }
                ?>

                <?php
                if (isset($_SESSION['login_successful'])) {

                ?>
                    <li><a href="../add_to_cart/view_add_to_cart_bikes.php"><i class="fa-solid fa-cart-plus"></i></a></li>
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
            <button><i class="fa-solid fa-filter"></i></button>
        </div>
        <div class="search_result">
            <?php
            if ($total_records >= 2) {
                print("<p class='search_data'>$total_records " . "Records Found</p>");
            } elseif ($total_records == 1) {
                print("<p class='search_data'>$total_records " . "Record Found</p>");
            }


            ?>
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
                                <p class="see_more" onclick="see_more('brand_bikes')">See More</p>

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
                                <p class="see_more" onclick="see_more('brand_scooters')">See More</p>

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
                                <p class="see_more" onclick="see_more('lot_no_bikes')">See More</p>

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

                            <?php
                            if (mysqli_num_rows($result_lot_no_scooters) > 5) {
                            ?>

                                <div>
                                    <p class="see_more" onclick="see_more('brand_bikes')">See More</p>

                                </div>

                            <?php } ?>

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
                                <div>
                                    <input type="checkbox" value="<?php print($rows_district_bikes['district']) ?>" name="district_bikes[]">
                                    <label for=""><?php print(ucwords($rows_district_bikes['district'])) ?></label>
                                </div>

                            <?php } ?>
                            <?php
                            if (mysqli_num_rows($result_district_bikes) > 5) {
                            ?>

                                <p class="see_more" onclick="see_more('brand_bikes')">See More</p>

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
                                <div>
                                    <input type="checkbox" value="<?php print($rows_district_scooters['district']) ?>" name="district_scooters[]">
                                    <label for=""><?php print(ucwords($rows_district_scooters['district'])) ?></label>
                                </div>

                            <?php } ?>

                            <?php
                            if (mysqli_num_rows($result_district_scooters) > 5) {
                            ?>
                                <p class="see_more">See More</p>


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
                                <button><a href="../add_to_cart/add_to_cart_<?php print($folder) ?>.php?id=<?php print($rows['id']) ?>&vehicle=<?php print($folder) ?>">Add To Cart</a></button>

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
    <script src="../../JS/search/filter_search.js">
    </script>
</body>

</html>