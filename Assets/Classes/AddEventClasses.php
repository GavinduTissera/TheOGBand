<?php
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Includes/ini.php";
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes/CreateArrayCheckQuery.php";

class InsertVenueController extends dbConnector
{
    //Initialising attributes
    var $maxCapacity;
    var $venueName;
    var $address;
    var $locationData;

    //Constructor
    public function __construct($maxCapacity, $venueName, $address, $locationData)
    {
        $this->maxCapacity = $maxCapacity;
        $this->venueName = $venueName;
        $this->address = $address;
        $this->locationData = $locationData;
    }

    
    private function addVenueToDBQuery()
    {
        //Prepares an insert statement to add a new venue to the venue table. Uses placeholders.
        $queryStatement = $this->connectTodb()->prepare("INSERT INTO venue (MaxCapacity, VenueName, Address, LocationData) VALUES (?, ?, ?, ?)");
        return $queryStatement;
    }

    private function GetIDOfVenue()
    {
        //Selects the last ID in the venue table
        $queryStatement = $this->connectTodb()->prepare("SELECT VenueID FROM `venue` ORDER BY VenueID DESC LIMIT 1;");
        return $queryStatement;
    }

    public function addVenueToDB()
    {
        //Tries to add a venue record in the database with the data given, and also returns the ID of the venue
        try {
            $queryStatement = $this->addVenueToDBQuery();
            $queryStatement->execute([$this->maxCapacity, $this->venueName, $this->address, $this->locationData]);
            $queryStatement = $this->GetIDOfVenue();
            $queryStatement->execute();
            $getID = new CreateArrayCheckQuery();
            $VenueID = $getID->GetAssocArray($queryStatement);
            session_start();
            $_SESSION["TempVenueID"] = $VenueID[0]["VenueID"];
        } catch (\PDOException) {
            $queryStatement = null;
            echo "there has been a problem";
        }
        $queryStatement = null;
    }
    
}

class GetVenueCapacityController extends dbConnector
{
    var $venueID;

    //Constructor
    public function __construct($venueID)
    {
        $this->venueID = $venueID;
    }

    private function getMaxCapacityQuery()
    {
        //Prepares an insert statement to add a new venue to the venue table. Uses placeholders.
        $queryStatement = $this->connectTodb()->prepare("SELECT MaxCapacity FROM `venue` WHERE VenueID = ?;");
        return $queryStatement;
    }

    public function getMaxCapacity()
    {
        //Selects the max capacity of a venue when given a venue ID. Stores it in TempMaxcapacity
        try {
            $queryStatement = $this->getMaxCapacityQuery();
            $queryStatement->execute([$this->venueID]);
            $getCapacity = new CreateArrayCheckQuery();
            $VenueCapacity = $getCapacity->GetAssocArray($queryStatement);
            session_start();
            $_SESSION["TempMaxCapacity"] = $VenueCapacity[0]["MaxCapacity"];
        } catch (\PDOException) {
            $queryStatement = null;
            echo "there has been a problem";
        }
        $queryStatement = null;
    }
}


class InsertTicketController extends dbConnector
{
    //Initialising attributes  
    var $TicketName;
    var $TicketQuantity;
    var $TicketPrice;
    var $TicketDescription;
    var $MaxTickets;
    var $EventID;
    var $TicketsSold;
    var $TicketAvailability;

    //Constructor
    public function __construct($TicketName, $TicketQuantity, $TicketPrice, $TicketDescription, $MaxTickets, $EventID, $TicketsSold, $TicketAvailability)
    {
        $this->TicketName = $TicketName;
        $this->TicketQuantity = $TicketQuantity;
        $this->TicketPrice = $TicketPrice;
        $this->TicketDescription = $TicketDescription;
        $this->MaxTickets = $MaxTickets;
        $this->EventID = $EventID;
        $this->TicketsSold = $TicketsSold;
        $this->TicketAvailability = $TicketAvailability;
    }

    
    private function addTicketToDBQuery()
    {
        //Prepares an insert statement to add a new ticket type to the tickets table. Uses placeholders.
        $queryStatement = $this->connectTodb()->prepare("INSERT INTO tickets (TicketName, TicketQuantity, TicketPrice, TicketDescription, MaxTickets, EventID, TicketsSold, TicketAvailability) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $queryStatement;
    }

    private function GetIDsOfTickets()
    {
        //Selects the last ID in the venue table
        $queryStatement = $this->connectTodb()->prepare("SELECT TicketTypeID FROM `tickets` ORDER BY TicketTypeID DESC LIMIT ?;");
        return $queryStatement;
    }

    public function addTicketToDB()
    {
        //For each ticket type, this adds a single record to a database of a ticket
        try {
            $queryStatement = $this->addTicketToDBQuery();
            $queryStatement->execute([$this->TicketName, $this->TicketQuantity, $this->TicketPrice, $this->TicketDescription, $this->MaxTickets, $this->EventID, $this->TicketsSold, $this->TicketAvailability]);
        } catch (\PDOException) {
            $queryStatement = null;
            echo "there has been a problem";
        }
        $queryStatement = null;
    }

    public function GetNewIDsOfTickets($count)
    {
        //Gets the ID's of the tickets that have just been added
        $queryStatement = $this->GetIDsOfTickets();
        $queryStatement->execute([$count]);
        $getIDs = new CreateArrayCheckQuery();
        $TicketIDs = $getIDs->GetAssocArray($queryStatement);
        session_start();
        $_SESSION["TicketAssoc"] = $TicketIDs;
        $queryStatement = null;
    }
    
}

class InsertEventController extends dbConnector
{
    //Initialising attributes
    var $VenueID;
    var $EventName;
    var $EventDescription;
    var $EventStartTime;
    var $EventEndTime;

