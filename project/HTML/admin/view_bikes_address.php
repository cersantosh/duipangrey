<?php

session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);


if (!isset($_SESSION['admin_email'])) {
    die("File Not Found");
}

include "../connection.php";

$id = $_GET['id'];
$address_value = $_GET['sn'];

$sql_bikes = "select * from sell_bikes";
$result = mysqli_query($con, $sql_bikes) or die("Query Failed !");

$sql_bikes_address = "select * from sell_bikes where id = $id";
$result_address = mysqli_query($con, $sql_bikes_address) or die("Query Failed !");

$value = 1;

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

    <div class="container">
        <div class="images">
            <button><a href="bikes_images.php">Images</a></button>
        </div>

        <div class="click_address">
            <div class="address_table">
                <table>
                    <tr class="table_header">
                        <th>S.N.</th>
                        <th>Zone</th>
                        <th>District</th>
                        <th>City</th>
                        <th>Tole</th>
                    </tr>
                    <?php
                    while ($rows_address = mysqli_fetch_assoc($result_address)) {

                    ?>

                        <tr class="table_data">
                            <td><?php print($address_value) ?></td>
                            <td>Gandaki</td>
                            <td><?php print($rows_address['district']) ?></td>
                            <td><?php print($rows_address['city']) ?></td>
                            <td><?php print($rows_address['tole']) ?></td>
                        </tr>

                    <?php
                        $address_value++;
                    } ?>

                </table>
            </div>
        </div>

        <div class="bikes_information">
            <table>
                <caption>
                    <div>Bikes Information</div>
                </caption>
                <tr>
                    <th>S.N.</th>
                    <th>Brand Name</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>E-mail</th>
                    <th>Delete</th>
                    <th>Address</th>
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
                        <td class="remove"><button><a href="delete_bikes.php?id=<?php print($rows['id']) ?>">Delete</a></button></td>
                        <td class="remove"><button class="address_btn"><a href="view_bikes_address.php?id=<?php print($rows['id']) ?>&sn=<?php print($value) ?>">Address</a></button></td>
                    </tr>

                <?php $value++;
                } ?>

            </table>
        </div>

    </div>



    <script>
        let table_data = document.querySelectorAll(".table_data");
        // console.log(table_data);
        let table_header = document.querySelector(".table_header");
        let click_address = document.querySelector(".click_address");


        function show_address(value) {
            console.log(value);
            for (let i = 0; i < table_data.length; i++) {
                if (i == value) {
                    table_header.style.display = "block";
                    table_data[i].style.display = "block";
                    continue;
                }
                table_data[i].style.display = "none";


            }
            // console.log(value);
            click_address.style.display = "block";
        }
    </script>





</body>

</html>