<?php
/**
 * File to search and get lost items from the database depending on user
 * search queries.
 *
 * This class is used by the controller to retrieve all the lost items from
 * the database, find items by id or to retrieve the contact info of
 * the user who has posted the item.
 *
 * @package models
 * Include the database connection file
 */
require_once LIBRARY_PATH . DS . 'Database.php';

/**
 *
 *
 * @access public
 */
class Lost {

    /**
     *
     *
     * @access public
     * @static
     * @return mixed
     */
    public static function showAll() {
        $sql = 'select * from lostItem order by id desc';
        $values = array();

        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );
            $statement->execute( $values );
            $result = $statement->fetchAll( PDO::FETCH_ASSOC );

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
     * @static
     */
    public static function showById( $id ) {
        $sql = 'select * from lostItem where id = ?';
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
     * @static
     */
    public static function getContactInfo( $id ) {
        $sql = 'SELECT u.email, u.fname, u.lname
                FROM `user` u JOIN `lostItem` l ON l.email =u.email
                WHERE l.id= ? ';

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
}
