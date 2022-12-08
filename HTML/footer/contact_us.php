<?php
session_start();
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);

// print_r($_SESSION);





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

<?php
if (isset($_POST['submit'])) {

    include "../connection.php";
    if (!isset($_SESSION['login_successful'])) {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $_SESSION['contact_email'] = $email;
    } else {
        $name = $_SESSION['full_name'];
        $email = $_SESSION['login_email'];
        $_SESSION['contact_email'] = $email;
    }
    $message = $_POST['message'];

    $sql = "insert into contact_us(name, email, message, respond) values('$name', '$email', '$message', 'false')";
    mysqli_query($con, $sql) or die("Query Failed !");
    print("<p class='message_contact'>Thank you for contacting us. We will respond you soon.</p>");

    die();
}

?>


<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

            <?php
            if (!isset($_SESSION['login_successful'])) {

            ?>

                <div class="name_details">
                    <input type="text" placeholder="Enter Your Name" required name="name" class="name" onkeyup="show_placeholder('label_name', this)">
                    <label for="" class="label_name">Enter Name</label>

                </div>

                <div class="email_details">
                    <input type="email" placeholder="Enter email" required name="email" class="email" onkeyup="show_placeholder('label_email', this)">
                    <label for="" class="label_email">Enter E-mail</label>

                </div>

            <?php } ?>

            <div class="message">
                <textarea name="message" id="" cols="" rows="" placeholder="Enter Your Message" required onkeyup="show_placeholder('label_message', this)"></textarea>
                <label for="" class="label_message">Enter Message</label>

            </div>



            <div class="submit">
                <input type="submit" value="Submit" name="submit" class="submit">
            </div>
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