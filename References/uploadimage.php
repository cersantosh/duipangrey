<!-- use enctype if you want upload a image -->


<?php
    if(isset($_FILES['image'])){
        print("<pre>");
        // it will display all the information about images as an array
        // pre tag is used for formatting
        print_r($_FILES);
        print("</pre>");
    }

    // it return array so array indexing is used to access data
    $file_name = $_FILES['image']["name"];
    $file_type = $_FILES['image']["type"];
    $file_tmp_name = $_FILES['image']["tmp_name"];
    $file_size = $_FILES['image']["size"];

    print($file_name."<br>");
    print($file_type."<br>");
    print($file_tmp_name."<br>");
    print(($file_size/1024)."KB");

    if(move_uploaded_file($file_tmp_name, "uploaded_images/".$file_name)){
        print("Image uploaded successfully");
    }
    else{
        print("Could not Upload a image");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="image">
        <input type="submit">

    </form>
    
</body>
</html>