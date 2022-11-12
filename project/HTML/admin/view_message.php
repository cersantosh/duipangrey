<?php

session_start();
include "../connection.php";
unset($_SESSION['password_changed_page']);
unset($_SESSION['signup_verification']);
unset($_SESSION['signup_access']);

if (!isset($_SESSION['admin_email'])) {
    die("File Not Found");
}

$sql_contact = "select * from contact_us";
$result = mysqli_query($con, $sql_contact) or die("Query Failed !");

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
                        <div>User Messages</div>
                    </caption>
                    <tr>
                        <th>S.N.</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Message</th>
                        <th>Respond</th>
                        <th>Respond Status</th>
                    </tr>

                    <?php
                    while ($rows = mysqli_fetch_assoc($result)) {

                    ?>

                        <tr>
                            <td><?php print($value) ?></td>
                            <td><?php print($rows['name']) ?></td>
                            <td class="show_email"><?php print($rows['email']) ?></td>
                            <td><?php print($rows['message']) ?></td>
                            <td class="remove respond"><button><a href="respond.php?id=<?php print($rows['id']) ?>">Respond</a></button></td>
                            <td><?php print($rows['respond']) ?></td>

                        </tr>
                    <?php $value++;
                    } ?>

                </table>
            </div>
        </div>

    <?php } else {
        print("No any messages");
    } ?>



</body>

</html>