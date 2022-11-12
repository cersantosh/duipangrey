<?php

session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
if (!isset($_SESSION['signup_access'])) {
    die("File Not Found !");
}
// if(isset($_SESSION['signup_successful']) && $_SESSION['signup_successful'] != "true"){
//     header("location:http://localhost/project/html/signup.php");
// }
include "../connection.php";

// getting whether email or phone_number error has occured
if (isset($_SESSION['email_number_error']) && $_SESSION['email_number_error'] == "true") {
    $has_email_error = true;
    $has_number_error = true;
    // print("both"."<br>");
}
if (isset($_SESSION['number_error']) && $_SESSION['number_error'] == "true") {
    $has_number_error = true;
    $has_email_error = false;
    // print("number error"."<br>");

}
if (isset($_SESSION['email_error']) && $_SESSION['email_error'] == "true") {
    $has_email_error = true;
    $has_number_error = false;
    // print("email error"."<br>");


}

// print("email".$has_email_error."<br>");
// print("number".$has_number_error."<br>");

// die();

// fetching all data as we have to show it here
$signup_email = $_SESSION['signup_email'];
$profile_picture_name = $_SESSION['profile_picture_name'];
$profile_tmp_name = $_SESSION['profile_tmp_name'];
$full_name = $_SESSION['full_name'];
$phone_number = $_SESSION['phone_number'];
$password = $_SESSION['password'];

