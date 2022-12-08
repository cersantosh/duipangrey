
<?php

    $mobile_name = $_POST['mobile_name'];
    $price = $_POST['price'];
    $ram = $_POST['ram'];
    $internal_storage = $_POST['internal_storage'];
    $is_5g = $_POST['is_5g'];
    $id = $_GET['idd'];

    include "connection.php";
    $sql = "update mobile_details set Mobile_name = '{$mobile_name}', Price = '{$price}', RAM = '{$ram}', Internal_storage = '{$internal_storage}', 5G_supported = '{$is_5g}' where id = '{$id}'";

    mysqli_query($con, $sql);
    header("location:http://localhost/PHP/show_products.php");
    mysqli_close($con);

?>