<?php

class Message {

    const NON_EXISTING_ID = -1;

    private $id;
    private $sendId;
    private $reciveId;
    private $status;
    private $text;
    private $creationDate;

    function __construct() {
        $this->id = self::NON_EXISTING_ID;
        $this->sendId = '';
        $this->reciveId = '';
        $this->status = 0;
        $this->text = '';
        $this->creationDate = '';
    }

    static public function loadMessageById(PDO $conn, $id) {
        $stmt = $conn->prepare('SELECT * FROM Messages WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadedMessage = new Message();
            $loadedMessage->id = $row['id'];
            $loadedMessage->sendId = $row['send_id'];
            $loadedMessage->reciveId = $row['recive_id'];
            $loadedMessage->status = $row['status'];
            $loadedMessage->text = $row['text'];
            $loadedMessage->creationDate = $row['creation_date'];

            return $loadedMessage;
        }
        return null;
    }

    static public function loadMessagesBySendId(PDO $conn, $sendId) {
        $stmt = $conn->prepare('SELECT * FROM Messages WHERE send_id=:send_id');
        $result = $stmt->execute(['send_id' => $sendId]);

        $ret = [];

        if ($result === true && $stmt->rowCount() > 0) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $loadedMessage = new Message();

                $loadedMessage->id = $row['id'];
                $loadedMessage->sendId = $row['send_id'];
                $loadedMessage->reciveId = $row['recive_id'];
                $loadedMessage->status = $row['status'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->creationDate = $row['creation_date'];

                $ret[] = $loadedMessage;
            }
        }
        return $ret;
    }

    static public function loadMessagesByReciveId(PDO $conn, $reciveId) {
        $stmt = $conn->prepare('SELECT * FROM Messages WHERE recive_id=:recive_id');
        $result = $stmt->execute(['recive_id' => $reciveId]);

        $ret = [];

        if ($result === true && $stmt->rowCount() > 0) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $loadedMessage = new Message();

                $loadedMessage->id = $row['id'];
                $loadedMessage->sendId = $row['send_id'];
                $loadedMessage->reciveId = $row['recive_id'];
                $loadedMessage->status = $row['status'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->creationDate = $row['creation_date'];

                $ret[] = $loadedMessage;
            }
        }
        return $ret;
    }

    public function saveToDb($conn) {
        if ($this->id == self::NON_EXISTING_ID) {
            //Saving new message to DB
            $stmt = $conn->prepare(
                    'INSERT INTO Messages(send_id, recive_id, status, text, creation_date)
                    VALUES (:sendId, :reciveId, :status, :text, :creationDate)');
            $result = $stmt->execute(['sendId' => $this->sendId, 'reciveId' => $this->reciveId,
                'status' => $this->status, 'text' => $this->text, 'creationDate' => $this->creationDate]);
            if ($result === true) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            $stmt = $conn->prepare('UPDATE Messages SET status=:status WHERE id=:id');
            $result = $stmt->execute(['status' => $this->status, 'id' => $this->id]);

            if ($result == true) {
                return true;
            }
        }
        return false;
    }

    function getId() {
        return $this->id;
    }

    function getSendId() {
        return $this->sendId;
    }

    function getReciveId() {
        return $this->reciveId;
    }

    function getStatus() {
        return $this->status;
    }

    function getText() {
        return $this->text;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    function setSendId($sendId) {
        $this->sendId = $sendId;
    }

    function setReciveId($reciveId) {
        $this->reciveId = $reciveId;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    function setMessageAsRead() {
        $this->status = 1;
    }

    function showMsgStatus() {
        if ($this->status == 1) {
            return "Read";
        }
        return 'Unread';
    }

}
