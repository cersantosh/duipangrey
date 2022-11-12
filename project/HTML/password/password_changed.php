
<?php
    session_start();
    if(!isset($_SESSION['password_changed_page'])){
        die("File Not Found");
    }
    // updaing old password with new password
    
    $new_password = $_POST['new_password'];
    $email = $_SESSION['forgot_password_email'];
    $encrypted_password = password_hash($new_password, PASSWORD_BCRYPT);
    $sql = "update signup set password = '$encrypted_password' where email = '$email'";

    include "../connection.php";
    $result = mysqli_query($con, $sql) or die("Query Failed !");
    header("location:http://localhost/project/html/login/login.php");

    mysqli_close($con);



?>