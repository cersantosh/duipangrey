

<?php
// give name attribute to each input field and get data using this method
    $mobile_name = $_POST['mobile_name'];
    $price = $_POST['price'];
    $ram = $_POST['ram'];
    $internal_storage = $_POST['internal_storage'];
    $is_5g = $_POST['is_5g'];

    include "connection.php";
    // you can use any of given two methods

    //error
    // $sql = "insert into mobile_details(Mobile_name, Price, RAM, Internal_storage, 5G_supported) values({$mobile_name}, {$price}, {$ram}, {$internal_storage}, {$is_5g})";

    $sql = "insert into mobile_details(Mobile_name, Price, RAM, Internal_storage, 5G_supported) values('$mobile_name', '$price', '$ram', '$internal_storage', '$is_5g')";

    // $sql = "insert into mobile_details(Mobile_name, Price, RAM, Internal_storage, 5G_supported) values('{$mobile_name}', '{$price}', '{$ram}', '{$internal_storage}', '{$is_5g}')";

    $result = mysqli_query($con, $sql) or die("Query failed");
    // after data inserted the page will redirected to show_products.php
    header("location:http://localhost/PHP/show_products.php");
    
    mysqli_close($con);
    
?>