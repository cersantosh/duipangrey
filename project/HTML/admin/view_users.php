<?php

session_start();
include "../connection.php";
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);

if (!isset($_SESSION['admin_email'])) {
    die("File Not Found");
}

$sql_users = "select * from signup";
$result = mysqli_query($con, $sql_users) or die("Query Failed !");

$value = 1;

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="../CSS/view_details.css"> -->
    <link rel="stylesheet" href="../../CSS/admin/view_users.css?v=<?php echo time(); ?>">
</head>

<body>

    <?php
    if (mysqli_num_rows($result) > 0) {


    ?>
        <div class="container">

            <div class="users_information">
                <table>
                    <caption>
                        <div>User Information</div>
                    </caption>
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>E-mail</th>
                        <th>Phone Number</th>
                        <th>Remove</th>
                    </tr>

                    <?php
                    while ($rows = mysqli_fetch_assoc($result)) {

                    ?>

                        <tr>
                            <td><?php print($value) ?></td>
                            <td><?php print($rows['full_name']) ?></td>
                            <td class="show_email"><?php print($rows['email']) ?></td>
                            <td><?php print($rows['phone_number']) ?></td>
                            <td class="remove"><button><a href="remove_user.php?email=<?php print($rows['email']) ?>">Remove</a></button></td>

                        </tr>
                    <?php $value++;
                    } ?>

                </table>
            </div>
        </div>

    <?php } else {
        print("No any users.");
    } ?>



</body>

</html>