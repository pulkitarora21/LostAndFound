<?php
/**
 * File controlling connection to the database.
 *
 * The Database class is a template for conneting to the databse and getting the singleton
 * instance of the database.
 *
 * @package libraries
 * @author Referenced from showvotes prodived by Donal
 */
/**
 *
 *
 * @access public
 */
class Database {

    /**
     * Define the static variables: host, prot, databaseName, username and password.
     *
     * @access private
     */
    private static $db_host       = 'yallara.cs.rmit.edu.au';
    private static $db_port       = '56365';
    private static $db_name       = 'lostAndFound';
    private static $db_username   = 'admin';
    private static $db_password   = 'P@ssw0rd';
    private static $instance;

    public $dsn;
    public $pdo;

    /**
     * Use pdo to connect to the database and catch the exceptions.
     *
     * @access private
     */
    private function __construct() {
        $this->dsn = 'mysql:host=' . self::$db_host . ';port=' . self::$db_port .  ';dbname=' . self::$db_name;
        try {
            $this->pdo = new PDO( $this->dsn, self::$db_username, self::$db_password );
            $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch ( PDOException $e ) {
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * Return the singleton instance of databse.
     *
     * @access public
     * @return Database | mixed
     */
    public static function getInstance() {
        if ( !self::$instance ) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

}
