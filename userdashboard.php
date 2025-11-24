<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Loan;

// create an app object based on App class
$app = new App();

$title = "User Dashboard";
$message = "User Dashboard";

// check if the user is authenticated
// if not redirect to signin
if( empty($_SESSION['email']) ) {
    header("location: /signin.php");
}
// get user loans
$account_id = $_SESSION["account_id"];
// initialise loan class
$loan = new Loan();
$user_loans = $loan -> getLoansByAccount($account_id);

// create a template loader
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment( $loader );
// load the template into memory
$template = $twig -> load('userdashboard.html.twig');
// add some variables for twig to render
echo $template -> render([
    'title' => $title,
    'message' => $message,
    'userloans' => $user_loans
]);
?>