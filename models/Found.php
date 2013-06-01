<?php
/**
 * File to search and get found items from the database depending on user search queries.
 *
 * This class is used by the controller to retrieve all the found items from the database, find items by id or to
 * retrieve the contact info of the user who has posted the item.
 *
 * @package models
 */
/**
 * Include the database file
 */
require_once LIBRARY_PATH . DS . 'Database.php';

/**
 *
 *
 * @access public
 */
class Found {

    /**
     *
     *
     * @access public
     * @return mixed
     */
    public static function showAll() {
        $sql = 'select * from foundItem order by id desc';
        $values = array();

        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );
            $statement->execute( $values );
            $result = $statement->fetchAll( PDO::FETCH_ASSOC );
            //$database->pdo = null;

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }

        if ( count( $result ) > 1 ) {
            return $result;
        } else if ( count( $result ) == 1 ) {
                return $result[0];
            } else {
            return NULL;
        }
    }

    /**
     *
     *
     * @access public
     * @param String|mixed $id
     * @return mixed
     */
    public static function showById( $id ) {
        $sql = 'select * from foundItem where id = ?';
        $values = array( $id );
        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );
            $statement->execute( $values );
            $result = $statement->fetchAll( PDO::FETCH_ASSOC );

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }

        if ( count( $result ) == 1 ) {
            return $result[0];
        } else {
            return NULL;
        }
    }

    /**
     *
     *
     * @access public
     * @param String|mixed $id
     * @return mixed
     */
    public static function getContactInfo( $id ) {
        $sql = 'SELECT u.email, u.fname, u.lname
                FROM `user` u JOIN `foundItem` f ON f.email =u.email
                WHERE f.id= ? ';


        $values = array( $id );
        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );
            $statement->execute( $values );
            $result = $statement->fetchAll( PDO::FETCH_ASSOC );

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }

        if ( count( $result ) == 1 ) {
            return $result[0];
        } else {
            return NULL;
        }
    }

    /**
     * to populate data in databse
     *
     * @access public
     * @param String|mixed $id
     * @return mixed
     */
    public static function match( $lost, $found ) {
        $sql1 = "UPDATE `foundItem` SET `isSolved` = ? WHERE `id` = ? ";
        $sql2 = "UPDATE `lostItem` SET `isSolved` = ? WHERE `id` = ? ";

        $values = array( $lost, $found );

        try {
            $database = Database::getInstance();

            $statement = $database->pdo->prepare( $sql1 );
            $statement->execute( $values );

            $statement = $database->pdo->prepare( $sql2 );
            $statement->execute( array_reverse( $values ) );

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
    }
}
