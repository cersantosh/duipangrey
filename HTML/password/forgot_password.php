<?php
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
$is_submitted = isset($_POST['submit']);
$has_error = false;
if (isset($_POST['submit'])) {
    session_start();
    // generating token
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ*%$@><';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $token = $randomString;
    include "../connection.php";
    $email = $_POST['email'];
    mysqli_query($con, "update signup set token = '$token' where email = '$email'") or die("Query Failed !");
    $sql = "select * from signup where email = '$email'";
    $result = mysqli_query($con, $sql) or die("Query Failed !");
    $no_of_rows = mysqli_num_rows($result);
    $rows = mysqli_fetch_assoc($result);

    // validating whether email or correct or not
    if ($no_of_rows == 1) {
        $token = $rows['token'];
        // print($token);
        $_SESSION['forgot_password_email'] = $email;
        $link = "http://localhost/project/HTML/password/change_password.php?token=$token";
        $to_email = $email;
        $subject = "Forgot Password Link :";
        $body = "Click On this link : $link";
        $headers = "From: information11993@gmail.com";

        if (mail($to_email, $subject, $body, $headers)) {
            header("location:http://localhost/project/html/password/link_sent.php");
        }
    } else {
        $has_error = true;
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="../CSS/signup_verification.css"> -->
    <link rel="stylesheet" href="../../CSS/password/forgot_password.css?v=<?php echo time(); ?>">
</head>

<body>



    <code class="error">Not a valid email address</code>
    <p class="link">Link will be sent to your email</p>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="email" placeholder="Enter your email" class="email" name="email"> <br>
            <input type="submit" class="submit" name="submit">
        </form>
    </div>

    <script>
        // for displaying error message
        let is_submitted = '<?php print($is_submitted) ?>';
        let has_error = '<?php print($has_error) ?>';
        let error = document.querySelector(".error");
        if (is_submitted && has_error) {
            error.style.display = "block";
        }
    </script>



</body>

</html>