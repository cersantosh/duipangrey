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