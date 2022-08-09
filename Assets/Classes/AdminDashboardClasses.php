<?php
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Includes/ini.php";
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes/CreateArrayCheckQuery.php";

//Inherit from db connector class.
class SalesController extends dbConnector
{

    protected function ReturnAssocArray($queryStatement)
    {
        $queryStatement->execute();
        $queryStatementCheck = new CreateArrayCheckQuery();
        $queryStatementCheck->CheckifExcecutableQuery($queryStatement);
        $userArray = $queryStatementCheck->GetAssocArray($queryStatement);
        return $userArray;
    }
    //Uses an aggregate function to 
    public function GetTotalRevenueQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT SUM(TotalPrice) FROM orders WHERE OrderStatus = 'Completed';");
        $userArray = $this->ReturnAssocArray($queryStatement);
        $_SESSION["Sales.NetEarnings"] = $userArray[0]["SUM(TotalPrice)"];
    }

    public function GetTotalTicketsQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT SUM(NoOfTicketsBought) FROM orders WHERE OrderStatus = 'Completed';");
        $userArray = $this->ReturnAssocArray($queryStatement);
        $_SESSION["Sales.TotalAttendees"] = $userArray[0]["SUM(NoOfTicketsBought)"];
    }

    public function GetTotalOrdersQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT COUNT(OrderID) FROM orders WHERE OrderStatus = 'Completed';");
        $userArray = $this->ReturnAssocArray($queryStatement);
        $_SESSION["Sales.TotalOrders"] = $userArray[0]["COUNT(OrderID)"];
    }

    public function GetTotalOrdersIncQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT COUNT(OrderID) FROM orders WHERE OrderStatus != 'Completed' AND OrderStatus != 'Refunded';");
        $userArray = $this->ReturnAssocArray($queryStatement);
        $_SESSION["Sales.TotalOrdersInc"] = $userArray[0]["COUNT(OrderID)"];
    }

    public function GetTotalUsersQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT COUNT(userID) FROM `userlogins`;");
        $userArray = $this->ReturnAssocArray($queryStatement);
        $_SESSION["Sales.TotalUsers"] = $userArray[0]["COUNT(userID)"];
    }

    public function GetTotalRefundedQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT COUNT(OrderID) FROM orders WHERE OrderStatus = 'Refunded';");
        $userArray = $this->ReturnAssocArray($queryStatement);
        $_SESSION["Sales.TotalRefunded"] = $userArray[0]["COUNT(OrderID)"];
    }

    public function GetAvgTicketsPerOrderQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT TRUNCATE(AVG(NoOfTicketsBought),2) FROM orders WHERE OrderStatus = 'Completed';");
        $userArray = $this->ReturnAssocArray($queryStatement);
        $_SESSION["Sales.AvgTicketsPerOrder"] = $userArray[0]["TRUNCATE(AVG(NoOfTicketsBought),2)"];
    }

    public function GetAvgTicketPriceQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT TRUNCATE(AVG(TicketPrice),2) FROM `tickets`;");
        $userArray = $this->ReturnAssocArray($queryStatement);
        $_SESSION["Sales.AvgTicketPrice"] = $userArray[0]["TRUNCATE(AVG(TicketPrice),2)"];
    }
}

class EventsController extends dbConnector
{
    //Orders the events from soonest to furthest away, and gets the details of the first 5 events to happen
    protected function GetEventsDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT * FROM event, eventsdatetime, venue WHERE event.EventDateTime = eventsdatetime.EventDateTime AND event.VenueID = venue.VenueID ORDER BY event.EventDateTime ASC LIMIT 5;");
        return $queryStatement;
    }

    //Gets the data from the database
    public function GetEventsDataFromDB()
    {
        $queryStatement = $this->GetEventsDataQuery();
        $queryStatement->execute();
        //Checks if the query is excecutable and creates a 2d associative array.
        $eventDatabaseCheck = new CreateArrayCheckQuery();
        $eventDatabaseCheck->CheckifExcecutableQuery($queryStatement);
        $userArray = $eventDatabaseCheck->GetAssocArray($queryStatement);
        $keys = array_keys($userArray);
        //Iterating through the associative array and storing them in session variables. They are also ordered through their rows in the database, from 0 to 4
        for ($i=0; $i < count($keys); $i++) { 
            $_SESSION["Events.TotalEvents"] = count($keys);
            $_SESSION["Events.EventID".$i] = $userArray[$i]["EventID"];
            $_SESSION["Events.VenueID".$i] = $userArray[$i]["VenueID"];
            $_SESSION["Events.EventName".$i] = $userArray[$i]["EventName"];
            $_SESSION["Events.EventDescription".$i] = $userArray[$i]["EventDescription"];
            $_SESSION["Events.EventDateTime".$i] = $userArray[$i]["EventDateTime"];
            $_SESSION["Events.TotalTicketsBought".$i] = $userArray[$i]["TotalTicketsBought"];
            $_SESSION["Events-EventsDateTime.EventMonth".$i] = $userArray[$i]["EventMonth"];
            $_SESSION["Events-EventsDateTime.EventDay".$i] = $userArray[$i]["EventDay"];
            $_SESSION["Events-EventsDateTime.StartTime".$i] = $userArray[$i]["StartTime"]; 
            $_SESSION["Events-Venue.MaxCapacity".$i] = $userArray[$i]["MaxCapacity"];      
            $_SESSION["Events-Venue.VenueName".$i] = $userArray[$i]["VenueName"];  
            $_SESSION["Events-Venue.City".$i] = $userArray[$i]["City"]; 
            $_SESSION["Events-Venue.Address".$i] = $userArray[$i]["Address"];  
            $_SESSION["Events-Venue.Postcode".$i] = $userArray[$i]["Postcode"]; 
            $_SESSION["Events-Venue.Latitude".$i] = $userArray[$i]["Latitude"];
            $_SESSION["Events-Venue.Longitude".$i] = $userArray[$i]["Longitude"];
        }   
    }
}

