<?php
/**
 * A Login form
 *
 * This page is used by user to log in to the application. It displays a form that needs to be filled. If the
 * credentials are incorrect, an error is shown.
 *
 * @package session
 */
?>
<html>
<head>
<title>LostAndFound Login Page</title>

<!-- Link external style sheet-->
<link rel="stylesheet" href="../webroot/css/formStyle.css" type="text/css" />
<link rel="stylesheet" href="../webroot/css/style.css" type="text/css" />
<script type="text/javascript" src="../webroot/js/jquery.min.js"></script>

<!-- This javascript and jquery are sourced from http://yensdesign.com/2008/09/how-to-create-a-stunning-and-smooth-popup-using-jquery-->
<script type="text/javascript" src="../webroot/js/jquery.blockUI.js"></script>

<?php
if ( $_SESSION['newForget'] == true ) {
    unset( $_SESSION['newForget'] );
?>
                <script type="text/javascript">
                    $(document).ready(function() {
                $.growlUI('Voodoo Notification', 'Please check your email for new password');
                });
                </script>
            <?php
} else if ( $_SESSION['newActivate'] == true ) {
        unset( $_SESSION['newActivate'] );
?>
            <script type="text/javascript">
                    $(document).ready(function() {
                $.growlUI('Voodoo Notification', 'Successfully activated');
                });
                </script>
            <?php
    }
?>
</head>
<body>
    <?php
include_once '../webroot/include/template/header.php';
include_once '../webroot/include/template/menu.php';
include_once '../webroot/include/template/search.php';
?>
   <div id="login">
   <form method="POST" action="/voodoo/session/create">
      <div class="formHeader" style="width: 392px;">
         <h1>Login Form</h1>
      </div>
      <div id="formbody">
         <label for="email">
            User Email<br/>
            <input id="useremail" name="useremail" type="text" class="put"/>
         </label><br/>

         <label for="password">
            Password
            <a href="/voodoo/users/forgot_password">(forgot password)</a><br/>
            <input id="password" name="password" type="password" class="put"/>
         </label><br/>

         <label for="login">
            <input type="submit" value="Log in" name="login" class="button">
            <span id="loginError">
                <?php
if ( isset( $template->error ) ) {
    echo $template->error;
}
?>
            </span>
         </label>
      </div>
   </form>
   </div>
   <?php include_once '../webroot/include/template/footer.php';?>
</body>
</html>
