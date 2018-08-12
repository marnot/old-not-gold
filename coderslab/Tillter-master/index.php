
<?php
session_start();


require_once 'connection.php';
require_once 'src/Users.php';
require_once 'src/Tweet.php';
//if(isset($_SESSION['id']) && isset($_SESSION['username']))
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Tillter</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <legend>Add Tillt</legend>
                    <?php
                    if (isset($_SESSION['userId'])) {

                        echo
                        '
                            <a href="user_panel.php?id=' . $_SESSION['userId'] . '" class="btn btn-default">User Panel</a>
                            <a href="logOut.php" class="btn btn-default">Logout</a>;
                            <br>
                            <form action="" method="post" role="form">
                            <div class="form-group">
                            <textarea type="text" class="form-control" rows="7" maxlength="140"  
                                      name="newTweet" id="newTweet" style="resize:none"></textarea>
                        </div>
                        
                        
                                <button type="submit" class="btn btn-primary" value="submit">Post</button>
                    </form>

                </div>
                ';
                        ?>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                    </div>
                    <br>
                    <?php
                    $allTweets = Tweet::loadAllTweets($conn);
                    foreach ($allTweets as $tweet) {
                        $user = User::loadUserById($conn, $tweet->getUserId());
                        $nameUser = $user->getUsername();

                        echo
                        '<table align = "center" style="width: 40%;vertical-align: central" class="table table-boardered">
                <thead>
                    <tr>
                        <th>User: <a href = user_panel.php?id=' . $tweet->getUserId() . '>' . $nameUser . '</a></th>
                        <th>' . $tweet->getCreationDate() . '</th>
                        <th><a href = post_panel.php?id=' . $tweet->getId() . '>#' . $tweet->getId() . '</a></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>' . $tweet->getText() . '</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px"><a href ="post_panel.php?id=' . $tweet->getId() . '">Comments</td>
                    </tr>
                </tbody>
            </table>';
                    }
                    // put your code here
                    if (isset($_POST['newTweet']) && !empty($_POST['newTweet'])) {

                        $newTweet = new Tweet();
                        $newTweet->setUserId($_SESSION['userId']);
                        $newTweet->setText(trim($_POST['newTweet']));
                        $newTweet->setCreationDate(date('Y-m-d H:i:s'));

                        $newTweet->saveToDb($conn);
                    }
                } else {
                    echo'
            <a href="create_user.php" class="btn btn-default">Register</a>
            <a href="login_page.php" class="btn btn-default">Login</a>';
                }
                ?>

                </body>
                </html>
