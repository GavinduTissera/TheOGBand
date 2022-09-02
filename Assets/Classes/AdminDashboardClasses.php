<?php
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Includes/ini.php";
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes/CreateArrayCheckQuery.php";

//Inherit from db connector class.
class SalesController extends dbConnector
{
    var $startDate;
    var $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    protected function ReturnAssocArray($queryStatement)
    {
        $queryStatement->execute([$this->startDate, $this->endDate]);
        $queryStatementCheck = new CreateArrayCheckQuery();
        $queryStatementCheck->CheckifExcecutableQuery($queryStatement);
        $userArray = $queryStatementCheck->GetAssocArray($queryStatement);
        return $userArray;
    }

    //Uses an aggregate function to 
    public function GetTotalRevenueQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT SUM(TotalPrice) FROM orders WHERE orders.OrderStatus = 'Completed' AND OrderDate >= ? AND OrderDate <= ?;");
        $queryStatement->bindParam(1, $this->startDate);
        $queryStatement->bindParam(2, $this->endDate);
        return $this->ReturnAssocArray($queryStatement);
    }

    public function GetTotalTicketsQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT SUM(TicketsOrdered) FROM orders WHERE orders.OrderStatus = 'Completed' AND OrderDate >= ? AND OrderDate <= ?;");
        $queryStatement->bindParam(1, $this->startDate);
        $queryStatement->bindParam(2, $this->endDate);
        return $this->ReturnAssocArray($queryStatement);
        
    }

    public function GetTotalOrdersQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT COUNT(OrderID) FROM orders WHERE OrderStatus = 'Completed' AND OrderDate >= ? AND OrderDate <= ?;");
        $queryStatement->bindParam(1, $this->startDate);
        $queryStatement->bindParam(2, $this->endDate);
        return $this->ReturnAssocArray($queryStatement);
        
    }

    public function GetTotalOrdersIncQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT COUNT(OrderID) FROM orders WHERE OrderStatus != 'Completed' AND OrderStatus != 'Refunded' AND OrderDate >= ? AND OrderDate <= ?;");
        $queryStatement->bindParam(1, $this->startDate);
        $queryStatement->bindParam(2, $this->endDate);
        return $this->ReturnAssocArray($queryStatement);
    }

    public function GetTotalUsersQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT COUNT(userID) FROM `userlogins` WHERE userDateOfCreation >= ? AND userDateOfCreation <= ?;");
        $queryStatement->bindParam(1, $this->startDate);
        $queryStatement->bindParam(2, $this->endDate);
        return $this->ReturnAssocArray($queryStatement);
        
    }

    public function GetTotalRefundedQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT COUNT(OrderID) FROM orders WHERE OrderStatus = 'Refunded' AND OrderDate >= ? AND OrderDate <= ?;");
        $queryStatement->bindParam(1, $this->startDate);
        $queryStatement->bindParam(2, $this->endDate);
        return $this->ReturnAssocArray($queryStatement);
        
    }

    public function GetAvgTicketsPerOrderQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT TRUNCATE(AVG(TicketsOrdered), 2) FROM orders WHERE OrderStatus = 'Completed' AND OrderDate >= ? AND OrderDate <= ?;");
        $queryStatement->bindParam(1, $this->startDate);
        $queryStatement->bindParam(2, $this->endDate);
        return $this->ReturnAssocArray($queryStatement);
        
    }

    public function GetAvgTicketPriceQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT TRUNCATE(AVG(TicketPrice),2) FROM `tickets` WHERE TicketCreationTime >= ? AND TicketCreationTime <= ?;");
        $queryStatement->bindParam(1, $this->startDate);
        $queryStatement->bindParam(2, $this->endDate);
        return $this->ReturnAssocArray($queryStatement);
        
    }

    public function SalesDataAllTime()
    {
        $userArray = $this->GetTotalRevenueQuery();
        if ($userArray[0]["SUM(TotalPrice)"] == null) {
            $_SESSION["Sales.NetEarnings"] = 0;
        } else {
            $_SESSION["Sales.NetEarnings"] = $userArray[0]["SUM(TotalPrice)"];
        }
        $userArray = $this->GetTotalTicketsQuery();
        if ($userArray[0]["SUM(TicketsOrdered)"] == null) {
            $_SESSION["Sales.TotalAttendees"] = 0;
        } else {
            $_SESSION["Sales.TotalAttendees"] = $userArray[0]["SUM(TicketsOrdered)"];
        }
        $userArray = $this->GetTotalOrdersQuery();
        if ($userArray[0]["COUNT(OrderID)"] == null) {
            $_SESSION["Sales.TotalOrders"] = 0;
        } else {
            $_SESSION["Sales.TotalOrders"] = $userArray[0]["COUNT(OrderID)"];
        }
        $userArray = $this->GetTotalOrdersIncQuery();
        if ($userArray[0]["COUNT(OrderID)"] == null) {
            $_SESSION["Sales.TotalOrdersInc"] = 0;
        } else {
            $_SESSION["Sales.TotalOrdersInc"] = $userArray[0]["COUNT(OrderID)"];
        }
        $userArray = $this->GetTotalUsersQuery();
        if ($userArray[0]["COUNT(userID)"] == null) {
            $_SESSION["Sales.TotalUsers"] = 0;
        } else {
            $_SESSION["Sales.TotalUsers"] = $userArray[0]["COUNT(userID)"];
        }
        $userArray = $this->GetTotalRefundedQuery();
        if ($userArray[0]["COUNT(OrderID)"] == null) {
            $_SESSION["Sales.TotalRefunded"] = 0;
        } else {
            $_SESSION["Sales.TotalRefunded"] = $userArray[0]["COUNT(OrderID)"];
        }
        $userArray = $this->GetAvgTicketsPerOrderQuery();
        if ($userArray[0]["TRUNCATE(AVG(TicketsOrdered), 2)"] == null) {
            $_SESSION["Sales.AvgTicketsPerOrder"] = 0;
        } else {
            $_SESSION["Sales.AvgTicketsPerOrder"] = $userArray[0]["TRUNCATE(AVG(TicketsOrdered), 2)"];
        }
        $userArray = $this->GetAvgTicketPriceQuery();
        if ($userArray[0]["TRUNCATE(AVG(TicketPrice),2)"] == null) {
            $_SESSION["Sales.AvgTicketPrice"] = 0;
        } else {
            $_SESSION["Sales.AvgTicketPrice"] = $userArray[0]["TRUNCATE(AVG(TicketPrice),2)"];
        }
    }
}

