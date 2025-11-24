<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Loan;

// create an app object based on App class
$app = new App();

$title = "Staff Dashboard";
$message = "Staff Dashboard";

// check if the user is authenticated
// if not redirect to signin
if( empty($_SESSION['email'] || empty($_SESSION['account_id']) ) ) {
    header("location: /signin.php");
}
// user type
if( empty($_SESSION["type"] ) ) {
    $type = null;
}
else {
    $type = $_SESSION["type"];
}
// get user loans
$account_id = $_SESSION["account_id"];
// initialise loan class
$loan = new Loan();
$user_loans = $loan -> getOutstandingLoans();

// create a template loader
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment( $loader );
// load the template into memory
$template = $twig -> load('staffdashboard.html.twig');
// add some variables for twig to render
echo $template -> render([
    'title' => $title,
    'message' => $message,
    'userloans' => $user_loans,
    'type' => $type
]);
?>