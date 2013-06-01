<?php
/**
 * A form to reset the forgot password
 *
 * This page is used by users to reset the password they have forgotton. They must enter correct answer to security
 * question, in order to execute this operation successfully.
 *
 * @package users
 */
/**
 * Include the model for User
 */
require_once APP_PATH . DS . 'models/User.php';
?>
<html>
<head>
<title>LostAndFound Retrieve Page</title>

    <!-- Link external style sheet-->
    <link rel="stylesheet" href="../webroot/css/style.css" type="text/css" />
    <link rel="stylesheet" href="../webroot/css/formStyle.css" type="text/css" />
</head>
<body>
    <?php
include_once '../webroot/include/template/header.php';
include_once '../webroot/include/template/menu.php';
include_once '../webroot/include/template/search.php';
?>
   <div id="forget">
   <form method="POST" action="forgot_password/retrieve" id="forgetForm">
      <div class="formHeader" style="width: 430px;">
         <h1>Retrieve Password</h1>
      </div>
      <div id="formbody" style="width: 430px">
         <label for="email">
            User Email<br/>
            <input id="useremail" name="useremail" type="text" class="put" value="<?php echo $template->email;?>" /><br/>
         </label>

         <label for="question">
            Security Question
            <?php User::constructQuestion();?>
         </label><br/><br/>

         <label for="answer">
            Answer<br/>
            <input id="answer" name="answer" type="text" class="put"/>
         </label><br/>

         <label for="submit">
            <input type="submit" value="Submit" name="submit" class="Button">
         </label>
         <span id="retrieveError">
            <?php
if ( isset( $template->error ) ) {
    echo $template->error;
}
?>
            </span>
      </div>
   </form>
   </div>
   <?php include_once '../webroot/include/template/footer.php';?>
</body>
</html>
