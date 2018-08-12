<?php

class Book implements JsonSerializable
{

    private $id;
    private $name;
    private $author;
    private $description;
    public static $conn;
    
    public function __construct($name = '', $author = '', $description = '')
    {
        $this->id = -1;
        $this->name = $name;
        $this->author = $author;
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function loadFromDb($id)
    {
        $safe_id = self::$conn->real_escape_string($id);
        $sql = "SELECT * FROM books WHERE id = $safe_id";

        if ($result = self::$conn->query($sql)) {
            $row = $result->fetch_assoc();

            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->author = $row['author'];
            $this->description = $row['description'];

            return true;
            
        } else {
            
            return false;
        }
    }
    
    public static function loadAllBooks()
    {
        $sql = "SELECT * FROM books";
        $ret = [];
        $result = self::$conn->query($sql);
        if ($result !== false) {
            foreach ($result as $row) {
                $book = new Book();
                $book->id = $row['id'];
                $book->name = $row['name'];
                $book->author = $row['author'];
                $book->description = $row['description'];
                $ret[] = $book;
            }
        } else {
            $ret = 'no books in DB!';
        }
        return $ret;
    }

    public function create( $name, $author, $description)
    {
        $safe_name = self::$conn->real_escape_string($name);
        $safe_author = self::$conn->real_escape_string($author);
        $safe_desc = self::$conn->real_escape_string($description);

        $sql = "INSERT INTO books(name, author, description) VALUES ('$safe_name', '$safe_author', '$safe_desc')";

        if ($result = self::$conn->query($sql)) {
            $this->id = self::$conn->insert_id;
            $this->name = $name;
            $this->author = $author;
            $this->description = $description;

            return true;
        } else {
            return false;
        }
    }

    public function update($name, $author, $description)
    {
        $safe_name = self::$conn->real_escape_string($name);
        $safe_author = self::$conn->real_escape_string($author);
        $safe_desc = self::$conn->real_escape_string($description);
        $safe_id = self::$conn->real_escape_string($this->id);

        $sql = "UPDATE books SET name='$safe_name', author='$safe_author', description='$safe_desc' WHERE id=$safe_id";
        $result = self::$conn->query($sql);

        if ($result = self::$conn->query($sql)) {
            $this->name = $name;
            $this->author = $author;
            $this->description = $description;

            return true;
        } else {
            return false;
        }
    }

    public function deleteFromDb()
    {
        $safe_id = self::$conn->real_escape_string($this->id);

        $sql = "DELETE FROM books WHERE id=$safe_id";

        if ($result = self::$conn->query($sql)) {
            $this->name = '';
            $this->author = '';
            $this->description = '';
            $this->id = -1;
            
            return true;
            
        } else {
            
            return false;
            
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'author' => $this->author,
            'description' => $this->description
        ];
    }

    static public function getBooksIds()
    {
        $sql = "SELECT id FROM books ORDER BY author, name";
        $ret = [];

        $result = self::$conn->query($sql);
        if ($result == true && $result->num_rows > 0) {
            foreach ($result as $row) {
                $loadedBook = new Book();
                $loadedBook->id = $row['id'];

                $ret[$loadedBook->id] = $loadedBook;
            }
        } else {
            return NULL;
        }

        return $ret;
    }

}