<?php
/**
 * The homepage controller file.
 *
 * This is file is mainly used to construct an object of template and set the directory path to views-> home. It is
 * also used to display index.html.php.
 *
 * @package controllers
 */

/**
 * Include the files
 */
require_once LIBRARY_PATH . DS . 'Template.php';
require_once APP_PATH . DS . 'models/Home.php';

/**
 *
 *
 * @access public
 */
class HomeController {

    /**
     *
     *
     * @access public
     */
    public function __construct() {
        $this->template = new Template;
        $this->template->template_dir = APP_PATH . DS . 'views' . DS . 'home' . DS;
    }

    /**
     * display home page
     *
     * @access public
     */
    public function index() {
        $this->template->lostItems = Home::showLost();
        $this->template->foundItems = Home::showFound();
        $this->template->display( 'index.html.php' );
    }

    /**
     * display privacy page
     *
     * @access public
     */
    public function privacy() {
        $this->template->display( 'privacy.html.php' );
    }

    /**
     * display aboutUs page
     *
     * @access public
     */
    public function aboutUs() {
        $this->template->display( 'aboutUs.html.php' );
    }

    /**
     * display contactUs page
     *
     * @access public
     */
    public function contactUs() {
        $this->template->display( 'contactUs.html.php' );
    }

    /**
     * display sitemap page
     *
     * @access public
     */
    public function sitemap() {
        $this->template->display( 'sitemap.html.php' );
    }
}
