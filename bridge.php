
<?php

session_start();
$profile_picture = $_SESSION['profile_picture'];
$file_tmp_name = $_SESSION['file_tmp_name'];
print($profile_picture);
print($file_tmp_name);
$destination = "../uploaded_images/profile_picture/$profile_picture";

move_uploaded_file($file_tmp_name, $destination);

?>