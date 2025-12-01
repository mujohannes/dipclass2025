<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Search;

// create an app object based on App class
$app = new App();

// variables for the page
$title = "Search Results";
$message = "Search results";
$type = null;
$user = null;
$account_id = null;
$search_result = [];
$keywords = null;

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

if( isset($_GET["query"]) ) {
   $keywords = $_GET["query"];
   $title = "Search results for " . $keywords;
   // initialise search class
   $search = new Search();
   // call getResults method and pass user keyword
   $search_result = $search -> getResults($keywords);
}
else {
    echo "You are not searching";
}

// create a template loader
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment( $loader );
// load the template into memory
$template = $twig -> load('search.html.twig');
// add some variables for twig to render
echo $template -> render([
    'title' => $title,
    'message' => $message,
    'search' => $search_result,
    'user' => $user,
    'type' => $type,
    'account_id' => $account_id,
    'keywords' => $keywords 
]);
?>