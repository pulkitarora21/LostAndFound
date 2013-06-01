<?php
/**
 * Main model class controlling search behaviours.
 *
 * SearchController uses this class to connect to database and get results of normal search, advanced search and to
 * construct category dropdown list.
 *
 * @package models
 * Include the database file
 */
require_once LIBRARY_PATH . DS . 'Database.php';

/**
 * This is the Search class.
 *
 * @access public
 */
class Search {
    /**
     * Normal search methods.
     *
     * @param unknown $opt      The options choosed by user(lost or find item)
     * @param unknown $keywords The keywords POSTed by user
     */
    public static function normalSearch( $opt, $keywords ) {
        if ( $opt  == 1 )
            $query = "select * from lostItem where 1=1";
        else
            $query = "select * from foundItem where 1=1";

        $param = array();

        if ( $keywords != "" ) {
            $query .= " AND (name like ?  OR description like ?) ";
            array_push( $param, "%{$keywords}%", "%{$keywords}%" );
        }

        $query .= " ORDER BY id ;";

        try {
            $database = Database::getInstance();

            $statement = $database->pdo->prepare( $query );
            $statement->execute( $param );
            $results = $statement->fetchAll( PDO::FETCH_OBJ );

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
        return $results;
    }

    /**
     * Advanced search method.
     *
     * @param int     $opt  The options choosed by user(lost or find item)
     * @param mixed   $data The data POSTed by user
     * @static
     * @return mixed
     * @access public
     */
    public static function advanceSearch( $opt , $data ) {

        if ( $opt  == 1 )
            $query = "select * from lostItem where 1=1";
        else
            $query = "select * from foundItem where 1=1";

        $param = array();

        // ... then, if the user has specified details
        // as an AND clause ...
        // desc
        if ( isset( $data['desc'] ) && $data['desc'] != "" ) {
            $query .= " AND name like ?  AND description like ? ";
            array_push( $param, "%{$data['desc']}%", "%{$data['desc']}%" );
        }

        // category
        if ( isset( $data['category'] ) && $data['category'] != "" ) {
            $query .= " AND categoryid = ? ";
            array_push( $param, $data['category'] );
        }

        // Period
        if ( isset( $data['start'] ) && isset( $data['end'] ) && $data['start'] != "" && $data['end'] != "" ) {
            $query .= " AND date between ? AND ? ";
            array_push( $param, $data['start'], $data['end'] );
        }
        // street
        if ( isset( $data['street'] ) && $data['street'] != "" ) {
            $query .= " AND street like ? ";
            array_push( $param, "%{$data['street']}%" );
        }
        // suburb
        if ( isset( $data['suburb'] ) && $data['suburb'] != "" ) {
            $query .= " AND suburb like ? ";
            array_push( $param, "%{$data['suburb']}%" );
        }
        // state
        if ( isset( $data['state'] ) && $data['state'] != "" ) {
            $query .= " AND state = ? ";
            array_push( $param, $data['state'] );
        }
        // postCode
        if ( isset( $data['postCode'] ) && $data['postCode'] != "" ) {
            $query .= " AND postCode = ? ";
            array_push( $param, $data['postCode'] );
        }

        // ... and then complete the query.
        $query .= " ORDER BY id ;";

        try {
            $database = Database::getInstance();

            $statement = $database->pdo->prepare( $query );
            $statement->execute( $param );
            $results = $statement->fetchAll( PDO::FETCH_OBJ );

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
        return $results;
    }

    /**
     * Construct the dropdown list for category.
     *
     * @static
     * @access public
     */
    public static function constructCategory() {
        $sql = 'SELECT DISTINCT id,categoryName FROM category order by id';
        try {
            $database = Database::getInstance();
            $result = $database->pdo->query( $sql, PDO::FETCH_OBJ );

            print "\n<select name=\"category\">";
            print "<option value=\"\">--Please select--</option>";
            foreach ( $result as $row ) {
                $categoryName = $row->categoryName;
                $id = $row->id;
                print "\n\t<option value=\"{$id}\">{$categoryName}</option>";
            }
            print "\n</select>";

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
    }
}
