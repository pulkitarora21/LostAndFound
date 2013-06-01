<?php
/**
 * User profile page
 *
 * This page shows personal information about the user.
 *
 * @package users
 */
/**
 * Include the model for User
 */
require_once APP_PATH . DS . 'models/User.php';

if ( !isset( $template->user ) ) {
    header( "Location: /~Alison_aka_Hikosumi/voodoo/error/404.html.php" );
} else {
?>
<html>
<head>
<title>Personal Info Page</title>

    <!-- Link external style sheet-->
    <link rel="stylesheet" href="../webroot/css/style.css" type="text/css" />
    <link rel="stylesheet" href="../webroot/css/formStyle.css" type="text/css" />
</head>
<body>
    <?php
    include_once '../webroot/include/template/header.php';
    include_once '../webroot/include/template/menu.php';
    include_once '../webroot/include/template/search.php';

    echo "<pre>";
    var_dump( $template->user );
    echo "</pre>";

?>
    <div id="innerContent">
        <div class="formHeader" style="width: 730px;">
         <h1>Personal Info</h1>
      </div>
    <div id="register">
        <label>Email: </label><span> <?php echo $template->user->email; ?></span><br/><br/>
        <label>First Name: </label><span> <?php echo $template->user->fname; ?></span><br/><br/>
        <label>Last Name: </label><span> <?php echo $template->user->lname; ?></span><br/><br/>
        <label>Street No: </label><span> <?php echo $template->user->streetNo; ?></span><br/><br/>
        <label>Street: </label><span> <?php echo $template->user->street; ?></span><br/><br/>
        <label>Suburb: </label><span> <?php echo $template->user->suburb; ?></span><br/><br/>
        <label>State: </label><span> <?php echo $template->user->state; ?></span><br/><br/>
        <label>Postcode: </label><span> <?php echo $template->user->postcode; ?></span><br/><br/>
        <label>Phone: </label><span> <?php echo $template->user->phone; ?></span><br/><br/>
        <label>Date of birth: </label><span> <?php echo $template->user->dob; ?></span><br/><br/>
    </div>
   </div>
  <?php }?>
</body>
</html>
