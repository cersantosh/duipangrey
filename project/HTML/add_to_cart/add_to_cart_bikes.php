<?php

session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
$email = $_SESSION['login_email'];
// without login we can't add products to cart
if (!isset($_SESSION['login_email'])) {
    header("location:http://localhost/project/HTML/login/login.php");
} else {


    include "../connection.php";
    $id = $_GET['id'];
    // for getting values from database so that same bikes won't stored on the database
    $sql_read = "select * from add_to_cart_bikes where email = '$email' and bikes_id = '$id'";
    $result = mysqli_query($con, $sql_read);
    $no_of_rows = mysqli_num_rows($result);
    // for inserting into database if it is not already added to cart
    if ($no_of_rows == 0) {

        $sql = "insert into add_to_cart_bikes(bikes_id, email) values('$id', '$email')";
        mysqli_query($con, $sql) or die("Query Failed !");
    }
    header("location:http://localhost/project/html/add_to_cart/view_add_to_cart_bikes.php");
}
