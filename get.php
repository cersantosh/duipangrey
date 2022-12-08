
<?php
session_start();

if(isset($_GET['get'])){
    print("success");
}
else{
    print("failure");
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
<a href="bridge.php">click here</a>
</body>
</html>