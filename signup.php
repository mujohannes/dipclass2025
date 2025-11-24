<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Account;

// create an app object based on App class
$app = new App();

// variables for the page
$title = "Sign up to UniLibrary";
$message = "Join our website";
$success = null;
$response = null;
$type = null;
$user = null;
// username
if( !empty($_SESSION["username"]) ) {
    $user = $_SESSION["username"];
}

// user type
if( !empty($_SESSION["type"] ) ) {
    $type = $_SESSION["type"];
}

// handle POST request from the signup form
if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password1 = $_POST["password"];
    // initialise Account class
    $account = new Account();
    $signup = $account -> create($email,$password1,$username,"Test","User");
    // check if signup is successful
    if( $signup["success"] == true ) {
        // success
        $success = true;
        $response = $signup["message"];
        $_SESSION["email"] = $email;
        $_SESSION["username"] = $username;
        $_SESSION["account_id"] = $signup["account_id"];
        $_SESSION["type"] = 1;
        // update the user variable
        $user = $_SESSION["username"];
    }
    else {
        // failed
        $success = false;
        $response = $signup["message"];
    }
}


// create a template loader
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment( $loader );
// load the template into memory
$template = $twig -> load('signup.html.twig');
// add some variables for twig to render
echo $template -> render([
    'title' => $title,
    'message' => $message,
    'success' => $success,
    'response' => $response,
    'user' => $user,
    'type' => $type
]);
?>