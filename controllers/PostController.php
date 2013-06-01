<?php
/**
 * File helping to post the item data in the database.
 *
 * It retrieves all the data passed from the file and validates it. If everything is fine, it adds the row in the
 * database and display its success page.
 *
 * @package controller
 */
/**
 * Start the session.
 */
session_start();

require_once LIBRARY_PATH . DS . 'Template.php';
require_once APP_PATH . DS . 'models/Post.php';

/**
 *
 *
 * @access public
 */
class PostController {
    private $template;

    /**
     *
     *
     * @access public
     */
    public function __construct() {
        $this->template = new Template();
        $this->template->template_dir = APP_PATH . DS . 'views' . DS . 'post' . DS;
    }

    /**
     *
     *
     * @access public
     */
    public function post() {
        if ( !isset( $_SESSION['user'] ) ) {
            header( "Location: /voodoo" );
            exit;
        }

        if ( isset( $_SESSION['postItemData'] ) ) {
            $this->template->data = $_SESSION['postItemData'];
            unset( $_SESSION['postItemData'] );
        }

        if ( isset( $_SESSION['postItemErrors'] ) ) {
            $this->template->errors = $_SESSION['postItemErrors'];
            unset( $_SESSION['postItemErrors'] );
        }

        $this->template->category=Post::getCategory();
        $this->template->display( 'index.html.php' );
    }

    /**
     * Create a new user.
     *
     * @access public
     */
    public function postItem() {

        if ( !isset( $_POST ) || empty( $_POST ) ) {
            header( "Location: /voodoo/post" );
            exit;
        }

        $postItemData = array (
            'itemName' => trim( $_POST['itemName'] ),
            'type' => trim( $_POST['type'] ),
            'category' => trim( $_POST['category'] ),
            'date' => trim( $_POST['date'] ),
            'description' => trim( $_POST['description'] ),
            'state' => trim( $_POST['state'] ),
            'suburb' => trim( $_POST['suburb'] ),
            'street' => trim( $_POST['street'] ),
            'postCode' => trim( $_POST['postCode'] ),
            'image' => $_FILES['image']
        );

        if ( !Post::validates( $postItemData ) ) {
            $_SESSION['postItemData']=$postItemData;
            $_SESSION['postItemErrors'] = Post::errors();

            header( "Location: /voodoo/post" );
            exit;
        }

        $dir = $postItemData['type'];//'found';

        Post::create( $postItemData );

        $maxId=Post::getMaxId( "{$dir}Item" );

        // save the image to haha
        if ( strlen( $postItemData['image']['name'] ) > 3 ) {
            $uploaddir = APP_PATH . DS . 'webroot' . DS .'images' .DS . 'upload/';
            $path = $uploaddir.$postItemData['image']['name'];
            copy( $postItemData['image']['tmp_name'], $path );
        }

        header( "Location: /voodoo/$dir/{$maxId}" );
        exit;
    }
}
