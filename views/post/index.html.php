<?php
/**
 * A form to add a new item.
 *
 * This page is used by controllers to add a new item to the database. It displays a form that needs to be filled. It
 * includes image uploading for the item as well.
 *
 * @package post
 */
/**
 * Include the model for post
 */
require_once APP_PATH . DS . 'models/Post.php';
session_start();
?>
<html>
<head>
   <title>LostAndFound Registration Page</title>

   <!-- Link external style sheet-->
   <link rel="stylesheet" href="webroot/css/formStyle.css" type="text/css" />
   <link rel="stylesheet" href="webroot/css/style.css" type="text/css"/>
   <link rel="stylesheet" href="webroot/css/jquery-ui.css" type="text/css"/>

   <!-- link external javascript -->
   <script type="text/javascript" src="webroot/js/jquery-1.6.2.min.js"></script>
   <script type="text/javascript" src="webroot/js/PostItemValidation.js"></script>
   <script type="text/javascript" src="webroot/js/jquery-ui.min.js"></script>
   <script>
      $(document).ready(function() {
         $( "#date" ).datepicker({
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
    <?php
include_once '../webroot/include/template/header.php';
include_once '../webroot/include/template/menu.php';
include_once '../webroot/include/template/search.php';
?>
    <form method="post" action="postItem" id="postForm" enctype="multipart/form-data">
      <div class="formHeader" style="width: 730px;">
         <h1>Post Item Form</h1>
      </div>
      <div id ="register">
         <div class="formSeperator" style="border:none">
            <p><span class="required">*Please fill in all required fields.</span></p>

             <div class="inputDiv">
               <label for="itemName">Title Name <span class="required">*</span></label>
               <input class="field" id = "itemName" name="itemName" type="text"  value="<?php echo $template->data['itemName'];?>" />
               <span id="itemNameError" class="error">
                <?php
if ( isset( $template->errors['itemName'] ) ) {
    echo $template->errors['itemName'];
}
?>
               </span>
             </div>

             <div class="inputDiv">
                <label for="type">Item Type <span class="required">*</span></label>
               <input style="margin-left: 20px" type="radio" name="type" value="lost" <?php if ( $template->data['type']=='lost' ) echo 'checked'?> /> Lost
               <input style="margin-left: 20px" type="radio" name="type" value="found" <?php if ( $template->data['type']=='found' ) echo 'checked'?>/> Found
                <span id="typeError" class="error" style="margin-left:82px">
                <?php
        if ( isset( $template->errors['type'] ) ) {
            echo $template->errors['type'];
        }
?>
               </span>
             </div>

             <div class="inputDiv">
                <label for="category">Category <span class="required">*</span></label>
                   <select name="category" id="category">
                      <option selected value="0">--Please Select--</option>
                      <?php
    $category = $template->category;
foreach ( $template->category as $each ) {
    $each_detail = get_object_vars( $each );
    if ( $each_detail['id']==$template->data['category'] )
        echo ' <option selected value="'.$each_detail['id'].'">'.$each_detail['categoryName'].'</option>';
    else
        echo ' <option value="'.$each_detail['id'].'">'.$each_detail['categoryName'].'</option>';
}
?>
                   </select>
                <span id="categoryError" class="error">
                    <?php
if ( isset( $template->errors['category'] ) ) {
    echo $template->errors['category'];
}
?>
                </span>
            </div>

            <div class="inputDiv">
                <label for="date">Date <span class="required">*</span></label>
                <input class="field" id="date" name="date" type="text" readonly="ture" value=""/>
                <span id="dateError" class="error">
                    <?php
if ( isset( $template->errors['date'] ) ) {
    echo $template->errors['date'];
}
?>
                </span>
            </div>

            <div class="inputDiv">
                <label for="description">Description <span class="required">*</span> </label>
                <textarea rows="10" cols="20" class="field" id="description" name="description"><?php echo $template->data['description'];?></textarea>
                <span id="descriptionError" class="error0">
                <?php
if ( isset( $template->errors['description'] ) ) {
    echo $template->errors['description'];
}
?></span>
            </div>

            <div class="inputDiv">
                <label for="state">State <span class="required">*</span></label>
               <select name="state" id="state">
                  <option <?php if ( !isset( $template->data['state'] ) ) echo 'selected' ?> value="0">--Please Select--</option>
                  <option <?php if ( $template->data['state']=="ACT" ) echo 'selected'?> value="ACT">Australian Capital Territory</option>
                  <option <?php if ( $template->data['state']=="NSW" ) echo 'selected'?> value="NSW">New South Wales</option>
                  <option <?php if ( $template->data['state']=="NT" ) echo 'selected'?> value="NT">Northern Territory</option>
                  <option <?php if ( $template->data['state']=="QLD" ) echo 'selected'?> value="QLD">Queensland</option>
                  <option <?php if ( $template->data['state']=="SA" ) echo 'selected'?> value="SA">South Australia</option>
                  <option <?php if ( $template->data['state']=="TAS" ) echo 'selected'?> value="TAS">Tasmania</option>
                  <option <?php if ( $template->data['state']=="VIC" ) echo 'selected'?> value="VIC">Victoria</option>
                  <option <?php if ( $template->data['state']=="WA" ) echo 'selected'?> value="WA">Western Australia</option>
               </select>
               <span id="stateError" class="error">
               <?php if ( isset( $template->errors['state'] ) ) {
                                        echo $template->errors['state'];
                                    }?>
               </span>
            </div>

            <div class="inputDiv">
               <label for="suburb">Suburb <span class="required">*</span></label>
               <input class="field" id = "suburb" name="suburb" type="text"  value="<?php echo $template->data['suburb'];?>" />
               <span id="suburbError" class="error">
               <?php if ( isset( $template->errors['suburb'] ) ) {
                                echo $template->errors['suburb'];
                            }?></span>
             </div>

            <div class="inputDiv">
               <label for="street">Street </label>
               <input class="field" id = "street" name="street" type="text"  value="<?php echo $template->data['street'];?>" />
               <span id="streetError" class="error">
               <?php if ( isset( $template->errors['street'] ) ) {
                        echo $template->errors['street'];
                    }?></span>
            </div>

            <div class="inputDiv">
               <label for="postCode">Post Code </label>
               <input class="field" id = "postCode" name="postCode" type="text"  value="<?php echo $template->data['postCode'];?>" />
               <span id="postCodeError" class="error">
               <?php if ( isset( $template->errors['postCode'] ) ) {
                echo $template->errors['postCode'];
            }?></span>
            </div>

            <div class="inputDiv">
                    <label for="image">Upload Image </label>
                    <input class="field" type="file" name="image" id="image" style="border: none"/>&nbsp;&nbsp;&nbsp;
                    <span id="imageError" class="error">
                <?php if ( isset( $template->errors['image'] ) ) {
            echo $template->errors['image'];
        }?></span>
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
