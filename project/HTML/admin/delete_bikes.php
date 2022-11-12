
<?php
session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
$id = $_GET['id'];
include "../connection.php";

if (!isset($_SESSION['admin_email'])) {
    die("File Not Found");
}

// delete from add to cart bikes
mysqli_query($con, "delete from add_to_cart_bikes where bikes_id = '$id'") or die("Query Failed !");

// delete popular bikes
mysqli_query($con, "delete from popular_bikes where bikes_id = '$id'") or die("Query Failed !");

// delete from order bikes
mysqli_query($con, "delete from order_bikes where bikes_id = '$id'") or die("Query Failed !");


// to bypass foreign key constraint
// mysqli_query($con, "set foreign_key_checks = 0") or die("Query Failed !");

// to delete images
$sql_image = "select * from bikes_images where bikes_id = '$id'";
$result_image = mysqli_query($con, $sql_image) or die("Query Failed !");

while ($rows_images = mysqli_fetch_assoc($result_image)) {
    $image = $rows_images['image_name'];
    mysqli_query($con, "delete from bikes_images where bikes_id = '$id'") or die("Query Failed !");
    unlink("../../uploaded_images/bikes/$image");
}

// delete bikes details
$sql = "delete from sell_bikes where id = '$id'";
$result = mysqli_query($con, $sql) or die("Query Failed !");


header("location:view_bikes.php");

mysqli_close($con);

?>