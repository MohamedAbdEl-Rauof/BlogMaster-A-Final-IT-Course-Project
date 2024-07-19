<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $servername = "localhost";
        $username = "root";
        $dbPassword = "";
        $dbname = "blog";

        $conn = new mysqli($servername, $username, $dbPassword, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $checkEmailQuery = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmtCheckEmail = $conn->prepare($checkEmailQuery);
        $stmtCheckEmail->bind_param("s", $email);
        $stmtCheckEmail->execute();
        $stmtCheckEmail->bind_result($emailCount);
        $stmtCheckEmail->fetch();
        $stmtCheckEmail->close();

        if ($emailCount > 0) {

            $checkPasswordQuery = "SELECT * FROM users WHERE email = ? AND password = ?";
            $stmtCheckPassword = $conn->prepare($checkPasswordQuery);
            $stmtCheckPassword->bind_param("ss", $email, $password);
            $stmtCheckPassword->execute();
            $stmtCheckPassword->store_result();
            $rowCount = $stmtCheckPassword->num_rows;
            $stmtCheckPassword->close();

            if ($rowCount > 0) {

                session_start();
                $_SESSION['email'] = $email;
                header("Location: home.php");
                exit();
            } else {
                echo "<script>alert('The password you entered is incorrect.');</script>";
            }
        } else {
            echo "<script>alert('The email address you entered isn\'t connected to an account.');</script>";
        }

        $conn->close();
    }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Form</title>
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
                background-color: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                width: 450px;
                text-align: center;
            }
            
            .container h1 {
                margin-bottom: 20px;
                color: #333;
                font-size: 50px;
            }
            
            .container form {
                text-align: left;
            }
            
            .container label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
                color: #555;
                font-size: 25px;

            }
            
            .container input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 20px;
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
            }

            button:hover {
                background-color: #2980b9;
            }
            
            .options {
                margin-top: 15px;
                font-size: 14px;
                color: #555;
            }
            
            .options a {
                text-decoration: none;
                color: #007bff;
            }
            
            .options a:hover {
                text-decoration: underline;
            }

        </style>
        
    </head>

    <body>
        <div class="container">
            <h1>Login</h1>
            <form action="loginform.php" method="post">
                <label for="email">Email : </label><br>
                <input type="email" id="email" name="email" required><br>
                
                <label for="password">Password : </label><br>
                <input type="password" id="password" name="password" required><br>
                
                <button type="submit">Login</button>
            </form>

            <div class="options">
                <a href="forgetpassword.php">Forgot Password?</a> | <a href="registerationform.php">Create Account</a>
            </div>
        </div>
    </body>

</html>
