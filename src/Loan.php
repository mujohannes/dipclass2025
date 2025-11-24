<?php
namespace Jm\Webproject;

use \Exception;
use Jm\Webproject\Database;

class Loan extends Database {
    public function __construct()
    {
        parent::__construct();
    }

    public function getLoansByAccount($account_id) {
        $query = "
            SELECT  
            LoanId,
            BookId,
            BorrowDate,
            DueDate,
            ReturnDate,
            Title
            FROM Loan 
            INNER JOIN Book
            ON Loan.BookId = Book.id
            WHERE AccountId = ?
        ";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param("i",$account_id);
        try {
            if( !$statement -> execute() ) {
                throw new Exception("Database error");
            }
            else {
                $result = $statement -> get_result();
                $user_loans = array();
                while( $row = $result -> fetch_assoc() ) {
                    array_push($user_loans, $row);
                }
                return $user_loans;
            }
        }
        catch(Exception $e) {
            echo $e -> getMessage();
            return false;
        }
    }

    public function getOutstandingLoans () {
        // get all the books that have not been returned
        $query = "
        SELECT
        LoanId,
        BookId,
        AccountId,
        BorrowDate,
        DueDate,
        Title,
        Username,
        Email,
        ReturnDate
        FROM Loan 
        INNER JOIN Book
        ON Loan.BookId = Book.id
        INNER JOIN Account
        ON Loan.AccountId = Account.id
        WHERE ReturnDate IS NULL
        ";

        $statement = $this -> connection -> prepare($query);
        try {
            if( !$statement -> execute() ) {
                throw new Exception("Database error");
            }
            else {
                $result = $statement -> get_result();
                $loans = array();
                while( $row = $result -> fetch_assoc() ) {
                    array_push( $loans, $row );
                }
                return $loans;
            }
        } catch(Exception $e) {
            echo $e -> getMessage();
            return false;
        }
    }
}
?>