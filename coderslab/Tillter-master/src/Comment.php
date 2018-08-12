<?php

class Comment {

    const NON_EXISTING_ID = -1;

    private $id;
    private $userId;
    private $postId;
    private $creationDate;
    private $text;

    function __construct() {
        $this->id = self::NON_EXISTING_ID;
        $this->userId = '';
        $this->postId = '';
        $this->creationDate = '';
        $this->text = '';
    }

    static public function loadCommentById(PDO $conn, $id) {
        $stmt = $conn->prepare('SELECT * FROM Comments WHERE id=:id');

        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadedComment = new Comment();
            $loadedComment->id = $row['id'];
            $loadedComment->userId = $row['user_id'];
            $loadedComment->postId = $row['post_id'];
            $loadedComment->text = $row['text'];
            $loadedComment->creationDate = $row['creation_date'];

            return $loadedComment;
        }
        return null;
    }

    static public function loadAllCommentsByPostId(PDO $conn, $postId) {

        $stmt = $conn->prepare('SELECT * FROM Comments WHERE post_id=:postId');
        $result = $stmt->execute(['postId' => $postId]);
        $ret = [];

        if ($result == true && $stmt->rowCount() > 0) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $loadedComment = new Comment();
                $loadedComment->id = $row['id'];
                $loadedComment->postId = $row['post_id'];
                $loadedComment->userId = $row['user_id'];
                $loadedComment->text = $row['text'];
                $loadedComment->creationDate = $row['creation_date'];

                $ret[] = $loadedComment;
            }
        }
        return $ret;
    }

    public function saveToDb($conn) {
        if ($this->id == self::NON_EXISTING_ID) {
            $stmt = $conn->prepare(
                    'INSERT INTO Comments(user_id, post_id, creation_date, text) VALUES(:user_id, :post_id, :creation_date, :text)');
            $result = $stmt->execute(
                    ['user_id' => $this->userId, 'post_id' => $this->postId, 'creation_date' => $this->creationDate, 'text' => $this->text]);

            if ($result != false) {
                $this->id = $conn->lastInsertId();

                return true;
            }
        } else {
            $stmt = $conn->prepare(
                    'UPDATE Comments SET post_id=:post_id user_id=:user_id text=:text WHERE id=:id');
            $result = $stmt->execute(
                    ['post_id' => $this->postId, 'user_id' => $this->userId, 'text' => $this->text, 'creation_date' => $this->creationDate]);

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

    function getPostId() {
        return $this->postId;
    }

    function getCreation_date() {
        return $this->creationDate;
    }

    function getText() {
        return $this->text;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setPostId($postId) {
        $this->postId = $postId;
    }

    function setCreation_date($creationDate) {
        $this->creationDate = $creationDate;
    }

    function setText($text) {
        $this->text = $text;
    }

}
