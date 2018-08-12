<?php

class User {

    const NON_EXISTING_ID = -1;

    private $id;
    private $username;
    private $email;
    private $hashPass;

    function __construct() {
        $this->id = self::NON_EXISTING_ID;
        $this->username = '';
        $this->email = '';
        $this->hashPass = '';
    }

    static public function loadUserById(PDO $conn, $id) {

        $stmt = $conn->prepare('SELECT * FROM Users WHERE id=:id');
        //bind if exept.err:
        $result = $stmt->execute(['id' => $id]);

        if ($result == true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->email = $row['email'];
            $loadedUser->hashPass = $row['hash_pass'];

            return $loadedUser;
        }
        return null;
    }

    static public function loadUserByEmail(PDO $conn, $email) {
        $stmt = $conn->prepare('SELECT * FROM Users WHERE email=:email');
        $result = $stmt->execute(['email' => $email]);

        if ($result == true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->email = $row['email'];
            $loadedUser->hashPass = $row['hash_pass'];

            return $loadedUser;
        }
        return null;
    }

    static public function loadAllUsers(PDO $conn) {
        $sql = 'SELECT * FROM Users';
        $ret = [];

        $result = $conn->query($sql);

        if ($result !== false && $result->rowCount() != 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->username = $row['username'];
                $loadedUser->email = $row['email'];
                $loadedUser->hashPass = $row['hash_pass'];

                $ret = $loadedUser;
            }
        }
        return $ret;
    }

    public function delete(PDO $conn) {
        if ($this->id != self::NON_EXISTING_ID) {
            $stmt = $conn->prepare('DELETE FROM Users WHERE id=:id');
            $result = $stmt->execute(['id' => $this->id]);
            if ($result === true) {
                $this->id = self::NON_EXISTING_ID;
                return true;
            }
            return false;
        }
        return false;
    }

    public function saveToDb(PDO $conn) {
        if ($this->id == self::NON_EXISTING_ID) {
            $stmt = $conn->prepare(
                    'INSERT INTO Users(username, email, hash_pass) VALUES(:username, :email, :hash_pass)');
            $result = $stmt->execute(
                    ['username' => $this->username, 'email' => $this->email, 'hash_pass' => $this->hashPass]);

            if ($result != false) {
                $this->id = $conn->lastInsertId();

                return true;
            }
        } else {
            $stmt = $conn->prepare(
                    'UPDATE Users SET username=:username, email=:email, hash_pass WHERE id=:id');
            $result = $stmt->execute(
                    ['username' => $this->username, 'email' => $this->email,
                        'hash_pass' => $this->hashPass, 'id' => $this->id]);
            if ($result == true) {
                return true;
            }
        }
        return false;
    }

    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getEmail() {
        return $this->email;
    }

    function getHashPass() {
        return $this->hashPass;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPass($pass) {
        $this->hashPass = password_hash($pass, PASSWORD_BCRYPT);
    }

}
