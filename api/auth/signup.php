<?php
require('../../vendor/autoload.php');

use Jm\Webproject\App;
use Jm\Webproject\Account;

// php api for account signup
// request made via POST
// accepts username,email,password,confirmpassword
$app = new App();
$account = new Account();

$response = array();
// handle post request
if( $_SERVER['REQUEST_METHOD'] !== "POST" ) {
    $response["code"] = 400;
    $response["message"] = "bad request";
    http_response_code(400);
    echo json_encode($response);
    exit();
}
?>