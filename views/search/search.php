<?php
/**
 * A form to conduct advanced search
 *
 * This page is used by controllers to do advanced search from the database. It displays a form that needs to be
 * filled.
 *
 * @package search
 */
/**
 * Include the model for Search
 */
require_once APP_PATH . DS . 'models/Search.php';
?>
<html>
<head>
   <title>LostAndFound Advanced Search Page</title>

   <!-- Link external style sheet-->
   <link rel="stylesheet" href="webroot/css/formStyle.css" type="text/css" />
   <link rel="stylesheet" href="webroot/css/style.css" type="text/css" />
   <link rel="stylesheet" href="webroot/css/jquery-ui.css" type="text/css" />

   <!-- link external javascript -->
   <script type="text/javascript" src="webroot/js/jquery-1.6.2.min.js"></script>
   <script type="text/javascript" src="webroot/js/jquery-ui.min.js"></script>
   <script>
      $(function() {
         var dates = $( "#start , #end" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            onSelect: function( selectedDate ) {
                var option = this.id == "start" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
         });
      });
  </script>

</head>
<body>
<?php include_once '../webroot/include/template/header.php';
include_once '../webroot/include/template/menu.php';
include_once '../webroot/include/template/search.php';
?>
   <form method="GET" action="advancedSearch" id="registerForm">
      <div class="formHeader" style="width: 730px;">
         <h1>Advanced Search Form</h1>
      </div>
      <div id="register">
            <div class="inputDiv">
                    <label for="opt"> Item type: </label>
               <input style="margin-left: 20px" type="radio" name="opt" value="1" checked /> Lost
                    <input style="margin-left: 20px" type="radio" name="opt" value="2" /> Found
            </div>
            <div class="inputDiv">
               <label for="desc"> Item/Description: </label>
               <input class="field" id="desc" name="desc" type="text" />
            </div>
            <div class="inputDiv">
               <label for="category"> Category: </label>
               <?php Search::constructCategory();?>
            </div>
            <div class="inputDiv">
               <label for="period"> Period: </label>
               <input class="date" type="text" name="start" id="start" readonly="true"/>
               &nbsp;-
               <input class="date" type="text" name="end" id="end" readonly="true"/>
               <span id="dateError" class="error">
                <?php
if ( isset( $template->errors['date'] ) ) {
    echo $template->errors['date'];
}
?>
               </span>
            </div>
            <div class="inputDiv">
               <label for="street"> Street: </label>
               <input class="field" id="street" name="street" type="text" value="" />
            </div>
            <div class="inputDiv">
               <label for="suburb"> Suburb: </label>
               <input class="field" id="suburb" name="suburb" type="text" value="" />
               <span id="suburbError" class="error">
               <?php
if ( isset( $template->errors['suburb'] ) ) {
    echo $template->errors['suburb'];
}
?>
               </span>
            </div>
            <div class="inputDiv">
               <label for="state"> State: </label> <select name='state'>
                  <option value="">--Please select--</option>
                  <option value="ACT">Australian Capital Territory</option>
                  <option value="NSW">New South Wales</option>
                  <option value="NT">Northern Territory</option>
                  <option value="QLD">Queensland</option>
                  <option value="SA">South Australia</option>
                  <option value="TAS">Tasmania</option>
                  <option value="VIC">Victoria</option>
                  <option value="WA">Western Australia</option>
               </select>
            </div>
            <div class="inputDiv">
               <label for="postCode"> Post Code:</label>
               <input class="field" id="postCode" name="postCode" type="text" value="" />
               <span id="postCodeError" class="error">
               <?php
if ( isset( $template->errors['postCode'] ) ) {
    echo $template->errors['postCode'];
}
?>
               </span>
            </div>
            <div class="inputDiv">
               <div id="btn">
                  <input type="submit" value="Search" name="submit" class="button" />
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="reset" id="reset" value="Reset" name="reset" class="button" />
               </div>
            </div>
         </div>
   </form>
   <?php
include_once '../webroot/include/template/footer.php';
?>
</body>
</html>
