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

class InsertTicketController extends dbConnector
{
    //Initialising attributes
    var $TicketName;
    var $TicketQuantity;
    var $TicketPrice;
    var $TicketDescription;
    var $MaxTickets;

    //Constructor
    public function __construct($TicketName, $TicketQuantity, $TicketPrice, $TicketDescription, $MaxTickets)
    {
        $this->TicketName = $TicketName;
        $this->TicketQuantity = $TicketQuantity;
        $this->TicketPrice = $TicketPrice;
        $this->TicketDescription = $TicketDescription;
        $this->MaxTickets = $MaxTickets;
    }

    
    private function addTicketToDBQuery()
    {
        //Prepares an insert statement to add a new ticket type to the tickets table. Uses placeholders.
        $queryStatement = $this->connectTodb()->prepare("INSERT INTO tickets (TicketName, TicketQuantity, TicketPrice, TicketDescription, MaxTickets) VALUES (?, ?, ?, ?, ?)");
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
        try {
            $queryStatement = $this->addTicketToDBQuery();
            $queryStatement->execute([$this->TicketName, $this->TicketQuantity, $this->TicketPrice, $this->TicketDescription, $this->MaxTickets]);
        } catch (\PDOException) {
            $queryStatement = null;
            echo "there has been a problem";
        }
        $queryStatement = null;
    }

    public function GetNewIDsOfTickets($count)
    {
        // try {
            $queryStatement = $this->GetIDsOfTickets();
            $queryStatement->execute([$count]);
            $getIDs = new CreateArrayCheckQuery();
            $TicketIDs = $getIDs->GetAssocArray($queryStatement);
            session_start();
            $_SESSION["TicketAssoc"] = $TicketIDs;
        // } catch (\PDOException) {
        //     $queryStatement = null;
        //     echo "there has been a problem";
        // }
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


class InsertTicketsPerEventController extends dbConnector
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