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
                $this -> response["account_id"] = $this -> connection -> insert_id;
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
            if( !$statement -> execute() ) {
                throw new Exception("Database error");
            }
            // check if account exists
            $result = $statement -> get_result();
            if( $result -> num_rows == 0 ) {
                throw new Exception("Account is inactive or does not exist");
            }
            // check password
            $account = $result -> fetch_assoc();
            if( !password_verify($password, $account["Password"]) ) {
                throw new Exception("Invalid credentials");
            }
            else {
                // password matches
                $this -> response["success"] = true;
                $this -> response["message"] = "Login successful";
                $this -> response["account"] = $account;
            }
        }
        catch(Exception $e) {
           $this -> response["success"] = false;
           $this -> response["message"] = $e -> getMessage();
        }

       return $this -> response;
    }
}