<?php
session_start();
if (!file_exists("uploads"))
    mkdir("uploads");
?>
<!DOCTYPE html>
<html>

<head>
    <title>File Storage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

</head>

<body>
    <div>
        <h1>Please login to access</h1>
        <form method="post" action="./controllers/login.php">
            <div>
                <label>Username:</label>
                <input type="text" name="username" placeholder="Email">
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="password" placeholder="Password">
            </div>
            <div>
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
</body>

</html>