<?php

session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);

if (!isset($_GET['id']) || !isset($_GET['vehicle'])) {
    die("File Not Found");
}
$id = $_GET['id'];
$vehicle = $_GET['vehicle'];
// print($vehicle);


include "../connection.php";

$vec = "";
if ($vehicle == "bikes") {
    $vec = "Bike";
    $sql = "select * from sell_bikes where id = '$id'";
} else {
    $vec = "Scooter";
    $sql = "select * from sell_scooters where id = '$id'";
}
$result = mysqli_query($con, $sql);
$rows = mysqli_fetch_assoc($result);

$images_table = $vehicle . "_images";
$vehicle_id = $vehicle . "_id";
// print($id);
$sql_image = "select * from $images_table where $vehicle_id = '$id'";
$result_image = mysqli_query($con, $sql_image) or die("Query Failed !");


// working on how many times this vehicle has been clicked

$login = isset($_SESSION['login_successful']);
$vehicle_id = $vehicle . "_id";
$sql_count = "select * from popular_$vehicle where $vehicle_id = $id";
$result_count = mysqli_query($con, $sql_count) or die("Query Failed");

if (mysqli_num_rows($result_count) > 0) {
    $rows_count = mysqli_fetch_assoc($result_count);
    $count = $rows_count['count'];
    // incrementing the count only when the other people click on the products not the same person who upload the products
    if (isset($_SESSION['login_successful'])) {
        $email = $_SESSION['login_email'];
        if ($email != $rows['email']) {

            $count++;
        }
    } else {
        $count++;
    }
    $sql_update = "update popular_$vehicle set count = $count where $vehicle_id = $id";
    mysqli_query($con, $sql_update) or die("Query Failed");
} else {
    $sql_insert = "insert into popular_$vehicle($vehicle_id, count) values($id, 1)";
    mysqli_query($con, $sql_insert) or die("Query Failed");
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="../CSS/view_details.css"> -->
    <link rel="stylesheet" href="../../CSS/view_details/view_details.css?v=<?php echo time(); ?>">
</head>

<body>

    <div class="container">
        <div class="image_details">
            <?php
            if (mysqli_num_rows($result_image) >= 2) {
            ?>
                <span class="image_prev">&lt;</span>
                <span class="image_next">&gt;</span>
            <?php } ?>
            <?php
            while ($rows_images = mysqli_fetch_assoc($result_image)) {
            ?>
                <img src="../../uploaded_images/<?php print($vehicle);
                                                print("/");
                                                print($rows_images['image_name']); ?>" alt="" class="image">
            <?php } ?>
        </div>
        <div class="bikes_information">
            <table>
                <caption>
                    <div><?php print($vec) ?> Information</div>
                </caption>
                <tr>
                    <th>Brand Name</th>
                    <td><?php print($rows['company_name']) ?></td>
                </tr>
                <tr>
                    <th>Model</th>
                    <td><?php print($rows['model']) ?></td>
                </tr>
                <tr>
                    <th>CC</th>
                    <td><?php print($rows['cc']) ?></td>
                </tr>
                <tr>
                    <th>KM Run</th>
                    <td><?php print($rows['km_run']) ?></td>
                </tr>
                <tr>
                    <th>Lot Number</th>
                    <td><?php print($rows['lot_number']) ?></td>
                </tr>
                <tr>
                    <th>Fuel Capacity</th>
                    <td><?php print($rows['fuel_capacity']) ?></td>
                </tr>
                <tr>
                    <th>Original Price</th>
                    <td><?php print($rows['original_price']) ?></td>
                </tr>
                <tr>
                    <th>New Price</th>
                    <td><?php print($rows['new_price']) ?></td>
                </tr>
            </table>
        </div>
        <div class="address_information">
            <table>
                <caption>
                    <div>Address Information</div>
                </caption>
                <tr>
                    <th>Zone</th>
                    <td>Gandaki</td>
                </tr>
                <tr>
                    <th>District</th>
                    <td><?php print($rows['district']) ?></td>
                </tr>
                <tr>
                    <th>City</th>
                    <td><?php print($rows['city']) ?></td>
                </tr>
                <tr>
                    <th>Tole</th>
                    <td><?php print($rows['tole']) ?></td>
                </tr>
            </table>
        </div>
    </div>



    <script>
        // working on image slider of products details
        let images = document.querySelectorAll(".image_details img");
        let image_prev = document.querySelector(".image_prev")
        let image_next = document.querySelector(".image_next")

        // to track images
        let image_index = 0;

        // if there is only one image then next and previous button will be disabled so it contains null
        if (image_next != null) {
            image_next.addEventListener("click", next_image);

        }

        if (image_prev != null) {
            image_prev.addEventListener("click", prev_image);

        }
        // console.log(images);

        // displaying first image
        images[0].style.display = "block";

        function next_image() {
            images[image_index].style.display = "none";
            image_index++;
            if (image_index == images.length) {
                image_index = 0;
            }
            images[image_index].style.display = "block";
            // console.log(image_index);

        }

        function prev_image() {
            images[image_index].style.display = "none";
            image_index--;
            if (image_index == -1) {
                image_index = images.length - 1;
            }
            images[image_index].style.display = "block";
            // console.log(image_index);


        }
    </script>

</body>

</html>