class OrderController extends dbConnector
{
    public function GetAllOrderDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT orders.OrderID, event.EventName,tickets.TicketName, orders.TicketsOrdered, orders.TotalPrice, orders.OrderDate, cardholderdetails.cardholderFirstname, cardholderdetails.cardholderLastname, cardholderdetails.cardholderEmail, cardholderdetails.cardholderMobileNumber, orders.OrderStatus FROM orders,event,ticketsinevent,tickets, cardholderdetails WHERE orders.CardholderID = cardholderdetails.cardholderID AND orders.TicketTypeID = ticketsinevent.TicketsEventID AND ticketsinevent.EventID = event.EventID AND ticketsinevent.TicketTypeID = tickets.TicketTypeID ORDER BY `orders`.`OrderDate` DESC");
        return $queryStatement;
    }

    public function ReturnAssocArray($queryStatement)
    {
        $queryStatement->execute();
        //Checks if the query is excecutable and creates a 2d associative array.
        $eventDatabaseCheck = new CreateArrayCheckQuery();
        $eventDatabaseCheck->CheckifExcecutableQuery($queryStatement);
        $userArray = $eventDatabaseCheck->GetAssocArray($queryStatement);
        $keys = array_keys($userArray);
        // As it is not possible to return 2 items at once, an array is used
        $returnedArray = [$keys, $userArray];
        return $returnedArray;
    }

    // Similar to one above except no limit on number of events taken
    public function GetAllOrderDataFromDB()
    {
        $queryStatement = $this->GetAllOrderDataQuery();
        $assocArraykeys = $this->ReturnAssocArray($queryStatement);
        $keys = $assocArraykeys[0];
        $userArray = $assocArraykeys[1];
        //Iterating through the associative array and storing them in session variables. They are also ordered through their rows in the database
        for ($i=0; $i < count($keys); $i++) { 
            $_SESSION["Orders.TotalOrders"] = count($keys);
            $_SESSION["Orders.OrderID".$i] = $userArray[$i]["OrderID"];
            $_SESSION["Orders.EventName".$i] = $userArray[$i]["EventName"];
            $_SESSION["Orders.TicketName".$i] = $userArray[$i]["TicketName"];
            $_SESSION["Orders.TicketsOrdered".$i] = $userArray[$i]["TicketsOrdered"];
            $_SESSION["Orders.AmountSpent".$i] = $userArray[$i]["TotalPrice"];
            $_SESSION["Orders.OrderDate".$i] = $userArray[$i]["OrderDate"];
            $_SESSION["Orders-FirstName".$i] = $userArray[$i]["cardholderFirstname"];
            $_SESSION["Orders-LastName".$i] = $userArray[$i]["cardholderLastname"];
            $_SESSION["Orders-EmailAddress".$i] = $userArray[$i]["cardholderEmail"]; 
            $_SESSION["Orders-PhoneNumber".$i] = $userArray[$i]["cardholderMobileNumber"];      
            $_SESSION["Orders-OrderStatus".$i] = $userArray[$i]["OrderStatus"];  
        }   
    }

}


