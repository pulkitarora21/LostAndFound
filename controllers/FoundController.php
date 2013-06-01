<?php
/**
 * File getting items from the database and to display them.
 *
 * This is file is mainly used to construct an object of template and set the directory
 * path to views-> found. It is * also used to display all items or selected items.
 *
 * @package controllers
 */

/**
 * Start the session
 */
session_start();

require_once LIBRARY_PATH . DS . 'Template.php';
require_once APP_PATH . DS . 'models/Found.php';
require_once APP_PATH . DS . 'models/User.php';

/**
 *
 *
 * @access public
 */
class FoundController {
    private $template;

    /**
     *
     *
     * @access public
     */
    public function __construct() {
        $this->template = new Template();
        $this->template->template_dir = APP_PATH . DS . 'views' . DS . 'found' . DS;
    }

    /**
     * index(home) page for found item
     * show all
     *
     * @access public
     */
    public function index() {
        $this->template->allFoundItems = Found::showAll();
        $this->template->display( 'index.html.php' );
    }


    /**
     * show the specific item for this $id
     *
     * @access public
     * @param String  $id
     */
    public function show( $id ) {
        $this->template->contactInfo = Found::getContactInfo( $id );
        $this->template->foundItem = Found::showById( $id );

        if ( isset( $_SESSION['user']['email'] ) && $this->template->foundItem['isSolved'] ==0 ) {
            $this->template->myLostItem = User::showMyUnSolvedLostItems( $_SESSION['user']['email'] );
        }

        $this->template->display( 'show.html.php' );
    }

    /**
     * match page for found item for processing a post form
     *
     * @access public
     */
    public function match() {
        if ( isset( $_POST['submit'] ) && !empty( $_POST['submit'] ) ) {
            Found::match( $_POST['lost'], $_POST['found'] );
        } else {
            // in case some how POST method get problem, malicious user attack
            header( "Location: /voodoo/" );
            exit;
        }
        header( "Location: /voodoo/found/{$_POST['found']}" );
        exit;
    }
}
