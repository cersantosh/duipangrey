<!-- <?php
        include "html/connection.php";
        $sql = "insert into test(name) values('hi')";
        print(mysqli_insert_id($con));

        mysqli_query($con, $sql);

        print(mysqli_insert_id($con));


        ?> -->

<!-- <?php
        if (isset($_POST['submit'])) {
            $file = empty($_FILES['file']);
            print($file);
        }

        ?> -->

<!-- <?php
        if (isset($_POST['submit'])) {
            header("location:http://localhost/project/get.php");
        }

        ?> -->


<?php

session_start();
// $_SESSION['nice'] = "nice";
unset($_SESSION['nice']);
// print($_SESSION['nice']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        input:focus label {}

        input {
            width: 200px;
            height: 100%;
        }

        label {
            /* display: none; */
            position: absolute;
            left: 10px;
            top: -15px;
            background-color: white;
            padding: 5px;
            display: none;
        }

        div {
            height: 30px;
            /* border: 3px solid black; */
            position: relative;
        }
    </style>

</head>

<body onbeforeunload="hi()">
    <a href="get.php" name='get'>click here</a>

    <!-- <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="name">
        <input type="submit" name="submit">
    </form> -->

    <!-- <div>
    <label for="">Enter Price</label>
    <input type="text" placeholder="Enter Price" oninput="document.querySelector('label').style.display = 'block'; if(this.input=='') document.querySelector('label').style.display = 'none';">
    </div> -->
    <!-- <script>
        let input = document.querySelector("input")
        input.addEventListener("change", get)
        function get(){
            alert("nice")
        }
    </script> -->

    <script>
        function hi() {
            alert("nice");
        }
    </script>


</body>

</html>









<?php

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "select * from registration where email = '$email' and password = '$password";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Password and email does not match");
}

$rows = mysqli_fetch_assoc($result);
if ($rows['role'] == 'b') {
    header("location: business.php");
} else {
    header("location: personal.php");
}

//database connection

$con = new mysqli("localhost", "root", "", "loginsignup");
if ($con->connect_error) {
    die("faild to connect:" . $con->connect_error);
} else {
    $stmt = $con->prepare("select * from registration where email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if ($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc();

        if ($data['password'] === $password) {
            if ($data['role'] === 'b') {
                header("location: business.php");
            } else {
                header("location: personal.php");
            }
        } else {
            $alert = "<script> alert('user id or password is wrong');</script>";
            echo $alert;
            echo "<script>window.location.href='login.php?User_Id_or_Password_is_wrong';</script>";
        }
    } else {
        $alert = "<script> alert('user id or password is wrong');</script>";
        echo $alert;
        echo "<script>window.location.href='login.php?user id or password is wrong';</script>";
    }
}
?>