<?php
/**
 * An index page(home page)
 *
 * @package found
 */
/**
 * Include the model for found items
 */
session_start();
require_once APP_PATH . DS . 'models/Home.php';
define( IMAGE_URL, 'webroot/images/upload/' );

?>
<html>
<head>
    <title>Home Page</title>
    <!-- Link external style sheet-->
    <link rel="stylesheet" href="webroot/css/style.css" type="text/css" />
    <link rel="stylesheet" href="webroot/css/homeStyle.css" type="text/css" />
    <script type="text/javascript" src="webroot/js/jquery.min.js"></script>

    <script type="text/javascript">var switchTo5x=true;</script><script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'68467cd1-e705-4677-847d-fc516b9c0214'});</script>

    <!-- This javascript and jquery are sourced from http://yensdesign.com/2008/09/how-to-create-a-stunning-and-smooth-popup-using-jquery-->
    <script type="text/javascript" src="webroot/js/jquery.blockUI.js"></script>
</head>
<body>
    <?php
include_once '../webroot/include/template/header.php';
include_once '../webroot/include/template/menu.php';
include_once '../webroot/include/template/search.php';
?>
        <div id="left">
            <div style="float: left;"><h1>Welcome to our website</h1></div>
            <div style="float: right;"><span  class='st_facebook_large' ></span><span  class='st_twitter_large' ></span><span  class='st_gbuzz_large' ></span><span  class='st_email_large' ></span></div>

            <p>The theme of our project is Lost and found which has the aim of contributing to help local community to report and find lost items. This free online service will be helping connecting communities and making the society a better place by providing a platform to help each other.</p>
        </div>
        <div id="right">
            <h2>Latest Lost Item</h2>
            <?php
$lostitems = $template->lostItems;
for ( $i=0;$i<1;$i++ ) {
    echo '<div id="left_side">';
    echo '<a href="lost/'.$lostitems[$i]["id"].'"><img src="'.IMAGE_URL.$lostitems[$i]['image'].'" alt="image" width/></a><br />';
    echo '</div>';
    echo '<div id="right_side">';
    echo "{$lostitems[$i]["name"]}({$lostitems[$i]["date"]})<br />";
    echo "{$lostitems[$i]["street"]} {$lostitems[$i]["suburb"]} {$lostitems[$i]["state"]} {$lostitems[$i]["postcode"]}<br />";
    echo '</div>';
}
?>
        </div>
        <div id="right">
            <h2>Latest Found Item</h2>
            <?php
$founditems = $template->foundItems;
for ( $i=0;$i<1;$i++ ) {
    echo '<div id="left_side">';
    echo '<a href="found/'.$founditems[$i]["id"].'"><img src="'.IMAGE_URL.$founditems[$i]['image'].'" alt="image" width/></a><br />';
    echo '</div>';
    echo '<div id="right_side">';
    echo "{$founditems[$i]["name"]}({$founditems[$i]["date"]})<br />";
    echo "{$founditems[$i]["street"]} {$founditems[$i]["suburb"]} {$founditems[$i]["state"]} {$founditems[$i]["postcode"]}<br />";
    echo '</div>';
}
?>
        </div>
    <?php
if ( $_SESSION['newLogin'] == true ) {
    unset( $_SESSION['newLogin'] );
?>
            <script type="text/javascript">
                    $(document).ready(function() {
                $.growlUI('Voodoo Notification', 'welcome back, <?php echo $_SESSION['user']['email']?>');
                });
                </script>
            <?php
} else if ( $_SESSION['newRegistration'] == true ) {
        //echo "got new Registration";// plz go to email
        unset( $_SESSION['newRegistration'] );
?>
            <script type="text/javascript">
                    $(document).ready(function() {
                $.growlUI('Voodoo Notification', 'successful registration, please check your email for activate your account');
                });
                </script>
            <?php
    }
?>
    <?php include_once '../webroot/include/template/footer.php';?>
</body>
</html>
