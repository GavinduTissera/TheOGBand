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
    $_SESSION["IsNewVenue"] = false;
    $venueID = ($_POST["venueID"]);
    $_SESSION["TempVenueID"] = $venueID;
    header("location: ../../Pages/Admin/CreateConcert/4.php");
}

if (isset($_POST["submitPageFour"])) {
    // gets the raw body of http request
    $decodedContents = json_decode($_POST["TicketObjects"], true);
    var_dump($decodedContents);
    echo $_SESSION["TempConcertName"]; 
    echo "<br>";
    echo $_SESSION["TempConcertDescription"];
    echo "<br>";
    echo $_SESSION["TempConcertStartDate"];
    echo "<br>";
    echo $_SESSION["TempConcertEndDate"];
    echo "<br>";
    echo $_SESSION["IsNewVenue"];
    echo "<br>";
    echo $_SESSION["TempVenueID"];
    echo "<br>";
    echo $_SESSION["TempMaxCapacity"];
    echo "<br>";
    echo $_SESSION["TempVenueName"];
    echo "<br>";
    echo $_SESSION["TempAddress"];
    echo "<br>";
    echo $_SESSION["TempLocationData"];
    echo "<br>";
    echo $_SESSION["TempVenueID"];
    echo "<br>";


    if ($_SESSION["IsNewVenue"] == true) {
        //Need to insert all the items into the database, and then return the venue id to put in the events query.
        include_once "../Classes/dbConnectorClasses.php";
        include_once "../Classes/AddEventClasses.php";
        $addVenue = new InsertVenueController($_SESSION["TempMaxCapacity"], $_SESSION["TempVenueName"], $_SESSION["TempAddress"], $_SESSION["TempLocationData"]);
        $addVenue->addVenueToDB();
        echo $_SESSION["TempVenueID"];
    } else {
        echo $_SESSION["TempVenueID"];
    }

    $amountOfTickets = count($decodedContents);
    for ($i=0; $i < $amountOfTickets; $i++) { 
        $ticketNameInput = $decodedContents[$i]["ticketNameInput"];
        $AmountOfTicketsInput = $decodedContents[$i]["AmountOfTicketsInput"];
        if ($AmountOfTicketsInput == "") {
            //Max value for unsigned integer
            $AmountOfTicketsInput = 2147483647;
        }
        $TicketPriceInput = $decodedContents[$i]["TicketPriceInput"];
        if ($TicketPriceInput == "") {
            //If no input, it becomes free
            $TicketPriceInput = 0;
        }
        $ConcertDescriptionInput = $decodedContents[$i]["ConcertDescriptionInput"];
        $MaxTicketBoughtInput = $decodedContents[$i]["MaxTicketBoughtInput"];
        if ($MaxTicketBoughtInput == "") {
            //Max value for unsigned integer
            $MaxTicketBoughtInput = 2147483647;
        }
        echo "<br>";
        echo $ticketNameInput;
        echo $AmountOfTicketsInput;
        echo $TicketPriceInput;
        echo $ConcertDescriptionInput;
        echo $MaxTicketBoughtInput;
        echo "<br>";

        include_once "../Classes/dbConnectorClasses.php";
        include_once "../Classes/AddEventClasses.php";
        $addVenue = new InsertTicketController($ticketNameInput, $AmountOfTicketsInput, $TicketPriceInput, $ConcertDescriptionInput, $MaxTicketBoughtInput);
        $addVenue->addTicketToDB();
    }
    $addVenue->GetNewIDsOfTickets($amountOfTickets);
    echo "hi";
    var_dump($_SESSION["TicketAssoc"]);

    include_once "../Classes/dbConnectorClasses.php";
    include_once "../Classes/AddEventClasses.php";
    $addVenue = new InsertEventController($_SESSION["TempVenueID"], $_SESSION["TempConcertName"], $_SESSION["TempConcertDescription"], $_SESSION["TempConcertStartDate"], $_SESSION["TempConcertEndDate"]);
    $addVenue->addEventToDB();
    echo $_SESSION["TempEventID"];
    




}
