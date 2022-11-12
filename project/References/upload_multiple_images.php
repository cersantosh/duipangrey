
<?php
    // print("hi".DIRECTORY_SEPARATOR);
    if(isset($_POST['submit'])){
        $i = $_FILES['images'];
        foreach($i['name'] as $key => $value){
            $file_name = $value;
            $file_tmp_name = $i['tmp_name'][$key];
            $file_type = $i['type'][$key];
            $file_size = $i['size'][$key];
            // print($file_name."<br>");
            // print($file_tmp_name."<br>");
            // print($file_type."<br>");
            // print($file_size."<br>");
            // print("<br> <br>");
            $destination = "uploaded_images/$file_name";
            if(file_exists($destination)){
                $destination = "uploaded_images/".time().$file_name;
            }
            move_uploaded_file($file_tmp_name, $destination);
        }
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

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="images[]" multiple>
        <input type="submit" name="submit">
    </form>
    
</body>
</html>