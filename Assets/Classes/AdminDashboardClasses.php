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
        if ($userArray[0]["TRUNCATE((SUM(NoOfTicketsBought))/COUNT(DISTINCT orders.OrderID), 2)"] == null) {
            $_SESSION["Sales.AvgTicketsPerOrder"] = 0;
        } else {
            $_SESSION["Sales.AvgTicketsPerOrder"] = $userArray[0]["TRUNCATE((SUM(NoOfTicketsBought))/COUNT(DISTINCT orders.OrderID), 2)"];
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
        $queryStatement = $this->connectTodb()->prepare("SELECT * FROM event, eventsdatetime, venue WHERE event.EventDateTime = eventsdatetime.EventDateTime AND event.VenueID = venue.VenueID AND CURRENT_TIMESTAMP < event.EventDateTime ORDER BY event.EventDateTime ASC LIMIT 5;");
        return $queryStatement;
    }

    protected function GetAllEventsDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT * FROM event, eventsdatetime, venue WHERE event.EventDateTime = eventsdatetime.EventDateTime AND event.VenueID = venue.VenueID ORDER BY event.EventDateTime ASC;");
        return $queryStatement;
    }

    protected function GetHPEEventsDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT * FROM event, eventsdatetime, venue WHERE event.EventDateTime = eventsdatetime.EventDateTime AND event.VenueID = venue.VenueID AND CURRENT_TIMESTAMP < event.EventDateTime ORDER BY event.EventDateTime ASC;");
        return $queryStatement;
    }

    protected function GetHFEEventsDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT * FROM event, eventsdatetime, venue WHERE event.EventDateTime = eventsdatetime.EventDateTime AND event.VenueID = venue.VenueID AND CURRENT_TIMESTAMP > event.EventDateTime ORDER BY event.EventDateTime ASC;");
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

    // Similar to one above except no limit on number of events taken
    public function GetAllEventsDataFromDB()
    {
        $queryStatement = $this->GetAllEventsDataQuery();
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
            $_SESSION["Events.AllEventDateTime".$i] = $userArray[$i]["EventDateTime"];
            $_SESSION["Events.AllTotalTicketsBought".$i] = $userArray[$i]["TotalTicketsBought"];
            $_SESSION["Events-AllEventsDateTime.EventMonth".$i] = $userArray[$i]["EventMonth"];
            $_SESSION["Events-AllEventsDateTime.EventDay".$i] = $userArray[$i]["EventDay"];
            $_SESSION["Events-AllEventsDateTime.StartTime".$i] = $userArray[$i]["StartTime"]; 
            $_SESSION["Events-AllVenue.MaxCapacity".$i] = $userArray[$i]["MaxCapacity"];      
            $_SESSION["Events-AllVenue.VenueName".$i] = $userArray[$i]["VenueName"];  
            $_SESSION["Events-AllVenue.City".$i] = $userArray[$i]["City"]; 
            $_SESSION["Events-AllVenue.Address".$i] = $userArray[$i]["Address"];  
            $_SESSION["Events-AllVenue.Postcode".$i] = $userArray[$i]["Postcode"]; 
            $_SESSION["Events-AllVenue.Latitude".$i] = $userArray[$i]["Latitude"];
            $_SESSION["Events-AllVenue.Longitude".$i] = $userArray[$i]["Longitude"];
        }   
    }

    public function GetHPEEventsDataFromDB()
    {
        $queryStatement = $this->GetHPEEventsDataQuery();
        $assocArraykeys = $this->ReturnAssocArray($queryStatement);
        $keys = $assocArraykeys[0];
        $userArray = $assocArraykeys[1];
        //Iterating through the associative array and storing them in session variables. They are also ordered through their rows in the database
        for ($i=0; $i < count($keys); $i++) { 
            $_SESSION["Events.HPETotalEvents"] = count($keys);
            $_SESSION["Events.HPEEventID".$i] = $userArray[$i]["EventID"];
            $_SESSION["Events.HPEVenueID".$i] = $userArray[$i]["VenueID"];
            $_SESSION["Events.HPEEventName".$i] = $userArray[$i]["EventName"];
            $_SESSION["Events.HPEEventDescription".$i] = $userArray[$i]["EventDescription"];
            $_SESSION["Events.HPEEventDateTime".$i] = $userArray[$i]["EventDateTime"];
            $_SESSION["Events.HPETotalTicketsBought".$i] = $userArray[$i]["TotalTicketsBought"];
            $_SESSION["Events-HPEEventsDateTime.EventMonth".$i] = $userArray[$i]["EventMonth"];
            $_SESSION["Events-HPEEventsDateTime.EventDay".$i] = $userArray[$i]["EventDay"];
            $_SESSION["Events-HPEEventsDateTime.StartTime".$i] = $userArray[$i]["StartTime"]; 
            $_SESSION["Events-HPEVenue.MaxCapacity".$i] = $userArray[$i]["MaxCapacity"];      
            $_SESSION["Events-HPEVenue.VenueName".$i] = $userArray[$i]["VenueName"];  
            $_SESSION["Events-HPEVenue.City".$i] = $userArray[$i]["City"]; 
            $_SESSION["Events-HPEVenue.Address".$i] = $userArray[$i]["Address"];  
            $_SESSION["Events-HPEVenue.Postcode".$i] = $userArray[$i]["Postcode"]; 
            $_SESSION["Events-HPEVenue.Latitude".$i] = $userArray[$i]["Latitude"];
            $_SESSION["Events-HPEVenue.Longitude".$i] = $userArray[$i]["Longitude"];
        }   
    }

    public function GetHFEEventsDataFromDB()
    {
        $queryStatement = $this->GetHFEEventsDataQuery();
        $assocArraykeys = $this->ReturnAssocArray($queryStatement);
        $keys = $assocArraykeys[0];
        $userArray = $assocArraykeys[1];
        //Iterating through the associative array and storing them in session variables. They are also ordered through their rows in the database
        for ($i=0; $i < count($keys); $i++) { 
            $_SESSION["Events.HFETotalEvents"] = count($keys);
            $_SESSION["Events.HFEEventID".$i] = $userArray[$i]["EventID"];
            $_SESSION["Events.HFEVenueID".$i] = $userArray[$i]["VenueID"];
            $_SESSION["Events.HFEEventName".$i] = $userArray[$i]["EventName"];
            $_SESSION["Events.HFEEventDescription".$i] = $userArray[$i]["EventDescription"];
            $_SESSION["Events.HFEEventDateTime".$i] = $userArray[$i]["EventDateTime"];
            $_SESSION["Events.HFETotalTicketsBought".$i] = $userArray[$i]["TotalTicketsBought"];
            $_SESSION["Events-HFEEventsDateTime.EventMonth".$i] = $userArray[$i]["EventMonth"];
            $_SESSION["Events-HFEEventsDateTime.EventDay".$i] = $userArray[$i]["EventDay"];
            $_SESSION["Events-HFEEventsDateTime.StartTime".$i] = $userArray[$i]["StartTime"]; 
            $_SESSION["Events-HFEVenue.MaxCapacity".$i] = $userArray[$i]["MaxCapacity"];      
            $_SESSION["Events-HFEVenue.VenueName".$i] = $userArray[$i]["VenueName"];  
            $_SESSION["Events-HFEVenue.City".$i] = $userArray[$i]["City"]; 
            $_SESSION["Events-HFEVenue.Address".$i] = $userArray[$i]["Address"];  
            $_SESSION["Events-HFEVenue.Postcode".$i] = $userArray[$i]["Postcode"]; 
            $_SESSION["Events-HFEVenue.Latitude".$i] = $userArray[$i]["Latitude"];
            $_SESSION["Events-HFEVenue.Longitude".$i] = $userArray[$i]["Longitude"];
        }   
    }

    public function GetCDEventsDataFromDB()
    {
        $queryStatement = $this->GetHFEEventsDataQuery();
        $assocArraykeys = $this->ReturnAssocArray($queryStatement);
        $keys = $assocArraykeys[0];
        $userArray = $assocArraykeys[1];
        //Iterating through the associative array and storing them in session variables. They are also ordered through their rows in the database
        for ($i=0; $i < count($keys); $i++) { 
            $_SESSION["Events.HFETotalEvents"] = count($keys);
            $_SESSION["Events.HFEEventID".$i] = $userArray[$i]["EventID"];
            $_SESSION["Events.HFEVenueID".$i] = $userArray[$i]["VenueID"];
            $_SESSION["Events.HFEEventName".$i] = $userArray[$i]["EventName"];
            $_SESSION["Events.HFEEventDescription".$i] = $userArray[$i]["EventDescription"];
            $_SESSION["Events.HFEEventDateTime".$i] = $userArray[$i]["EventDateTime"];
            $_SESSION["Events.HFETotalTicketsBought".$i] = $userArray[$i]["TotalTicketsBought"];
            $_SESSION["Events-HFEEventsDateTime.EventMonth".$i] = $userArray[$i]["EventMonth"];
            $_SESSION["Events-HFEEventsDateTime.EventDay".$i] = $userArray[$i]["EventDay"];
            $_SESSION["Events-HFEEventsDateTime.StartTime".$i] = $userArray[$i]["StartTime"]; 
            $_SESSION["Events-HFEVenue.MaxCapacity".$i] = $userArray[$i]["MaxCapacity"];      
            $_SESSION["Events-HFEVenue.VenueName".$i] = $userArray[$i]["VenueName"];  
            $_SESSION["Events-HFEVenue.City".$i] = $userArray[$i]["City"]; 
            $_SESSION["Events-HFEVenue.Address".$i] = $userArray[$i]["Address"];  
            $_SESSION["Events-HFEVenue.Postcode".$i] = $userArray[$i]["Postcode"]; 
            $_SESSION["Events-HFEVenue.Latitude".$i] = $userArray[$i]["Latitude"];
            $_SESSION["Events-HFEVenue.Longitude".$i] = $userArray[$i]["Longitude"];
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
        $queryStatement = $this->connectTodb()->prepare("SELECT * FROM event, eventsdatetime, venue WHERE event.EventDateTime = eventsdatetime.EventDateTime AND event.VenueID = venue.VenueID AND event.EventDateTime > ? AND event.EventDateTime < ? ORDER BY event.EventDateTime ASC;");
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
            $_SESSION["Events.CDTotalEvents"] = 0;
        } else {
            for ($i=0; $i < count($keys); $i++) { 
                //Iterating through the associative array and storing them in session variables. They are also ordered through their rows in the database
                $_SESSION["Events.CDTotalEvents"] = count($keys);
                $_SESSION["Events.CDEventID".$i] = $userArray[$i]["EventID"];
                $_SESSION["Events.CDVenueID".$i] = $userArray[$i]["VenueID"];
                $_SESSION["Events.CDEventName".$i] = $userArray[$i]["EventName"];
                $_SESSION["Events.CDEventDescription".$i] = $userArray[$i]["EventDescription"];
                $_SESSION["Events.CDEventDateTime".$i] = $userArray[$i]["EventDateTime"];
                $_SESSION["Events.CDTotalTicketsBought".$i] = $userArray[$i]["TotalTicketsBought"];
                $_SESSION["Events-CDEventsDateTime.EventMonth".$i] = $userArray[$i]["EventMonth"];
                $_SESSION["Events-CDEventsDateTime.EventDay".$i] = $userArray[$i]["EventDay"];
                $_SESSION["Events-CDEventsDateTime.StartTime".$i] = $userArray[$i]["StartTime"]; 
                $_SESSION["Events-CDVenue.MaxCapacity".$i] = $userArray[$i]["MaxCapacity"];      
                $_SESSION["Events-CDVenue.VenueName".$i] = $userArray[$i]["VenueName"];  
                $_SESSION["Events-CDVenue.City".$i] = $userArray[$i]["City"]; 
                $_SESSION["Events-CDVenue.Address".$i] = $userArray[$i]["Address"];  
                $_SESSION["Events-CDVenue.Postcode".$i] = $userArray[$i]["Postcode"]; 
                $_SESSION["Events-CDVenue.Latitude".$i] = $userArray[$i]["Latitude"];
                $_SESSION["Events-CDVenue.Longitude".$i] = $userArray[$i]["Longitude"];
            }
        }       
    }
}


