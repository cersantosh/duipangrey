<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Details</title>
    <style>

       th, td{
            border: 3px solid red;
            padding: 10px;
            
        }
        a{
            text-decoration:none;
        }
        table{
            background-color:yellow;
            border-spacing : 10px;
        }
        body{
            display:flex;
            justify-content:center;
            align-items: center;
            height:100vh;
        }
    </style>
</head>
<body>
        <?php
        // used to import anohter php file
            include 'connection.php';
            // write sql command here
            $sql = "select * from mobile_details";
            // apply given sql to the linked database
            $result = mysqli_query($con, $sql);
            if(mysqli_num_rows($result) > 0){

            
        ?>

    <table>

        <tr>
            <th>ID</th>
            <th>Mobile Name</th>
            <th>Price</th>
            <th>RAM</th>
            <th>Internal Storage</th>
            <th>5G Supported or Not</th>
            <th colspan="2">Actions</th>

        </tr>
        <?php
        // this returns how many rows are there
        // mysqli_num_rows()
        // this function first show first details and then second and then third and so on.
            while($rows = mysqli_fetch_assoc($result)){
        ?>

        <tr>
            <!-- we can access data using following syntax -->
            <td><?php echo $rows['id'] ?></td>
            <td><?php echo $rows["Mobile_name"] ?></td>
            <td><?php echo $rows["Price"] ?></td>
            <td><?php echo $rows["RAM"] ?></td>
            <td><?php echo $rows["Internal_storage"] ?></td>
            <td><?php echo $rows["5G_supported"] ?></td>
            <td><a href="edit.php?id=<?php echo $rows['id']?>">EDIT</a></td>
            <td><a href="delete.php?idd=<?php echo $rows['id']?>">DELETE</a></td>

        </tr>
        <!-- see the above opening curly bracket so close it using php tag -->
        <?php } ?>

    </table>

    <?php }
    else{
        print("<h2> No records are on the database </h2>");
    } 
    // this is used to close the connection
    mysqli_close($con);
    ?>

</body>
</html>

