<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("location: index.php");
} else {

    require './connection.php';
    require './src/Tweet.php';
    require './src/Users.php';
    require './src/Comment.php';
    ?>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Post Panel</title>
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                        <?php
                        $tweetId = $_GET['id'];
                        $tweet = Tweet::loadTweetById($conn, $tweetId);



                        $idUser = $tweet->getUserId();
                        $user = User::loadUserById($conn, $idUser);
                        $nameUser = $user->getUsername();


                        $comment = Comment::loadAllCommentsByPostId($conn, $tweetId);
                        echo
                        ' 
<table align = "center" style="width: 40%;vertical-align: central" class="table table-boardered">
                <thead>
                    <tr>
                        <th>User: <a href = "user_panel.php?id=' . $tweet->getUserId() . '">' . $nameUser . '</a></th>
                        <th>' . $tweet->getCreationDate() . '</th>
                        <th><a href = "post_panel.php?id=' . $tweet->getId() . '" >#' . $tweet->getId() . '</a></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>' . $tweet->getText() . '</td>
                    </tr>
                </tbody>
            </table>
            ';
                        if (empty($comment)) {
                            echo 'No comments.';
                        }

                        echo
                        '<p style="text-align:center">Comment:</p>
            
            <form action="" method="post" role="form">
                            <div class="form-group">
                            <textarea type="text" class="form-control" rows="7" maxlength="140"  
                                      name="newComment" id="newComment" style="resize:none"></textarea>
                        </div>
                        
                        
                                <button type="submit" class="btn btn-primary" value="submit">Comment</button>
                    </form>
                           <input type="button" value="Go Back" onClick="history.go(-1);return true;">

                </div>
            
            ';

                        if ($tweet === null) {
                            echo 'no such tweet';
                            echo '<form><input type="button" value="Go Back" onClick="history.go(-1);return true;"></form>';
                        }


                        foreach ($comment as $comm) {
                            $commUser = User::loadUserById($conn, $comm->getUserId());
                            echo
                            ' 
<table align = "center" style="width: 40%;vertical-align: central" class="table table-boardered">
                <thead>
                    <tr>
                        <th>User: <a href = "post_panel.php?id=' . $comm->getUserId() . '">' . $commUser->getUsername() . '</a></th>
                        <th>' . $comm->getCreation_date() . '</th>
                        <th>#' . $comm->getId() . '</a></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>' . $comm->getText() . '</td>
                    </tr>
                </tbody>
            </table>';
                        }


                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['newComment'])) {

                            $newComment = new Comment();
                            $newComment->setUserId($_SESSION['userId']);
                            $newComment->setPostId($tweetId);
                            $newComment->setText(trim($_POST['newComment']));
                            $newComment->setCreation_date(date('Y-m-d H:i:s'));

                            $newComment->saveToDb($conn);
                        }
                    }
                    ?>
                    </body>
                    </html>

