<?php
session_start();
// available vars:
require_once APP_PATH . DS . 'models/Home.php';
define( "IMAGE_URL", 'webroot/images/upload/' );

?>
<html>
<head>
    <title>About us</title>
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
    <h1>About us</h1>

    <h2>Theme</h2>
    <p>Lost and Found</p>
    <h2>Who are we?</h2>
    <p>We are a group of students of RMIT university (Computer Science department)
    and enthusiastic developers who has developed this website in order to help
    the community to find their lost items.</p>
    <ol>
       <li>Rui Shen (Kamille)</li>
       <li>Xu Zhang (Wesley)</li>
       <li>Mihir Parikh</li>
       <li>Yin Ching NG (Alison)</li>
       <li>Katanchalee Chuaywongyart (Iam)</li>
    </ol>
    <p>Interested in contacting us? Please visit the contact us page.</p>

    <h2>Mission</h2>
    <p>Contributing to help local community to report and find lost items.</p>

    <h2>Our specialities:</h2>

    <ol>
       <li>It is a free service</li>
       <li>Connecting community</li>
    </ol>

    <h2>Benefit:</h2>
    <p>Helping people to look for lost item. </p>

    <h2>Implementation tools and languages: </h2>
    <ol>
       <li>php</li>
       <li>mySql</li>
       <li>HTML</li>
       <li>CSS</li>
       <li>Javascript</li>
       <li>Jquery</li>
       <li>Ajax</li>
       <li>Github – repository</li>
       <li>MVC (Model View Controller architecture) </li>
    </ol>
    <h2>Objectives and aims we have met:</h2>

    <ol>
        <li>Developed a medium scale lost and found online application.</li>
        <li>A system that is in accordance with future user needs.</li>
        <li>A user friendly and bug free website.</li>
        <li>A website with consistent and decent look.</li>
        <li>Providing all of the services to people free of charge</li>
    </ol>
    </div>
    <?php include_once '../webroot/include/template/footer.php';?>
</body>
</html>
