<?php
/**
 * Main model class controlling user behaviours.
 *
 * This class is used by controllers to validate the user data, store errors if existing, populate combobox of
 * security questions, send email with account activation link, send password notification, activate the user account
 * after the activation link has been clicked, update the user data, insert a row for the new user in the database,
 * delete lost and found items, show items posted by a user etc.
 *
 * @package models
 */
/**
 * Start the session
 */
session_start();
require_once LIBRARY_PATH . DS . 'Database.php';
require_once LIBRARY_PATH . DS . 'Mail.php';

/**
 * This is the User class.
 *
 * @access public
 */
class User {

    /**
     * If validation fails, errors are written to this variable.
     */
    private static $errors;

    private static $activeCode;

    /**
     * A method for validating the data
     *
     * @param array   $data An array of POSTed data.
     * @return bool Whether the data is valid or not.
     * @static
     */
    public static function validates( array &$data ) {
        $errors = array();

        // check first name
        if ( !preg_match( "/^[a-z ]+$/i", $data['fName'] ) ) {
            $errors['fName'] = 'Your first name must only be characters!';
        }
        if ( !isset( $data['fName'] ) || empty( $data['fName'] ) ) {
            $errors['fName'] = 'You must provide your first name!';
        }
        // only unset the first name data after checking for all errors
        if ( isset( $errors['fName'] ) ) {
            unset( $data['fName'] );
        }

        // check last name
        if ( !preg_match( "/^[a-z ]+$/i", $data['lName'] ) ) {
            $errors['lName'] = 'Your last name must only be characters!';
        }
        if ( !isset( $data['lName'] ) || empty( $data['lName'] ) ) {
            $errors['lName'] = 'You must provide your last name!';
        }
        // only unset the last name data after checking for all errors
        if ( isset( $errors['lName'] ) ) {
            unset( $data['lName'] );
        }

        //If the user is trying to update the details, no need to check this
        if ( !isset( $_SESSION['updateCheck'] ) ) {
            // check user email
            if ( !preg_match( "/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i", $data['email'] ) ) {
                $errors['email'] = 'Please enter your email in the correct format!';
            }

            if ( self::checkEmail( ( trim( $data['email'] ) ) ) ) {
                $errors['email'] = 'The user email has already been registered!';
            }
        }

        // only unset the email data after checking for all errors
        if ( isset( $errors['email'] ) ) {
            unset( $data['email'] );
        }

        //The reset password functionality is not included in the update user
        //page. So, checking if the source is update form
        if ( !isset( $_SESSION['updateCheck'] ) ) {
            // check password
            if ( strlen( $data['password1'] ) < 8 ) {
                $errors['password1'] = "At least 8 characters: letters, numbers and '_'!";
            }
            if ( strcmp( $data['password1'], $data['password2'] ) != 0 ) {
                $errors['password2'] = "Passwords doesn't match!";
            }
            // only unset the password data after checking for all errors
            if ( isset( $errors['password1'] ) ) {
                unset( $data['password1'] );
            }
            if ( isset( $errors['password2'] ) ) {
                unset( $data['password2'] );
            }
        }

        // check phone number
        if ( !empty( $data['phoneNo'] ) && !preg_match( "/^0[\d]{9}$/", $data['phoneNo'] ) ) {
            $errors['phoneNo'] = 'Please enter the phone number in the correct format!';
            unset( $data['phoneNo'] );
        }

        // check street number
        if ( !empty( $data['streetNo'] ) && !preg_match( "/^[\w-\/ ]+$/", $data['streetNo'] ) ) {
            $errors['streetNo'] = 'Please enter the street number in the correct format!';
            unset( $data['streetNo'] );
        }

        // check streetname
        if ( !empty( $data['streetName'] ) && !preg_match( "/^[a-z ]+$/i", $data['streetName'] ) ) {
            $errors['streetName'] = 'The street name must only be characters!';
            unset( $data['streetName'] );
        }

        // check suburb
        if ( !empty( $data['suburb'] ) && !preg_match( "/^[a-z ]+$/i", $data['suburb'] ) ) {
            $errors['suburb'] = 'The suburb must only be characters!';
            unset( $data['suburb'] );
        }

        // check post code
        if ( !empty( $data['postCode'] ) && !preg_match( "/^[\d]{4}$/", $data['postCode'] ) ) {
            $errors['postCode'] = 'The post code must be 4 didigts!';
            unset( $data['postCode'] );
        }

        // check security answer
        if ( !isset( $_SESSION['updateCheck'] ) ) {
            if ( !isset( $data['answer'] ) || empty( $data['answer'] ) ) {
                $errors['answer'] = 'You must prodive your security answer!';
                unset( $data['answer'] );
            }
        }

        self::$errors = $errors;

        if ( isset( $_SESSION['updateCheck'] ) ) {
            unset( $_SESSION['updateCheck'] );
        }

        if ( count( $errors ) ) {
            return false;
        }
        return true;
    }

