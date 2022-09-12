<?php
include "ini.php";
session_start();
//Only allows access to session variables for admins
if ($_SESSION["userisadmin"] === 1) {
    //Getting all the files that have classes that need to be called
    include_once "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes\dbConnectorClasses.php";
    include_once "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes\ReturnVenuesClasses.php";
    $venueData = new ReturnVenues();
    $venueData->GetVenueList();
}