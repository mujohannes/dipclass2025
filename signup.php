<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Account;

// create an app object based on App class
$app = new App();

$title = "Sign up to UniLibrary";
$message = "Join our website";

// handle POST request from the signup form
if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    $username = $_POST["username"];
    $first = $_POST["firstname"];
    $last = $_POST["lastname"];
    $email = $_POST["email"];
    $password1 = $_POST["password"];
    $password2 = $_POST["confirm-password"];
    // initialise Account class
    $account = new Account();
    $signup = $account -> create($email,$password1,$username,$first,$last);
}


// create a template loader
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment( $loader );
// load the template into memory
$template = $twig -> load('signup.html.twig');
// add some variables for twig to render
echo $template -> render([
    'title' => $title,
    'message' => $message
]);
?>