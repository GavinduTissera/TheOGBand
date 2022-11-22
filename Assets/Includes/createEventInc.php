<?php
include "ini.php";
session_start();
//Only runs the code if the submit button is pressed.
if(isset($_POST["submitPageOne"])) {
    // uses session variables to keep track of the user inputs between pages, so that all of it can be used to input into the database
    $_SESSION["TempConcertName"] = trim($_POST["ConcertNameInput"]);
    $_SESSION["TempConcertDescription"] =  trim($_POST["ConcertDescriptionInput"]);
    //After every page it redirects to the next one
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
    //If the end date is sooner than the start date, then redirects back to the second page with an error message in the URL
    if ($_SESSION["TempConcertStartDate"] > $_SESSION["TempConcertEndDate"]) {
        header("location: ../../Pages/Admin/CreateConcert/2.php?error=EndDateAfter");
        //If no error, then goes to next page
    } else {
        header("location: ../../Pages/Admin/CreateConcert/3.php");   
    }
}

if (isset($_POST["submitPageThreeAddNew"])) {
    //Stores user inputs in temporary session variables
    $_SESSION["TempMaxCapacity"] = ($_POST["MaxCapacity"]);
    $_SESSION["TempVenueName"] = ($_POST["nameInput"]);
    $_SESSION["TempAddress"] = ($_POST["addressInput"]);
    $_SESSION["TempLocationData"] = ($_POST["locationData"]);
    //Need to insert all the items into the database, and then return the venue id to put in the events query.
    include_once "../Classes/dbConnectorClasses.php";
    include_once "../Classes/AddEventClasses.php";
    //This adds a new venue to the database. This also adds a session variable for tempVenueID which is then used.
    $addVenue = new InsertVenueController($_SESSION["TempMaxCapacity"], $_SESSION["TempVenueName"], $_SESSION["TempAddress"], $_SESSION["TempLocationData"]);
    $addVenue->addVenueToDB();
    header("location: ../../Pages/Admin/CreateConcert/4.php?Capacity=".$_SESSION["TempMaxCapacity"]);
}

if (isset($_POST["submitPageThreeUseExisting"])) {
    $venueID = ($_POST["venueID"]);
    $_SESSION["TempVenueID"] = $venueID;
    include_once "../Classes/dbConnectorClasses.php";
    include_once "../Classes/AddEventClasses.php";
    $addVenue = new GetVenueCapacityController($_SESSION["TempVenueID"]);
    $addVenue->getMaxCapacity();
    //Adds the capacity, so the user knows the full capacity of the venue.
    header("location: ../../Pages/Admin/CreateConcert/4.php?Capacity=".$_SESSION["TempMaxCapacity"]);
}
//Submission of the final page means all of the data is used to make the event
if (isset($_POST["submitPageFour"])) {
    // decodes the json into an object
    $decodedContents = json_decode($_POST["TicketObjects"], true);
    var_dump($decodedContents);

    include_once "../Classes/dbConnectorClasses.php";
    include_once "../Classes/AddEventClasses.php";
    //Inserts the event into the database
    $addVenue = new InsertEventController($_SESSION["TempVenueID"], $_SESSION["TempConcertName"], $_SESSION["TempConcertDescription"], $_SESSION["TempConcertStartDate"], $_SESSION["TempConcertEndDate"]);
    $addVenue->addEventToDB();

    // Changes empty values to max/min values to put into the database
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

        include_once "../Classes/dbConnectorClasses.php";
        include_once "../Classes/AddEventClasses.php";
        //Adds the tickets for the event in the database
        $addVenue = new InsertTicketController($ticketNameInput, $AmountOfTicketsInput, $TicketPriceInput, $ConcertDescriptionInput, $MaxTicketBoughtInput, $_SESSION["TempEventID"], 0, 1);
        $addVenue->addTicketToDB();
    }
    $addVenue->GetNewIDsOfTickets($amountOfTickets);
    var_dump($_SESSION["TicketAssoc"]);

    //redirects to the final page.
    header("location: ../../Pages/Admin/CreateConcert/finished.php");
}
