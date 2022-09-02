<?php
include "ini.php";
session_start();
if(isset($_POST["submitPageOne"])) {
    $_SESSION["TempConcertName"] = trim($_POST["ConcertNameInput"]);
    $_SESSION["TempConcertDescription"] =  trim($_POST["ConcertDescriptionInput"]);
    header("location: ../../Pages/Admin/CreateConcert/2.php");
}

if(isset($_POST["submitPageTwo"])) {
    $_SESSION["TempConcertName"] = trim($_POST["ConcertNameInput"]);
    $_SESSION["TempConcertDescription"] =  trim($_POST["ConcertDescriptionInput"]);
    header("location: ../../Pages/Admin/CreateConcert/2.php");
}