    //Constructor
    public function __construct($VenueID, $EventName, $EventDescription, $EventStartTime, $EventEndTime)
    {
        $this->VenueID = $VenueID;
        $this->EventName = $EventName;
        $this->EventDescription = $EventDescription;
        $this->EventStartTime = $EventStartTime;
        $this->EventEndTime = $EventEndTime;
    }

    
    private function addEventToDBQuery()
    {
        //Prepares an insert statement to add a new venue to the venue table. Uses placeholders.
        $queryStatement = $this->connectTodb()->prepare("INSERT INTO event (VenueID, EventName, EventDescription, EventStartTime, EventEndTime, TotalTicketsBought, EventVisibility) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $queryStatement;
    }

    private function GetIDOfEvent()
    {
        //Selects the last ID in the venue table
        $queryStatement = $this->connectTodb()->prepare("SELECT EventID FROM `event` ORDER BY EventID DESC LIMIT 1;");
        return $queryStatement;
    }

    public function addEventToDB()
    {
        //Adds an event to the database and gets the ID of it
        try {
            $queryStatement = $this->addEventToDBQuery();
            $queryStatement->execute([$this->VenueID, $this->EventName, $this->EventDescription, $this->EventStartTime, $this->EventEndTime, 0, "Unlisted"]);
            $queryStatement = $this->GetIDOfEvent();
            $queryStatement->execute();
            $getID = new CreateArrayCheckQuery();
            $EventID = $getID->GetAssocArray($queryStatement);
            session_start();
            $_SESSION["TempEventID"] = $EventID[0]["EventID"];
        } catch (\PDOException) {
            $queryStatement = null;
            echo "there has been a problem";
        }
        $queryStatement = null;
    }
    
}


// class InsertTicketsPerEventController extends dbConnector
// {
//     //Initialising attributes
//     var $VenueID;
//     var $EventName;
//     var $EventDescription;
//     var $EventStartTime;
//     var $EventEndTime;

//     //Constructor
//     public function __construct($VenueID, $EventName, $EventDescription, $EventStartTime, $EventEndTime)
//     {
//         $this->VenueID = $VenueID;
//         $this->EventName = $EventName;
//         $this->EventDescription = $EventDescription;
//         $this->EventStartTime = $EventStartTime;
//         $this->EventEndTime = $EventEndTime;
//     }

    
//     private function addEventToDBQuery()
//     {
//         //Prepares an insert statement to add a new venue to the venue table. Uses placeholders.
//         $queryStatement = $this->connectTodb()->prepare("INSERT INTO event (VenueID, EventName, EventDescription, EventStartTime, EventEndTime, TotalTicketsBought, EventVisibility) VALUES (?, ?, ?, ?, ?, ?, ?)");
//         return $queryStatement;
//     }

//     private function GetIDOfEvent()
//     {
//         //Selects the last ID in the venue table
//         $queryStatement = $this->connectTodb()->prepare("SELECT EventID FROM `event` ORDER BY EventID DESC LIMIT 1;");
//         return $queryStatement;
//     }

//     public function addEventToDB()
//     {
//         try {
//             $queryStatement = $this->addEventToDBQuery();
//             $queryStatement->execute([$this->VenueID, $this->EventName, $this->EventDescription, $this->EventStartTime, $this->EventEndTime, 0, "Unlisted"]);
//             $queryStatement = $this->GetIDOfEvent();
//             $queryStatement->execute();
//             $getID = new CreateArrayCheckQuery();
//             $EventID = $getID->GetAssocArray($queryStatement);
//             session_start();
//             $_SESSION["TempEventID"] = $EventID[0]["EventID"];
//         } catch (\PDOException) {
//             $queryStatement = null;
//             echo "there has been a problem";
//         }
//         $queryStatement = null;
//     }
    
// }
