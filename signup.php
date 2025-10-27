<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Account;

// create an app object based on App class
$app = new App();

$title = "Sign up to UniLibrary";
$message = "Join our website";



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