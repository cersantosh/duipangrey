
<!-- cookies store information on client side
session store information on server -->

<!-- always declare session on top of the page -->

<?php

    session_start();
    $_SESSION["name"] = "Shyam";
    $_SESSION["address"] = "Kathmandu";

    print_r($_SESSION);
    print($_SESSION['name']);
    print($_SESSION['address']);


?>
