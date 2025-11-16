<?php
namespace Jm\Webproject;
// declare other components used in this class
use Dotenv;
use \Exception;

class App {
    // visibility
    public function __construct() {
        // get the root directory or Current Working Directory
        $path = getcwd();
        // pass the path to Dotenv to load the .env file
        $dotenv = Dotenv\Dotenv::createImmutable( $path );
        // load the .env configuration into $_ENV (super global)
        $dotenv -> load();
        $this -> initSession();
    }
    private function initSession() {
        // check if session doesn't already exist
        if( session_status() == PHP_SESSION_NONE ) {
            // enable session
            session_start();
        }
    }
    
}
?>