<?php
require('db.inc.php');
if(!isset($_SESSION['IS_LOGIN'])){
    header('location:login.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">
</head>

<body>
    <header>
        <img src="logo3.png" alt="logo" width="250" height="91"></h2>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </header>
</body>
</html>