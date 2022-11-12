<?php

session_start();
// to see all session variable set
// print("<pre>");
// print_r($_SESSION);
// print("</pre>");

// here if session is set then it remains until we logout
unset($_SESSION['email_number_error']);
unset($_SESSION['email_error']);
unset($_SESSION['number_error']);
unset($_SESSION['signup_complete']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_successful']);
unset($_SESSION['signup_access']);
unset($_SESSION['password_changed_page']);
include "../connection.php";

if (isset($_POST['submit'])) {
    //storing all data into session variable
    $_SESSION['profile_picture_name'] = $_FILES['profile_picture']['name'];
    $profile_picture_name = $_FILES['profile_picture']['name'];
    $file_tmp_name = $_FILES['profile_picture']['tmp_name'];
    $_SESSION['profile_tmp_name'] = $_FILES['profile_picture']['tmp_name'];
    $_SESSION['full_name'] = $_POST["full_name"];
    $email = $_POST["email"];
    $_SESSION['signup_email'] = $email;
    $phone_number = $_POST['phone_number'];
    $_SESSION['phone_number'] = $phone_number;
    $_SESSION['password'] = $_POST['password'];

    // uploding image because we have to show it if email is already exist
    $destination = "../../uploaded_images/profile_picture/$profile_picture_name";
    if (file_exists($destination)) {
        $profile_picture_name = time() . $profile_picture_name;
        $destination = "../../uploaded_images/profile_picture/$profile_picture_name";
    }
    move_uploaded_file($file_tmp_name, $destination);

    // fetching email from database
    $sql_email = "select * from signup where email = '$email'";
    $result_email = mysqli_query($con, $sql_email) or die("Query failed !");
    $no_of_email = mysqli_num_rows($result_email);
    // print($no_of_email."email");
    // die();
    // fetching phone_number from database
    $sql_phone_number = "select * from signup where phone_number = '$phone_number'";
    $result_phone_number = mysqli_query($con, $sql_phone_number) or die("Query failed !");
    $no_of_phone_number = mysqli_num_rows($result_phone_number);
    // print($no_of_phone_number."number");
    // die();

    // if both email and phone_number are exist in database
    if ($no_of_email == 1 && $no_of_phone_number == 1) {
        // print("both"."<br>");
        $_SESSION['email_number_error'] = "true";
        $_SESSION['signup_complete'] = "partial true";
        $_SESSION['signup_access'] = "true";
        header("location:http://localhost/project/html/signup/signup_error.php");
    } elseif ($no_of_email == 1) {
        // print("email error"."<br>");

        $_SESSION['email_error'] = "true";
        $_SESSION['signup_complete'] = "partial true";
        $_SESSION['signup_access'] = "true";

        header("location:http://localhost/project/html/signup/signup_error.php");
    } elseif ($no_of_phone_number == 1) {
        // print("number error"."<br>");
        $_SESSION['signup_access'] = "true";

        $_SESSION['number_error'] = "true";
        $_SESSION['signup_complete'] = "partial true";

        header("location:http://localhost/project/html/signup/signup_error.php");
    } else {
        $_SESSION['signup_complete'] = "under verification";
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

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->


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
                                <input type="file" class="image" required accept="image/*" name="profile_picture">
                                <img src="" alt="" class="show_image">
                            </div>
                        </div>
                        <code class="error">Images Size Must Be less than 1MB</code>

                        <div class="full_name_details">
                            <span for="">*</span><input type="text" placeholder="Enter Full Name" required name="full_name" onkeyup="show_placeholder('label_full_name', this)">
                            <label for="" class="label_full_name">Enter Full Name</label>

                        </div>

                        <div class="email_details">
                            <div>
                                <span for="">*</span> <input type="email" placeholder="Enter email" required class="email" name="email" onkeyup="show_placeholder('label_email', this)">
                                <label for="" class="label_email">Enter E-mail</label>

                            </div>
                            <i class="fa-solid fa-circle-check correct correct_email"></i>
                            <i class="fa-solid fa-square-xmark incorrect incorrect_email"></i>


                        </div>
                        <code class="error">Invalid E-mail Address</code>

                        <div class="phone_number_details">
                            <div>
                                <span for="">*</span> <input type="text" placeholder="Enter phone number" required class="phone_number" name="phone_number" maxlength="10" onkeyup="show_placeholder('label_phone_number', this)" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <label for="" class="label_phone_number">Enter Phone Number</label>

                            </div>
                            <i class="fa-solid fa-circle-check correct correct_phone_number"></i>
                            <i class="fa-solid fa-square-xmark incorrect incorrect_phone_number"></i>


                        </div>
                        <code class="error">Invalid Phone Number</code>

                        <div class="password_details">
                            <div>
                                <span for="">*</span><input type="password" placeholder="Enter Password" required name="password" onkeyup="show_placeholder('label_password', this)">
                                <label for="" class="label_password">Enter Password</label>

                            </div>
                            <p class="show_hide">SHOW</p>
                            <i class="fa-solid fa-circle-check correct correct_first_password"></i>
                            <i class="fa-solid fa-square-xmark incorrect incorrect_first_password"></i>
                        </div>
                        <code class="error">Password is Different</code>

                        <div class="confirm_password_details">
                            <div>
                                <span for="">*</span><input type="password" placeholder="Confirm Password" required class="confirm_password" onkeyup="show_placeholder('label_confirm_password', this)">
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
                            <p class="login">Already SignUp ? <a href="../login/login.php">Login Here</a></p>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="../../JS/signup/signup.js">


    </script>
</body>

</html>