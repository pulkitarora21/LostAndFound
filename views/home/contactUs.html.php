<?php
session_start();
// available vars:
require_once APP_PATH . DS . 'models/Home.php';
define( "IMAGE_URL", 'webroot/images/upload/' );

?>
<html>
<head>
    <title>Contact us</title>
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
    <h1>Drop us a line</h1>

    <h2>If,</h2>
    <ul>
       <li>You have a project or an idea, that we can help you to implement.</li>
       <li>You just want to say "Hi!"</li>
    </ul>

    <h2>The best and most comfortable way to contact us is via email:</h2>
    <ul>
       <li>Rui Shen (Kamille): s123456@student.rmit.edu.au</li>
       <li>Mihir Parikh: mihir.parikh@student.rmit.edu.au</li>
       <li>Katanchalee Chuaywongyart(Iam): s3265037@student.rmit.edu.au</li>
       <li>Wesley: s3260804@student.rmit.edu.au</li>
       <li>Alison: s3301415@student.rmit.edu.au</li>
    </ul>
    </div>
    <?php include_once '../webroot/include/template/footer.php';?>
</body>
</html>
