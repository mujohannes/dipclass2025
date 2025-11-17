<?php

namespace Jm\Webproject;

use Exception;
use Jm\Webproject\Database;

class Account extends Database
{
    public $response = array();

    public function __construct()
    {
        // initialise the database connection
        parent::__construct();
    }

    public function create(
        $email,
        $password,
        $username,
        $first,
        $last
    ) {
        $query = "
        INSERT INTO Account
        (Email,Password,Username,First,Last,Type)
        VALUES
        (?,?,?,?,?,1)
        ";
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $statement = $this->connection->prepare($query);
        $statement->bind_param("sssss", $email, $hash, $username, $first, $last);
        try {
            if (!$statement->execute()) {
                throw new Exception("Oops! Something is wrong");
            } else {
                // account is created
                $this -> response["success"] = true;
                $this -> response["message"] = "Account is successfully created";
                return $this -> response;
            }
        } catch (Exception $e) {
            // do something
            //echo $e->getMessage();
            // failure to create account
            $this -> response["success"] = false;
            $this -> response["message"] = $e -> getMessage();
            return $this -> response;
        }
    }

    public function login($email, $password)
    {
        // find the user in the database
        $query = "
            SELECT 
            id,
            Email,
            Username,
            Password,
            First,
            Last,
            Type
            FROM Account
            WHERE 
            Email = ?
            AND
            Active = 1
        ";
        $statement = $this->connection->prepare($query);
        $statement -> bind_param("s", $email);
        try {
            if(!$statement -> execute()) {
                throw new Exception("database error");
            }
            else {
                $result = $statement -> get_result();
                $account_data = array();
                while( $row = $result->fetch_assoc() ) {
                    array_push($account_data,$row);
                }
                if( count($account_data) == 0 ) {
                    // account does not exist
                    //return false;
                }
                $account = $account_data[0];
                // check the password
                if( password_verify($password,$account["Password"]) ) {
                    //
                    return $account;
                }
                else {
                    // password does not match
                    return false;
                }
                
            }
        }
        catch(Exception $e) {
            echo $e -> getMessage();
            exit();
        }

        //check account data
        //$account = $account_data[0];
       // print_r( $account );
        // if( count($account_data) == 0 ) {
        //     // account does not exist if the array length is 0
        //     return false;
        // }
        // else {
        //     // check the password
        //     $account = $account_data[0];
        //     if( !password_verify($password, $account["Password"] )) {
        //         // password does not match the hash in database
                
        //         return false;
        //     }
        //     else {

        //         return $account;
        //     }
        // }
        //return true;
    }
}
