
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php
    // first fetch data from database and insert it into input element using value attribute
        $id = $_GET['id'];
        include "connection.php";
        $sql = "select * from mobile_details where id = {$id}";
        $result = mysqli_query($con, $sql);
        $rows = mysqli_fetch_assoc($result);
        
        $mobile_name = $rows['Mobile_name'];
        $price = $rows['Price'];
        $ram = $rows['RAM'];
        $internal_storage = $rows['Internal_storage'];
        $is_5g_supported = $rows['5G_supported'];

    ?>

    <div class="container">
    <form action="update.php?idd=<?php echo $id ?>" method="post">
        <div class="first_name">
        <label for="">Mobile Name :</label> <input type="text" required name="mobile_name" value="<?php echo $mobile_name?>">
        </div>

        <div class="last_name">
        <label for="">Price : </label><input type="number" requred name="price" value="<?php echo $price?>">

        </div>

        <div class="username">
        <label for="">RAM : </label><input type="text" required name="ram" value="<?php echo $ram?>"> 

        </div>

        <div class="password">
        <label for="">Internal Storage :</label> <input type="text" required name="internal_storage" value="<?php echo $internal_storage?>">

        </div>

        <div class="list">
            <label for="">IS 5G Supported</label>
            <select id="" name="is_5g">
                <?php 
                    if($is_5g_supported == "yes"){
                        
                        echo "<option value='yes' selected>Yes</option>";
                        echo "<option value='no'>NO</option>";
                    }
                    else{
                        echo "<option value='yes'>Yes</option>";
                        echo "<option value='no' selected>NO</option>";
                    }
                ?>

            </select>
        </div>

        <div class="buttons">
        <input type="submit" value = "UPDATE">
        <button><a href="show_products.php">Show Products</a></button>
        </div>
    </form>  
    </div>  

    <?php 

        
       
    ?>
    
</body>
</html>



