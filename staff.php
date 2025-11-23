<?php
require('vendor/autoload.php');

use Jm\Webproject\App;

// create an app object based on App class
$app = new App();

$title = "Staff Dasboard";
$message = "Manage Uni Library";
$type = null;
// staff dashboard
// create a template loader
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment( $loader );
// load the template into memory
$template = $twig -> load('staff.html.twig');
// add some variables for twig to render
echo $template -> render([
    'title' => $title,
    'message' => $message
]);
?>