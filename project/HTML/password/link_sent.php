<?php
session_start();
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



    <p class="link">Link has sent to <?php print($_SESSION['forgot_password_email']) ?></p>




</body>

</html>