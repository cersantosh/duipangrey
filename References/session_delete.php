
<?php

    session_start();
    // we can't directly destroy session so use this
    session_unset(); // delete all the variables set (session id)
    session_destroy(); // delete session

?>