<?php

session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
$email = $_SESSION['login_email'];
if (!isset($_SESSION['login_email'])) {
    header("location:http://localhost/project/HTML/login/login.php");
}
include "../connection.php";
// getting add_to_cart_scooters of logged in user

$sql_read = "select * from add_to_cart_scooters join sell_scooters on scooters_id = sell_scooters.id where add_to_cart_scooters.email = '$email'";
$result = mysqli_query($con, $sql_read) or die("Query Failed !");
// used in image slider button

$value = -1;

?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../CSS/add_to_cart.css"> -->
    <link rel="stylesheet" href="../../CSS/products_showing/my_products.css?v=<?php echo time(); ?>">
    <title>My Products</title>
    <style>
        .focus_scooters {
            outline: 3px solid red;
            outline-offset: 2px;
        }
    </style>
</head>

<body>
    <div class="bikes_scooters">
        <button class="bikes"> <a href="../add_to_cart/view_add_to_cart_bikes.php" class="a_bikes">Bikes</a></button>
        <button class="scooters focus_scooters"> <a href="../add_to_cart/view_add_to_cart_scooters.php" class="a_scooters">Scooters</a></button>
    </div>
    <div class="container_all">

        <?php
        if (mysqli_num_rows($result) > 0) {


        ?>
            <table>
                <?php
                while ($rows = mysqli_fetch_assoc($result)) {
                    $value++;
                    $id = $rows['id'];
                    $sql_image = "select * from scooters_images where scooters_id = '$id'";
                    $result_image = mysqli_query($con, $sql_image) or die("Query Failed !");
                ?>
                    <tr class="records">
                        <td class="records_td">

                            <div>
                                <div class="image_details">
                                    <?php
                                    if (mysqli_num_rows($result_image) >= 2) {
                                    ?>
                                        <span class="image_prev" onclick="prev_image(<?php print($value) ?>)">&lt;</span>
                                        <span class="image_next" onclick="next_image(<?php print($value) ?>)">&gt;</span>
                                    <?php } ?>
                                    <a href="../view_details/view_details.php?id=<?php print($rows['scooters_id']) ?>&vehicle=scooters">

                                        <?php
                                        while ($rows_images = mysqli_fetch_assoc($result_image)) {
                                        ?>
                                            <img src="../../uploaded_images/scooters/<?php print($rows_images['image_name']) ?>" alt="" class="image">
                                        <?php } ?>
                                    </a>
                                </div>

                            </div>
                            <div class="bikes_and_buttons">
                                <div>

                                    <div class="bikes_details">
                                        <p class="model">Model : <?php print($rows['model']) ?></p>
                                        <p class="price">Price : <?php print($rows['new_price']) ?></p>
                                    </div>
                                </div>
                                <div>
                                    <div class="buttons">
                                        <button><a href="../view_details/view_details.php?id=<?php print($rows['id']) ?>&vehicle=scooters">View Details</a></button>
                                        <button><a href="../order/order_scooters.php?id=<?php print($rows['id']) ?>&vehicle=scooters">Request Order</a></button>
                                        <button><a href="../add_to_cart/remove_add_to_cart_scooters.php?id=<?php print($rows['id']) ?>&vehicle=scooters">Remove</a></button>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="buttons_td">
                            <div class="buttons_mobile">
                                <button class="button_view"><a href="../view_details/view_details.php?id=<?php print($rows['id']) ?>&vehicle=scooters">View Details</a></button>
                                <button><a href="../order/order_scooters.php?id=<?php print($rows['id']) ?>&vehicle=scooters">Request Order</a></button>
                                <button><a href="../add_to_cart/remove_add_to_cart_scooters.php?id=<?php print($rows['id']) ?>&vehicle=scooters">Remove</a></button>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>

            </table>
        <?php } else {
            print("<div class='no_products_details'><div class='no_products'> You Haven't added any scooters to cart ! </div></div>");
        }
        mysqli_close($con);
        ?>
    </div>

    <script>
        // focusing selected option

        let bikes = document.querySelector(".bikes")
        let scooters = document.querySelector(".scooters")
        let a_scooters = document.querySelector(".a_scooters")
        let a_bikes = document.querySelector(".a_bikes")

        a_bikes.addEventListener("click", focus)

        function focus() {
            bikes.classList.add("focus_bikes");
            scooters.classList.remove("focus_scooters");
        }

        // working on image slider of add to cart scooters

        let add_to_cart_records = document.querySelectorAll(".records");
        let images = [];
        for (let i = 0; i < add_to_cart_records.length; i++) {
            // this is for if there is only one image of vehicles
            if (add_to_cart_records[i].children[0].children[0].children[0].children[2] == undefined) {
                images.push(add_to_cart_records[i].children[0].children[0].children[0].children[0].children);
            } else {
                images.push(add_to_cart_records[i].children[0].children[0].children[0].children[2].children);

            }
        }
        console.log(images);
        // displaying first image of all products
        for (let i = 0; i < images.length; i++) {
            images[i][0].style.display = "block";
        }

        let image_index = 0;

        function next_image(value) {
            // console.log(value);
            images[value][image_index].style.display = "none";
            image_index++;
            if (image_index == images[value].length) {
                image_index = 0;
            }
            images[value][image_index].style.display = "block";
            // console.log(image_index);

        }

        function prev_image(value) {
            // console.log(value);
            images[value][image_index].style.display = "none";
            image_index--;
            if (image_index == -1) {
                image_index = images[value].length - 1;
            }
            images[value][image_index].style.display = "block";
            // console.log(image_index);


        }
    </script>

</body>

</html>