class EventsController extends dbConnector
{
    public function ReturnAssocArray($queryStatement)
    {
        $queryStatement->execute();
        //Checks if the query is excecutable and creates a 2d associative array.
        $eventDatabaseCheck = new CreateArrayCheckQuery();
        $eventDatabaseCheck->CheckifExcecutableQuery($queryStatement);
        $userArray = $eventDatabaseCheck->GetAssocArray($queryStatement);
        $keys = array_keys($userArray);
        // As it is not possible to return 2 items at once, an array is used
        $returnedArray = [$keys, $userArray];
        return $returnedArray;
    }
    //Orders the events from soonest to furthest away, and gets the details of the first 5 events to happen
    protected function GetEventsDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT *, DAY(EventStartTime), MONTHNAME(EventStartTime), TIME(EventStartTime), TIME(EventEndTime) FROM event, venue WHERE event.VenueID = venue.VenueID AND CURRENT_TIMESTAMP < event.EventStartTime ORDER BY event.EventStartTime ASC LIMIT 5;");
        return $queryStatement;
    }

    protected function GetAllEventsDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT *, DAY(EventStartTime), MONTHNAME(EventStartTime), TIME(EventStartTime), TIME(EventEndTime) FROM event, venue WHERE event.VenueID = venue.VenueID ORDER BY event.EventStartTime ASC;");
        return $queryStatement;
    }

    protected function GetHPEEventsDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT *, DAY(EventStartTime), MONTHNAME(EventStartTime), TIME(EventStartTime), TIME(EventEndTime) FROM event, venue WHERE event.VenueID = venue.VenueID AND CURRENT_TIMESTAMP < event.EventStartTime ORDER BY event.EventStartTime ASC;");
        return $queryStatement;
    }

    protected function GetHFEEventsDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT *, DAY(EventStartTime), MONTHNAME(EventStartTime), TIME(EventStartTime), TIME(EventEndTime) FROM event, venue WHERE event.VenueID = venue.VenueID AND CURRENT_TIMESTAMP > event.EventStartTime ORDER BY event.EventStartTime ASC;");
        return $queryStatement;
    }

    //Gets the data from the database
    public function GetEventsDataFromDB()
    {   
        $queryStatement = $this->GetEventsDataQuery();
        $assocArraykeys = $this->ReturnAssocArray($queryStatement);
        $keys = $assocArraykeys[0];
        $userArray = $assocArraykeys[1];
        //Iterating through the associative array and storing them in session variables. They are also ordered through their rows in the database, from 0 to 4
        for ($i=0; $i < count($keys); $i++) { 
            $_SESSION["Events.TotalEvents"] = count($keys);
            $_SESSION["Events.EventID".$i] = $userArray[$i]["EventID"];
            $_SESSION["Events.VenueID".$i] = $userArray[$i]["VenueID"];
            $_SESSION["Events.EventName".$i] = $userArray[$i]["EventName"];
            $_SESSION["Events.EventDescription".$i] = $userArray[$i]["EventDescription"];
            $_SESSION["Events.EventStartTime".$i] = $userArray[$i]["EventStartTime"];
            $_SESSION["Events.EventEndTime".$i] = $userArray[$i]["EventEndTime"];
            $_SESSION["Events-EventMonth".$i] = $userArray[$i]["MONTHNAME(EventStartTime)"];
            $_SESSION["Events-EventDay".$i] = $userArray[$i]["DAY(EventStartTime)"];
            $_SESSION["Events-StartTime".$i] = $userArray[$i]["TIME(EventStartTime)"];
            $_SESSION["Events-EndTime".$i] = $userArray[$i]["TIME(EventEndTime)"];  
            $_SESSION["Events.TotalTicketsBought".$i] = $userArray[$i]["TotalTicketsBought"];
            $_SESSION["Events-Venue.MaxCapacity".$i] = $userArray[$i]["MaxCapacity"];      
            $_SESSION["Events-Venue.VenueName".$i] = $userArray[$i]["VenueName"];  
            $_SESSION["Events-Venue.City".$i] = $userArray[$i]["City"]; 
            $_SESSION["Events-Venue.Address".$i] = $userArray[$i]["Address"];  
            $_SESSION["Events-Venue.Postcode".$i] = $userArray[$i]["Postcode"]; 
            $_SESSION["Events-Venue.Latitude".$i] = $userArray[$i]["Latitude"];
            $_SESSION["Events-Venue.Longitude".$i] = $userArray[$i]["Longitude"];
        }   
    }

    // Similar to one above except no limit on number of events taken
    public function GetFullEventsDataFromDB()
    {
        if ($_SESSION["ShowAllEvents"] == true) {
            $queryStatement = $this->GetAllEventsDataQuery();
        } elseif ($_SESSION["HidePastEvents"] == true) {
            $queryStatement = $this->GetHPEEventsDataQuery();
        } elseif ($_SESSION["HideFutureEvents"] == true) {
            $queryStatement = $this->GetHFEEventsDataQuery();
        }
        $assocArraykeys = $this->ReturnAssocArray($queryStatement);
        $keys = $assocArraykeys[0];
        $userArray = $assocArraykeys[1];
        //Iterating through the associative array and storing them in session variables. They are also ordered through their rows in the database
        for ($i=0; $i < count($keys); $i++) { 
            $_SESSION["Events.AllTotalEvents"] = count($keys);
            $_SESSION["Events.AllEventID".$i] = $userArray[$i]["EventID"];
            $_SESSION["Events.AllVenueID".$i] = $userArray[$i]["VenueID"];
            $_SESSION["Events.AllEventName".$i] = $userArray[$i]["EventName"];
            $_SESSION["Events.AllEventDescription".$i] = $userArray[$i]["EventDescription"];
            $_SESSION["Events.AllEventStartTime".$i] = $userArray[$i]["EventStartTime"];
            $_SESSION["Events-AllEventMonth".$i] = $userArray[$i]["MONTHNAME(EventStartTime)"];
            $_SESSION["Events-AllEventDay".$i] = $userArray[$i]["DAY(EventStartTime)"];
            $_SESSION["Events-AllStartTime".$i] = $userArray[$i]["TIME(EventStartTime)"]; 
            $_SESSION["Events-AllEndTime".$i] = $userArray[$i]["TIME(EventEndTime)"];  
            $_SESSION["Events.AllTotalTicketsBought".$i] = $userArray[$i]["TotalTicketsBought"];
            $_SESSION["Events-AllVenue.MaxCapacity".$i] = $userArray[$i]["MaxCapacity"];      
            $_SESSION["Events-AllVenue.VenueName".$i] = $userArray[$i]["VenueName"];  
            $_SESSION["Events-AllVenue.City".$i] = $userArray[$i]["City"]; 
            $_SESSION["Events-AllVenue.Address".$i] = $userArray[$i]["Address"];  
            $_SESSION["Events-AllVenue.Postcode".$i] = $userArray[$i]["Postcode"]; 
            $_SESSION["Events-AllVenue.Latitude".$i] = $userArray[$i]["Latitude"];
            $_SESSION["Events-AllVenue.Longitude".$i] = $userArray[$i]["Longitude"];
        }   
    }
}



