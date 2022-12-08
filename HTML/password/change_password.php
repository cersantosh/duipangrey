<?php

session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
// if someone directly enter this url
if (!isset($_SESSION['forgot_password_email'])) {
    header("location:http://localhost/project/html/login/login.php");
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="../CSS/signup_verification.css"> -->
    <link rel="stylesheet" href="../../CSS/password/change_password.css?v=<?php echo time(); ?>">

</head>

<body>
    <?php
    include "../connection.php";

    $email = $_SESSION['forgot_password_email'];
    $sql = "select * from signup where email = '$email'";
    $result = mysqli_query($con, $sql) or die("Query Failed !");
    $rows = mysqli_fetch_assoc($result);
    $database_token = $rows['token'];
    // print($database_token."<br>");
    // to remove $token error
    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        // print($token);
        // show this page only when both tokes are equal
        if ($token == $database_token) {
            $_SESSION['password_changed_page'] = "true";

    ?>

            <div class="container">
                <form action="password_changed.php" method="POST">
                    <div class="new_password_details">
                        <div>
                            <input type="password" placeholder="Enter New Password" required class="new_password" name="new_password">
                        </div>
                        <p class="show_hide">SHOW</p>
                        <i class="fa-solid fa-circle-check correct correct_first_password"></i>
                        <i class="fa-solid fa-square-xmark incorrect incorrect_first_password"></i>
                    </div>
                    <code class="error">Password is Different</code>

                    <div class="confirm_password_details">
                        <div>
                            <input type="password" placeholder="Confirm Password" required class="confirm_password" name="confirm_password">
                        </div>
                        <p class="show_hide">SHOW</p>
                    </div>
                    <code class="error">Password is Different</code>
                    <input type="submit" name="submit" class="submit">
                </form>
            </div>


            <script src="../../JS/password/change_password.js">

            </script>

    <?php

        } else {
            print("<h2> File Not Found </h2>");
        }
    } else {
        print("<h2> File Not Found </h2>");
    }


    ?>
</body>

</html>