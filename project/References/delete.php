
<?php
// here use get not post to fetch data from url bar
    $m_id = $_GET['idd'];
    include "connection.php";
    // you can use any of three methods given below
    $sql = "delete from mobile_details where id = '{$m_id}'";
    // $sql = "delete from mobile_details where id = {$m_id}";
    // $sql = "delete from mobile_details where id = '$m_id'";
    $result = mysqli_query($con, $sql);
    header("location:http://localhost/PHP/show_products.php");

    mysqli_close($con);

?>