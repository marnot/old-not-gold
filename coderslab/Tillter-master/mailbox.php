<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("location: index.php");
} else {

    require './connection.php';
    require './src/Users.php';
    require './src/Message.php';

    $sendMsg = Message::loadMessagesBySendId($conn, $sendId);
    $recivedMsg = Message::loadMessagesByReciveId($conn, $reciveId);
    ?>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Mailbox</title>
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    </div>
                    <?php
                    foreach ($sendMsg as $message) {
                        echo $message->getText();
                    }
                }
                ?>
                </body>
                </html>