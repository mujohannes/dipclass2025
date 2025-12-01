<?php

namespace Jm\Webproject;

use Exception;
use Jm\Webproject\App;
use Jm\Webproject\Database;

class Book extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getBooks()
    {
        $query = "
        SELECT 
        id,
        Title,
        Author,
        Cover,
        Publisher,
        Genre
        FROM Book
        ";
        // run the query against the database connection
        $statement = $this->connection->prepare($query);
        // execute the query
        $statement->execute();
        // get the result
        $result = $statement->get_result();
        // create an array to store result
        $books = array();
        // loop through every row in the result
        while ($row = $result->fetch_assoc()) {
            array_push($books, $row);
        }
        return $books;
    }

    public function getBookById($id)
    {
        $query =
            "
        SELECT 
        id,
        Title,
        Author,
        ISBN,
        ISBN13,
        Cover,
        Genre,
        Publisher,
        Description,
        Year,
        Pages
        FROM Book WHERE id = ?
        ";
        $statement = $this->connection->prepare($query);
        $statement -> bind_param("i",$id);
        $statement -> execute();
        $result = $statement -> get_result();
        $book = $result -> fetch_assoc();
        return $book;
    }

    public function updateBook($book_id,$title) {
        $query = "
        UPDATE Book SET Title=? WHERE id = ?
        ";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param("si",$title,$book_id);
        try{
            if( !$statement -> execute() ) {
                throw new Exception("Database error");
            }
            else {
                return true;
            }
        } catch(Exception $e) {
            return false;
            echo $e -> getMessage();
        }
    }

}
