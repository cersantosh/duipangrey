<?php
session_start();

if (!isset($_SESSION['admin_email'])) {
    die("File Not Found");
}


include "../connection.php";
$sql_users = "select * from signup";
$sql_bikes = "select * from sell_bikes";
$sql_scooters = "select * from sell_scooters";
$sql_messages = "select * from contact_us";
$sql_ordered_bikes = "select * from order_bikes";
$sql_ordered_scooters = "select * from order_scooters";

$no_of_users = mysqli_num_rows(mysqli_query($con, $sql_users));
$no_of_bikes = mysqli_num_rows(mysqli_query($con, $sql_bikes));
$no_of_scooters = mysqli_num_rows(mysqli_query($con, $sql_scooters));
$no_of_messages = mysqli_num_rows(mysqli_query($con, $sql_messages));
$no_of_bikes_order_request = mysqli_num_rows(mysqli_query($con, $sql_ordered_bikes));
$no_of_scooters_order_request = mysqli_num_rows(mysqli_query($con, $sql_ordered_scooters));


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../../CSS/admin/admin.css?v=<?php echo time(); ?>">
</head>

<body>


    <div class="container">

        <div class="wrapper">
            <div class="users">
                <p><?php print($no_of_users) ?></p>
                <p>Users</p>
                <i class="fa-sharp fa-solid fa-users"></i>
                <div class="link">
                    <a href="view_users.php">More Info</a>
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </div>

            </div>

            <div class="bikes">
                <p><?php print($no_of_bikes) ?></p>
                <p>Bikes</p>
                <i class="fa-sharp fa-solid fa-motorcycle"></i>

                <div class="link">
                    <a href="view_bikes.php">More Info</a>
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </div>

            </div>

            <div class="scooters">
                <p><?php print($no_of_scooters) ?></p>
                <p>Scooters</p>
                <i class="fa-solid fa-person-biking"></i>
                <div class="link">
                    <a href="view_scooters.php">More Info</a>
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </div>
            </div>

            <div class="message">
                <p><?php print($no_of_messages) ?></p>
                <p>Messages</p>
                <i class="fa-solid fa-message"></i>
                <div class="link">
                    <a href="view_message.php">More Info</a>
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </div>
            </div>
        </div>

        <div class="order_details">
            <div class="bikes_ordered">
                <p><?php print($no_of_bikes_order_request) ?></p>
                <p>Bikes Order Request</p>
                <i class="fa-solid fa-chart-simple"></i>
                <div class="link">
                    <a href="view_order_bikes.php">More Info</a>
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </div>
            </div>
            <div class="scooters_ordered">
                <p><?php print($no_of_scooters_order_request) ?></p>
                <p>Scooters Order Request</p>
                <i class="fa-solid fa-chart-simple"></i>
                <div class="link">
                    <a href="view_order_scooters.php">More Info</a>
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </div>
            </div>
        </div>



    </div>




</body>

</html>