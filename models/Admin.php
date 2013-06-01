<?php
/**
 * Model file for admin
 *
 * This file is the main model for the admin functionalities. All the database connection
 * and other interaction related to admin happen here.
 *
 * @package models
 */

/**
 * Start the session
 */
@session_start();
require_once LIBRARY_PATH . DS . 'Database.php';

/**
 * This is the Admin class
 *
 * @access public
 *
 */
class Admin {
    /**
     * If validation fails, errors are written to this variable.
     *
     * @staticVar
     */
    private static $errors;

    /**
     * Get all users details
     *
     * @static
     * @return mixed
     * @access public
     */
    public static function getUsers() {
        $sql = 'SELECT * FROM user ORDER BY email';

        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );

            $statement->execute();
            $result = $statement->fetchAll( PDO::FETCH_OBJ );
        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }

        if ( count( $result ) == 0 ) {
            return NULL;
        } else {
            return $result;
        }
    }

    /**
     * Block malicious users
     * Update table by setting isActivate status to false
     *
     * @param String  $email user registered email
     * @access public
     * @static
     */
    public static function blockUser( $email ) {
        $sql = 'UPDATE user SET isActivated = 0 WHERE email = ?';

        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );

            $statement->bindValue( 1, $email, PDO::PARAM_STR );
            $statement->execute();
        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * Unblock user by sending email with new activation code
     *
     * @param String  $email user registered email
     * @param String  $name  user registered name
     * @access public
     * @static
     */
    public static function unblockUser( $email, $name ) {
        User::sendEmail( $email, $name );
        $code = User::activeCode();

        $sql = 'UPDATE user SET activateCode = ? WHERE email = ?';

        $values = array( $code, $email );

        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );

            $statement->execute( $values );
        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
    }
}
?>
