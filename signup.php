<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="../CSS/signup_verification.css"> -->
    <link rel="stylesheet" href="../CSS/signup_verification.css?v=<?php echo time(); ?>">
</head>

<body>

    <?php

    // getting email

    $email = $_POST['email'];

    // generating 6 digit code
    $code = "";
    for ($i = 1; $i <= 6; $i++) {
        $code = $code . rand(0, 9);
    }

    // sending email

    $to_email = $email;
    $subject = "Verification code";
    $body = "Enter this verification code : " . $code;
    $headers = "From: information11993@gmail.com";
    mail($to_email, $subject, $body, $headers);

    ?>

    <div class="container">
        <p class="error">Invalid Code</p>
        <p>Verification Code is sent to the <?php print($email) ?>
        <p>
        <form action="" method="post">
            <input type="number" placeholder="Enter the 6 digit code" class="code"> <br>
            <input type="submit" class="submit">
        </form>
    </div>

    <?php

    // function save_data_to_database()
    // {

    //     $profile_picture = $_FILES['profile_picture']['name'];
    //     $file_tmp_name = $_FILES['profile_picture']['tmp_name'];
    //     $full_name = $_POST['full_name'];
    //     $district = $_POST['district'];
    //     $city = $_POST['city'];
    //     $tole = $_POST['tole'];
    //     $password = $_POST['password'];
    //     $encrypted_password = password_hash($password, PASSWORD_BCRYPT);


    //     include "connection.php";

    //     $sql = "insert into signup(profile_picture, full_name, district, city, tole, email, password) values('$profile_picture', '$full_name', '$district', '$city', '$tole', '$email', '$encrypted_password')";

    //     $result = mysqli_query($con, $sql) or die("Query failed");

    //     move_uploaded_file($file_tmp_name, "../uploaded_images/profile_picture/" . $profile_picture);

    //     // header("location:http://localhost/project/html/login.php");

    //     mysqli_close($con);
    // }

    ?>


    <script>
        let entered_code = document.querySelector(".code")
        let actual_code = "<?php print($code) ?>";
        document.write(actual_code)
        let form = document.querySelector("form");
        form.addEventListener("submit", validate_code);

        function validate_code(event) {

            if (entered_code.value != actual_code) {
                document.querySelector(".error").style.display = "block";
                event.preventDefault();
            } else {
                document.querySelector(".error").style.display = "none";
                // let call = "<?php save_data_to_database(); ?>"

            }
        }
    </script>

    

</body>

</html>