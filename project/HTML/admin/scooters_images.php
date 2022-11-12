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
$result_scooters = mysqli_query($con, $sql_scooters) or die("Query Failed !");

// to know index of bikes used in next and previous button
$value = -1;



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scooters Images</title>
    <link rel="stylesheet" href="../../CSS/admin/bikes_images.css?v=<?php echo time(); ?>">
</head>

<body>

    <div class="container">

        <?php
        while ($rows_scooters = mysqli_fetch_assoc($result_scooters)) {
            $value++;
            $scooters_id = $rows_scooters['id'];
            $sql_image = "select * from scooters_images where scooters_id = '$scooters_id'";
            $result_image = mysqli_query($con, $sql_image) or die("Query Failed !");

            $sql_button = "select * from scooters_images where scooters_id = '$scooters_id'";
            $result_button = mysqli_query($con, $sql_button) or die("Query Failed !");



        ?>

            <div class="images">
                <?php
                if (mysqli_num_rows($result_image) >= 2) {
                ?>
                    <span class="image_prev" onclick="prev_image(<?php print($value) ?>)">&lt;</span>
                    <span class="image_next" onclick="next_image(<?php print($value) ?>)">&gt;</span>
                <?php } ?>

                <div>

                    <div>
                        <?php while ($rows_images = mysqli_fetch_assoc($result_image)) {
                        ?>
                            <img src="../../uploaded_images/scooters/<?php print($rows_images['image_name']) ?>" alt="">

                        <?php } ?>
                    </div>
                    <div>
                        <?php while ($rows_button = mysqli_fetch_assoc($result_button)) {
                        ?>
                            <button class="delete"><a href="remove_scooters_image.php?id=<?php print($rows_button['id']) ?>">Delete</a></button>
                        <?php } ?>
                    </div>
                </div>
            </div>

        <?php }
        ?>

    </div>

    <script>
        // working on image slider of products details
        let images_div = document.querySelectorAll(".images");
        let image_prev = document.querySelector(".image_prev")
        let image_next = document.querySelector(".image_next")
        // console.log(images_div[0].children[2].children[0])



        let images_array = [];
        let buttons_array = [];
        for (let i = 0; i < images_div.length; i++) {
            // this is for if there is only one image of vehicles
            if (images_div[i].children[2] == undefined) {
                images_array.push(images_div[i].children[0].children[0].children);
                buttons_array.push(images_div[i].children[0].children[1].children);
            } else {
                images_array.push(images_div[i].children[2].children[0].children);
                buttons_array.push(images_div[i].children[2].children[1].children);

            }
        }
        console.log(images_array);
        // displaying first image of all products
        for (let i = 0; i < images_array.length; i++) {
            images_array[i][0].style.display = "block";
            buttons_array[i][0].style.display = "block";
        }

        // to track images
        let image_index = 0;

        function next_image(value) {
            console.log(value);
            images_array[value][image_index].style.display = "none";
            buttons_array[value][image_index].style.display = "none";
            image_index++;
            if (image_index == images_array[value].length) {
                image_index = 0;
            }
            images_array[value][image_index].style.display = "block";
            buttons_array[value][image_index].style.display = "block";
            // console.log(image_index);

        }

        function prev_image(value) {
            console.log(value);
            images_array[value][image_index].style.display = "none";
            buttons_array[value][image_index].style.display = "none";
            image_index--;
            if (image_index == -1) {
                image_index = images_array[value].length - 1;
            }
            images_array[value][image_index].style.display = "block";
            buttons_array[value][image_index].style.display = "block";
            // console.log(image_index);


        }
    </script>


</body>

</html>