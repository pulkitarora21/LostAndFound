<?php
/**
 * File pointing to views->error and to display 404 page.
 *
 * This is file is mainly used to construct an object of template and set the directory to views-> error. It is also
 * used for displaying 404 page.
 *
 * @package controllers
 */

/**
 * Defining a constant that is pointing to Template.php.
 */
require_once LIBRARY_PATH . DS . 'Template.php';

/**
 *
 *
 * @access public
 */
class ErrorController {

    /**
     *
     *
     * @access public
     */
    public function __construct() {
        $this->template = new Template;
        $this->template->template_dir = APP_PATH . DS . 'views' . DS . 'error' . DS;
    }

    /**
     *
     *
     * @access public
     */
    public function error() {
        $this->template->display( '404.html.php' );
    }
}
