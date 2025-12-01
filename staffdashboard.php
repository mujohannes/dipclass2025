<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Loan;

// create an app object based on App class
$app = new App();

// variables for the page
$title = "Staff Dashboard";
$message = "Staff Dashboard";
$user = null;
$type = null;
// check if the user is authenticated
// if not redirect to signin
if( empty($_SESSION['email'] ) ) {
    header("location: /signin.php");
}

// username
if( !empty($_SESSION["username"]) ) {
    $user = $_SESSION["username"];
}

// user type
if( !empty($_SESSION["type"] ) ) {
    $type = $_SESSION["type"];
}

//redirect for the wrong type
if( $type < 2 ) {
    session_destroy();
    header("location: /signin.php");
}

// get user loans
$account_id = $_SESSION["account_id"];
// initialise loan class
$loan = new Loan();
// check if book is being returned
if( $_SERVER['REQUEST_METHOD'] == 'POST') {
    $loan_id = $_POST['loan_id'];
    $return = $loan -> returnBook($loan_id);
}
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
    'user' => $user,
    'type' => $type
]);
?>