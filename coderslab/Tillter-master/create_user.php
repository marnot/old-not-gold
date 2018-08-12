<?php
session_start();

require 'src/Users.php';
require './connection.php';

if (isset($_SESSION['userId'])) {
    header("Location: index.php");
}

if (isset($_POST['username']) && isset($_POST['mail']) && isset($_POST['pass'])) {
    if (!empty($_POST['username']) && !empty($_POST['mail']) && !empty($_POST['pass'])) {

        $user = new User();

        $user->setUsername(trim($_POST['username']));
        $user->setEmail(trim($_POST['mail']));
        $user->setPass(trim($_POST['pass']));

        $user->saveToDb($conn);

        if ($user->getId() != -1) {
            header("location: index.php");
        } else {
            echo 'User with that Email already exist';
        }
    } else {
        echo 'Fill empty fields';
    }
}
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Register</title>
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
                        <legend>Register</legend>
                        <div class="form-group">
                            <label for="">Username:</label>
                            <input type="use" class="form-control" name="username" id="username">
                        </div>
                        <div class="form-group">
                            <label for="">Email:</label>
                            <input type="use" class="form-control" name="mail" id="mail">
                        </div>
                        <div class="form-group">
                            <label for="">Password:</label>
                            <input type="password" class="form-control" name="pass" id="pass">
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                        <a href="index.php">Back</a>
                    </form>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                </div>
            </div>
        </div>
    </body>
</html>