<?php

session_start();
unset($_SESSION['signup_access']);
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_access']);
include "../connection.php";
if (!isset($_SESSION['signup_verification'])) {
    die("File Not Found !");
}
// $email = $_POST['email'];
// $sql = "select * from signup where email = '$email'";
// $result = mysqli_query($con, $sql) or die("Query Failed !");
// $no_of_rows = mysqli_num_rows($result);

// if ($no_of_rows >= 1) {
//     header("location:http://localhost/project/html/signup.php");
// }

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="../CSS/signup_verification.css"> -->
    <link rel="stylesheet" href="../../CSS/signup/signup_verification.css?v=<?php echo time(); ?>">
</head>

<body>

    <?php

    // getting email

    $email = $_SESSION['signup_email'];

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

    <p class="error">Invalid Code</p>
    <p class="verification">Verification Code is sent to the <?php print($email) ?> </p>
    <div class="container">
        <form action="account_created.php" method="POST">
            <input type="number" placeholder="Enter the 6 digit code" class="code"> <br>
            <input type="submit" class="submit">
        </form>
    </div>


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
                let a = "<?php print($_SESSION['account_created'] = 'true') ?>";
                document.querySelector(".error").style.display = "none";

            }
        }
    </script>



</body>

</html>