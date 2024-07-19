<?php

    session_start();

    if (!isset($_SESSION['email'])) {
        header('Location: login.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $conn = mysqli_connect("localhost", "root", "", "blog");

        if ($conn === false) {
            die("Error: Could not connect to database.");
        }

        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $body = $_POST['body'];
            $category = $_POST['category'];
        
            $userEmail = $_SESSION['email']; 

            $sql = "SELECT uid FROM users WHERE email = '$userEmail'";
            $result = mysqli_query($conn, $sql);
    
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $uid = $row['uid'];
    
                $sql = "INSERT INTO posts (uid, title, body, category) VALUES ('$uid', '$title', '$body', '$category')";
    
                $result = mysqli_query($conn, $sql);
    
                if ($result === false) {
                    die("Error: Could not insert data into database.");
                }
            } else {
                echo "User ID not found.";
            }
    
            mysqli_close($conn);    
        }
        
        
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>The Daily Blog</title>
        <style>
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #eee;
            }
            
            header {
                background-color: #3498dbb7;
                color: white;
                text-align: center;
                padding: 10px 0;
                height: 70px;
            }
            
            .header-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-top: 15px;
            }
            
            .blog-name h1 {
                margin: 0;
                padding-left: 50px;
                padding-bottom: 20px;
            }
            
            .user-infoo {
                text-align: right;
                padding-right: 20px;
            }
            
            .user-infoo a {
                color: white;
                text-decoration: none;
            }
            
            .circle-button {
                display: inline-block;
                padding: 8px 15px;
                border-radius: 50%;
                border: 1px solid white;
                margin: 0 5px;
            }
                        
            .Publish {
                display: flex;
                align-items: center;
                background-color: #f5f5f5;
                padding: 10px;
                border-radius: 5px;
                margin-top: 40px;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                padding-bottom: 50px;
                padding-top: 50px;
            }
            
            .Publish textarea[type="text"],
            .Publish input[type="text"] {
                flex: 1;
                padding: 8px; 
                font-size: 16px;
                border: none;
                border-radius: 5px;
                outline: none;
                height: 28px; 
                margin-right: 50px; 
                margin-left: 100px; 
                font-size: 20px;
            
            }
            
            .Publish button {
                background-color: #3498db;
                color: white;
                border: none;
                border-radius: 5px;
                padding: 8px 15px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                margin-right: 30px;     
                font-size: 20px;
            }
            
            .Publish button:hover {
                background-color: #2980b9;
            }

            :focus {
                outline: 0;
                border-color: #2260ff;
                box-shadow: 0 0 0 4px #b5c9fc;
            
            }

            .mydict div {
                display: flex;
                flex-wrap: wrap;
                margin-top: 0.5rem;
                justify-content: center;
                margin-right: 30px; 

            }

            .mydict input[type="radio"] {
                clip: rect(0 0 0 0);
                clip-path: inset(100%);
                height: 1px;
                overflow: hidden;
                position: absolute;
                white-space: nowrap;
                width: 1px;
            }

            .mydict input[type="radio"]:checked + span {
                box-shadow: 0 0 0 0.0625em #0043ed;
                background-color: #dee7ff;
                z-index: 1;
                color: #0043ed;
            }

            label span {
                display: block;
                cursor: pointer;
                background-color: #fff;
                padding: 0.375em .75em;
                position: relative;
                margin-left: .0625em;
                box-shadow: 0 0 0 0.0625em #b5bfd9;
                letter-spacing: .05em;
                color: #3e4963;
                text-align: center;
                transition: background-color .5s ease;
            }

            label:first-child span {
                border-radius: .375em 0 0 .375em;
            }

            label:last-child span {
                border-radius: 0 .375em .375em 0;
            }

            .circle-button {
                width: 40px;
                height: 40px;
                background-color: #3498db;
                color: white;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 18px;
                margin-right: 10px;
                text-decoration: none;
            }

        </style>

    </head>


    <body>
        <form method="post" action="">
            <header>

                <div class="header-content">

                    <div class="blog-name">
                        <h1>The Daily Blog</h1>
                    </div>

                    <div class="user-infoo" id="user-infoo">

                        <?php

                            $userEmail = $_SESSION['email'];

                            $conn = mysqli_connect("localhost", "root", "", "blog");

                            if ($conn === false) {
                                die("Error: Could not connect to the database.");
                            }

                            $sql = "SELECT first_name FROM users WHERE email = '$userEmail'";
                            $result = mysqli_query($conn, $sql);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $userInitial = strtoupper(substr($row['first_name'], 0, 1));
                                echo '<a href="#" class="circle-button">' . $userInitial . '</a>';
                            }

                            mysqli_close($conn);

                        ?>
                    </div>

                </div>

            </header>


            <div class="Publish">

                <input type="text" name="title" placeholder="Title">
                <textarea type="text" name="body" placeholder="What's on your mind?"></textarea>

                <div class="mydict">
                    <div>
                        <label>
                            <input type="radio" name="radio" value="sport" checked>
                            <span>Sports</span>
                        </label>
                        <label>
                            <input type="radio" name="radio" value="education">
                            <span>Education</span>
                        </label>
                        <label>
                            <input type="radio" name="radio" value="Literature">
                            <span>Literature</span>
                        </label>
                        <label>
                            <input type="radio" name="radio" value="Literature">
                            <span>Religious</span>
                        </label>
                    
                    </div>
                </div>
                <button type="submit">Post</button> 
            </div>
        </form>

    </body>
