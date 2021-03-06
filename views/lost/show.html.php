<?php
/**
 * An index page for lost items.
 *
 * This page is used by controllers to display a particular lost item. It includes location of the item as well using
 * google api.
 *
 * @package lost
 */
/**
 * Include the model for lost items
 */
require_once APP_PATH . DS . 'models/Lost.php';
require_once APP_PATH . DS . 'libraries/GoogleMapAPI.class.php';
define( IMAGE_URL, '../webroot/images/upload/' );

$item=$template->lostItem;
if ( empty( $item ) ) {
    header( "Location: /voodoo/error/404.html.php" );
} else {
    $map = new GoogleMapAPI( 'map' );
    $map->setAPIKey( 'ABQIAAAAYnm0KVYv2PRyN5zrLu2QhxSw7V38xWstz7lczvjaBmTaeTn8UBSB_Q4iLY-010wwgb2s5sx4yWk0DQ' );
    $map->setWidth( '720px' );
    $map->setHeight( '400px' );
    $map->addMarkerByAddress( $item['street'].' '.$item['suburb'].' '.$item['state'].' '.$item['postcode'], $item['name'], '<b>'.$item['name'].'</b>' );
?>
<html>
<head>
<title>Lost Item Page</title>

    <!-- Link external style sheet-->
    <link rel="stylesheet" href="../webroot/css/style.css" type="text/css" />
    <link rel="stylesheet" href="../webroot/css/formStyle.css" type="text/css" />
    <link rel="stylesheet" href="../webroot/css/item.css" type="text/css" />
    <link rel="stylesheet" href="../webroot/css/contact.css" type="text/css" media="screen" />
    <script src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../webroot/js/contact.js" ></script>
    <script type="text/javascript">var switchTo5x=true;</script><script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'68467cd1-e705-4677-847d-fc516b9c0214'});</script>

     <?php $map->printHeaderJS(); ?>
    <?php $map->printMapJS(); ?>
</head>
<body onload="onLoad()">
    <?php
    include_once '../webroot/include/template/header.php';
    include_once '../webroot/include/template/menu.php';
    include_once '../webroot/include/template/search.php';
}
?>
    <div id="itemHeader">
        <h1>Lost: <?php echo $item["name"]; ?></h1>
        <div style="float: right; padding: 5px;"><span  class='st_facebook_large' ></span><span  class='st_twitter_large' ></span><span  class='st_gbuzz_large' ></span><span  class='st_email_large' ></span></div>

    </div>
    <div id="item">
        <span style="padding-left: 10px;"><strong>This item was LOST on <?php echo $item["date"]; ?>.</strong></span><br/><br/>
        <div id="button"><input name="contact" id="contactBtn" type="button" /><span id="contactSpan">Contact owner</span></div>

        <div id="popupContact">
            <a id="popupContactClose">Close</a>

        <?php
if ( isset( $_SESSION['user']['email'] ) ) {?>
                <h1>Item was found by:</h1>
                <div class="userDetail">
                    <label>First Name:</label>
                    <span> <?php echo $template->contactInfo['fname']; ?></span>
                </div>
                <div class="userDetail">
                    <label>Last Name:</label>
                    <span> <?php echo $template->contactInfo['lname']; ?></span>
                </div>
                <div class="userDetail">
                    <label>Email:</label>
                    <span> <?php echo $template->contactInfo['email']; ?></span>
                </div>
        <?php  } else { ?>
            <h1>Sorry, you have no access for the info.</h1>
            <p>
                Please <a href="/voodoo/session/new"> login </a>to view contact details.<br />
            </p>

            <?php
}
?>

        </div>
        <div id="backgroundPopup"></div>
        <div class="itemSeperator"></div>
        <div id="details">
        <div class="split">
            <h3>Details</h3>
            <span class="detailsCat">Title : </span><span><?php echo $item["name"];?></span><br/><br/>
            <span class="detailsCat">Date Lost : </span><span><?php echo $item["date"];?></span><br/><br/>
            <span class="detailsCat">Location : </span><span><?php echo trim( $item["street"] ) . ", " . trim( $item["suburb"] ) . ", " . $item["state"];?></span><br/><br/>
            <span class="detailsCat">Description : </span><span><?php echo $item["description"];?></span><br/>
            </div>
            <?php
if ( $item['isSolved'] != 0 ) {
    echo '<div class="split" style="padding-top: 15px;">';
    echo '<a href="/voodoo/found/'.$item['isSolved'].'"><img src="../webroot/images/template/solved.png" alt="solved" /></a>';
    echo '</div>';
}
?>
        </div>
        <div class="itemSeperator"></div>
        <div id="imageDiv">
            <h3>Picture</h3>
            <img src="<?php echo IMAGE_URL.$item['image'];?>" alt="<?php echo $item['image'];?>"/>
        </div>
        <div style="clear: both; height: 10px;"></div>
        <div class="itemSeperator"></div>
        <div id="mapDiv">
            <h3>Map</h3>
            <div id="mapArea"><?php $map->printMap();?></div>
        </div>
    </div>

    <?php include_once '../webroot/include/template/footer.php';?>
</body>
</html>
