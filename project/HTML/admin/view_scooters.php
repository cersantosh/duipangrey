<?php

session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);


if (!isset($_SESSION['admin_email'])) {
    die("File Not Found");
}

include "../connection.php";

$sql_scooters = "select * from sell_scooters";
$result = mysqli_query($con, $sql_scooters) or die("Query Failed !");

$sql_scooters_address = "select * from sell_scooters";
$result_address = mysqli_query($con, $sql_scooters_address) or die("Query Failed !");

$value = 1;
$address_value = 1;
$pass_address = -1;


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
            <div class="images">
                <button><a href="scooters_images.php">Images</a></button>
            </div>



            <div class="bikes_information">
                <table>
                    <caption>
                        <div>Scooters Information</div>
                    </caption>
                    <tr>
                        <th>S.N.</th>
                        <th>Brand Name</th>
                        <th>Model</th>
                        <th>Price</th>
                        <th>E-mail</th>
                        <th>Delete</th>
                        <th>Address</th>
                        <!-- <th>Images</th> -->
                        <!-- <th class="address_th">District</th>
                    <th class="address_th">City</th>
                    <th class="address_th">Tole</th> -->
                    </tr>

                    <?php
                    while ($rows = mysqli_fetch_assoc($result)) {

                    ?>

                        <tr>
                            <td><?php print($value) ?></td>
                            <td><?php print($rows['company_name']) ?></td>
                            <td><?php print($rows['model']) ?></td>
                            <td><?php print($rows['new_price']) ?></td>
                            <td class="show_email"><?php print($rows['email']) ?></td>
                            <td class="remove"><button><a href="delete_scooters.php?id=<?php print($rows['id']) ?>">Delete</a></button></td>
                            <td class="remove"><button class="address_btn"><a href="view_scooters_address.php?id=<?php print($rows['id']) ?>&sn=<?php print($value) ?>">Address</a></button></td>
                        </tr>

                    <?php $value++;
                    } ?>

                </table>
            </div>

        </div>

    <?php } else {
        print("No scooters.");
    } ?>






</body>

</html>