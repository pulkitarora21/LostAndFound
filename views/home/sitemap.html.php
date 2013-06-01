    <?php
session_start();
require_once APP_PATH . DS . 'models/Home.php';
?>
<html>
<head>
    <title>Sitemap</title>
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
    <div id="sitemap">
        <h1>Sitemap</h1>
        <h2>General</h2>
        <ul>
            <li><a href="/voodoo">Home</a></li>
            <li><a href="/voodoo/aboutus">About Us</a></li>
            <li><a href="/voodoo/privacy">Privacy Policy</a></li>
            <li><a href="/voodoo/contactus">Contact Us</a></li>
        </ul>
        <h2>Items</h2>
        <ul>
            <li><a href="/voodoo/lost">Lost Items</a></li>
            <li><a href="/voodoo/found">Found Items</a></li>
        </ul>
        <h2>Search</h2>
        <ul>
            <li><a href="/voodoo/search">Advanced Search</a></li>
        </ul>
        <h2>Account</h2>
        <ul>
            <?php if ( !isset( $_SESSION['user']['email'] ) ) {?>
            <li><a href="/voodoo/users/new">Register</a></li>
            <li><a href="/voodoo/session/new">Login</a></li>
            <li><a href="/voodoo/users/forgot_password">Retrieve Password</a></li>
            <?php } elseif ( $_SESSION['user']['type']=='a' ) { ?>
            <li><a href="/voodoo/admin/listUsers">List All Users</a></li>
            <li><a href="/voodoo/session/destroy">Logout</a></li>
            <?php } else { ?>
            <li><a href="/voodoo/users/showMyItem">Posted Item</a></li>
            <li><a href="/voodoo/post">Post An Item</a></li>
            <li><a href="/voodoo/users/change_password">Change Password</a></li>
            <li><a href="/voodoo/session/destroy">Logout</a></li>
            <?php } ?>
        </ul>
    </div>
    <?php include_once '../webroot/include/template/footer.php';?>
</body>
</html>
