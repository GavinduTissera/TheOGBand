<?php


include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Includes/ini.php";
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes/CreateArrayCheckQuery.php";
include "C:/xampp/htdocs/ComputerScienceNEA/RootFolder/Assets/Classes/dbConnectorClasses.php";

class FutureEventsController extends dbConnector
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

    protected function GetFutureEventsDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT *, DAY(EventStartTime), MONTHNAME(EventStartTime), TIME(EventStartTime), TIME(EventEndTime) FROM event, venue WHERE event.VenueID = venue.VenueID AND CURRENT_TIMESTAMP < event.EventStartTime AND event.EventVisibility = 'Public' ORDER BY event.EventStartTime ASC;");
        return $queryStatement;
    }

    protected function GetCapacityTickets()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT EventID, MaxCapacity, TotalTicketsBought FROM `event`, venue WHERE event.VenueID = venue.VenueID AND CURRENT_TIMESTAMP < event.EventStartTime AND event.EventVisibility = 'Public' ORDER BY event.EventStartTime ASC;");
        return $queryStatement;
    }

    public function GetEventsDataFromDB()
    {
        $queryStatement = $this->GetFutureEventsDataQuery();
        $assocArraykeys = $this->ReturnAssocArray($queryStatement);
        $queryStatementTwo = $this->GetCapacityTickets();
        $assocArraykeysTwo = $this->ReturnAssocArray($queryStatementTwo);
        $keys = $assocArraykeys[0];
        $keyCount = count($keys);
        array_push($assocArraykeys, $assocArraykeysTwo, $keyCount);
        echo json_encode($assocArraykeys);
        
    }
}


$eventsData = new FutureEventsController();
$eventsData->GetEventsDataFromDB();
