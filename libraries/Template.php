<?php
/**
 * The Template class will be used by different controllers.
 *
 * This is the main class controlling templating system. Whatever file is passed as parameter in display(), it will
 * be executed and displayed on the browser screen.
 *
 * @package libraries
 * @author Referenced from showvotes prodived by Donal
 * @access public
 */
class Template {
    public $template_dir;

    /**
     *
     *
     * @access public
     * @param String  $file
     */
    public function display( $file ) {
        $template = $this;
        $path = $this->template_dir . $file;
        include $this->template_dir . $file;
    }
}