if (isset($_POST['submit'])) {

    // again getting user values as user can change the input
    $_SESSION['full_name'] = $_POST["full_name"];
    $email = $_POST["email"];
    $_SESSION['signup_email'] = $email;
    $phone_number = $_POST['phone_number'];
    $_SESSION['phone_number']  = $phone_number;
    $_SESSION['password'] = $_POST['password'];
    // upload image only if user select another image
    if (isset($_FILES['profile_picture'])) {
        $image_name = $_FILES['profile_picture']['name'];
        // print_r($_FILES['profile_picture']);
        // die();

        if ($image_name != "") {
            unlink("../uploaded_images/profile_picture/$profile_picture_name");
            $profile_picture_name = $_FILES['profile_picture']['name'];
            $_SESSION['profile_picture_name'] = $profile_picture_name;
            $file_tmp_name = $_FILES['profile_picture']['tmp_name'];
            $_SESSION['profile_tmp_name'] = $file_tmp_name;
            $destination = "../uploaded_images/profile_picture/$profile_picture_name";
            if (file_exists($destination)) {
                $profile_picture_name = time() . $profile_picture_name;
                $destination = "../uploaded_images/profile_picture/$profile_picture_name";
            }
            move_uploaded_file($file_tmp_name, $destination);
        }
    }

    // fetching email from database
    $sql_email = "select * from signup where email = '$email'";
    $result_email = mysqli_query($con, $sql_email) or die("Query failed !");
    $no_of_email = mysqli_num_rows($result_email);

    $sql_phone_number = "select * from signup where phone_number = '$phone_number'";
    $result_phone_number = mysqli_query($con, $sql_phone_number) or die("Query failed !");
    $no_of_phone_number = mysqli_num_rows($result_phone_number);

    // print($email);

    if ($no_of_email == 1 && $no_of_phone_number == 1) {
        $has_email_error = true;
        $has_number_error = true;
        $_SESSION['email_number_error'] = "true";
        $_SESSION['signup_complete'] = "partial true";
    } elseif ($no_of_email == 1) {
        $has_email_error = true;
        $has_number_error = false;
        $_SESSION['email_error'] = "true";
        $_SESSION['signup_complete'] = "partial true";
    } elseif ($no_of_phone_number == 1) {
        $has_email_error = true;
        $has_number_error = false;
        $_SESSION['number_error'] = "true";
        $_SESSION['signup_complete'] = "partial true";
    } else {
        $_SESSION['signup_complete'] = "under verfication";
        $_SESSION['signup_verification'] = "under verification";
        header("location:http://localhost/project/html/signup/signup_verification.php");
    }


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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="../CSS/signup.css"> -->
    <!-- if css is not working use this -->
    <!-- or use ctr + f5 which is hard refresh -->
    <link rel="stylesheet" href="../../CSS/signup/signup.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-7 col-lg-5 col-xl-4 column">
                <div class="container_all">
                    <form action="" method="post" enctype="multipart/form-data">
                        <h3>Create Your Account</h3>
                        <div>
                            <div class="image_details">
                                <div class="icon_and_text">
                                    <i class="fa-solid fa-camera-rotate icon"></i>
                                    <p>Profile Picture</p>
                                </div>
                                <input type="file" class="image" accept="image/*" name="profile_picture">
                                <img src="<?php print("../../uploaded_images/profile_picture/$profile_picture_name") ?>" alt="" class="show_image" style="display:block;">
                            </div>
                        </div>
                        <code class="error">Images Size Must Be less than 1MB</code>

                        <div class="full_name_details">
                            <span for="">*</span><input type="text" placeholder="Enter Full Name" required name="full_name" value="<?php print($full_name) ?>" onkeyup="show_placeholder('label_full_name', this)">
                            <label for="" class="label_full_name">Enter Full Name</label>
                        </div>

                        <div class="email_details">
                            <div>
                                <span for="">*</span> <input type="email" placeholder="Enter email" required class="email" name="email" value="<?php print($signup_email) ?>" onkeyup="show_placeholder('label_email', this)">
                                <label for="" class="label_email">Enter E-mail</label>
                            </div>
                            <i class="fa-solid fa-circle-check correct correct_email"></i>
                            <i class="fa-solid fa-square-xmark incorrect incorrect_email"></i>


                        </div>
                        <code class="error">Invalid E-mail Address</code>

                        <div class="phone_number_details">
                            <div>
                                <span for="">*</span> <input type="number" placeholder="Enter phone number" required class="phone_number" name="phone_number" maxlength="10" value="<?php print($phone_number) ?>" onkeyup="show_placeholder('label_phone_number', this)" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <label for="" class="label_phone_number">Enter Phone Number</label>
                            </div>
                            <i class="fa-solid fa-circle-check correct correct_phone_number"></i>
                            <i class="fa-solid fa-square-xmark incorrect incorrect_phone_number"></i>


                        </div>
                        <code class="error">Invalid Phone Number</code>

                        <div class="password_details">
                            <div>
                                <span for="">*</span><input type="password" placeholder="Enter Password" required name="password" value="<?php print($password) ?>" onkeyup="show_placeholder('label_password', this)">
                                <label for="" class="label_password">Enter Password</label>
                            </div>
                            <p class="show_hide">SHOW</p>
                            <i class="fa-solid fa-circle-check correct correct_first_password"></i>
                            <i class="fa-solid fa-square-xmark incorrect incorrect_first_password"></i>
                        </div>
                        <code class="error">Password is Different</code>

                        <div class="confirm_password_details">
                            <div>
                                <span for="">*</span><input type="password" placeholder="Confirm Password" required class="confirm_password" value="<?php print($password) ?>" onkeyup="show_placeholder('label_confirm_password', this)">
                                <label for="" class="label_confirm_password">Enter Confirm Password</label>
                            </div>
                            <p class="show_hide">SHOW</p>
                            <i class="fa-solid fa-circle-check correct correct_confirm_password"></i>
                            <i class="fa-solid fa-square-xmark incorrect incorrect_confirm_password"></i>
                        </div>
                        <code class="error">Password is Different</code>


                        <div class="submit">
                            <input type="submit" value="SignUp" name="submit">
                        </div>
                        <div class="login_details">
                            <p class="login">Already SignUp ? <a href="login.php">Login Here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let email_number_error = document.querySelectorAll(".error");
        let has_email_error = "<?php print($has_email_error) ?>";
        let has_number_error = "<?php print($has_number_error) ?>";
        console.log(has_email_error)
        console.log(has_number_error)
        // console.log(typeof(has_error))
        if (has_email_error == "1") {
            email_number_error[1].style.display = "block"
            email_number_error[1].textContent = "E-mail Already Exists !";
        } else {
            email_number_error[1].style.display = "none"
        }


        if (has_number_error == "1") {
            email_number_error[2].style.display = "block"
            email_number_error[2].textContent = "Phone Number Already Exists !";
        } else {
            email_number_error[2].style.display = "none"
        }
    </script>
    <script src="../../JS/signup/signup.js">


    </script>
</body>

</html>