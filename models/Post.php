<?php
/**
 * A multipurpose class, but mainly used for error and data validation purposes.
 *
 * This class is used to validate item data, store errors if needed.
 * In addition to these, it contains collection of some functinos,
 * used by different controllers.
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

class Post {

    /**
     * this error info is for validation on Post page
     */
    private static $errors;

    /**
     *
     *
     * @access public
     * @param array   $data
     * @return boolean
     * @static
     */
    public static function validates( array &$data ) {
        $errors = array();

        if ( !isset( $data['itemName'] ) || empty( $data['itemName'] ) ) {
            $errors['itemName'] = 'You must provide an item name!';
            unset( $data['itemName'] );
        }

        if ( $data['type'] != "lost" && $data['type'] != "found" ) {
            $errors['type'] = 'You must provide an proper item type';
            unset( $data['type'] );
        }

        if ( $data['category'] > count( self::getCategory() ) || $data['category'] < 1 ) {
            $errors['category'] = 'You must select an proper category';
            unset( $data['category'] );
        }

        if ( !isset( $data['date'] ) || empty( $data['date'] ) ) {
            $errors['date'] = 'You must provide an proper date';
            unset( $data['date'] );
        }

        if ( !isset( $data['description'] ) || empty( $data['description'] ) ) {
            $errors['description'] = 'You must provide an description';
        } else if ( strlen( $data['description'] ) > 1000 ) {
                $errors['description'] = 'description has to less then 1000';
            }
        if ( isset( $errors['description'] ) ) {
            unset( $data['description'] );
        }

        if ( !isset( $data['state'] ) || empty( $data['state'] ) || $data['state'] == "0" ) {
            $errors['state'] = 'You must select an proper state';
            unset( $data['state'] );
        }

        if ( !preg_match( "/^[a-z ]+$/i", $data['suburb'] ) ) {
            $errors['suburb'] = 'The suburb must only be characters!';
            unset( $data['suburb'] );
        }

        if ( !empty( $data['postCode'] ) && !preg_match( "/^[\d]{4}$/", $data['postCode'] ) ) {
            $errors['postCode'] = 'The post code must be 4 didigts!';
            unset( $data['postCode'] );
        }

        if ( strlen( $data['image']['name'] )>1 ) {
            $data['image']['name'] = str_replace( "#", "No.", $data['image']['name'] );
            $data['image']['name'] = str_replace( "$", "Dollar", $data['image']['name'] );
            $data['image']['name'] = str_replace( "%", "Percent", $data['image']['name'] );
            $data['image']['name'] = str_replace( "^", "", $data['image']['name'] );
            $data['image']['name'] = str_replace( "&", "and", $data['image']['name'] );
            $data['image']['name'] = str_replace( "*", "", $data['image']['name'] );
            $data['image']['name'] = str_replace( "?", "", $data['image']['name'] );

            if ( $data['image']['type'] !='image/jpeg' && $data['image']['type'] !='image/png'
                && $data['image']['type'] !='image/bmp' && $data['image']['type'] !='image/gif' ) {
                $errors['image'] = 'image type has to be one of jpeg, png, bmp and gif';
            }

            if ( $data['image']['size'] >999999 ) {
                $errors['image'] = 'The image is too large, should less then 1MB';
            }
        }

        if ( self::isDuplicateImage( $data['image']['name'] ) ) {
            $errors['image'] = 'Duplicated image name';
        } else if ( strlen( $data['image']['name'] ) > 20 ) {
                $errors['image'] = 'Could you make a shorter-named image file ???';
            }

        if ( isset( $errors['image'] ) ) {
            unset( $data['image'] );
        }

        self::$errors =$errors;
        if ( count( $errors ) ) {
            return false;
        }
        return true;
    }

    /**
     *
     *
     * @access public
     * @static
     * @return mixed
     */
    public static function errors() {
        return self::$errors;
    }

    /**
     * Checking for duplicate image in system
     *
     * @access public
     * @static
     * @return boolean
     */
    public static function isDuplicateImage( $imageName ) {
        $sql1 = "SELECT count(*) AS duplicate FROM `foundItem` WHERE image= ?";
        $sql2 = "SELECT count(*) AS duplicate FROM `lostItem` WHERE image= ?";
        $values = array( $imageName );
        try {
            $database = Database::getInstance();

            $statement = $database->pdo->prepare( $sql1 );
            $statement->execute( $values );
            $result1 = $statement->fetchAll( PDO::FETCH_ASSOC );

            $statement = $database->pdo->prepare( $sql2 );
            $statement->execute( $values );
            $result2 = $statement->fetchAll( PDO::FETCH_ASSOC );

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }

        if ( $result1[0]['duplicate'] == "0" && $result2[0]['duplicate'] == "0" ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     *
     *
     * @access public
     * @static
     * @return mixed
     */
    public static function getCategory() {
        $sql = 'SELECT `id`, `categoryName` FROM `category`';
        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );
            $statement->execute( null );
            $result = $statement->fetchAll( PDO::FETCH_OBJ );
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
     * @param mixed   $table
     * @return array
     * @static
     */
    public static function getMaxId( $table ) {
        $sql = 'SELECT MAX(id) as max FROM `'.$table.'`';
        $lockTable = "LOCK TABLES $table write";
        try {
            $database = Database::getInstance();

            $statement = $database->pdo->prepare( $lockTable );
            $statement->execute( null );

            $statement = $database->pdo->prepare( $sql );
            $statement->execute( null );

            $max= $statement->fetchAll( PDO::FETCH_ASSOC );

            $statement = $database->pdo->prepare( "UNLOCK TABLES" );
            $statement->execute( null );
        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
        return $max[0]['max'];
    }

    /**
     *
     *
     * @access public
     * @param array|mixed $data
     * @return mixed
     * @static
     */
    public static function create( array $data ) {
        $image= strlen( $data['image']['name'] ) >3 ? $data['image']['name']: "default.jpg";
        $result=array();
        $postValues = array(
            $data['itemName'],
            $data['date'],
            $data['description'],
            $data['street'],
            $data['suburb'],
            $data['state'],
            $data['postCode'],
            $image,
            $data['category'],
            $_SESSION['user']['email'],
            0
        );

        $searchValues = array( $data['category'] , $data['state'],
            $data['suburb'], $data['date'] );
        if ( $data['type']=='found' ) {
            $latestId=self::getMaxId( 'foundItem' ) + 1;
            $sqlPost = "INSERT INTO `foundItem` (name, date, description, street,
                suburb, state, postcode, image, categoryId, email, isSolved)
                VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $sqlSearch = "SELECT id FROM `lostItem` WHERE categoryId = ?
                AND state = ? AND suburb =? AND date <= CAST(? AS DATE) AND isSolved !=0";
        } else if ( $data['type']=='lost' ) {
                $latestId=self::getMaxId( 'lostItem' ) + 1;
                $sqlPost ="INSERT INTO `lostItem` (name, date, description,
                    street, suburb, state, postcode, image, categoryId, email, isSolved)
                    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $sqlSearch = "SELECT id FROM `foundItem` WHERE categoryId = ?
                    AND state = ? AND suburb =? AND date >= CAST(? AS DATE) AND isSolved !=0";
            } else {
            echo "warning malicious user attack!!!";
            exit;
        }

        try {
            $database = Database::getInstance();

            $statement = $database->pdo->prepare( $sqlPost );
            $statement->execute( $postValues );

            $statement = $database->pdo->prepare( $sqlSearch );
            $statement->execute( $searchValues );
            $result= $statement->fetchALL( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }

        // to save potentiality matched item into matchedItem table
        if ( count( $result ) != 0 ) {
            $sqlMatch="INSERT INTO `matchedItem` VALUES (?, ?, ?)";
            $matchValues=array();
            try {
                if ( $data['type']=='found' ) {
                    for ( $i = 0; $i < count( $result ); $i++ ) {
                        $matchValues=array( $result[$i]['id'], $latestId, 0 );
                        $statement = $database->pdo->prepare( $sqlMatch );
                        $statement->execute( $matchValues );
                    }
                } else if ( $data['type']=='lost' ) {
                        for ( $i = 0; $i < count( $result ); $i++ ) {
                            $matchValues=array( $latestId, $result[$i]['id'], 0 );
                            $statement = $database->pdo->prepare( $sqlMatch );
                            $statement->execute( $matchValues );
                        }
                    }
            } catch ( PDOException $e ) {
                var_dump( $matchValues );
                echo $e->getMessage();
                exit;
            }
        }
    }
}
