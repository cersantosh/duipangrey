<?php

session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);

if (!isset($_SESSION['admin_email'])) {
    die("File Not Found");
}


include "../connection.php";

$sql_bikes = "select company_name, bikes_id, model, new_price, order_bikes.email as order_email, sell_bikes.email as owner_email from order_bikes join sell_bikes on bikes_id = sell_bikes.id";
$result = mysqli_query($con, $sql_bikes) or die("Query Failed !");

// $sql_bikes_address = "select * from sell_bikes";
// $result_address = mysqli_query($con, $sql_bikes_address) or die("Query Failed !");

$value = 1;


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="../CSS/view_details.css"> -->
    <link rel="stylesheet" href="../../CSS/admin/view_users.css?v=<?php echo time(); ?>">

</head>

<body>

    <?php
    if (mysqli_num_rows($result) > 0) {


    ?>

        <div class="container">

            <div class="bikes_information">
                <table>
                    <tr>
                        <th colspan="4" class="common">Bikes Information</th>
                        <th colspan="2" class="common">Owner</th>
                        <th colspan="2" class="common">Order By</th>
                    </tr>
                    <tr>
                        <th>S.N.</th>
                        <th>Brand Name</th>
                        <th>Model</th>
                        <th>Price</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Delete</th>
                    </tr>

                    <?php
                    while ($rows = mysqli_fetch_assoc($result)) {
                        $owner_email = $rows['owner_email'];
                        $order_email = $rows['order_email'];
                        $sql_owner = "select full_name from signup where email = '$owner_email'";
                        $sql_order = "select full_name from signup where email = '$order_email'";

                        $result_owner = mysqli_query($con, $sql_owner) or die("Query Failed !");
                        $result_order = mysqli_query($con, $sql_order) or die("Query Failed !");

                        $owner_full_name = mysqli_fetch_assoc($result_owner)['full_name'];
                        $order_full_name = mysqli_fetch_assoc($result_order)['full_name'];

                    ?>

                        <tr>
                            <td><?php print($value) ?></td>
                            <td><?php print($rows['company_name']) ?></td>
                            <td><?php print($rows['model']) ?></td>
                            <td><?php print($rows['new_price']) ?></td>
                            <td><?php print($owner_full_name) ?></td>
                            <td class="show_email"><?php print($rows['owner_email']) ?></td>
                            <td><?php print($order_full_name) ?></td>
                            <td class="show_email"><?php print($rows['order_email']) ?></td>
                            <td class="remove"><button><a href="delete_bikes.php?id=<?php print($rows['bikes_id']) ?>">Delete</a></button></td>
                        </tr>

                    <?php $value++;
                    } ?>

                </table>
            </div>

        </div>


    <?php } else {
        print("No any bikes ordered.");
    } ?>

</body>

</html>