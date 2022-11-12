<?php
session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
// we can't sell without login
if ($_SESSION['login_successful'] != "true") {
    header("location:http://localhost/project/html/login/login.php");
}

if (isset($_POST['submit'])) {
    // getting bikes details
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

    include "../connection.php";
    $sql = "insert into sell_bikes(company_name, model, cc, km_run, lot_number, fuel_capacity, original_price, new_price, district, city, tole, additional_details, keywords, email) values('$company_name', '$model', '$cc', '$km_run', '$lot_no', '$fuel_capacity', '$original_price', '$new_price', '$district', '$city', '$tole', '$additional_details', '$keywords', '$email')";

    mysqli_query($con, $sql) or die("Query Failed !");
    // getting last inserted auto increment id
    $id = mysqli_insert_id($con);
    // getting uploaded_images
    $i = $_FILES['images'];
    foreach ($i['name'] as $key => $value) {
        $file_name = $value;
        $file_tmp_name = $i['tmp_name'][$key];
        $destination = "../../uploaded_images/bikes/$file_name";
        if (file_exists($destination)) {
            $file_name = time() . $file_name;
            $destination = "../../uploaded_images/bikes/$file_name";
        }
        move_uploaded_file($file_tmp_name, $destination);
        $sql_insert = "insert into bikes_images(bikes_id, image_name) values('$id', '$file_name')";
        mysqli_query($con, $sql_insert) or die("Query Failed !");
    }


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
    <link rel="stylesheet" href="../../CSS/sell_vehicle/sellbikes.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- <?php include "../nav_bar.php" ?> -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-9 col-md-7 col-lg-5 col-xl-4 column">
                <div class="container_all">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <span for="" class="image_star">*</span>
                        <div>
                            <div class="image_details">
                                <span class="prev">&lt;</span>
                                <span class="next">&gt;</span>
                                <div class="icon_and_text">
                                    <i class="fa-solid fa-camera-rotate icon"></i>
                                    <p>Add Image</p>
                                </div>
                                <input type="file" class="image" required multiple accept="image/*" name="images[]">
                                <img src="" alt="" class="show_image">
                            </div>
                        </div>
                        <code class="error">You Can Upload Only 5 Images</code>


                        <div class="company_details">
                            <span for="">*</span><input type="text" placeholder="Enter Brand Name" required name="company_name" onkeyup="show_placeholder('label_brand_name', this)">
                            <label for="" class="label_brand_name">Enter Brand Name</label>
                        </div>

                        <div class="model_details">
                            <span for="">*</span><input type="text" placeholder="Enter Model" required name="model" onkeyup="show_placeholder('label_model', this)">
                            <label for="" class="label_model">Enter Model</label>
                        </div>

                        <div class="cc_details">
                            <span for="">*</span>
                            <!-- <input type="number" placeholder="Enter CC" required class="cc" name="cc"> -->
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Enter CC" class="cc" name="cc" required onkeyup="show_placeholder('label_cc', this)" />
                            <label for="" class="label_cc">Enter CC</label>

                        </div>
                        <code class="error">Enter Positive Number</code>

                        <div class="km_details">
                            <span for="">*</span>
                            <!-- <input type="number" placeholder="Enter KM Run" required class="km" name="km_run"> -->
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Enter KM Run" class="km" name="km_run" required onkeyup="show_placeholder('label_km_run', this)" />
                            <label for="" class="label_km_run">Enter KM Run</label>
                        </div>
                        <code class="error">Enter Positive Number</code>

                        <div class="lotno_details">
                            <span for="">*</span>
                            <!-- <input type="number" placeholder="Enter Lot Number" required class="lot_no" name="lot_no"> -->
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Enter Lot Number" class="lot_no" name="lot_no" required onkeyup="show_placeholder('label_lot_no', this)" />
                            <label for="" class="label_lot_no">Enter Lot Number</label>
                        </div>
                        <code class="error">Enter Positive Number</code>


                        <div class="fuel_details">
                            <span for="">*</span>
                            <!-- <input type="number" placeholder="Enter Fuel Capacity" required class="fuel_capacity" name="fuel_capacity"> -->
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Enter Fuel Capacity" class="fuel_capacity" name="fuel_capacity" required onkeyup="show_placeholder('label_fuel_capacity', this)" />
                            <label for="" class="label_fuel_capacity">Enter Fuel Capacity</label>
                        </div>
                        <code class="error">Enter Positive Number</code>


                        <div class="original_price_details">
                            <span for="">*</span>
                            <!-- <input type="number" placeholder="Enter Original Price" required
                    class="original_price" name="original_price"> -->
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Enter Original Price" class="original_price" name="original_price" required onkeyup="show_placeholder('label_original_price', this)" />
                            <label for="" class="label_original_price">Enter Original Price</label>
                        </div>
                        <code class="error">Enter Positive Number</code>


                        <div class="new_price_details">
                            <span for="">*</span>
                            <!-- <input type="number" placeholder="Enter New Price" required class="new_price" name="new_price"> -->
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Enter New Price" class="new_price" name="new_price" required onkeyup="show_placeholder('label_new_price', this)" />
                            <label for="" class="label_new_price">Enter New Price</label>
                        </div>
                        <code class="error">Enter Positive Number</code>

                        <div class="location_details">
                            <div class="district_details">
                                <span for="">*</span>
                                <select name="district" id="" class="district_list" required>
                                    <option value="" selected disabled>Select District</option>
                                    <option value="kaski">Kaski</option>
                                    <option value="baglung">Baglung</option>
                                    <option value="gorkha">Gorkha</option>
                                    <option value="syangja">Syangja</option>
                                    <option value="tanahun">Tanahun</option>
                                    <option value="manang">Manang</option>
                                    <option value="mustang">Mustang</option>
                                    <option value="myagdi">Myagdi</option>
                                    <option value="parbat">Parbat</option>
                                    <option value="nawalpur">Nawalpur</option>
                                    <option value="lamjung">Lamjung</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="city_details">
                                <span for="">*</span><input type="text" placeholder="Enter City" required name="city" onkeyup="show_placeholder('label_city', this)">
                                <label for="" class="label_city">Enter City</label>
                            </div>

                            <div class="tole_details">
                                <span for="">*</span><input type="text" placeholder="Enter Tole" required name="tole" onkeyup="show_placeholder('label_tole', this)">
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
                            <input type="submit" value="Add Bikes" class="submit_button" name="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../../JS/sell_vehicle/sellbikesvalidation.js">

    </script>
</body>

</html>