
<?php

session_start();
if (!isset($_SESSION['admin_email'])) {
    die("File Not Found");
}

include "../connection.php";
$id = $_GET['id'];

$sql_image = "select * from bikes_images where id = '$id'";
$result_image = mysqli_query($con, $sql_image) or die("Query Failed !");
$image_name = mysqli_fetch_assoc($result_image)['image_name'];
unlink("../uploaded_images/bikes/$image_name");

mysqli_query($con, "delete from bikes_images where id = '$id'") or die("Query Failed !");


header("location:bikes_images.php");


?>