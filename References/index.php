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

    <div class="container">
    <form action="addproducts.php" method="post">
        <div class="first_name">
        <label for="">Mobile Name :</label> <input type="text" required name="mobile_name">
        </div>

        <div class="last_name">
        <label for="">Price : </label><input type="number" requred name="price">

        </div>

        <div class="username">
        <label for="">RAM : </label><input type="text" required name="ram"> 

        </div>

        <div class="password">
        <label for="">Internal Storage :</label> <input type="text" required name="internal_storage">

        </div>

        <div class="list">
            <label for="">IS 5G Supported</label>
            <select id="" name="is_5g">
                    <option value="yes" selected>Yes</option>
                    <option value="no" >NO</option>

            </select>
        </div>

        <div class="buttons">
        <input type="submit" value = "ADD">
        <button><a href="show_products.php">Show Products</a></button>
        </div>
    </form>  
    </div>  

    
</body>
</html>

