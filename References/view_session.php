<!-- we can view session from another page also
for this you have to use session_start() method -->

<?php

    session_start();
    if(isset($_SESSION['name'])){

        print($_SESSION['name']);
    }
    else{
        print("Name is not set");
    }
    if(isset($_SESSION['address'])){

        print($_SESSION['address']);
    }
    else{
        print("Address is not set");
    }
?>