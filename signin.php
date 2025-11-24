<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Account;

// create an app object based on App class
$app = new App();

$title = "Sign in to UniLibrary";
$message = "Sign in to your account";
$success = null;
$response = null;
$type = null;

if( empty($_SESSION["username"]) ) {
    $user = null;
}
else {
    $user = $_SESSION["username"];
}

// handle POST request from the sign in form
if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    // get data from the form
    $email = $_POST["email"];
    $password = $_POST["password"];
    // authenticate user
    $account = new Account();
    $signin = $account -> login($email,$password);
    // check if signin is successful
    if( $signin["success"] == true ) {
        // success
        $success = true;
        $username = $signin["account"]["Username"];
        $type = $signin["account"]["Type"];

        $_SESSION["email"] = $email;
        $_SESSION["username"] = $username;
        $_SESSION["type"] = $type;
        $_SESSION["account_id"] = $signin["account"]["id"];
        // // update the user variable
       $user = $username;
       $response = $signin["message"];
    }
    else {
        // failed
        $success = false;
        $response = $signin["message"];
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
    'user' => $user,
    'response' => $response,
    'type' => $type
]);
?>