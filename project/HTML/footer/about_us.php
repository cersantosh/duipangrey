<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: sans-serif;
        }

        .images img {
            width: 250px;
            height: 250px;
            border-radius: 50%;
        }

        .images {
            width: 40%;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            /* border: 3px solid red; */
        }

        .images div {
            display: flex;
            justify-content: center;
        }

        .logo {
            width: 50px;
            height: 50px;
        }

        figcaption {
            text-align: center;
        }

        @media only screen and (max-width: 725px) {
            .images div {
                flex-direction: column;
            }

            .images img {
                margin-bottom: 20px;
            }
        }
    </style>

</head>

<body>

    <img src="../../Images/logo.png" alt="" class="logo">
    <p>Duipangrey is a website where you can list your second hand bikes and scooters for sale.</p>
    <h3>Our Members</h3>
    <div class="images">
        <figure>
            <img src="../../Images/santosh1.jpg" alt="" class="santosh">
            <figcaption>Santosh Poudel</figcaption>
        </figure>
        <div>
            <figure>
                <img src="../../Images/prajwol.jpg" alt="">
                <figcaption>Prajwol Poudel</figcaption>

            </figure>
            <figure>

                <img src="../../Images/reewaj.jpg" alt="">
                <figcaption>Reewaj Gurung</figcaption>
            </figure>
        </div>
    </div>

</body>

</html>