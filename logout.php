<?php
require('vendor/autoload.php');

use Jm\Webproject\App;
// initialise App to access session
$app = new App();
// destroy the session to sign user out
session_destroy();

header("location:/");
?>