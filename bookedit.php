<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Book;

$app = new App();
$book = new Book();

if( $_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $book_id = $_POST['book_id'];
    $origin = $_POST['origin'];
    $update = $book -> updateBook($book_id,$title);
    if($update) {
        header("location: $origin");
    }
}
?>