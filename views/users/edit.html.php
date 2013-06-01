<?php
/**
 * A form to update user info
 *
 * This page is used by users to update their profile information. It displays a form that needs to be
 * filled. If there are not errors generated, the details of the user is updated in the database.
 *
 * @package users
 */
/**
 * Start the session
 */
require_once APP_PATH . DS . 'models/User.php';
$_SESSION['updateCheck'] = 'true';
?>
<html>
<head>
   <title>Update User Info</title>

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
      <form method="post" action="update" id="updateForm">
      <div class="formHeader" style="width: 730px;">
         <h1>Personal Info</h1>
      </div>
      <div id ="register">
         <div class="formSeperator" >
            <p><span class="required">*Please fill in all required fields.</span></p>
            <div class="inputDiv">
               <label for="fName">First Name <span class="required">*</span></label>

               <input class="field" id = "fName" name="fName" type="text"  value="<?php echo $template->user->fname;?>" />
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

               <input class="field" id = "lName" name="lName" type="text"  value="<?php echo $template->user->lname;?>"/>
               <span id="lNameError" class="error">
               <?php
if ( isset( $template->errors['lName'] ) ) {
    echo $template->errors['lName'];
}
?>
               </span>
            </div>
                <div class="inputDiv">
               <label for="phoneNo">Phone Number
               <span class="small">(10 Digits-begin with 0)</span></label>

               <input class="field" id = "phoneNo" name="phoneNo" type="text" value="<?php echo $template->user->phone;?>"/>
               <span id="phoneNoError" class="error">
               <?php
if ( isset( $template->errors['phoneNo'] ) ) {
    echo $template->errors['phoneNo'];
}
?>
               </span>
            </div>
            <div class="inputDiv">
            <label for="dob">Date of Birth</label>
               <input class="field" id = "dob" name="dob" type="text" readonly="readonly" value="<?php echo $template->user->dob;?>"/>
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
               <input class="field" id = "streetNo" name="streetNo" type="text" value="<?php echo $template->user->streetNo;?>"/>
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
               <input class="field" id = "streetName" name="streetName" type="text" value="<?php echo $template->user->street;?>"/>
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
               <input class="field" id = "suburb" name="suburb" type="text" value="<?php echo $template->user->suburb;?>"/>
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
               <input class="field" id = "postCode" name="postCode" type="text" value="<?php echo $template->user->postcode;?>"/>
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
            <div id="btn">
                <input type="submit" value="Update" name="update" class="button"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="reset" id="reset" value="Reset" name="reset" class="button"/>
            </div>
        </div>
        </div>
      </form>
   <?php include_once '../webroot/include/template/footer.php';?>
</body>
</html>