</html>




<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $conn = mysqli_connect("localhost", "root", "", "blog");

        if ($conn === false) {
            die("Error: Could not connect to database.");
        }

        if (isset($_POST['title']) && isset($_POST['body']) && isset($_POST['radio'])) {
            $title = $_POST['title'];
            $body = $_POST['body'];
            $category = $_POST['radio'];

            $userEmail = $_SESSION['email'];

            $uidQuery = "SELECT uid FROM users WHERE email = ?";
            $stmtUid = $conn->prepare($uidQuery);
            $stmtUid->bind_param("s", $userEmail);
            $stmtUid->execute();
            $stmtUid->bind_result($uid);
            $stmtUid->fetch();
            $stmtUid->close();

            $sql = "INSERT INTO posts (uid, title, body, category) VALUES ('$uid', '$title', '$body', '$category')";

            $result = mysqli_query($conn, $sql);

            if ($result === false) {
                die("Error: Could not insert data into database.");
            }

            mysqli_close($conn);
        }
    }
?>
  


<?php

    $conn = mysqli_connect("localhost", "root", "", "blog");

    if ($conn === false) {
        die("Error: Could not connect to database.");
    }
    $sql = "SELECT p.*, u.first_name, u.last_name FROM posts p
            INNER JOIN users u ON p.uid = u.uid
            ORDER BY p.created_at DESC";    
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        die("Error: Could not get post data from database.");
    }

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>>The Daily Blog</title>
        <style>
            body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            }

            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }

            .post {
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
                overflow: hidden;
                transition: transform 0.2s ease-in-out;
                padding-top: 50px;
                align-items: flex-start;
                 width: 65%;
                margin: 0 auto;
                 height: auto; 
            }

            .post:hover {
                transform: translateY(-5px);
            }

            .user-info {
                background-color: #3498db;
                color: white;
                padding: 10px;
                display: flex;
                align-items: center;
                align-items: flex-start;
                font-weight: bold;
            }

            .user-initial {
                width: 40px;
                height: 40px;
                background-color: white;
                color: #3498db;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 18px;
                margin-right: 10px;
                border: 2px solid #3498db;
            }

            .post-info {
                padding: 20px;
                background-color: #f9f9f9;
            }

            .content {
                font-size: 16px;
                line-height: 1.6;
                margin-bottom: 15px;
                margin-left: 120px;
            }

            .category {
                background-color: #3498db;
                color: white;
                padding: 5px 10px;
                border-radius: 5px;
                font-size: 14px;
                text-transform: uppercase;
                display: inline-block;
            }

            .comment-section {
                padding: 20px;
                border-top: 1px solid #ccc;
            }

            .comment {
                background-color: #f9f9f9;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                padding: 15px;
                margin-bottom: 15px;
            }

            .comment p {
                font-size: 14px;
                line-height: 1.4;
                margin-bottom: 5px;
            }

            .comment-date {
                font-size: 12px;
                color: #777;
            }

            .post-info h2 {
                font-size: 24px;
                color: #333;
            }

            .comment-textarea {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                resize: vertical;
            }

            .comment-submit {
                background-color: #3498db;
                color: white;
                border: none;
                border-radius: 5px;
                padding: 10px 20px;
                cursor: pointer;
                transition: background-color 0.2s ease-in-out;
            }

            .comment-submit:hover {
                background-color: #2980b9;
            }


        </style>
    </head>

    <body>

        <header>
            <h1>POSTS</h1>
        </header>

        <?php
            $conn = mysqli_connect("localhost", "root", "", "blog");

            if ($conn === false) {
                die("Error: Could not connect to the database.");
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['comment']) && isset($_POST['pid'])) {
                    $pid = $_POST['pid'];
                    $comment = $_POST['comment'];
                    $userEmail = $_SESSION['email'];

                    $uidQuery = "SELECT uid FROM users WHERE email = ?";
                    $stmtUid = $conn->prepare($uidQuery);
                    $stmtUid->bind_param("s", $userEmail);
                    $stmtUid->execute();
                    $stmtUid->bind_result($uid);
                    $stmtUid->fetch();
                    $stmtUid->close();

                    $insertCommentQuery = "INSERT INTO comments (uid, pid, body, created_at) VALUES (?, ?, ?, NOW())";
                    $stmtInsertComment = $conn->prepare($insertCommentQuery);
                    $stmtInsertComment->bind_param("iis", $uid, $pid, $comment);
                    $stmtInsertComment->execute();
                    $stmtInsertComment->close();
                }
            }


            $sql = "SELECT p.*, u.first_name, u.last_name FROM posts p
                    INNER JOIN users u ON p.uid = u.uid
                    ORDER BY p.created_at DESC";

            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                $userInitial = strtoupper(substr($row['first_name'], 0, 1) . substr($row['last_name'], 0, 1));
                echo '<div class="post">';
                echo '<div class="user-info">';
                echo '<div class="user-initial">' . $userInitial . '</div>';
                echo '<p>' . $row['first_name'] . ' ' . $row['last_name'] . '</p>';
                echo '</div>';
                echo '<div class="post-info">';
                echo '<p>Date: ' . $row['created_at'] . '</p>';
                echo '<div class="content">';
                echo '<h2>' . $row['title'] . '</h2>';
                echo '<p>' . $row['body'] . '</p>';
                echo '<p>Category: ' . $row['category'] . '</p>';
                

                
                echo '<div class="comment">';
                echo '<form method="post" action="">';
                echo '<textarea name="comment" class="comment-textarea" placeholder="Write a comment"></textarea>';
                echo '<input type="hidden" name="pid" value="' . $row['pid'] . '">';
                echo '<button type="submit" class="comment-submit">Submit Comment</button>';
                echo '</form>';
                echo '</div>';
                
                echo '<div class="comment-section" data-post-id="' . $row['pid'] . '">';

                $commentQuery = "SELECT c.*, u.first_name, u.last_name FROM comments c
                    INNER JOIN users u ON c.uid = u.uid
                    WHERE c.pid = ?
                    ORDER BY c.created_at DESC";
                $stmtComments = $conn->prepare($commentQuery);
                $stmtComments->bind_param("i", $row['pid']);
                $stmtComments->execute();
                $commentsResult = $stmtComments->get_result();

                while ($commentRow = mysqli_fetch_assoc($commentsResult)) {
                    echo '<div class="comment">';
                    echo '<p>' . $commentRow['first_name'] . ' ' . $commentRow['last_name'] . '</p>';
                    echo '<p>' . $commentRow['created_at'] . '</p>';
                    echo '<p>' . $commentRow['body'] . '</p>';

   
                    echo '</div>';
                }

                $stmtComments->close();

                echo '</div>'; 
                echo '</div>'; 
                echo '</div>'; 
                echo '</div>'; 
            }

            mysqli_close($conn);
        ?>

    </body>
</html>