    /**
     * Returns any validation errors.
     *
     * @return array An array of errors, or an empty array.
     */
    public static function errors() {
        return self::$errors;
    }

    /**
     * Check the uniqueness of user email.
     *
     * @param String  $email A string of POSTed email
     * @return bool Whether the user email is valid or not.
     * @access public
     * @static
     */
    public static function checkEmail( $email ) {
        $sql = 'SELECT email FROM user';
        $found = false;
        try {
            $database = Database::getInstance();
            $result = $database->pdo->query( $sql, PDO::FETCH_OBJ );
            foreach ( $result as $row ) {
                if ( strcasecmp( $row->email, $email ) == 0 ) {
                    $found = true;
                    break;
                }
            }
        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
        if ( $found == true )
            return true;
        else
            return false;
    }

    /**
     * Construct the dropdown list of serurity questions used in registration form.
     *
     * @access public
     * @static
     */
    public static function constructQuestion() {
        $sql = 'SELECT question FROM question ORDER BY question';
        try {
            $database = Database::getInstance();
            $result = $database->pdo->query( $sql, PDO::FETCH_OBJ );

            print "\n<select name=\"question\">";
            foreach ( $result as $row ) {
                $question = $row->question;
                print "\n\t<option value=\"{$question}\">{$question}</option>";
            }
            print "\n</select>";

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * generate active token for user (for activate via email)
     *
     * @access public
     * @static
     */
    public static function generateCode() {
        $id = uniqid( rand(), true );
        $randomCode = hash( "sha256", "{$id}" );
        $code = substr( $randomCode, 0 , 50 );
        self::$activeCode = $code;
    }

    /**
     * After registration without errors, the system will send a email to user to activate their account.
     *
     * @param String  $email A String of POSTed email
     * @param String  $name  The name of user
     * @access public
     * @static
     */
    public static function sendEmail( $email, $name ) {
        self::generateCode();

        $message = "Hi " . $name . ",\n\n Thanks for your registration!\n Please activate your account " .
            "by click this link: http://yallara.cs.rmit.edu.au/voodoo/users/activate/" .
            self::$activeCode . "!\n If you cannot click the above link, please copy the url to your web browser to activate the account!";

        $to =  $name ."<" . $email . ">";
        $subject = "Activate your account";
        $body = $message;
        self::smtpSend( $email, $to, $subject, $body );
    }

    /**
     * Send the new password to user.
     *
     * @param String  $email    A String of POSTed email
     * @param String  $password The new password set for user
     * @access public
     */
    public static function sendPassword( $email, $password ) {
        $message = "Hi,\nYour new password is " . $password . " .\n" .
            "Please change your password as soon as possible! Don't forget again!";

        $to =  $email;
        $subject = "New Passord";
        $body = $message;
        self::smtpSend( $email, $to, $subject, $body );
    }

    /**
     * Send the email by using smtp.
     *
     * @param String  $email   The email to be sent
     * @param String  $subject The subject of email to be set
     * @param String  $body    The body of email to be set
     * @param String  $to
     * @access private
     */
    private static function smtpSend( $email, $to, $subject, $body ) {
        $from = "Voodoo Admin <superAdmin@voodoo.com>";
        $host = "mail-auth.rmit.edu.au";
        $port = "465";
        $username = "s123456@student.rmit.edu.au";
        $password = "camillerui1102";

        $headers = array ( 'From' => $from,
            'To' => $to,
            'Subject' => $subject );
        $smtp = Mail::factory( 'smtp',
            array ( 'host' => $host,
                'port' => $port,
                'auth' => true,
                'username' => $username,
                'password' => $password ) );

        $mail = $smtp->send( $to, $headers, $body );
    }

    /**
     * Returns the activate code.
     *
     * @return String A string of activate code.
     * @access public
     * @static
     */
    public static function activeCode() {
        return self::$activeCode;
    }

    /**
     * Writes the new information to the user table, login table and answer table based on given data.
     *
     * @param array   $data The POSTed data.
     * @static
     * @access public
     */
    public static function create( array $data ) {

        $sql1  = "INSERT INTO user (email, fname, lname, streetNo, street, suburb,
               state, postcode, phone, dob, activateCode) VALUES
               (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sql2 = 'INSERT INTO login (email, type, password ) VALUES (?, ?, ?)';

        $sql3 = 'SELECT id FROM question WHERE question = ?';
        $sql4 = 'INSERT INTO answer (email, answer, id) VALUES (?, ?, ?)';

        $useremail = $data['email'];
        $password =  $data['password1'];
        $pwd_hash = hash( "sha256", "{$useremail}{$password}" );

        $values1 = array(
            $data['email'],
            $data['fName'],
            $data['lName'],
            $data['streetNo'],
            $data['streetName'],
            $data['suburb'],
            $data['state'],
            $data['postCode'],
            $data['phoneNo'],
            $data['dob'],
            $data['activateCode']
        );

        $values2 = array(
            $data['email'],
            $data['type']
        );
        array_push( $values2, $pwd_hash );

        $values3 = array(
            $data['question'],
        );

        $values4 = array (
            $data['email'],
            $data['answer']
        );

        try {
            $database = Database::getInstance();

            // insert information to the login table
            $statement2 = $database->pdo->prepare( $sql2 );
            $statement2->execute( $values2 );

            // insert information to the user table
            $statement1 = $database->pdo->prepare( $sql1 );
            $statement1->execute( $values1 );

            // get the id of question from question table
            $statement3 = $database->pdo->prepare( $sql3 );
            $statement3->execute( $values3 );
            $result = $statement3->fetch( PDO::FETCH_OBJ );
            array_push( $values4, $result->id );

            // insert information to the answer table
            $statement4 = $database->pdo->prepare( $sql4 );
            $statement4->execute( $values4 );

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * Activate the user account.
     *
     * @param unknown $code The code to be checked
     */
    public static function activateAccount( $code ) {
        $sql = 'UPDATE user SET isActivated = 1 WHERE activateCode = ?';
        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );

            $statement->bindValue( 1, $code, PDO::PARAM_STR );
            $statement->execute();

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * A method for retrieving user login information from the login table.
     *
     * @param String  $email the user email to be checked
     * @access public
     * @return mixed
     * @static
     */
    public static function retrieve( $email ) {

        $sql = 'SELECT * FROM login WHERE email = ?';

        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );

            $statement->bindValue( 1, $email, PDO::PARAM_STR );
            $statement->execute();

            // result is FALSE if no rows found
            $result = $statement->fetchAll( PDO::FETCH_OBJ );

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
     * A method for retrieving user information from the user table.
     *
     * @param unknown $email the user email to be checked
     */
    public static function getData( $email ) {
        $sql = 'SELECT * FROM user WHERE email = ?';

        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );

            $statement->bindValue( 1, $email, PDO::PARAM_STR );
            $statement->execute();

            $result = $statement->fetchAll( PDO::FETCH_OBJ );

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
     * Check whether the user has already activated the account.
     *
     * @param String  $email The email POSTed by user
     * @static
     * @return bool
     */
    public static function checkStatus( $email ) {
        $sql = 'SELECT * FROM user WHERE email = ?';
        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );

            $statement->bindValue( 1, $email, PDO::PARAM_STR );
            $statement->execute();

            // result is FALSE if no rows found
            $result = $statement->fetchAll( PDO::FETCH_OBJ );

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }

        if ( $result[0]->isActivated == true ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check the security question and answer of user.
     *
     * @param String  $email The email POSTed by user
     * @static
     * @return mixed
     * @access public
     */
    public static function verifySecurity( $email ) {

        $sql = 'SELECT question, answer FROM question, answer
              WHERE question.id = answer.id AND email = ?';
        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );

            $statement->bindValue( 1, $email, PDO::PARAM_STR );
            $statement->execute();

            // result is FALSE if no rows found
            $result = $statement->fetchAll( PDO::FETCH_OBJ );

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
     * Generate a new password for user.
     *
     * @param String|int $length The length of password
     * @access public
     * @static
     * @return String
     */
    public static function generatePwd( $length = 8 ) {
        $password = "";
        $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
        $maxlength = strlen( $possible );

        // check for length overflow and truncate if necessary
        if ( $length > $maxlength ) {
            $length = $maxlength;
        }
        // set up a counter for how many characters are in the password so far
        $i = 0;
        // add random characters to $password until $length is reached
        while ( $i < $length ) {
            // pick a random character from the possible ones
            $char = substr( $possible, mt_rand( 0, $maxlength-1 ), 1 );
            if ( !strstr( $password, $char ) ) {
                $password .= $char;
                $i++;
            }
        }
        return $password;
    }

    /**
     * Set the new password for user.
     *
     * @param String  $email    The email of user
     * @param String  $password The new password to be set
     * @static
     * @access public
     */
    public static function updatePwd( $email, $password ) {

        $pwd_hash = hash( "sha256", "{$email}{$password}" );
        $sql = 'UPDATE login SET password = ? WHERE email = ?';
        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );

            $statement->bindValue( 1, $pwd_hash, PDO::PARAM_STR );
            $statement->bindValue( 2, $email, PDO::PARAM_STR );
            $statement->execute();

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * Get all the lost itmes posted by user.
     *
     * @param String  $email The email of the user, stored in the sesssion.
     * @return mixed
     * @access public
     * @static
     */
    public static function showMyLostItems( $email ) {
        $sql = "SELECT * FROM lostItem, login
                WHERE lostItem.email = login.email AND lostItem.email = ?";
        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );

            $statement->bindValue( 1, $email, PDO::PARAM_STR );
            $statement->execute();
            $results = $statement->fetchAll( PDO::FETCH_OBJ );

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
        return $results;
    }

    public static function showMyUnSolvedLostItems( $email ) {
        $sql = "SELECT * FROM lostItem, login
                WHERE lostItem.email = login.email AND lostItem.email = ? AND lostItem.isSolved =0";
        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );

            $statement->bindValue( 1, $email, PDO::PARAM_STR );
            $statement->execute();
            $results = $statement->fetchAll( PDO::FETCH_OBJ );

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
        return $results;
    }

    /**
     * Get all the found itmes posted by user.
     *
     * @param String  $email The email of the user, stored in the sesssion.
     * @static
     * @access public
     * @return mixed
     */
    public static function showMyFoundItems( $email ) {
        $sql = "SELECT * FROM foundItem, login
                WHERE foundItem.email = login.email AND foundItem.email = ?";
        try {
            $database = Database::getInstance();
            $statement = $database->pdo->prepare( $sql );

            $statement->bindValue( 1, $email, PDO::PARAM_STR );
            $statement->execute();
            $results = $statement->fetchAll( PDO::FETCH_OBJ );

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
        return $results;
    }

    /**
     * Delete the lost item posted by the user, importantly delete the records in matchedItem first.
     *
     * @param String  $id The item id.
     * @access publice
     * @static
     */
    public static function deleteLostItem( $id ) {
        $sql3 = "UPDATE foundItem SET isSolved = 0 WHERE isSolved = ?";
        $sql1 = "DELETE FROM matchedItem WHERE lostId = ?";
        $sql2 = "DELETE FROM lostItem WHERE id = ?";

        try {
            $database = Database::getInstance();

            $statement = $database->pdo->prepare( $sql3 );
            $statement->execute( array( $id ) );

            $statement1 = $database->pdo->prepare( $sql1 );
            $statement1->bindValue( 1, $id, PDO::PARAM_STR );
            $statement1->execute();

            $statement2 = $database->pdo->prepare( $sql2 );
            $statement2->bindValue( 1, $id, PDO::PARAM_STR );
            $statement2->execute();

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * Delete the found item posted by the user, importantly delete the records in matchedItem first.
     *
     * @param String  $id The item id.
     * @access public
     * @static
     */
    public static function deleteFoundItem( $id ) {
        $sql3 = "UPDATE lostItem SET isSolved = 0 WHERE isSolved = ?";
        $sql1 = "DELETE FROM matchedItem WHERE foundId = ?";
        $sql2 = "DELETE FROM foundItem WHERE id = ?";

        try {
            $database = Database::getInstance();

            $statement = $database->pdo->prepare( $sql3 );
            $statement->execute( array( $id ) );

            $statement1 = $database->pdo->prepare( $sql1 );
            $statement1->bindValue( 1, $id, PDO::PARAM_STR );
            $statement1->execute();

            $statement2 = $database->pdo->prepare( $sql2 );
            $statement2->bindValue( 1, $id, PDO::PARAM_STR );
            $statement2->execute();

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * Updates an existing row in the users table based on given data.
     *
     * @param int     $id   The row id of the user to update.
     * @param array   $data The POSTed data.
     * @return mixed Whether update was successful or not.
     * @access public
     * @static
     */
    public static function update( $email, array $data ) {
        // assumes all new users will not be admin
        $sql  = 'UPDATE user
            SET fname = ?, lname = ?, streetNo = ?,
            street = ?, suburb = ?, state = ?, postcode = ?, phone = ?, dob = ?
            WHERE email = ?';

        $values = array(
            $data['fName'],
            $data['lName'],
            $data['streetNo'],
            $data['streetName'],
            $data['suburb'],
            $data['state'],
            $data['postCode'],
            $data['phoneNo'],
            $data['dob'],
            $email
        );

        try {
            $database = Database::getInstance();

            $statement = $database->pdo->prepare( $sql );
            $return = $statement->execute( $values );

            $database->pdo = null;
        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
    }
}
