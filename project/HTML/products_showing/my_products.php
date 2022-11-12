<?php

session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
if (!isset($_SESSION['login_successful'])) {
    header("location:http://localhost/project/html/login/login.php");
}
$email = $_SESSION['login_email'];
include "../connection.php";
// showing listed bikes 
$sql = "select * from sell_bikes where email = '$email'";
$result = mysqli_query($con, $sql) or die("Query Failed !");
$value = -1;


?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link rel="stylesheet" href="../../bootstrap/bootstrap.css"> -->

    <!-- <link rel="stylesheet" href="../CSS/add_to_cart.css"> -->
    <link rel="stylesheet" href="../../CSS/products_showing/my_products.css?v=<?php echo time(); ?>">
    <title>My Products</title>
</head>

<body>
    <div class="bikes_scooters">
        <button class="bikes focus_bikes"> <a href="../products_showing/my_products.php" class="a_bikes">Bikes</a></button>
        <button class="scooters"> <a href="../products_showing/my_scooters.php" class="a_scooters">Scooters</a></button>
    </div>
    <div class="container_all">

        <?php
        // checking if there are listed products or not
        if (mysqli_num_rows($result) > 0) {


        ?>

            <table>
                <?php
                while ($rows = mysqli_fetch_assoc($result)) {
                    $value++;
                    $id = $rows['id'];
                    // displaying images of products
                    $sql_image = "select * from bikes_images where bikes_id = '$id'";
                    $result_image = mysqli_query($con, $sql_image) or die("Query Failed !");

                ?>
                    <tr class="records">
                        <td class="records_td">

                            <div class="">
                                <div class="image_details">
                                    <?php
                                    // showing images slider button only when there are greater than 2 images
                                    if (mysqli_num_rows($result_image) >= 2) {
                                    ?>
                                        <span class="image_prev" onclick="prev_image(<?php print($value) ?>)">&lt;</span>
                                        <span class="image_next" onclick="next_image(<?php print($value) ?>)">&gt;</span>
                                    <?php } ?>
                                    <a href="../view_details/view_details.php?id=<?php print($rows['id']) ?>&vehicle=bikes">

                                        <?php
                                        // creating img tag equl to no of images
                                        while ($rows_images = mysqli_fetch_assoc($result_image)) {
                                        ?>
                                            <img src="../../uploaded_images/bikes/<?php print($rows_images['image_name']) ?>" alt="" class="image">
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
                                        <button><a href="../view_details/view_own_details.php?id=<?php print($rows['id']) ?>&vehicle=bikes&my_products">View Details</a></button>
                                        <button><a href="../edit/edit_bikes.php?id=<?php print($rows['id']) ?>&vehicle=bikes" class="edit">Edit</a></button>
                                        <button><a href="../delete/delete_bikes.php?id=<?php print($rows['id']) ?>&vehicle=bikes">Remove</a></button>
                                    </div>
                                </div>
                            </div>

                        </td>

                        <td class="buttons_td">
                            <div class="buttons_mobile">
                                <button class="button_view"><a href="../view_details/view_own_details.php?id=<?php print($rows['id']) ?>&vehicle=bikes&my_products">View Details</a></button>
                                <button><a href="../edit/edit_bikes.php?id=<?php print($rows['id']) ?>&vehicle=bikes" class="edit">Edit</a></button>
                                <button><a href="../delete/delete_bikes.php?id=<?php print($rows['id']) ?>&vehicle=bikes">Remove</a></button>
                            </div>
                        </td>
                    </tr>


                <?php
                }
                ?>

            </table>
        <?php } else {
            print("<div class='no_products_details'><div class='no_products'> You Haven't listed any bikes ! </div></div>");
        }
        mysqli_close($con);
        ?>
    </div>
    <script>
        // to show outline on selected options
        let bikes = document.querySelector(".bikes")
        let scooters = document.querySelector(".scooters")
        let a_scooters = document.querySelector(".a_scooters")
        let a_bikes = document.querySelector(".a_bikes")

        a_scooters.addEventListener("click", focus)

        function focus() {
            scooters.classList.add("focus_scooters");
            bikes.classList.remove("focus_bikes");
        }

        // working on image slider of add to cart bikes

        let add_to_cart_records = document.querySelectorAll(".records");
        // console.log(add_to_cart_records[0].children[0].children)
        // contains images of each products
        let images = [];
        for (let i = 0; i < add_to_cart_records.length; i++) {
            // this is for if there is only one image of vehicles
            if (add_to_cart_records[i].children[0].children[0].children[0].children[2] == undefined) {
                images.push(add_to_cart_records[i].children[0].children[0].children[0].children[0].children);
            } else {
                images.push(add_to_cart_records[i].children[0].children[0].children[0].children[2].children);

            }
        }

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