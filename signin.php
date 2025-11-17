<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Account;

// create an app object based on App class
$app = new App();

$title = "Sign in to UniLibrary";
$message = "Sign in to your account";
$success = null;
if( empty($_SESSION["username"]) ) {
    $user = null;
}
else {
    $user = $_SESSION["username"];
}

// handle POST request from the signup form
if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $account = new Account();
    $signin = $account -> login($email,$password);
    // check if signin is successful
    print_r($signin);
    if( $signin ) {
        // success
        $success = true;
        // $_SESSION["email"] = $email;
        // $_SESSION["username"] = $username;
        // // update the user variable
        // $user = $_SESSION["username"];
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
$template = $twig -> load('signin.html.twig');
// add some variables for twig to render
echo $template -> render([
    'title' => $title,
    'message' => $message,
    'success' => $success,
    'user' => $user
]);
?>