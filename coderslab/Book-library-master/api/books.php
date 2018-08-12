<?php

include_once(__DIR__ . '/../src/Book.php');
include_once('config/config.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $books = [];
        $book = new Book();
        $book->loadFromDb($_GET['id']);
        $books[$book->getId()] = $book;
        echo json_encode($books);
        
    } else {
        $loadedBooks = Book::loadAllBooks();
        $books = [];
        
        foreach ($loadedBooks as $value) {
            $books[$value->getId()] = $value;
        }
        echo json_encode($books);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!(strlen(trim($_POST['name'])) == 0)) {
        $name = ($_POST['name']);
        $author = $_POST['author'];
        $description = $_POST['description'];
        $book = new Book();
        $book->create($name, $author, $description);
    } else {
        return "Nie podano nazwy książki";
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $del_vars);
    var_dump($del_vars);
    $id = $del_vars['id'];
    $book = new Book();
    $book->loadFromDb($id);
    $book->deleteFromDb();
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $put_vars);
    var_dump($put_vars);
    $id = $put_vars['id'];
    $book = new Book();
    $book->loadFromDb($id);


    if (!(strlen(trim($put_vars['name'])) == 0)) {
        $name = $put_vars['name'];
    } else {
        $name = $book->getName();
    }
    if (!(strlen(trim($put_vars['author'])) == 0)) {
        $author = $put_vars['author'];
    } else {
        $author = $book->getAuthor();
    }
    if (!(strlen(trim($put_vars['description'])) == 0)) {
        $description = $put_vars['description'];
    } else {
        $description = $book->getDesc();
    }
    $book->update($name, $author, $description);
}
