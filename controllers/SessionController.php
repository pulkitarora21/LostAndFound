<?php
/**
 * File looking after creating, adding and destroying sessions for user.
 *
 * The class checks if the user session is existing. If it is not, then redirecting user to login. It compares
 * username, password and if they are successful create a new session. If the user wants, it also destroys the
 * session.
 *
 * @package controller
 */
/**
 * Start the session.
 */
session_start();

require_once LIBRARY_PATH . DS . 'Template.php';
require_once APP_PATH . DS . 'models/User.php';

class SessionController {

    /**
     *
     *
     * @access public
     */
    public function __construct() {
        $this->template = new Template;
        $this->template->template_dir = APP_PATH . DS . 'views' . DS . 'session' . DS;
    }

    /**
     *
     *
     * @access public
     */
    public function add() {
        if ( isset( $_SESSION['user']['email'] ) ) {
            header( "Location: /voodoo/" );

            exit;
        }

        if ( isset( $_SESSION['session']['error'] ) ) {
            $this->template->error = $_SESSION['session']['error'];
            unset( $_SESSION['session']['error'] );
        }
        $this->template->display( 'login.php' );
    }

    /**
     *
     *
     * @access public
     */
    public function create() {

        $userEmail = strtolower( trim( $_POST['useremail'] ) );
        $password =  trim( $_POST['password'] );
        // get username and password
        // and validate them against values in db
        if ( !$user = User::retrieve( $userEmail ) ) {
            // user doesn't exist
            // redirect back to login page
            $_SESSION['session']['error'] = "Incorrect user email or password!";
            header( "Location: /voodoo/session/new" );

            exit;
        }

        $pwd_hash = hash( "sha256", "{$userEmail}{$password}" );
        if ( $pwd_hash != $user->password ) {
            // password is wrong
            // redirect back to login page
            $_SESSION['session']['error'] = "Incorrect user email or password!";

            header( "Location: /voodoo/session/new" );
            exit;
        }

        if ( !User::checkStatus( $userEmail ) ) {
            // user has not activated the account
            $_SESSION['session']['error'] = "Please activate your account first!";
            header( "Location: /voodoo/session/new" );
            exit;
        }

        // credentials are correct
        // add user to session
        // redirect to users show page
        $_SESSION['user']['email'] = $user->email;
        $_SESSION['user']['type'] = $user->type;

        // this is for popup
        $_SESSION['newLogin'] = true;
        header( "Location: /voodoo" );
        exit;
    }

    /**
     *
     *
     * @access public
     */
    public function destroy() {
        $_SESSION = array();
        if ( ini_get( 'session.use_cookies' ) ) {
            $params = session_get_cookie_params();
            setcookie( session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();

        header( "Location: /voodoo", false );

        exit;
    }
}
