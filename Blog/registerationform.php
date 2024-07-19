<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $address = $_POST['addres'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];

        $servername = "localhost";
        $username = "root";
        $dbPassword = "";
        $dbname = "blog";

        $conn = new mysqli($servername, $username, $dbPassword, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $checkEmailQuery = "SELECT email FROM users WHERE email = ?";
        $checkStmt = $conn->prepare($checkEmailQuery);
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            echo '<script>alert("Email already registered.");</script>';
        } else {

            $errorMessages = [];

            if (preg_match('/\d/', $firstName) || preg_match('/\d/', $lastName)) {
                $errorMessages[] = "First Name and Last Name should not contain numbers.";
            }

            if (strlen($firstName) > 15 || strlen($lastName) > 15) {
                $errorMessages[] = "First Name and Last Name should not exceed 10 characters.";
            }

            if (!preg_match('/\d/', $password) || !preg_match('/[a-zA-Z]/', $password) || strlen($password) < 8) {
                $errorMessages[] = "Password must contain at least 8 characters and include both characters and numbers.";
            }

            if ($password !== $_POST['confirm_password']) {
                $errorMessages[] = "Passwords do not match.";
            }

            if (count($errorMessages) > 0) {
                echo '<script>';
                foreach ($errorMessages as $errorMessage) {
                    echo 'alert("' . $errorMessage . '");';
                }
                echo '</script>';
            } else {
                $sql = "INSERT INTO users (first_name, last_name, email, address, password, gender)
                        VALUES (?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $firstName, $lastName, $email, $address, $password, $gender);

                if ($stmt->execute()) {
                    echo '<script>alert("Registration successful");</script>';
                    echo '<script>setTimeout(function() {
                        window.location.href = "loginform.php";
                    }, 2000);</script>';
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $stmt->close();
            }
        }

        $checkStmt->close();

        $conn->close();
    }
    
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registeration Form</title><div class=""></div>

        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background: linear-gradient(to top left, #9853a1, #2fbee1); 
            }
            
            .container {
                background-color: white; 
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                width: 50%; 
                max-width: 500px;
                margin: 0 auto; 
            }
            
            
            input[type="text"],
            input[type="password"],
            input[type="number"],
            input[type="email"],
            input[type="cpassword"],
            input[type="date"],
            select[name="course"]{
                width: 95%;
                padding: 10px;
                border: 1px solid #ccc;
                margin-bottom: 10px;
            }
            
            button {
                background-color: #3498db;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            button:hover {
                background-color: #2980b9;
            }

            img{
                width: 90px;
                padding-left: 50px;
            }

            label{
                font-size: 20px;
                font-weight: bold;
            }
            
                
        </style>
    </head>

    <body>
        <div class="container">
            <h1>Registration Form</h1>
            <hr>
            <form method="post" action="">
                <label for="first_name">First Name :</label><br>
                <input type="text" name="first_name" id="first_name" placeholder="First Name" required>
                <br>

                <label for="last_name">Last Name :</label><br> 
                <input type="text" name="last_name" id="last_name" placeholder="Last Name" required>
                <br>

                <label for="email">Email :</label><br> 
                <input type="email" name="email" id="email" placeholder="Email" required>
                <br>

                <label for="addres">Addres :</label><br> 
                <input type="text" name="addres" id="addres" placeholder="Addres" required>
                <br>

                <label for="password">Password :</label><br> 
                <input type="password" name="password" id="password" placeholder="Password" required> 
                <br>

                <label for="cpassword">Confirm Password :</label><br> 
                <input type="password" name="confirm_password" id="cpassword" placeholder="Confirm Password" required>
                <br>

                <label>Gender :</label><br> <br>
                <label for="male"><input type="radio" id="male" name="gender" value="male"> Male</label>
                <label for="female"><input type="radio" id="female" name="gender" value="female"> Female</label>
                <br><br>

                <button type="submit">Submit</button>
            </form>
        </div>

    </body>
</html>

