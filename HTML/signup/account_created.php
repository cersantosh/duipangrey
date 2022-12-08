
<?php

session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    die("File Not Found !");
}

print("<pre>");
print_r($_SESSION);
print("</pre>");
// generating token of length 10

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ*%$@><';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < 10; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
}

// print($randomString);

// getting session variable
$_SESSION['signup_successful'] = "true";
$_SESSION['signup_complete'] = "true";
$profile_picture = $_SESSION['profile_picture_name'];
$full_name = $_SESSION['full_name'];
$email = $_SESSION['signup_email'];
$phone_number = $_SESSION['phone_number'];
$token = $randomString;
$encrypted_password = password_hash($_SESSION['password'], PASSWORD_BCRYPT);
$destination = "../uploaded_images/profile_picture/$profile_picture";

include "../connection.php";
// inserting data to database

$sql = "insert into signup(profile_picture, full_name, email, password, phone_number, token) values('$profile_picture', '$full_name', '$email', '$encrypted_password', '$phone_number', '$token')";

$result = mysqli_query($con, $sql) or die("Query failed");


header("location:http://localhost/project/html/login/login.php");

mysqli_close($con);

?>