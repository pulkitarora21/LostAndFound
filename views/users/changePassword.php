<?php
/**
 * A form to change password
 *
 * This page is used by users to change the password. User must be logged in, in order to access this page. If
 * he/she is not logged in, they will be redirected to the login form page. It requires users to enter current and new
 * passwords.
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
<title>LostAndFound Change Password Page</title>

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
   <div id="login">
   <form method="POST" action="change_password/modify">
      <div class="formHeader" style="width: 430px;">
         <h1>Change Password</h1>
      </div>
      <div id="formbody" style="width: 430px">
          <label for="currentPassword">
            Current Password<br/>
            <input id="oldPwd" name="oldPwd" type="password" class="put" value="<?php echo $template->password;?>"/><br/>
         </label>

          <label for="newPassword">
            New password<br/>
            <input id="newPwd" name="newPwd" type="password" class="put" /><br/>
         </label>

          <label for="confirmNewPassoword">
            Confirm New Password<br/>
            <input id="confirmNewPwd" name="confirmNewPwd" type="password" class="put" /><br/>
         </label>

         <label for="submit">
            <input type="submit" value="Update" name="submit" class="Button">
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
