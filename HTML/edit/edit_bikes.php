<?php
session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
if (!isset($_SESSION['login_successful'])) {
    header("location:http://localhost/project/html/login/login.php");
}
if (!isset($_GET['id']) || !isset($_GET['vehicle'])) {
    die("File NOt Found");
}
include "../connection.php";
$id = $_GET['id'];
// showing all information about bikes
$sql = "select * from sell_bikes where id = '$id'";
$result = mysqli_query($con, $sql);
$rows = mysqli_fetch_assoc($result);

// to show images
$sql_image = "select * from bikes_images where bikes_id = '$id'";
$result_image = mysqli_query($con, $sql_image) or die("Query Failed !");


$company_name = $rows['company_name'];
$model = $rows['model'];
$cc = $rows['cc'];
$km_run = $rows['km_run'];
$lot_no = $rows['lot_number'];
$fuel_capacity = $rows['fuel_capacity'];
$original_price = $rows['original_price'];
$new_price = $rows['new_price'];
$district = $rows['district'];
$city = $rows['city'];
$tole = $rows['tole'];
$additional_details = $rows['additional_details'];
$keywords = $rows['keywords'];

if (isset($_POST['submit'])) {
    $image_name = $_FILES['images']['name'][0];
    // update database if images are selected
    if ($image_name != "") {
        // deleting all previous images of this product
        $sql_image = "select * from bikes_images where bikes_id = '$id'";
        $result_image = mysqli_query($con, $sql_image) or die("Query Failed !");

        while ($rows_images = mysqli_fetch_assoc($result_image)) {
            mysqli_query($con, "delete from bikes_images where bikes_id = '$id'") or die("Query Failed !");
            $image = $rows_images['image_name'];
            unlink("../uploaded_images/bikes/$image");
        }

        // insering new uploaded images to database
        $i = $_FILES['images'];
        foreach ($i['name'] as $key => $value) {
            $file_name = $value;
            $file_tmp_name = $i['tmp_name'][$key];
            $destination = "../uploaded_images/bikes/$file_name";
            if (file_exists($destination)) {
                $file_name = time() . $file_name;
                $destination = "../uploaded_images/bikes/$file_name";
            }
            move_uploaded_file($file_tmp_name, $destination);
            $sql_insert = "insert into bikes_images(bikes_id, image_name) values('$id', '$file_name')";
            mysqli_query($con, $sql_insert) or die("Query Failed !");
        }
    }

    // updaing products details

    $company_name = $_POST['company_name'];
    $model = $_POST['model'];
    $cc = $_POST['cc'];
    $km_run = $_POST['km_run'];
    $lot_no = $_POST['lot_no'];
    $fuel_capacity = $_POST['fuel_capacity'];
    $original_price = $_POST['original_price'];
    $new_price = $_POST['new_price'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $tole = $_POST['tole'];
    $additional_details = $_POST['additional_details'];
    $keywords = $_POST['keywords'];
    $email = $_SESSION['login_email'];

    include "connection.php";
    $sql = "update sell_bikes set company_name = '$company_name', model = '$model', cc = '$cc', km_run = '$km_run', lot_number = '$lot_no', fuel_capacity = '$fuel_capacity', original_price = '$original_price', new_price = '$new_price', district = '$district', city = '$city', tole = '$tole', additional_details = '$additional_details', keywords = '$keywords' where id = '$id'";

    $result = mysqli_query($con, $sql) or die("Query Failed !");
    header("location:http://localhost/project/HTML/main");

    mysqli_close($con);
}


?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../bootstrap/bootstrap.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <!-- <link rel="stylesheet" href="../CSS/sellbikes.css"> -->
    <link rel="stylesheet" href="../../CSS/edit/edit_bikes.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-9 col-md-7 col-lg-5 col-xl-4 column">
                <div class="container_all">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <span for="" class="image_star">*</span>
                        <div class="image_wrapper">
                            <div class="image_details">
                                <?php
                                if (mysqli_num_rows($result_image) >= 2) {
                                ?>
                                    <span class="image_prev">&lt;</span>
                                    <span class="image_next">&gt;</span>
                                <?php } ?>
                                <span class="prev">&lt;</span>
                                <span class="next">&gt;</span>
                                <div class="icon_and_text">
                                    <i class="fa-solid fa-camera-rotate icon"></i>
                                    <p>Add Image</p>
                                </div>
                                <input type="file" class="image" multiple accept="image/*" name="images[]">
                                <?php
                                while ($rows_images = mysqli_fetch_assoc($result_image)) {
                                ?>
                                    <img src="../../uploaded_images/bikes/<?php print($rows_images['image_name']) ?>" alt="" class="show_image">
                                <?php } ?>
                            </div>
                        </div>
                        <code class="error">You Can Upload Only 5 Images</code>


                        <div class="company_details">
                            <span for="">*</span><input type="text" placeholder="Enter Brand Name" required name="company_name" value="<?php print($company_name) ?>" onkeyup="show_placeholder('label_brand_name', this)">
                            <label for="" class="label_brand_name">Enter Brand Name</label>
                        </div>

                        <div class="model_details">
                            <span for="">*</span><input type="text" placeholder="Enter Model" required name="model" value="<?php print($model) ?>" onkeyup="show_placeholder('label_model', this)">
                            <label for="" class="label_model">Enter Model</label>
                        </div>

                        <div class="cc_details">
                            <span for="">*</span> <input type="number" placeholder="Enter CC" required class="cc" name="cc" value="<?php print($cc) ?>" onkeyup="show_placeholder('label_cc', this)">
                            <label for="" class="label_cc">Enter CC</label>

                        </div>
                        <code class="error">Enter Positive Number</code>

                        <div class="km_details">
                            <span for="">*</span><input type="number" placeholder="Enter KM Run" required class="km" name="km_run" value="<?php print($km_run) ?>" onkeyup="show_placeholder('label_km_run', this)">
                            <label for="" class="label_km_run">Enter KM Run</label>
                        </div>
                        <code class="error">Enter Positive Number</code>

                        <div class="lotno_details">
                            <span for="">*</span><input type="number" placeholder="Enter Lot Number" required class="lot_no" name="lot_no" value="<?php print($lot_no) ?>" onkeyup="show_placeholder('label_lot_no', this)">
                            <label for="" class="label_lot_no">Enter Lot Number</label>
                        </div>
                        <code class="error">Enter Positive Number</code>


                        <div class="fuel_details">
                            <span for="">*</span><input type="number" placeholder="Enter Fuel Capacity" required class="fuel_capacity" name="fuel_capacity" value="<?php print($fuel_capacity) ?>" onkeyup="show_placeholder('label_fuel_capacity', this)">
                            <label for="" class="label_fuel_capacity">Enter Fuel Capacity</label>
                        </div>
                        <code class="error">Enter Positive Number</code>

                        <div class="original_price_details">
                            <span for="">*</span><input type="number" placeholder="Enter Original Price" required class="original_price" name="original_price" value="<?php print($original_price) ?>" onkeyup="show_placeholder('label_original_price', this)">
                            <label for="" class="label_original_price">Enter Original Price</label>
                        </div>
                        <code class="error">Enter Positive Number</code>


                        <div class="new_price_details">
                            <span for="">*</span><input type="number" placeholder="Enter New Price" required class="new_price" name="new_price" value="<?php print($new_price) ?>" onkeyup="show_placeholder('label_new_price', this)">
                            <label for="" class="label_new_price">Enter New Price</label>
                        </div>
                        <code class="error">Enter Positive Number</code>

                        <div class="location_details">
                            <div class="district_details">
                                <span for="">*</span>
                                <select name="district" id="" class="district_list" required>

                                    <?php
                                    if ($district == "kaski") {

                                        print("<option value='' disabled>Select District</option>");
                                        print("<option value='kaski' selected>Kaski</option>");
                                        print("<option value='baglung'>Baglung</option>");
                                        print("<option value='gorkha'>Gorkha</option>");
                                        print("<option value='syangja'>Syangja</option>");
                                        print("<option value='tanahun'>Tanahun</option>");
                                        print("<option value='manang'>Manang</option>");
                                        print("<option value='mustang'>Mustang</option>");
                                        print("<option value='myagdi'>Myagdi</option>");
                                        print("<option value='parbat'>Parbat</option>");
                                        print("<option value='nawalpur'>Nawalpur</option>");
                                        print("<option value='lamjung'>Lamjung</option>");
                                    } else if ($district == "baglung") {
                                        print("<option value='' disabled>Select District</option>");
                                        print("<option value='kaski'>Kaski</option>");
                                        print("<option value='baglung' selected>Baglung</option>");
                                        print("<option value='gorkha'>Gorkha</option>");
                                        print("<option value='syangja'>Syangja</option>");
                                        print("<option value='tanahun'>Tanahun</option>");
                                        print("<option value='manang'>Manang</option>");
                                        print("<option value='mustang'>Mustang</option>");
                                        print("<option value='myagdi'>Myagdi</option>");
                                        print("<option value='parbat'>Parbat</option>");
                                        print("<option value='nawalpur'>Nawalpur</option>");
                                        print("<option value='lamjung'>Lamjung</option>");
                                    } else if ($district == "gorkha") {
                                        print("<option value='' disabled>Select District</option>");
                                        print("<option value='kaski>Kaski</option>");
                                        print("<option value='baglung'>Baglung</option>");
                                        print("<option value='gorkha' selected>Gorkha</option>");
                                        print("<option value='syangja'>Syangja</option>");
                                        print("<option value='tanahun'>Tanahun</option>");
                                        print("<option value='manang'>Manang</option>");
                                        print("<option value='mustang'>Mustang</option>");
                                        print("<option value='myagdi'>Myagdi</option>");
                                        print("<option value='parbat'>Parbat</option>");
                                        print("<option value='nawalpur'>Nawalpur</option>");
                                        print("<option value='lamjung'>Lamjung</option>");
                                    } else if ($district == "syangja") {
                                        print("<option value='' disabled>Select District</option>");
                                        print("<option value='kaski'>Kaski</option>");
                                        print("<option value='baglung'>Baglung</option>");
                                        print("<option value='gorkha'>Gorkha</option>");
                                        print("<option value='syangja' selected>Syangja</option>");
                                        print("<option value='tanahun'>Tanahun</option>");
                                        print("<option value='manang'>Manang</option>");
                                        print("<option value='mustang'>Mustang</option>");
                                        print("<option value='myagdi'>Myagdi</option>");
                                        print("<option value='parbat'>Parbat</option>");
                                        print("<option value='nawalpur'>Nawalpur</option>");
                                        print("<option value='lamjung'>Lamjung</option>");
                                    } else if ($district == "tanahun") {
                                        print("<option value='' disabled>Select District</option>");
                                        print("<option value='kaski'>Kaski</option>");
                                        print("<option value='baglung'>Baglung</option>");
                                        print("<option value='gorkha'>Gorkha</option>");
                                        print("<option value='syangja'>Syangja</option>");
                                        print("<option value='tanahun' selected>Tanahun</option>");
                                        print("<option value='manang'>Manang</option>");
                                        print("<option value='mustang'>Mustang</option>");
                                        print("<option value='myagdi'>Myagdi</option>");
                                        print("<option value='parbat'>Parbat</option>");
                                        print("<option value='nawalpur'>Nawalpur</option>");
                                        print("<option value='lamjung'>Lamjung</option>");
                                    } else if ($district == "manang") {
                                        print("<option value='' disabled>Select District</option>");
                                        print("<option value='kaski'>Kaski</option>");
                                        print("<option value='baglung'>Baglung</option>");
                                        print("<option value='gorkha'>Gorkha</option>");
                                        print("<option value='syangja'>Syangja</option>");
                                        print("<option value='tanahun'>Tanahun</option>");
                                        print("<option value='manang' selected>Manang</option>");
                                        print("<option value='mustang'>Mustang</option>");
                                        print("<option value='myagdi'>Myagdi</option>");
                                        print("<option value='parbat'>Parbat</option>");
                                        print("<option value='nawalpur'>Nawalpur</option>");
                                        print("<option value='lamjung'>Lamjung</option>");
                                    } else if ($district == "mustang") {
                                        print("<option value='' disabled>Select District</option>");
                                        print("<option value='kaski'>Kaski</option>");
                                        print("<option value='baglung'>Baglung</option>");
                                        print("<option value='gorkha'>Gorkha</option>");
                                        print("<option value='syangja'>Syangja</option>");
                                        print("<option value='tanahun'>Tanahun</option>");
                                        print("<option value='manang'>Manang</option>");
                                        print("<option value='mustang' selected>Mustang</option>");
                                        print("<option value='myagdi'>Myagdi</option>");
                                        print("<option value='parbat'>Parbat</option>");
                                        print("<option value='nawalpur'>Nawalpur</option>");
                                        print("<option value='lamjung'>Lamjung</option>");
                                    } else if ($district == "myagdi") {
                                        print("<option value='' disabled>Select District</option>");
                                        print("<option value='kaski'>Kaski</option>");
                                        print("<option value='baglung'>Baglung</option>");
                                        print("<option value='gorkha'>Gorkha</option>");
                                        print("<option value='syangja'>Syangja</option>");
                                        print("<option value='tanahun'>Tanahun</option>");
                                        print("<option value='manang'>Manang</option>");
                                        print("<option value='mustang'>Mustang</option>");
                                        print("<option value='myagdi' selected>Myagdi</option>");
                                        print("<option value='parbat'>Parbat</option>");
                                        print("<option value='nawalpur'>Nawalpur</option>");
                                        print("<option value='lamjung'>Lamjung</option>");
                                    } else if ($district == "parbat") {
                                        print("<option value='' disabled>Select District</option>");
                                        print("<option value='kaski'>Kaski</option>");
                                        print("<option value='baglung'>Baglung</option>");
                                        print("<option value='gorkha'>Gorkha</option>");
                                        print("<option value='syangja'>Syangja</option>");
                                        print("<option value='tanahun'>Tanahun</option>");
                                        print("<option value='manang'>Manang</option>");
                                        print("<option value='mustang'>Mustang</option>");
                                        print("<option value='myagdi'>Myagdi</option>");
                                        print("<option value='parbat' selected>Parbat</option>");
                                        print("<option value='nawalpur'>Nawalpur</option>");
                                        print("<option value='lamjung'>Lamjung</option>");
                                    } else if ($district == "nawalpur") {
                                        print("<option value='' disabled>Select District</option>");
                                        print("<option value='kaski'>Kaski</option>");
                                        print("<option value='baglung'>Baglung</option>");
                                        print("<option value='gorkha'>Gorkha</option>");
                                        print("<option value='syangja'>Syangja</option>");
                                        print("<option value='tanahun'>Tanahun</option>");
                                        print("<option value='manang'>Manang</option>");
                                        print("<option value='mustang'>Mustang</option>");
                                        print("<option value='myagdi'>Myagdi</option>");
                                        print("<option value='parbat'>Parbat</option>");
                                        print("<option value='nawalpur' selected>Nawalpur</option>");
                                        print("<option value='lamjung'>Lamjung</option>");
                                    } else if ($district == "lamjung") {
                                        print("<option value='' disabled>Select District</option>");
                                        print("<option value='kaski'>Kaski</option>");
                                        print("<option value='baglung'>Baglung</option>");
                                        print("<option value='gorkha'>Gorkha</option>");
                                        print("<option value='syangja'>Syangja</option>");
                                        print("<option value='tanahun'>Tanahun</option>");
                                        print("<option value='manang'>Manang</option>");
                                        print("<option value='mustang'>Mustang</option>");
                                        print("<option value='myagdi'>Myagdi</option>");
                                        print("<option value='parbat'>Parbat</option>");
                                        print("<option value='nawalpur'>Nawalpur</option>");
                                        print("<option value='lamjung' selected>Lamjung</option>");
                                    }

                                    ?>


                                </select>
                            </div>

                            <div class="city_details">
                                <span for="">*</span><input type="text" placeholder="Enter City" required name="city" value="<?php print($city) ?>" onkeyup="show_placeholder('label_city', this)">
                                <label for="" class="label_city">Enter City</label>
                            </div>

                            <div class="tole_details">
                                <span for="">*</span><input type="text" placeholder="Enter Tole" required name="tole" value="<?php print($tole) ?>" onkeyup="show_placeholder('label_tole', this)">
                                <label for="" class="label_tole">Enter Tole</label>
                            </div>
                        </div>
                        <div class="description_details">
                            <textarea id="" placeholder="Enter Additional Details" class="description" name="additional_details" onkeyup="show_placeholder('label_additional_details', this)"></textarea>
                            <label for="" class="label_additional_details">Additional Details</label>
                        </div>

                        <div class="tags_details">
                            <textarea name="keywords" id="" placeholder="Enter Keywords (Use Comma For Multiple Values)" class="tags" onkeyup="show_placeholder('label_keywords', this)"></textarea>
                            <label for="" class="label_keywords">Enter Keywords</label>
                        </div>
                        <div class="submit">
                            <input type="submit" value="Update Bikes" class="submit_button" name="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="../../JS/edit/edit_bikes.js">

    </script>
</body>

</html>