class CustomEventsDates extends dbConnector
{
    // initialising attributes
    var $startDate;
    var $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    protected function GetCDEventsDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT *, DAY(EventStartTime), MONTHNAME(EventStartTime), TIME(EventStartTime) FROM event, venue WHERE event.VenueID = venue.VenueID AND event.EventStartTime > ? AND event.EventStartTime < ? ORDER BY event.EventStartTime ASC;");
        return $queryStatement;
    }

    public function GetCDEventsDataFromDB($startDate, $endDate)
    {
        $queryStatement = $this->GetCDEventsDataQuery();
        $queryStatement->execute([$startDate,$endDate]);
        //Checks if the query is excecutable and creates a 2d associative array.
        $eventDatabaseCheck = new CreateArrayCheckQuery();
        $eventDatabaseCheck->CheckifExcecutableQuery($queryStatement);
        $userArray = $eventDatabaseCheck->GetAssocArray($queryStatement);
        $keys = array_keys($userArray);
        // If there are no events within the time frame, it sets total events to 0 so when ShowCustomEvents.php processes it, it fails the first if statement and so no event is shown 
        if (count($keys) === 0) {
            $_SESSION["Events.AllTotalEvents"] = 0;
        } else {
            for ($i=0; $i < count($keys); $i++) { 
                //Iterating through the associative array and storing them in session variables. They are also ordered through their rows in the database
                $_SESSION["Events.AllTotalEvents"] = count($keys);
                $_SESSION["Events.AllEventID".$i] = $userArray[$i]["EventID"];
                $_SESSION["Events.AllVenueID".$i] = $userArray[$i]["VenueID"];
                $_SESSION["Events.AllEventName".$i] = $userArray[$i]["EventName"];
                $_SESSION["Events.AllEventDescription".$i] = $userArray[$i]["EventDescription"];
                $_SESSION["Events.AllEventStartTime".$i] = $userArray[$i]["EventStartTime"];
                $_SESSION["Events-AllEventMonth".$i] = $userArray[$i]["MONTHNAME(EventStartTime)"];
                $_SESSION["Events-AllEventDay".$i] = $userArray[$i]["DAY(EventStartTime)"];
                $_SESSION["Events-AllStartTime".$i] = $userArray[$i]["TIME(EventStartTime)"]; 
                $_SESSION["Events-AllEndTime".$i] = $userArray[$i]["TIME(EventEndTime)"];
                $_SESSION["Events.AllTotalTicketsBought".$i] = $userArray[$i]["TotalTicketsBought"];
                $_SESSION["Events-AllVenue.MaxCapacity".$i] = $userArray[$i]["MaxCapacity"];      
                $_SESSION["Events-AllVenue.VenueName".$i] = $userArray[$i]["VenueName"];  
                $_SESSION["Events-AllVenue.City".$i] = $userArray[$i]["City"]; 
                $_SESSION["Events-AllVenue.Address".$i] = $userArray[$i]["Address"];  
                $_SESSION["Events-AllVenue.Postcode".$i] = $userArray[$i]["Postcode"]; 
                $_SESSION["Events-AllVenue.Latitude".$i] = $userArray[$i]["Latitude"];
                $_SESSION["Events-AllVenue.Longitude".$i] = $userArray[$i]["Longitude"];
            }
        }       
    }
}


