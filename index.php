<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Book;

// create an app object based on App class
$app = new App();

// variables for the page
$title = "Home Page";
$message = "Browse our books";
$type = null;
$user = null;
$account_id = null;

// username
if( !empty($_SESSION["username"]) ) {
    $user = $_SESSION["username"];
}

// user type
if( !empty($_SESSION["type"] ) ) {
    $type = $_SESSION["type"];
}
// account id
if(!empty($_SESSION['account_id'])) {
    $account_id = $_SESSION["account_id"];
}
// create an instance of the book class
$cls_book = new Book();
$books = $cls_book -> getBooks();
// check if we have book data
//print_r($books);

// create a template loader
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment( $loader );
// load the template into memory
$template = $twig -> load('index.html.twig');
// add some variables for twig to render
echo $template -> render([
    'title' => $title,
    'message' => $message,
    'books' => $books,
    'user' => $user,
    'type' => $type,
    'account_id' => $account_id
]);
?>