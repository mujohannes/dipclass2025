<?php
namespace Jm\Webproject;

use \Exception;
use Jm\Webproject\Database;

class Loan extends Database {
    public function __construct()
    {
        parent::__construct();
    }
    // get all loans
    public function getLoans() {
        
    }
    // borrow book using it's id
    public function borrow($book_id,$account_id) {
        $query = "
        INSERT INTO Loan( BookId, AccountId, BorrowDate,ReturnDate) 
        VALUES
        (?,?,NOW(),NULL)
        ";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param("ii", $book_id, $account_id );
        try {
            if( !$statement -> execute() ) {
                // failed to create loan
                throw new Exception("failed to create loan");
            }
            else {
                // loan created
                return true;
            }
        } catch( Exception $e) {
            return false;
        }
    }
    public function isBookOnLoan($book_id) {
        $query = "
        SELECT
        id, BookId
        FROM Loan WHERE ReturnDate IS NULL
        ";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param("i", $book_id );
        try {
            if( !$statement -> execute() ) {
                // check failed
                throw new Exception("status check failed");
            }
            else {
                $result = $statement -> get_result();
                if( $result -> num_rows > 0 ) {
                    // book is out on loan
                    return true;
                }
                else {
                    // book is available
                    return false;
                }
            }
        } catch( Exception $e) {
            echo $e -> getMessage();
            exit();
        }
    }

    public function returnBook($loan_id,$book_id) {
        $query = "
        UPDATE Loan
        SET ReturnDate = NOW()
        WHERE id=$loan_id AND BookId = $book_id
        ";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param("ii", $loan_id, $book_id );
        try {
            if( !$statement -> execute() ) {
                // check failed
                throw new Exception("return failed");
            }
            else {
                return true;
            }
        } catch( Exception $e) {
            return false;
        }
    }

}
?>