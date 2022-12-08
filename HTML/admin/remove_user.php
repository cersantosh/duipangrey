

<?php


session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);


$email = $_GET['email'];
include "../connection.php";

if (!isset($_SESSION['admin_email'])) {
    die("File Not Found");
}

// delete from add to cart bikes

$sql_cart_bikes = "select * from add_to_cart_bikes where email = '$email'";
$result_cart_bikes = mysqli_query($con, $sql_cart_bikes) or die("Query Failed !");

if (mysqli_num_rows($result_cart_bikes) > 0) {
    while ($rows_cart_bikes = mysqli_fetch_assoc($result_cart_bikes)) {
        mysqli_query($con, "delete from add_to_cart_bikes where email = '$email'") or die("Query Failed !");
    }
}

// delete from add to cart scooters
$sql_cart_scooters = "select * from add_to_cart_scooters where email = '$email'";
$result_cart_scooters = mysqli_query($con, $sql_cart_scooters) or die("Query Failed !");

if (mysqli_num_rows($result_cart_scooters) > 0) {
    while ($rows_cart_scooters = mysqli_fetch_assoc($result_cart_scooters)) {
        mysqli_query($con, "delete from add_to_cart_scooters where email = '$email'") or die("Query Failed !");
    }
}




// delete from order bikes
$sql_order_bikes = "select * from order_bikes where email = '$email'";
$result_order_bikes = mysqli_query($con, $sql_order_bikes) or die("Query Failed !");

if (mysqli_num_rows($result_order_bikes) > 0) {
    while ($rows_order_bikes = mysqli_fetch_assoc($result_order_bikes)) {
        mysqli_query($con, "delete from order_bikes where email = '$email'") or die("Query Failed !");
    }
}


// delete form order scooters
$sql_order_scooters = "select * from order_scooters where email = '$email'";
$result_order_scooters = mysqli_query($con, $sql_order_scooters) or die("Query Failed !");

if (mysqli_num_rows($result_order_scooters) > 0) {
    while ($rows_order_scooters = mysqli_fetch_assoc($result_order_scooters)) {
        mysqli_query($con, "delete from order_scooters where email = '$email'") or die("Query Failed !");
    }
}

// delete bikes if given user has uploaded 

$sql_bikes = "select * from sell_bikes where email = '$email'";
$result_bikes = mysqli_query($con, $sql_bikes) or die("Query Failed !");

$sql_bikes_remove = $sql_bikes;
$result_bikes_remove = mysqli_query($con, $sql_bikes_remove) or die("Query Failed !");

if (mysqli_num_rows($result_bikes) > 0) {
    while ($rows_bikes = mysqli_fetch_assoc($result_bikes)) {
        $bikes_id = $rows_bikes['id'];

        mysqli_query($con, "delete from add_to_cart_bikes where bikes_id = '$bikes_id'") or die("Query Failed !");

        mysqli_query($con, "delete from order_bikes where bikes_id = '$bikes_id'") or die("Query Failed !");

        mysqli_query($con, "delete from popular_bikes where bikes_id = '$bikes_id'") or die("Query Failed !");

        $sql_image = "select * from bikes_images where bikes_id = '$bikes_id'";
        $result_image = mysqli_query($con, $sql_image) or die("Query Failed !");

        while ($rows_images = mysqli_fetch_assoc($result_image)) {
            $image = $rows_images['image_name'];
            mysqli_query($con, "delete from bikes_images where bikes_id = '$bikes_id'") or die("Query Failed !");
            unlink("../../uploaded_images/bikes/$image");
        }
    }
}

if (mysqli_num_rows($result_bikes_remove) > 0) {
    while ($rows_bikes_remove = mysqli_fetch_assoc($result_bikes_remove)) {
        mysqli_query($con, "delete from sell_bikes where email = '$email'") or die("Query Failed !");
    }
}
// delete scooters if given user has uploaded 

$sql_scooters = "select * from sell_scooters where email = '$email'";
$result_scooters = mysqli_query($con, $sql_scooters) or die("Query Failed !");
$sql_scooters_remove = $sql_scooters;
$result_scooters_remove = mysqli_query($con, $sql_scooters_remove) or die("Query Failed !");

if (mysqli_num_rows($result_scooters) > 0) {
    while ($rows_scooters = mysqli_fetch_assoc($result_scooters)) {
        $scooters_id = $rows_scooters['id'];

        mysqli_query($con, "delete from add_to_cart_scooters where scooters_id = '$scooters_id'") or die("Query Failed !");

        mysqli_query($con, "delete from order_scooters where scooters_id = '$scooters_id'") or die("Query Failed !");

        mysqli_query($con, "delete from popular_scooters where scooters_id = '$scooters_id'") or die("Query Failed !");

        $sql_image = "select * from scooters_images where scooters_id = '$scooters_id'";
        $result_image = mysqli_query($con, $sql_image) or die("Query Failed !");

        while ($rows_images = mysqli_fetch_assoc($result_image)) {
            $image = $rows_images['image_name'];
            mysqli_query($con, "delete from scooters_images where scooters_id = '$scooters_id'") or die("Query Failed !");
            unlink("../../uploaded_images/scooters/$image");
        }
    }
}

if (mysqli_num_rows($result_scooters_remove) > 0) {
    while ($rows_scooters_remove = mysqli_fetch_assoc($result_scooters_remove)) {
        mysqli_query($con, "delete from sell_scooters where email = '$email'") or die("Query Failed !");
    }
}

$sql_profile = "select * from signup where email = '$email'";
$result_profile = mysqli_query($con, $sql_profile) or die("Query Failed !");
$profile_name = mysqli_fetch_assoc($result_profile)['profile_picture'];
unlink("../../uploaded_images/profile_picture/$profile_name");

mysqli_query($con, "delete from signup where email = '$email'") or die("Query Failed !");

// if this user is logged in then logout
if ($_SESSION['login_email'] == $email) {
    session_start();
    session_unset();
    session_destroy();
}

header("location:view_users.php");

mysqli_close($con);

?> 