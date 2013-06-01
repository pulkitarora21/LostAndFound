<?php
/**
 * File controlling behaviour of normal as well as advanced search.
 *
 * It retrieves all the data passed from the search form or from the url, calls appropriate function passing the
 * data, stores the retrieved data and display it.
 *
 * @package controller
 */
/**
 * Start the session.
 */
session_start();

require_once LIBRARY_PATH . DS . 'Template.php';
require_once APP_PATH . DS . 'models/Search.php';

/**
 * This is the SearchController class.
 *
 * @access public
 */
class SearchController {

    /**
     * construct a new instance of SearchController.
     *
     * @access public
     */
    public function __construct() {
        $this->template = new Template;
        $this->template->template_dir = APP_PATH . DS . 'views' . DS . 'search' . DS;
    }


    /**
     * Show the advanced search page.
     *
     * @acess public
     */
    public function index() {
        $this->template->display( 'search.php' );
    }


    /**
     * Show the normal search results.
     *
     * @access public
     */
    public function get() {
        if ( !isset( $_GET ) || empty( $_GET ) ) {
            header( "Location: /voodoo" );
            exit;
        }
        $opt = trim( $_GET['opt'] );
        $keywords = trim( $_GET['keywords'] );
        $this->template->results=Search::normalSearch( $opt , $keywords );
        $this->template->display( 'searchresult.php' );
    }

    /**
     * Show the advanced search results.
     *
     * @access public
     */
    public function obtain() {
        if ( !isset( $_GET ) || empty( $_GET ) ) {
            header( "Location: /voodoo" );
            exit;
        }

        $data = array(
            'desc' => trim( $_GET['desc'] ),
            'category' => trim( $_GET['category'] ),
            'start' => trim( $_GET['start'] ),
            'end' => trim( $_GET['end'] ),
            'street' => trim( $_GET['street'] ),
            'suburb' => trim( $_GET['suburb'] ),
            'state' => trim( $_GET['state'] ),
            'postCode' => trim( $_GET['postCode'] ),
        );

        $opt = trim( $_GET['opt'] );
        $this->template->results=Search::advanceSearch( $opt , $data );
        $this->template->display( 'searchresult.php' );
    }
}
