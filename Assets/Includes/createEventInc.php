<?php
include "ini.php";
session_start();
if(isset($_POST["submitPageOne"])) {
    $_SESSION["TempConcertName"] = trim($_POST["ConcertNameInput"]);
    $_SESSION["TempConcertDescription"] =  trim($_POST["ConcertDescriptionInput"]);
    header("location: ../../Pages/Admin/CreateConcert/2.php");
}

if(isset($_POST["submitPageTwo"])) {
    //Takes in data from the form. This consists of the date, and the dropdown values for hours and minutes
    $startDate = ($_POST["ConcertStartDateInput"]);
    $startHours = ($_POST["StartHoursSelect"]);
    $startMinutes = ($_POST["StartMinutesSelect"]);
    $endDate = ($_POST["ConcertEndDateInput"]);
    $endHours = ($_POST["EndHoursSelect"]);
    $endMinutes = ($_POST["EndMinutesSelect"]);
    // Uses sprintf to format the numbers and returns a string. This is then converted into time and that is reformatted into the correct datetime format to go into the database
    $startDateTimeStr = sprintf("%s %s:%s", $startDate, $startHours, $startMinutes);
    $timeFormat = strtotime($startDateTimeStr);
    $_SESSION["TempConcertStartDate"] = date("Y-m-d H:i:s", $timeFormat);
    $endDateTimeStr = sprintf("%s %s:%s", $endDate, $endHours, $endMinutes);
    $timeFormat = strtotime($endDateTimeStr);
    $_SESSION["TempConcertEndDate"] = date("Y-m-d H:i:s", $timeFormat);
    header("location: ../../Pages/Admin/CreateConcert/3.php");
}

if (isset($_POST["submitPageThreeAddNew"])) {
    $_SESSION["IsNewVenue"] = true;
    $_SESSION["TempMaxCapacity"] = ($_POST["MaxCapacity"]);
    $_SESSION["TempVenueName"] = ($_POST["nameInput"]);
    $_SESSION["TempAddress"] = ($_POST["addressInput"]);
    $_SESSION["TempLocationData"] = ($_POST["locationData"]);
    header("location: ../../Pages/Admin/CreateConcert/4.php");
}

if (isset($_POST["submitPageThreeUseExisting"])) {
    $venueID = ($_POST["venueID"]);
    $_SESSION["TempVenueID"] = $venueID;
    header("location: ../../Pages/Admin/CreateConcert/4.php");
}

if (isset($_POST["submitPageFour"])) {
    // gets the raw body of http request
    $decodedContents = json_decode($_POST["TicketObjects"], true);
    var_dump($decodedContents);
}
