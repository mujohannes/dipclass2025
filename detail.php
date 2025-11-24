<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Book;

// create an app object based on App class
$app = new App();

$title = "Detail Page";
$message = "Hello there";
if( empty($_SESSION["username"]) ) {
    $user = null;
}
else {
    $user = $_SESSION["username"];
}

// user type
if( empty($_SESSION["type"] ) ) {
    $type = null;
}
else {
    $type = $_SESSION["type"];
}

// create an instance of the book class
$cls_book = new Book();

if (isset($_GET["id"])) {
    //echo "<h2>" . $_GET["id"] . "</h2>";
    // get the book details using its id
    $book_detail = $cls_book->getBookById($_GET["id"]);
    // print_r($book_detail);
    // create a template loader
    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    // load the template into memory
    $template = $twig->load('detail.html.twig');
    // add some variables for twig to render
    echo $template->render([
        'title' => $book_detail["Title"],
        'book' => $book_detail,
        'user' => $user,
        'type' => $type
    ]);
} else {
    header("location: index.php");
}
