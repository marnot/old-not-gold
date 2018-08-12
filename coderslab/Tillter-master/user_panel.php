<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("location: index.php");
} else {

    require './connection.php';
    require './src/Tweet.php';
    require './src/Users.php';
    require './src/Message.php';
    require './src/Comment.php';

    $userId = $_GET['id'];
    $allTweet = Tweet::loadAllTweetsByUserId($conn, $userId);


    $user = User::loadUserById($conn, $userId);
    $nameUser = $user->getUsername();
    ?>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>User Panel</title>
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">


                        <?php
                        foreach ($allTweet as $tweet) {
                            echo
                            ' 
<table align = "center" style="width: 40%;vertical-align: central" class="table table-boardered">
                <thead>
                    <tr>
                        <th>User: <a href = "user_panel.php?id=' . $tweet->getUserId() . '" >' . $nameUser . '</th>
                        <th>' . $tweet->getCreationDate() . '</th>
                        <th><a href = "post_panel.php?id=' . $tweet->getId() . '" >#' . $tweet->getId() . '</a></th>
                    </tr>
                    
                </thead>
                <tbody>
                    <tr>
                        <td>' . $tweet->getText() . '</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px"><a href ="post_panel.php?id=' . $tweet->getId() . '">Comments: '
                            . count(Comment::loadAllCommentsByPostId($conn, $tweet->getId())) . '</td>
                    </tr>
                </tbody>
            </table>';
                        }

                        echo '<form><input type="button" value="Go Back" onClick="history.go(-1);return true;"></form>
            </div>';

                        if ($allTweet === null) {
                            echo 'no such tweet';
                            echo '<form><input type="button" value="Go Back" onClick="history.go(-1);return true;"></form>';
                        }
                        if ($_SESSION['userId'] !== $userId) {
                            echo '<a target="_blank" href="create_message.php?id=' . $userId . '" class="btn btn-default">Send message to this user.</a>';
                        } else {
                            echo '<a href="messages.php" class="btn btn-default">My messages.</a>';
                        }
                    }
                    ?>


                    </body>
                    </html>