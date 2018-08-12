<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("location: index.php");
} else {
    require './connection.php';
    require './src/Users.php';
    require './src/Message.php';
}
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Send Message</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <form align='center' action="" method="post" role="form">
                        <div class="form-group">
                            <textarea type="text" class="form-control" rows="7" maxlength="140"  
                                      name="newMsg" id="newMsg" style="resize:none"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" value="submit">Send</button>
                        <button class="btn btn-primary" onclick="self.close()">Close</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
        if (isset($_POST['newMsg']) && !empty($_POST['newMsg'])) {

            $newMessage = new Message();
            $newMessage->setSendId($_SESSION['userId']);
            $newMessage->setReciveId($_GET['id']);
            $newMessage->setText(trim($_POST['newMsg']));
            $newMessage->setCreationDate(date('Y-m-d H:i:s'));

            $newMessage->saveToDb($conn);
            
            echo 'Message sent!';
        }
        ?>
    </body>
</html>

