<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("location: index.php");
} else {
    require './connection.php';
    require './src/Users.php';
    require './src/Message.php';

    $id = $_GET['id'];
    $message = Message::loadMessageById($conn, $id);

    if ($message->getReciveId() == $_SESSION['userId']) {
        $message->setMessageAsRead();
        $message->saveToDb($conn);
    }
    ?>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Message Panel</title>
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">



                        <form><input type="button" value="Go Back" onClick="history.go(-1);return true;"></form>

                        <?php
                        echo
                        ' 
<table align = "center" style="width: 40%;
                                            vertical-align: central" class="table table-boardered">
                <thead>
                    <tr>
                        <th>User: <a href = "user_panel.php?id = ' . $message->getSendId() . '" >'
                        . User::loadUserById($conn, $message->getSendId())->getUsername() . '</th>
                        <th>' . $message->getCreationDate() . '</th>
                    </tr>
                    
                </thead>
                <tbody>
                    <tr>
                        <td>' . $message->getText() . '</td>
                    </tr>
                </tbody>
            </table>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>