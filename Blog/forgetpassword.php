<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forgot Password</title>

        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #3498dbc3;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .container {
                background-color: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                width: 400px;
                height: 500px;

            }

            h2 {
                text-align: center;
                margin-bottom: 20px;
                font-size: 35px;

            }

            label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
                font-size: 30px;

            }

            input[type="email"],
            input[type="email"] {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                margin-bottom: 15px;
                border-radius: 5px;
                font-size: 25px;
                max-width: 93%;

            }

            button {
                background-color: #3498db;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                width: 100%;
                font-size: 20px;

            }

            button:hover {
                background-color: #2980b9;
            }
            p{
                font-size: 20px;
                font-weight: bold;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h2>Forgot Password</h2><br><br>
            <form action="forgetpassword.php" method="post">

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" placeholder="Enter your Email" required><br><br>

                <button type="submit">Submit</button><br>

            </form>

            <br>  <p>If Your Email Addres is Registered, You Will Receive Instructions To Reset Your Password.</p>

        </div>
    </body> 

</html>


<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];

        $servername = "localhost";
        $username = "root";
        $dbPassword = "";
        $dbname = "blog";

        $conn = new mysqli($servername, $username, $dbPassword, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        if ($count == 0) {

            echo "<script>alert('The email address you entered isn\'t connected to an account.');</script>";
        } else {

            echo "<script>alert('An email has been sent to you with instructions on how to reset your password.');</script>";
        }

        $stmt->close();
        $conn->close();
    }
?>

