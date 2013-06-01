$(document)
      .ready(
            function() {

               // global vars
               var form = $("#registerForm");
               var fName = $("#fName");
               var fNameError = $("#fNameError");
               var lName = $("#lName");
               var lNameError = $("#lNameError");
               var email = $("#email");
               var emailError = $("#emailError");
               var password1 = $("#password1");
               var pwdError = $("#pwdError");
               var password2 = $("#password2");
               var confirmPwdError = $("#confirmPwdError");
               var phoneNo = $("#phoneNo");
               var phoneNoError = $("#phoneNoError");

               var streetNo = $("#streetNo");
               var streetNoError = $("#streetNoError");
               var streetName = $("#streetName");
               var streetNameError = $("#streetNameError");
               var suburb = $("#suburb");
               var suburbError = $("#suburbError");
               var postCode = $("#postCode");
               var postCodeError = $("#postCodeError");

               var answer = $("#answer");
               var answerError = $("#answerError");
               var reset = $("#reset");

               // On blur
               fName.blur(validateFName);
               lName.blur(validateLName);
               email.blur(validateEmail);
               password1.blur(validatePass1);
               password2.blur(validatePass2);
               phoneNo.blur(validatePhoneNo);
               streetNo.blur(validateStreetNo);
               streetName.blur(validateStreetName);
               suburb.blur(validateSuburb);
               postCode.blur(validatePostCode);
               answer.blur(validateAnswer);

               // On key press
               fName.keyup(validateFName);
               lName.keyup(validateLName);
               email.keyup(validateEmail);
               password1.keyup(validatePass1);
               password2.keyup(validatePass2);
               phoneNo.keyup(validatePhoneNo);
               streetNo.keyup(validateStreetNo);
               streetName.keyup(validateStreetName);
               suburb.keyup(validateSuburb);
               postCode.keyup(validatePostCode);
               answer.keyup(validateAnswer);

               // on button click
               reset.click(formReset);

               // On Submitting
               form.submit(function() {
                  if (validateFName() & validateLName() & validateEmail()
                        & validatePass1() & validatePass2() & validatePhoneNo()
                        & validateStreetNo() & validateStreetName()
                        & validateSuburb() & validatePostCode()
                        & validateAnswer())
                     return true
                  else
                     return false;
               });

               // validation functions
               function validateFName() {
                  var f = $("#fName").val();
                  var filter = /^[a-zA-Z ]+$/;
                  // not valid
                  if (f.length < 1) {
                     fName.addClass("error");
                     fNameError.text("You must provide your frist name!");
                     fNameError.addClass("error");
                     return false;
                  } else if (filter.test(f)) {
                     fName.removeClass("error");
                     fNameError.text("");
                     fNameError.removeClass("error");
                     return true;
                  }
                  // valid
                  else {
                     fName.addClass("error");
                     fNameError
                           .text("Your first name must only be characters!");
                     fNameError.addClass("error");
                     return false;
                  }
               }

               function validateLName() {
                  var l = $("#lName").val();
                  var filter = /^[a-zA-Z ]+$/;
                  // not valid
                  if (l.length < 1) {
                     lName.addClass("error");
                     lNameError.text("You must provide your last name!");
                     lNameError.addClass("error");
                     return false;
                  } else if (filter.test(l)) {
                     lName.removeClass("error");
                     lNameError.text("");
                     lNameError.removeClass("error");
                     return true;
                  }
                  // valid
                  else {
                     lName.addClass("error");
                     lNameError.text("Your last name must only be characters!");
                     lNameError.addClass("error");
                     return false;
                  }
               }

               function validateEmail() {
                  var a = $("#email").val();
                  var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
                  // valid
                  if (filter.test(a)) {
                     email.removeClass("error");
                     emailError.text("");
                     emailError.removeClass("error");
                     return true;
                  }
                  // not valid
                  else {
                     email.addClass("error");
                     emailError
                           .text("Please enter your email in the correct format!");
                     emailError.addClass("error");
                     return false;
                  }
               }

               function validatePass1() {
                  var pwd1 = $("#password1");
                  var pwd2 = $("#password2");
                  // not valid
                  if (pwd1.val().length < 8) {
                     password1.addClass("error");
                     pwdError
                           .text("At least 8 characters: letters, numbers and '_'!");
                     pwdError.addClass("error");
                     return false;
                  }
                  // valid
                  else {
                     password1.removeClass("error");
                     pwdError.text("");
                     pwdError.removeClass("error");
                     validatePass2();
                     return true;
                  }
               }

               function validatePass2() {
                  var pwd1 = $("#password1");
                  var pwd2 = $("#password2");
                  // not valid
                  if (pwd1.val() != pwd2.val()) {
                     password2.addClass("error");
                     confirmPwdError.text("Passwords doesn't match!");
                     confirmPwdError.addClass("error");
                     return false;
                  }
                  // valid
                  else {
                     password2.removeClass("error");
                     confirmPwdError.text("");
                     confirmPwdError.removeClass("error");
                     return true;
                  }
               }

               function validatePhoneNo() {
                  var p = $("#phoneNo").val();
                  var filter = /^0[\d]{9}$/;
                  // valid
                  if (filter.test(p) || p.length < 1) {
                     phoneNo.removeClass("error");
                     phoneNoError.text("");
                     phoneNoError.removeClass("error");
                     return true;
                  }
                  // not valid
                  else {
                     phoneNo.addClass("error");
                     phoneNoError
                           .text("Please enter the phone number in the correct format!");
                     phoneNoError.addClass("error");
                     return false;
                  }
               }

               function validateStreetNo() {
                  var s = $("#streetNo").val();
                  var filter = /^[0-9a-zA-Z \-\/]+$/;
                  // valid
                  if (filter.test(s) || s.length < 1) {
                     streetNo.removeClass("error");
                     streetNoError.text("");
                     streetNoError.removeClass("error");
                     return true;
                  }
                  // not valid
                  else {
                     streetNo.addClass("error");
                     streetNoError
                           .text("Please enter the street number in the correct format!");
                     streetNoError.addClass("error");
                     return false;
                  }
               }

               function validateStreetName() {
                  var sn = $("#streetName").val();
                  var filter = /^[a-zA-Z ]+$/;
                  // valid
                  if (filter.test(sn) || sn.length < 1) {
                     streetName.removeClass("error");
                     streetNameError.text("");
                     streetNameError.removeClass("error");
                     return true;
                  }
                  // not valid
                  else {
                     streetName.addClass("error");
                     streetNameError
                           .text("The street name must only be characters!");
                     streetNameError.addClass("error");
                     return false;
                  }
               }

               function validateSuburb() {
                  var s = $("#suburb").val();
                  var filter = /^[a-zA-Z ]+$/;
                  // valid
                  if (filter.test(s) || s.length < 1) {
                     suburb.removeClass("error");
                     suburbError.text("");
                     suburbError.removeClass("error");
                     return true;
                  }
                  // not valid
                  else {
                     suburb.addClass("error");
                     suburbError.text("The suburb must only be characters!");
                     suburbError.addClass("error");
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

               function validateAnswer() {
                  var a = $("#answer").val();
                  // not valid
                  if (a.length < 1) {
                     answer.addClass("error");
                     answerError.text("You must provide your security answer!");
                     answerError.addClass("error");
                     return false;
                  }
                  // valid
                  else {
                     answer.removeClass("error");
                     answerError.text("");
                     answerError.removeClass("error");
                     return true;
                  }
               }


               function formReset() {
                  fName.removeClass("error");
                  fNameError.text("");
                  fNameError.removeClass("error");

                  lName.removeClass("error");
                  lNameError.text("");
                  lNameError.removeClass("error");

                  email.removeClass("error");
                  emailError.text("");
                  emailError.removeClass("error");

                  password1.removeClass("error");
                  pwdError.text("");
                  pwdError.removeClass("error");

                  password2.removeClass("error");
                  confirmPwdError.text("");
                  confirmPwdError.removeClass("error");

                  phoneNo.removeClass("error");
                  phoneNoError.text("");
                  phoneNoError.removeClass("error");

                  streetNo.removeClass("error");
                  streetNoError.text("");
                  streetNoError.removeClass("error");

                  streetName.removeClass("error");
                  streetNameError.text("");
                  streetNameError.removeClass("error");

                  suburb.removeClass("error");
                  suburbError.text("");
                  suburbError.removeClass("error");

                  postCode.removeClass("error");
                  postCodeError.text("");
                  postCodeError.removeClass("error");

                  answer.removeClass("error");
                  answerError.text("");
                  answerError.removeClass("error");
               }

            });