<?php
session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
$is_submitted = isset($_POST['submit']);
$has_error = false;
include "../connection.php";


// to insert admin password
// $admin_password = "Jnjfd*&96554)";
// $admin_password = password_hash($admin_password, PASSWORD_BCRYPT);
// mysqli_query($con, "insert into admin(email, password) values('information11993@gmail.com', '$admin_password')");

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "select * from signup where email = '$email'";
    $result = mysqli_query($con, $sql);
    $no_of_rows = mysqli_num_rows($result);
    $rows = mysqli_fetch_assoc($result);

    // validating admin
    $sql_admin = "select * from admin where email = '$email'";
    $result_admin = mysqli_query($con, $sql_admin);
    $no_of_rows_admin = mysqli_num_rows($result_admin);
    $rows_admin = mysqli_fetch_assoc($result_admin);

    $decrypted_password = "";

    if ($no_of_rows_admin == 1) {
        $db_password = $rows_admin['password'];
        $decrypted_password = password_verify($password, $db_password);
        // validating password
        if ($decrypted_password == $password) {

            $_SESSION['admin_email'] = $email;
            header("location:../admin/admin.php");
        } else {
            $has_error = true;
        }
    } else {
        $has_error = true;
    }


    // validating email
    if ($no_of_rows == 1) {
        $db_password = $rows['password'];
        $decrypted_password = password_verify($password, $db_password);
        // validating password
        if ($decrypted_password == $password) {

            $_SESSION['login_email'] = $email;
            $_SESSION['full_name'] = $rows['full_name'];
            $_SESSION['login_successful'] = "true";
            header("location:http://localhost/project/HTML/main");
        } else {
            $has_error = true;
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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <!-- <link rel="stylesheet" href="../CSS/login.css"> -->
    <link rel="stylesheet" href="../../CSS/login/login.css?v=<?php echo time(); ?>">
</head>

<body>

    <h3 class="error"> E-mail and Password doesn't match</h3>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h3 class="login_text">Login</h3>

            <div class="email_details">
                <input type="email" placeholder="Enter email" required name="email" class="email" onkeyup="show_placeholder('label_email', this)">
                <label for="" class="label_email">Enter E-mail</label>

            </div>

            <div class="password_details">
                <input type="password" placeholder="Enter Password" required class="password" name="password" class="show_hide" onkeyup="show_placeholder('label_password', this)">
                <p class="show_hide">SHOW</p>
                <i class="fa-solid fa-circle-check correct correct_first_password"></i>
                <i class="fa-solid fa-square-xmark incorrect incorrect_first_password"></i>
                <label for="" class="label_password">Enter Password</label>

            </div>

            <div class="submit">
                <input type="submit" value="Login" name="submit" class="login">
            </div>
            <div class="forgot-password">
                <p class="f-password-text"><a href="../password/forgot_password.php">Forgot Password ?</a></p>
            </div>
            <p class="signup">Don't have an Account ? <a href="../signup/signup.php">SignUp Here</a></p>
        </form>
    </div>



    <script>
        // for displaying error message
        let is_submitted = '<?php print($is_submitted); ?>';
        let has_error = '<?php print($has_error) ?>';
        let error = document.querySelector(".error");
        let email = "<?php print($email) ?>";
        let password = "<?php print($password) ?>";
        let decrypted_password = "<?php print($decrypted_password) ?>";
        let no_of_rows = "<?php print($no_of_rows) ?>";


        if (is_submitted && has_error) {

            if (no_of_rows != "1" && password != decrypted_password) {
                error.style.display = "block";
            } else if (password != decrypted_password) {
                error.style.display = "block";
                error.textContent = "Password is incorrect";
            } else {
                error.style.display = "none";
            }
        }
    </script>

    <script src="../../JS/login/login.js">

    </script>

</body>

</html>