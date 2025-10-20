<?php

namespace Jm\Webproject;

use Exception;
use Jm\Webproject\App;
use Jm\Webproject\Database;

class Search extends Database {
    public function __construct() {
        parent::__construct();
    }
    public function getResults( $keyword ) {
        $query = "SELECT 
                id,
                Title,
                Cover,
                Description
                FROM `Book` WHERE title LIKE ? ";
        $search_keyword = "%$keyword%";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param("s", $search_keyword );
        $statement -> execute();
        $result = $statement -> get_result();
        $search_result = array();
        while( $row = $result -> fetch_assoc() ) {
            array_push($search_result, $row);
        }
        return $search_result;
    }
}
?>