<?php

class Tweet {

    const NON_EXISTING_ID = -1;

    private $id;
    private $userId;
    private $text;
    private $creationDate;

    function __construct() {
        $this->id = self::NON_EXISTING_ID;
        $this->userId = '';
        $this->text = '';
        $this->creationDate = '';
    }

    static public function loadTweetById(PDO $conn, $id) {

        $stmt = $conn->prepare('SELECT * FROM Tweets WHERE id=:id');
        //??bind if exept.err:?
        $result = $stmt->execute(['id' => $id]);

        if ($result == true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadedTweet = new Tweet();
            $loadedTweet->id = $row['id'];
            $loadedTweet->userId = $row['user_id'];
            $loadedTweet->text = $row['text'];
            $loadedTweet->creationDate = $row['creation_date'];

            return $loadedTweet;
        }
        return null;
    }

    static public function loadAllTweetsByUserId(PDO $conn, $userId) {

        $stmt = $conn->prepare('SELECT * FROM Tweets WHERE user_id=:userId');
        //??bind if exept.err:?
        $result = $stmt->execute(['userId' => $userId]);
        $ret = [];

        if ($result == true && $stmt->rowCount() > 0) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['user_id'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creation_date'];

                $ret[] = $loadedTweet;
            }
        }
        return $ret;
    }

    static public function loadAllTweets(PDO $conn) {
        $sql = 'SELECT * FROM Tweets';
        $ret = [];

        $result = $conn->query($sql);

        if ($result !== false && $result->rowCount() != 0) {
            foreach ($result as $row) {

                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['user_id'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creation_date'];

                $ret[] = $loadedTweet;
            }
        }
        return $ret;
    }

    public function saveToDb(PDO $conn) {
        if ($this->id == self::NON_EXISTING_ID) {
            $stmt = $conn->prepare(
                    'INSERT INTO Tweets(user_id, text, creation_date) VALUES(:user_id, :text, :creation_date)');
            $result = $stmt->execute(
                    ['user_id' => $this->userId, 'text' => $this->text, 'creation_date' => $this->creationDate]);

            if ($result != false) {
                $this->id = $conn->lastInsertId();

                return true;
            }
        } else {
            $stmt = $conn->prepare(
                    'UPDATE Tweets SET user_id=:user_id, text=:text, creation_date WHERE id=:id');
            $result = $stmt->execute(
                    ['user_id' => $this->userId, 'creation_date' => $this->creation_date,]);
            if ($result == true) {
                return true;
            }
        }
        return false;
    }

    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->userId;
    }

    function getText() {
        return $this->text;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

}
