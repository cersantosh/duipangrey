
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <script>
        let url = location.href;
        // it gives the search value
        let parameter = location.search;
        // it is used to get search parameter and value
        let url_parameter = new URLSearchParams(parameter);
        console.log(parameter);
        //to get value
        console.log(url_parameter.get("hi"));
        // check parameter exist or not
        console.log(url_parameter.has("hii"));

    </script>


</body>
</html>