<?php
session_start();

require 'src/Users.php';
require './connection.php';

if (isset($_SESSION['userId'])) {
    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $user = User::loadUserByEmail($conn, $_POST['mail']);
    
    if ($user != null && password_verify($_POST['pass'], $user->getHashPass())) {
        
        $_SESSION['userId'] = $user->getId();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['userName'] = $user->getUsername();

        header("Location: index.php");
    } else {
        echo "Wrong Email or Password";
    }
}
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login Page</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <form action="" method="post" role="form">
                        <legend>Login</legend>
                        <div class="form-group">
                            <label for="">Email:</label>
                            <input type="use" class="form-control" name="mail" id="mail">
                        </div>
                        <div class="form-group">
                            <label for="">Password:</label>
                            <input type="password" class="form-control" name="pass" id="pass">
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <a href="create_user.php">Register</a>
                </div>
            </div>
        </div>
    </body>
</html>
