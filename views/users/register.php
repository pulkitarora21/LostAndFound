<?php
/**
 * User registration form
 *
 * This is the form that needs to filled by user in order to register for the website. Data validation is applied on
 * the data supplied by user. So, the data that is entered must be sensible data.
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
   <title>LostAndFound Registration Page</title>

   <!-- Link external style sheet-->
   <link rel="stylesheet" href="../webroot/css/formStyle.css" type="text/css" />
   <link rel="stylesheet" href="../webroot/css/style.css" type="text/css"/>
   <link rel="stylesheet" href="../webroot/css/jquery-ui.css" type="text/css"/>

   <!-- link external javascript -->
   <script type="text/javascript" src="../webroot/js/jquery-1.6.2.min.js"></script>
   <script type="text/javascript" src="../webroot/js/RegisterValidation.js"></script>
   <script type="text/javascript" src="../webroot/js/jquery-ui.min.js"></script>
   <script>
      $(document).ready(function() {
         $( "#dob" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            minDate: new Date('1949/01/01'),
                maxDate: '0d',
                yearRange: '-100:+00'
         });
      });
  </script>

</head>
<body>
    <?php include_once '../webroot/include/template/header.php';
include_once '../webroot/include/template/menu.php';
include_once '../webroot/include/template/search.php';
?>
      <form method="post" action="create" id="registerForm">
      <div class="formHeader" style="width: 730px;">
         <h1>Registration Form</h1>
      </div>
      <div id ="register">
         <div class="formSeperator" >
            <p><span class="required">*Please fill in all required fields.</span></p>
            <div class="inputDiv">
               <label for="fName">First Name <span class="required">*</span></label>

               <input class="field" id = "fName" name="fName" type="text"  value="<?php echo $template->user['fName'];?>" />
               <span id="fNameError" class="error">
                <?php
if ( isset( $template->errors['fName'] ) ) {
    echo $template->errors['fName'];
}
?>
               </span>
            </div>
            <div class="inputDiv">
               <label for="lName">Last Name <span class="required">*</span></label>

               <input class="field" id = "lName" name="lName" type="text"  value="<?php echo $template->user['lName'];?>"/>
               <span id="lNameError" class="error">
               <?php
if ( isset( $template->errors['lName'] ) ) {
    echo $template->errors['lName'];
}
?>
               </span>
            </div>
            <div class="inputDiv">
               <label for="email">User Email <span class="required">*</span></label>
               <input class="field" id = "email" name="email" type="text" value="<?php echo $template->user['email'];?>"/>
               <span id="emailError" class="error">
               <?php
if ( isset( $template->errors['email'] ) ) {
    echo $template->errors['email'];
}
?>
               </span>
            </div>
            <div class="inputDiv">
               <label for="password1">Password <span class="required">*</span>
               <span class="small">(At least 8 characters)</span></label>
               <input class="field" id = "password1" name="password1" type="password" value="<?php echo $template->user['password1'];?>"/>
               <span id="pwdError" class="error">
               <?php
if ( isset( $template->errors['password1'] ) ) {
    echo $template->errors['password1'];
}
?>
               </span>
            </div>
            <div class="inputDiv">
               <label for="password2">Confirm Password <span class="required">*</span></label>

               <input class="field" id = "password2" name="password2" type="password" value="<?php echo $template->user['password2'];?>"/>
               <span id="confirmPwdError" class="error">
                <?php
if ( isset( $template->errors['password2'] ) ) {
    echo $template->errors['password2'];
}
?>
               </span>
            </div>
                <div class="inputDiv">
               <label for="phoneNo">Phone Number
               <span class="small">(10 Digits-begin with 0)</span></label>

               <input class="field" id = "phoneNo" name="phoneNo" type="text" value="<?php echo $template->user['phoneNo'];?>"/>
               <span id="phoneNoError" class="error">
               <?php
if ( isset( $template->errors['phoneNo'] ) ) {
    echo $template->errors['phoneNo'];
}
?>
               </span>
            </div>

            <div class="inputDiv">

            <label for="dob">Data of Birth</label>
               <input class="field" id = "dob" name="dob" type="text" readonly="readonly" value="<?php echo $template->user['dob'];?>"/>
               <span id="dobError" class="error">
                <?php
if ( isset( $template->errors['dob'] ) ) {
    echo $template->errors['dob'];
}
?>
               </span>
            </div>
         </div>

         <div class="formSeperator">
            <div class="inputDiv">

            <label for="streetNo">Street Number</label>
               <input class="field" id = "streetNo" name="streetNo" type="text" value="<?php echo $template->user['streetNo'];?>"/>
               <span id="streetNoError" class="error">
                <?php
if ( isset( $template->errors['streetNo'] ) ) {
    echo $template->errors['streetNo'];
}
?>
               </span>
            </div>

            <div class="inputDiv">

            <label for="streetName">Street Name</label>
               <input class="field" id = "streetName" name="streetName" type="text" value="<?php echo $template->user['streetName'];?>"/>
               <span id="streetNameError" class="error">
               <?php
if ( isset( $template->errors['streetName'] ) ) {
    echo $template->errors['streetName'];
}
?>
               </span>
            </div>

            <div class="inputDiv">

            <label for="suburb">Suburb</label>
               <input class="field" id = "suburb" name="suburb" type="text" value="<?php echo $template->user['suburb'];?>"/>
               <span id="suburbError" class="error">
               <?php
if ( isset( $template->errors['suburb'] ) ) {
    echo $template->errors['suburb'];
}
?>
               </span>
            </div>

            <div class="inputDiv">

            <label for="state">State</label>
               <select name="state">
                  <option selected value="">--Please Select--</option>
                  <option value="ACT">Australian Capital Territory</option>
                  <option value="NSW">New South Wales</option>
                  <option value="NT">Northern Territory</option>
                  <option value="QLD">Queensland</option>
                  <option value="SA">South Australia</option>
                  <option value="TAS">Tasmania</option>
                  <option value="VIC">Victoria</option>
                  <option value="WA">Western Australia</option>
               </select>
               <span></span>
            </div>

            <div class="inputDiv">

            <label for="postCode">Post Code</label>
               <input class="field" id = "postCode" name="postCode" type="text" value="<?php echo $template->user['postCode'];?>"/>
               <span id="postCodeError" class="error">
               <?php
if ( isset( $template->errors['postCode'] ) ) {
    echo $template->errors['postCode'];
}
?>
               </span>
            </div>
         </div>
         <div class="wrapper2">
            <div class="inputDiv">
               <label for="question">Security Question <span class="required">*</span></label>
               <?php User::constructQuestion();?>
            </div>
            <div class="inputDiv">
               <label for="answer">Answer <span class="required">*</span></label>

               <input class="field" id = "answer" name="answer" type="text" value="<?php echo $template->user['answer'];?>"/>
               <span id="answerError" class="error">
                <?php
if ( isset( $template->errors['answer'] ) ) {
    echo $template->errors['answer'];
}
?>
               </span>
            </div>
            <div id="btn">
                <input type="submit" value="Submit" name="submit" class="button"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="reset" id="reset" value="Reset" name="reset" class="button"/>
            </div>
           </div>
        </div>
      </form>
   <?php include_once '../webroot/include/template/footer.php';?>
</body>
</html>
