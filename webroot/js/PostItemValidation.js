$(document)
      .ready(
            function() {

               // global vars
               var form = $("#postForm");

               var itemName = $("#itemName");
               var itemNameError = $("#itemNameError");

               var category = $("#category");
               var categoryError = $("#categoryError");

               // var date = $("#date");
               // var dateError = $("#dateError");

               var description = $("#description");
               var descriptionError = $("#descriptionError");

               var state = $("#state");
               var stateError = $("#stateError");

               var suburb = $("#suburb");
               var suburbError = $("#suburbError");

               var street = $("#street");
               var streetError = $("#streetError");

               var postCode = $("#postCode");
               var postCodeError = $("#postCodeError");

               var reset = $("#reset");

               // On blur
               itemName.blur(validateItemName);
               category.blur(validateCategory);
               description.blur(validateDescription); // <1000
               state.blur(validateState);
               suburb.blur(validateSuburb);
               street.blur(validateStreet);
               postCode.blur(validatePostCode);

               // On key press
               itemName.keyup(validateItemName);
               category.keyup(validateCategory);
               description.keyup(validateDescription); // <1000
               state.keyup(validateState);
               suburb.keyup(validateSuburb);
               street.keyup(validateStreet);
               postCode.keyup(validatePostCode);

               // on button click
               reset.click(formReset);

               // On Submitting
               form.submit(function() {
                  if (validateItemName() & validateCategory()
                        & validateDescription() & validateState()
                        & validateSuburb() & validateStreet()
                        & validatePostCode())
                     return true
                  else
                     return false;
               });

               // validation functions
               function validateItemName() {
                  var i = $("#itemName").val();
                  var filter = /^[a-zA-Z0-9 ]+$/;
                  // not valid
                  if (i.length < 1) {
                     itemName.addClass("error");
                     itemNameError.text("You must provide an item name!");
                     itemNameError.addClass("error");
                     return false;
                  } else if (filter.test(i)) {
                     itemName.removeClass("error");
                     itemNameError.text("");
                     itemNameError.removeClass("error");
                     return true;
                  } else {
                     itemName.addClass("error");
                     itemNameError
                           .text("Item name should only be letters and numbers!");
                     itemNameError.addClass("error");
                     return false;
                  }
               }

               function validateCategory() {
                  var ca = $("#category").val();
                  // not valid
                  if (ca == 0) {
                     category.addClass("error");
                     categoryError.text("Please select a category!");
                     categoryError.addClass("error");
                     return false;
                  } else {
                     category.removeClass("error");
                     categoryError.text("");
                     categoryError.removeClass("error");
                     return true;
                  }
               }

               function validateDescription() {
                  var des = $("#description").val();
                  // not valid
                  if (des.length < 1) {
                     description.addClass("error");
                     descriptionError
                           .text("You must provide an item description!");
                     descriptionError.addClass("error");
                     return false;
                  } else if (des.length > 1000) {
                     description.addClass("error");
                     descriptionError
                           .text("Sorry, your description is too long!");
                     descriptionError.addClass("error");
                     return false;
                  } else {
                     description.removeClass("error");
                     descriptionError.text("");
                     descriptionError.removeClass("error");
                     return true;
                  }
               }

               function validateState() {
                  var s = $("#state").val();
                  // not valid
                  if (s == 0) {
                     state.addClass("error");
                     stateError.text("Please select a state!");
                     stateError.addClass("error");
                     return false;
                  } else {
                     state.removeClass("error");
                     stateError.text("");
                     stateError.removeClass("error");
                     return true;
                  }

               }

               function validateSuburb() {
                  var sub = $("#suburb").val();
                  var filter = /^[a-zA-Z ]+$/;
                  // valid
                  if (sub.length < 1) {
                     suburb.addClass("error");
                     suburbError.text("You must provide a suburb!");
                     suburbError.addClass("error");
                     return false;
                  } else if (filter.test(sub)) {
                     suburb.removeClass("error");
                     suburbError.text("");
                     suburbError.removeClass("error");
                     return true;
                  } else {
                     suburb.addClass("error");
                     suburbError.text("The suburb must only be characters!");
                     suburbError.addClass("error");
                     return false;
                  }
               }

               function validateStreet() {
                  var sn = $("#street").val();
                  var filter = /^[a-zA-Z0-9 ]+$/;
                  // valid
                  if (filter.test(sn) || sn.length < 1) {
                     street.removeClass("error");
                     streetError.text("");
                     streetError.removeClass("error");
                     return true;
                  }
                  // not valid
                  else {
                     street.addClass("error");
                     streetError
                           .text("The street should only contain letters and numbers!");
                     streetError.addClass("error");
                     return false;
                  }
               }

               function validatePostCode() {
                  var p = $("#postCode").val();
                  var filter = /^[0-9]{4}$/;
                  // valid
                  if (filter.test(p) || p.length < 1) {
                     postCode.removeClass("error");
                     postCodeError.text("");
                     postCodeError.removeClass("error");
                     return true;
                  }
                  // not valid
                  else {
                     postCode.addClass("error");
                     postCodeError.text("The post code must be 4 didigts!");
                     postCodeError.addClass("error");
                     return false;
                  }
               }

               function formReset() {
                  itemName.removeClass("error");
                  itemNameError.text("");
                  itemNameError.removeClass("error");

                  category.removeClass("error");
                  categoryError.text("");
                  categoryError.removeClass("error");

                  description.removeClass("error");
                  descriptionError.text("");
                  descriptionError.removeClass("error");

                  state.removeClass("error");
                  stateError.text("");
                  stateError.removeClass("error");

                  suburb.removeClass("error");
                  suburbError.text("");
                  suburbError.removeClass("error");

                  street.removeClass("error");
                  streetError.text("");
                  streetError.removeClass("error");

                  postCode.removeClass("error");
                  postCodeError.text("");
                  postCodeError.removeClass("error");

               }
            });