<?php
/**
 * File looking after user account related activities.
 *
 * The class redirect users to registration page for them to register. It shows the forgot password page to reset
 * password. If user has posted the registration data, than adds a new row in the user table in the database and
 * shows the registration confirmation page. This file also help users to activate their account by clicking on the
 * link sent in the email and generate a new password. There some more functionalities looked after by the same file.
 *
 * @package controller
 */
/**
 * Start the session.
 */
session_start();

require_once LIBRARY_PATH . DS . 'Template.php';
require_once APP_PATH . DS . 'models/User.php';

/**
 * This is the UsersController class.
 * It will exercise the corresponding actions according to the user events.
 *
 * @access public
 */
class UsersController {

    /**
     * construct a new instance of UsersController.
     *
     * @access public
     */
    public function __construct() {
        $this->template = new Template;
        $this->template->template_dir = APP_PATH . DS . 'views' . DS . 'users' . DS;
    }

    /**
     * Show the register page.
     *
     * @access public
     */
    public function add() {
        // store all the errors of registration to template
        if ( isset( $_SESSION['user'] ) ) {
            $this->template->user = $_SESSION['user'];
            unset( $_SESSION['user'] );
        }
        if ( isset( $_SESSION['registerErrors'] ) ) {
            $this->template->errors = $_SESSION['registerErrors'];
            unset( $_SESSION['registerErrors'] );
        }

        $this->template->display( 'register.php' );
    }

    /**
     * Show the forgot password page.
     *
     * @access public
     */
    public function forget() {
        if ( isset( $_SESSION['GetPwdError'] ) ) {
            $this->template->error = $_SESSION['GetPwdError'];
            unset( $_SESSION['GetPwdError'] );
        }

        if ( isset( $_SESSION['email'] ) ) {
            $this->template->email = $_SESSION['email'];
            unset( $_SESSION['email'] );
        }

        $this->template->display( 'forgotPassword.php' );
    }

    /**
     * Create a new user.
     *
     * @access public
     */
    public function create() {
        if ( !isset( $_POST ) || empty( $_POST ) ) {
            header( "Location: /voodoo/users/new" );
            exit;
        }

        // get the user data
        $data1 = array(
            'fName' => trim( $_POST['fName'] ),
            'lName' => trim( $_POST['lName'] ),
            'email' => strtolower( trim( $_POST['email'] ) ),
            'password1' => trim( $_POST['password1'] ),
            'password2' => trim( $_POST['password2'] ),
            'phoneNo' => trim( $_POST['phoneNo'] ),
            'dob' => trim( $_POST['dob'] ),
            'streetNo' => trim( $_POST['streetNo'] ),
            'streetName' => trim( $_POST['streetName'] ),
            'suburb' => trim( $_POST['suburb'] ),
            'state' => $_POST['state'],
            'postCode' => trim( $_POST['postCode'] ),
            'question' => $_POST['question'],
            'answer' => trim( $_POST['answer'] ),
            'type' => "u"
        );

        // validate the userdata
        // false, redirect to the register page and show the possible errors
        if ( !User::validates( $data1 ) ) {
            $_SESSION['user'] = $data1;
            $_SESSION['registerErrors'] = User::errors();
            header( "Location: /voodoo/users/new" );
            exit;
        }

        // success, send the user an email to avtivate the account
        User::sendEmail( $data1['email'], $data1['fName'] );
        $data2 = array ( 'activateCode' => User::activeCode() );
        $data = array_merge( $data1, $data2 );

        // create the user information to the database
        User::create( $data );

        // this is for popup
        $_SESSION['newRegistration'] = true;
        header( "Location: /voodoo" );
        exit;
    }

    /**
     * Activate the user account.
     *
     * @param mixed   $code the unique code to be set
     * @access public
     */
    public function activate( $code ) {
        // activate the account
        User::activateAccount( $code );

        // this is for popup
        $_SESSION['newActivate'] = true;
        header( "Location: /voodoo/session/new" );
        exit;

    }

    /**
     * Generate the new password for users.
     *
     * @access public
     */
    public function generate() {
        if ( !isset( $_POST ) || empty( $_POST ) ) {
            header( "Location: /voodoo/users/forgot_password" );
            exit;
        }

        $email = strtolower( trim( $_POST['useremail'] ) );
        $question = $_POST['question'];
        $answer = trim( $_POST['answer'] );

        if ( !$user = User::verifySecurity( $email ) ) {
            // user doesn't exist
            $_SESSION['GetPwdError'] = "Incorrect user email!";
            header( "Location: /voodoo/users/forgot_password" );
            exit;
        }else if ( $question != $user->question || $answer != $user->answer ) {
                // question and answer doesn't match
                $_SESSION['GetPwdError'] = "The question and answer doesn't match!";
                $_SESSION['email'] = $email;
                header( "Location: /voodoo/users/forgot_password" );
                exit;
            }

        $password = User::generatePwd();
        User::sendPassword( $email, $password );
        User::updatePwd( $email, $password );

        $_SESSION['newForget']=true;
        header( "Location: /voodoo/session/new" );
    }

    /**
     * Show all the items posted by the user.
     *
     * @access public
     */
    public function show() {
        if ( !isset( $_SESSION['user']['email'] ) ) {
            header( "Location: /voodoo/session/new" );
            exit;
        }
        $email = $_SESSION['user']['email'];
        $this->template->lostItems=User::showMyLostItems( $email );
        $this->template->foundItems=User::showMyFoundItems( $email );
        $this->template->display( 'itemResults.php' );
    }

