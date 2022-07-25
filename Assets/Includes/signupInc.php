<?php
include "ini.php";
//Checks if the user got here by pressing submit button. If not then code doesn't run
if(isset($_POST["submit"])) {

    //Getting data from the signup form
    $unsanitisedEmail = $_POST["email"] ;
    $unsanitisedFirstname = $_POST["firstname"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["repeatpassword"];
    $isAdmin = false;

    //Input sanitisation of email and first name

    $email = filter_var($unsanitisedEmail, FILTER_SANITIZE_EMAIL, FILTER_FLAG_EMAIL_UNICODE);
    $firstname = filter_var($unsanitisedFirstname, FILTER_SANITIZE_ENCODED, FILTER_FLAG_STRIP_HIGH);

    //Instantiating Signup class
    include "../Classes/dbConnectorClasses.php";
    include "../Classes/signupClasses.php";
    $newUser = new SignupController($email, $firstname, $password, $repeatPassword, $isAdmin);
    $newUser->errorHandlingAndSignup();
        header("location: ../../index.php?error=none");

} else {
    //If the user got here by typing the link, it referres them back to the login page if they are a regular user, else referres them to the admin page
    header("location: ../../Pages/login.php");
    
    
}
