<?php
/**
 * File getting lost items from the database and to display them.
 *
 * This is file is mainly used to construct an object of template and set the directory path to views-> lost. It is
 * also used to display all lost items or selected lost items.
 *
 * @package controllers
 */

/**
 * Start the session
 */
session_start();

require_once LIBRARY_PATH . DS . 'Template.php';
require_once APP_PATH . DS . 'models/Lost.php';

/**
 *
 *
 * @access public
 */
class LostController {
    private $template;

    /**
     *
     *
     * @access public
     */
    public function __construct() {
        $this->template = new Template();
        $this->template->template_dir = APP_PATH . DS . 'views' . DS . 'lost' . DS;
    }

    /**
     * index(home) page for found item
     * show all
     *
     * @access public
     */
    public function index() {
        $this->template->allLostItems = Lost::showAll();
        $this->template->display( 'index.html.php' );
    }


    /**
     * show the specific item for this $id
     *
     * @access public
     * @param String  $id
     */
    public function show( $id ) {
        $this->template->contactInfo=Lost::getContactInfo( $id );
        $this->template->lostItem=Lost::showById( $id );
        $this->template->display( 'show.html.php' );
    }

}
