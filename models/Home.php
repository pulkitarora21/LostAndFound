<?php
/**
 * This class is the main model for lost and found items.
 *
 * It is having collection of some methods used by controllers to retrieve and
 * show all the lost or found items from  the database.
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
class Home {

    /**
     *
     *
     * @access public
     * @return mixed
     * @static
     */
    public static function showLost() {
        $sql = 'select id,name,date,street,suburb,state,postcode,image from
            lostItem group by name,date,description order by id desc ;';
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
     * @static
     * @return mixed
     */
    public static function showFound() {
        $sql = 'select id as id,name,date,street,suburb,state,postcode,image
        from foundItem group by name,date,description order by id desc ;';
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
}
