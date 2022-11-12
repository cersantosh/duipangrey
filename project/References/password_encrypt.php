<!-- algorithm used is blowfish
it is secure, free and slow -->

<?php

    $original_password = "good";
    $encrypted_password = password_hash($original_password, PASSWORD_BCRYPT);

    print($original_password."<br>");
    print($encrypted_password."<br>");
    print(strlen($encrypted_password));

    if(password_verify($original_password, $encrypted_password)){
        print("Password matched");
    }
    else{
        print("Password is not matched");
    }

?>