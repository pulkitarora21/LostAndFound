<?php
/**
 * File controlling all of the behaviours of admin
 *
 * This class contains collection of functions to list all users, block, unblock and
 * edit users.
 *
 * @package controllers
 */

/**
 * Include some model and template files
 */
require_once LIBRARY_PATH . DS . 'Template.php';
require_once APP_PATH . DS . 'models/User.php';
require_once APP_PATH . DS . 'models/Admin.php';

/**
 *
 *
 * @access public
 */
class AdminController {

    /**
     *
     *
     * @access public
     */
    public function __construct() {
        $this->template = new Template;
        $this->template->template_dir = APP_PATH . DS . 'views' . DS . 'admin' . DS;
    }

    /**
     * List all users in database
     *
     * @access public
     */
    public function listUsers() {
        if ( !isset( $_SESSION['user']['email'] ) ) {
            header( "Location: /voodoo/session/new" );
            exit;
        }

        if ( $_SESSION['user']['type'] != 'a' ) {
            header( "Location: /voodoo" );
            exit;
        }

        $this->template->allUsers = Admin::getUsers();
        $this->template->display( 'listUsers.php' );
    }

    /**
     * Block malicious user
     *
     * Bloacked user will not be able to login after this operation
     *
     * @access public
     */
    public function blockUser() {
        if ( !isset( $_SESSION['user']['email'] ) ) {
            header( "Location: /voodoo/session/new" );
            exit;
        }

        if ( $_SESSION['user']['type'] != 'a' ) {
            header( "Location: /voodoo" );
            exit;
        }

        $email = trim( $_POST['email'] );
        Admin::blockUser( $email );
        header( "Location: /voodoo/admin/listUsers" );
    }

    /**
     * Unblock malicious user
     * User will receive email with new activation code before they are re-activated
     *
     * @access public
     */
    public function unblockUser() {
        if ( !isset( $_SESSION['user']['email'] ) ) {
            header( "Location: /voodoo/session/new" );
            exit;
        }

        if ( $_SESSION['user']['type'] != 'a' ) {
            header( "Location: /voodoo" );
            exit;
        }

        $email = trim( $_POST['email'] );
        $name = trim( $_POST['fname'] );
        Admin::unblockUser( $email, $name );
        header( "Location: /voodoo/admin/listUsers" );
    }

    /**
     * Edit user info
     *
     * @access public
     */
    public function editUser() {
        $email = trim( $_POST['email'] );
        $user = User::getData( $email );

        $_SESSION['editUser'] = $user;
        header( "Location: /voodoo/users/edit" );
    }
}
