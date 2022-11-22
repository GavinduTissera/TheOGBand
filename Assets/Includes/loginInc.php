<?php
include "ini.php";

//Checks if the user got here by pressing submit button. If not then code doesn't run
if(isset($_POST["submit"])) {
    //Getting data from the Login form
    $email = $_POST["email"];
    $password = $_POST["password"];

    //Instantiating Login class
    include "../Classes/dbConnectorClasses.php";
    include "../Classes/loginClasses.php";
    $login = new LoginController($email, $password);
    $login->errorHandlingAndLogin();
    header("location: ../../index.php?error=none");
} else {
    //If the user got here by typing the link, it referres them back to the login page
    header("location: ../../Pages/login.php");
}