    /**
     * Delete the lost item posted by user in his/her account.
     *
     * @access public
     */
    public function deleteLost() {
        $id = trim( $_POST['id'] );
        User::deleteLostItem( $id );
        header( "Location:/voodoo/users/showMyItem" );
    }

    /**
     * Delete the found item posted by user in his/her account.
     *
     * @access public
     */
    public function deleteFound() {
        $id = trim( $_POST['id'] );
        User::deleteFoundItem( $id );
        header( "Location:/voodoo/users/showMyItem" );
    }

    /**
     * Dispay the change password page.
     *
     * @access public
     */
    public function change() {
        if ( !isset( $_SESSION['user']['email'] ) ) {
            header( "Location: /voodoo/session/new" );
            exit;
        }
        if ( isset( $_SESSION['session']['error'] ) ) {
            $this->template->error = $_SESSION['session']['error'];
            unset( $_SESSION['session']['error'] );
        }
        if ( isset( $_SESSION['password'] ) ) {
            $this->template->password = $_SESSION['password'];
            unset( $_SESSION['password'] );
        }
        $this->template->display( 'changePassword.php' );
    }

    /**
     * Change the password of user.
     *
     * @access public
     */
    public function modify() {
        $email = $_SESSION['user']['email'];
        $password =  trim( $_POST['oldPwd'] );
        $pwd_hash = hash( "sha256", "{$email}{$password}" );

        $newPwd1 =  trim( $_POST['newPwd'] );
        $newPwd2 =  trim( $_POST['confirmNewPwd'] );

        $user = User::retrieve( $email );
        if ( $pwd_hash != $user->password ) {
            $_SESSION['session']['error'] = "Incorrect current password!";
            header( "Location: /voodoo/users/change_password" );
            exit;
        }
        if ( strlen( $newPwd1 ) < 8 ) {
            $_SESSION['session']['error'] = " New Password: At least 8 characters!";
            $_SESSION['password'] = $password;
            header( "Location: /voodoo/users/change_password" );
            exit;
        }
        if ( strcmp( $newPwd1, $newPwd2 ) != 0 ) {
            $_SESSION['session']['error'] = "New Passwords doesn't match!";
            $_SESSION['password'] = $password;
            header( "Location: /voodoo/users/change_password" );
            exit;
        }

        User::updatePwd( $email, $newPwd1 );
        header( "Location: /voodoo" );
        exit;
    }


    /*
    * show profile of the user.
    * @access public
    */
    public function index() {
        // must be logged in to access this page
        //if the user session variable is not existing
        if ( !isset( $_SESSION['user'] ) ) {
            //redirect back to the login page
            header( "Location: /voodoo/session/new" );
            exit;
        }

        if ( $_SESSION['user']['type'] == 'u' ) {
            // get the user with email = $email
            $email = $_SESSION['user']['email'];
        } else {
            $email = $_SESSION['editUser']->email;
        }

        $user = User::getData( $email );

        //If the user exists, create template variable $user
        if ( count( $user ) == 1 ) {
            $this->template->user = $user;
        }
        //If the user doesn't exist, create template variable passing email
        else if ( count( $user ) == 0 ) {
                $this->template->email = $email;
            }

        //Display show.html.php
        $this->template->display( 'index.html.php' );
    }


    /*
   * edit profile of the user
   * @access public
   */
    public function edit() {
        // must be logged in to access this page
        if ( !isset( $_SESSION['user'] ) ) {
            //redirect back to the login page
            header( "Location: /voodoo/session/new" );
            exit;
        }

        if ( $_SESSION['user']['type'] == 'u' ) {
            $email = $_SESSION['user']['email'];
        } else {
            $email = $_SESSION['editUser']->email;
        }

        $user = User::getData( $email );
        //create a new template variable and assign the user reference to it
        $this->template->user = $user;

        if ( isset( $_SESSION['user']['errors'] ) ) {
            $this->template->errors = $_SESSION['user']['errors'];
            unset( $_SESSION['user']['errors'] );
        }

        //If everything is successful call the display function and pass edit.html.php
        $this->template->display( 'edit.html.php' );
    }

    /* processing the post form of editing user profile
   * @access public
   */
    public function update() {
        // must be logged in to access this page
        if ( !isset( $_SESSION['user'] ) ) {
            //redirect back to the login page
            header( "Location: /voodoo/session/new" );
            exit;
        }

        if ( $_SESSION['user']['type'] == 'u' ) {
            $email = $_SESSION['user']['email'];
        } else {
            $email = $_SESSION['editUser']->email;
        }

        // must have some POSTed data
        // could check for referer here
        if ( !isset( $_POST ) || empty( $_POST ) ) {
            header( "Location: /voodoo/users" );
            exit;
        }

        $values = array(
            'fName' => trim( $_POST['fName'] ),
            'lName' =>trim( $_POST['lName'] ),
            'streetNo' => trim( $_POST['streetNo'] ),
            'streetName' => trim( $_POST['streetName'] ),
            'suburb' => trim( $_POST['suburb'] ),
            'state' => trim( $_POST['state'] ),
            'postCode' => trim( $_POST['postCode'] ),
            'phoneNo' => trim( $_POST['phoneNo'] ),
            'dob' => trim( $_POST['dob'] )
        );

        if ( !User::validates( $values ) ) {
            // store errors in session and redirect
            $_SESSION['user']['errors'] = User::errors();
            header( "Location: /voodoo/users/edit" );
            exit;
        }

        // update user
        // redirect to user's show page
        User::update( $email, $values );
        $_SESSION['updateSuccessful'] = 'true';
        header( "Location: /voodoo/users" );
        exit;
    }
}
