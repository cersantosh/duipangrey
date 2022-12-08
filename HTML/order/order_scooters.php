<?php
session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
// we can't order any products withoout login

if (!isset($_SESSION['login_email'])) {
    header("location:http://localhost/project/HTML/login/login.php");
} else {
    if (!isset($_GET['id']) || !isset($_GET['vehicle'])) {
        die("File Not Found");
    }

    $login_email = $_SESSION['login_email'];
    $id = $_GET['id'];
    $vehicle = $_GET['vehicle'];
    $sql = "select * from sell_scooters where id = '$id'";

    include "../connection.php";
    $result = mysqli_query($con, $sql) or die("Query Failed !");
    $rows = mysqli_fetch_assoc($result);
    // getting product owner email to send mail

    $product_owner_email = $rows['email'];
    // getting product_owner phone_number and name to show to the client
    // print($product_owner_email);

    $sql_phone_number = "select phone_number,full_name from signup where email = '$product_owner_email'";
    $result_phone_number = mysqli_query($con, $sql_phone_number) or die("Query Failed !");
    $rows_phone_number = mysqli_fetch_assoc($result_phone_number);
    $phone_number = $rows_phone_number['phone_number'];
    $full_name = $rows_phone_number['full_name'];
    // print($phone_number);

}

// getting client phone_number and email so that product_owner can contact to the client

$sql_client_phone_number = "select phone_number from signup where email = '$login_email'";
$client_phone_number = (mysqli_fetch_assoc(mysqli_query($con, $sql_client_phone_number)))['phone_number'];
// print($client_phone_number);

$to_email = $product_owner_email;
$subject = "Order Request";
$body = "Please contact the client as soon as possible.<br> Email : '$login_email' <br> Phone Number : '$client_phone_number'";
$headers = "From: '$login_email'";


$sql_count = "select * from order_scooters where scooters_id = '$id' and email = '$login_email'";
$result_count = mysqli_query($con, $sql_count) or die("Query Failed !");
$no_of_rows = mysqli_num_rows($result_count);
// print($no_of_rows);

// if same products is ordered twice
// inserting to databse only once
if ($no_of_rows == 0) {

    $sql_request_order = "insert into order_scooters(scooters_id, email) values('$id', '$login_email')";
    $result_request_order = mysqli_query($con, $sql_request_order) or die("Query Failed !");
    mail($to_email, $subject, $body, $headers);
}
// header("location:http://localhost/project/html/view_scooters_order.php");


// displaying images

$sql_image = "select * from scooters_images where scooters_id = '$id'";
$result_image = mysqli_query($con, $sql_image) or die("Query Failed !");




?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="../CSS/signup_verification.css"> -->
    <link rel="stylesheet" href="../../CSS/order/order.css?v=<?php echo time(); ?>">
</head>

<body>
    <p class="verification">Your Order request has sent to the owner </p>
    <div class="container">
        <div class="products">
            <div class="image_details">
                <?php
                // showing image slider button if there are greater than 2 images

                if (mysqli_num_rows($result_image) >= 2) {
                ?>
                    <span class="image_prev">&lt;</span>
                    <span class="image_next">&gt;</span>
                <?php } ?>
                <?php
                while ($rows_images = mysqli_fetch_assoc($result_image)) {
                ?>

                    <img src="../../uploaded_images/<?php print($vehicle) ?>/<?php print($rows_images['image_name']) ?>" alt="" class="image">
                <?php } ?>
            </div>
            <div>
                <p>Model : <?php print($rows['model']) ?></p>
                <p>Price : <?php print($rows['new_price']) ?></p>
                <p>District : <?php print($rows['district']) ?></p>
                <p>City : <?php print($rows['city']) ?></p>
            </div>
        </div>
        <div class="contact">
            <p>Owner Name : <?php print($full_name) ?></p>
            <label for="number">Contact Number : </label>
            <input type="password" value="<?php print($phone_number) ?>" id="number" readonly maxlength="10">
        </div>
    </div>


    <script>
        // showing phone_number on click

        let input = document.querySelector("#number")
        let state = true;
        input.addEventListener("click", () => {
            if (state == true) {

                input.type = "text";
                state = false;
            } else {
                input.type = "password";
                state = true;
            }
        })

        // working on image slider of products details
        let images = document.querySelectorAll(".products img");
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