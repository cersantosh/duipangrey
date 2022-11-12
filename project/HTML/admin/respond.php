<?php

session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);

include "../connection.php";
if (!isset($_SESSION['admin_email'])) {
    die("File Not Found");
}
// print_r($_GET);
// when respond button is clicked then it will redirect to same page so there is no id key so i have used method get and input type hidden to pass id

$id = $_GET['id'];

$sql = "select * from contact_us where id = '$id'";
$result = mysqli_query($con, $sql) or die("Query Failed !");
$email = mysqli_fetch_assoc($result)['email'];

// print($email);

if (isset($_GET['submit'])) {
    $message = $_GET['message'];
    $to_email = $email;
    $subject = "Greeting From DuiPanGrey";
    $body = $message;
    $headers = "From: information11993@gmail.com";

    if (mail($to_email, $subject, $body, $headers)) {
        $sql = "update contact_us set respond = 'true' where id = '$id'";
        mysqli_query($con, $sql) or die("Query Failed !");
        // print("E-mail has sent successfully");
        header("location:view_message.php");
    } else {
        die("E-mail failed");
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
    <link rel="stylesheet" href="../../CSS/footer/contact_us.css?v=<?php echo time(); ?>">
</head>



<body>
    <div class="container">
        <form action="" method="GET">

            <div class="message">
                <textarea name="message" id="" cols="" rows="" placeholder="Enter Your Message" required onkeyup="show_placeholder('label_message', this)"></textarea>
                <label for="" class="label_message">Enter Message</label>

            </div>



            <div class="submit">
                <input type="submit" value="Respond" name="submit" class="submit">
            </div>
            <input type="hidden" value="<?php print($id) ?>" name="id">
        </form>
    </div>

    <script>
        function show_placeholder(class_name, element) {
            let label = document.querySelector(`.${class_name}`);
            label.style.display = "block";
            if (element.value == "") {
                label.style.display = "none";
            }
        }
    </script>
</body>

</html>