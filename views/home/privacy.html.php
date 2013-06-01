<?php
session_start();
// available vars:
require_once APP_PATH . DS . 'models/Home.php';
define( "IMAGE_URL", 'webroot/images/upload/' );

?>
<html>
<head>
    <title>Privacy policy</title>
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
    <h1>Privacy Statement</h1>

    <h2>Protecting your privacy</h2>
    <span>We are committed to providing you with a friendly and professional environment
    for the purpose of posting lost and found items on the website. This includes
    ensuring the security of your personal information.</span>

    <span>Set below is information concerning your privacy. We recommend that you keep
    this information for future reference.</span>

    <h2>About us</h2>
    <span>We are a group of students and enthusiastic developers who has developed
    this website in order to help the community to find their lost items.</span>

    <h2>Your personal information</h2>
    <span>Personal information held by us may include your:</span>

    <ul>
        <li>first name;</li>
        <li>last name;</li>
        <li>user name;</li>
        <li>phone number;</li>
        <li>date of birth;</li>
        <li>street number;</li>
        <li>street name;</li>
        <li>suburb;</li>
        <li>state;</li>
        <li>post code;</li>
        <li>security answer;</li>
    </ul>

    <h2>How we collect personal information</h2>
    <span>We collect personal information directly from you when you register.</span>

    <h2>How we use your personal information</h2>
    <span>Your personal information may be used to:</span>

    <ul>
       <li>verify your identity</li>
    </ul>

    <span>You may also be contacted via email about suggestions related to the items
    you have lost or found. </span>
    <h2>Disclosure of personal information to third parties</h2>
    <span>In order to let others contact you for the item you have posted on the
    website, we may disclose your personal information to other registered users.</span>

    <span>Your first name, last name and email may be disclosed to the other
    registered users.</span>

    <h2>Access your personal information</h2>
    <span>You have a right to access your personal information, except where law
    prohibits disclosure of such information. If you would like to access any
    personal information that we store about you then please visit the show profile
     page or contact any of us from the contact us page.</span>

    <h2>How to contact us</h2>
    <span>If you would like to access your personal information, have questions in
    relation to privacy, have a complaint about a breach of your privacy or any
    query on how your personal information is collected or used please write to
    any of us from contact us page.</span>

    </div>
    <?php include_once '../webroot/include/template/footer.php';?>
</body>
</html>
