<?php
include "ini.php";
session_start();
//Only allows access to session variables for admins
if ($_SESSION["userisadmin"] === 1) {
    //Getting all the files that have classes that need to be called
    include_once "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes\dbConnectorClasses.php";
    include_once "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes\AdminDashboardClasses.php";
    //Initialising class and then excecuting the methods inside it to get the values from server into the client side
    $eventsData = new EventsController();
    $eventsData->GetEventsDataFromDB();
    $eventsData->GetFullEventsDataFromDB();
    $orderData = new OrderController();
    $orderData->GetAllOrderDataFromDB();
    $salesData = new SalesController('1970-01-01',date('Y-m-d H:i:s'));
    $salesData->SalesDataAllTime();
    
    //Checks if the button to hide past, future of custom dates of events have been clicked. If they have then it updates the session variable, and then redirects them back to the main file
    if(isset($_POST["SALcheckbox"])) {
            // Since this is always going to show all events when clicked, it cannot be turned off hence the lack of if statement
            $_SESSION["ShowAllEvents"] = true;
            //Only 1 button can be selected at a time so the rest of the buttons return as false
            $_SESSION["HideFutureEvents"] = false;
            $_SESSION["HidePastEvents"] = false;
            $_SESSION["ShowCustomEvents"] = false;
            $eventsData->GetFullEventsDataFromDB();
            $_SESSION["UpdateEventsTable"] = true;
        header("location: ../../Pages/Admin/MyEvents.php");
    }

    if(isset($_POST["HPEcheckbox"])) {
        if ($_SESSION["HidePastEvents"] === false) {
            $_SESSION["HidePastEvents"] = true;
            //Only 1 button can be selected at a time so the rest of the buttons return as false
            $_SESSION["HideFutureEvents"] = false;
            $_SESSION["ShowAllEvents"] = false;
            $_SESSION["ShowCustomEvents"] = false;
        } else {
            $_SESSION["HidePastEvents"] = false;
        }
        $eventsData->GetFullEventsDataFromDB();
        $_SESSION["UpdateEventsTable"] = true;
        header("location: ../../Pages/Admin/MyEvents.php");
    }
    
    if(isset($_POST["HFEcheckbox"])) {
        if ($_SESSION["HideFutureEvents"] === false) {
            $_SESSION["HideFutureEvents"] = true;
            $_SESSION["HidePastEvents"] = false;
            $_SESSION["ShowAllEvents"] = false;
            $_SESSION["ShowCustomEvents"] = false;
        } else {
            $_SESSION["HideFutureEvents"] = false;
        }
        $eventsData->GetFullEventsDataFromDB();
        $_SESSION["UpdateEventsTable"] = true;
        header("location: ../../Pages/Admin/MyEvents.php");
    } 
    
    if(isset($_POST["SCEsubmit"])) {
        //Initialising attributes for start date and end date
        $startDate = $_POST["StartDate"];
        $endDate = $_POST["EndDate"];

        $customDateData = new CustomEventsDates($startDate, $endDate);
        $customDateData->GetCDEventsDataFromDB($startDate, $endDate);
        // no need for if statement because the submit button was pressed and cant be deselected
        $_SESSION["ShowCustomEvents"] = true;
        $_SESSION["HideFutureEvents"] = false;
        $_SESSION["HidePastEvents"] = false;
        $_SESSION["ShowAllEvents"] = false;
        $_SESSION["UpdateEventsTable"] = true;
        header("location: ../../Pages/Admin/MyEvents.php");
    }  

    
    //For dashboard.php. Does same thing as the elements for myEvents except used for the time limiters

    if(isset($_POST["TimeButtonSAT"])) {
        // Since this is always going to show all events when clicked, it cannot be turned off hence the lack of if statement
        $_SESSION["ShowAllTime"] = true;
        //Only 1 button can be selected at a time so the rest of the buttons return as false
        $_SESSION["ShowLastMonth"] = false;
        $_SESSION["ShowLastWeek"] = false;
        $_SESSION["ShowCustomDates"] = false;
        $salesData = new SalesController('1970-01-01',date('Y-m-d H:i:s'));
        $salesData->SalesDataAllTime();
        header("location: ../../Pages/Admin/Dashboard.php");
    }

    if(isset($_POST["TimeButtonSLM"])) {
        if ($_SESSION["ShowLastMonth"] === false) {
            $_SESSION["ShowLastMonth"] = true;
            //Only 1 button can be selected at a time so the rest of the buttons return as false
            $_SESSION["ShowAllTime"] = false;
            $_SESSION["ShowLastWeek"] = false;
            $_SESSION["ShowCustomDates"] = false;
        } else {
            $_SESSION["ShowLastMonth"] = false;
            $_SESSION["ShowAllTime"] = true;
        }
        // DateTime() generates the current date
        $NewDate = new DateTime();
        // It them subtracts the given interval ( in this case 1 month) from the current date
        $NewDate->sub(new DateInterval('P1M'));
        // Formats it in the format used by the database (yyyy-mm-dd hh:mm:ss) and then passes the current date and that date into the SalesController class
        $startDate = $NewDate->format("Y-m-d H:i:s");
        $salesData = new SalesController($startDate,date("Y-m-d H:i:s"));
        $salesData->SalesDataAllTime();
        header("location: ../../Pages/Admin/Dashboard.php");
    }

    if(isset($_POST["TimeButtonsSLW"])) {
        if ($_SESSION["ShowLastWeek"] === false) {
            $_SESSION["ShowLastWeek"] = true;
            //Only 1 button can be selected at a time so the rest of the buttons return as false
            $_SESSION["ShowAllTime"] = false;
            $_SESSION["ShowLastMonth"] = false;
            $_SESSION["ShowCustomDates"] = false;
        } else {
            $_SESSION["ShowLastWeek"] = false;
            $_SESSION["ShowAllTime"] = true;
        }
        $NewDate = new DateTime();
        $NewDate->sub(new DateInterval('P7D'));
        $startDate = $NewDate->format("Y-m-d H:i:s");
        $salesData = new SalesController($startDate,date("Y-m-d H:i:s"));
        $salesData->SalesDataAllTime();
        header("location: ../../Pages/Admin/Dashboard.php");
    }

    if(isset($_POST["SCDsubmit"])) {
        //Initialising attributes for start date and end date
        $startDate = $_POST["StartDateDashboard"];
        $endDate = $_POST["EndDateDashboard"];
        // no need for if statement because the submit button was pressed and cant be deselected
        $_SESSION["ShowCustomDates"] = true;
        $_SESSION["ShowAllTime"] = false;
        $_SESSION["ShowLastMonth"] = false;
        $_SESSION["ShowLastWeek"] = false;
        $salesData = new SalesController($startDate,$endDate);
        $salesData->SalesDataAllTime();
        header("location: ../../Pages/Admin/Dashboard.php");
    } 
}


