<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Account;

// create an app object based on App class
$app = new App();

$title = "Sign up to UniLibrary";
$message = "Join our website";
$success = null;
if( empty($_SESSION["username"]) ) {
    $user = null;
}
else {
    $user = $_SESSION["username"];
}

// handle POST request from the signup form
if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password1 = $_POST["password"];
    //$password2 = $_POST["confirm-password"];
    // initialise Account class
    $account = new Account();
    $signup = $account -> create($email,$password1,$username,"Test","User");
    // check if signup is successful
    if( $signup == true ) {
        // success
        $success = true;
        $_SESSION["email"] = $email;
        $_SESSION["username"] = $username;
        // update the user variable
        $user = $_SESSION["username"];
    }
    else {
        // failed
        $success = false;
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
    'user' => $user
]);
?>