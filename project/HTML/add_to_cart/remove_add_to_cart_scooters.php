
<?php
// removing products from add to cart section
session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
include "../connection.php";
$email = $_SESSION['login_email'];
$id = $_GET['id'];
$sql = "delete from add_to_cart_scooters where scooters_id = '$id' and email = '$email    '";
$result = mysqli_query($con, $sql) or die("Query Failed !");
header("location:http://localhost/project/HTML/add_to_cart/view_add_to_cart_scooters.php");

mysqli_close($con);

?>