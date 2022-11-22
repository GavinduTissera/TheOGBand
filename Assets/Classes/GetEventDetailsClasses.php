<?php
header("Content-Type: application/json; charset=UTF-8");
//Gets information from the URL for the ID
$obj = json_decode($_GET["id"], false);
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Includes/ini.php";
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes/CreateArrayCheckQuery.php";
include "C:/xampp/htdocs/ComputerScienceNEA/RootFolder/Assets/Classes/dbConnectorClasses.php";


class GetEventDetailsController extends dbConnector
{
    //Initialise variables
    var $EventID;

    //Constructor
    public function __construct($EventID)
    {
        $this->EventID = $EventID;
    }


    //Gets an associative array of the event information for the specific event ID given.
    public function ReturnAssocArray($queryStatement)
    {
        $queryStatement->execute([$this->EventID]);
        //Checks if the query is excecutable and creates a 2d associative array.
        $eventDatabaseCheck = new CreateArrayCheckQuery();
        $eventDatabaseCheck->CheckifExcecutableQuery($queryStatement);
        $userArray = $eventDatabaseCheck->GetAssocArray($queryStatement);
        $keys = array_keys($userArray);
        // As it is not possible to return 2 items at once, an array is used
        $returnedArray = [$keys, $userArray];
        return $returnedArray;
    }

    protected function GetEventDetailsQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT * FROM event, venue WHERE event.EventID = ? AND event.VenueID = venue.VenueID;");
        return $queryStatement;
    }

    protected function GetTicketDetailsQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT * FROM tickets WHERE tickets.EventID = ?;");
        return $queryStatement;
    }

    public function GetEventsDataFromDB()
    {
        $queryStatement = $this->GetEventDetailsQuery();
        $assocArraykeys = $this->ReturnAssocArray($queryStatement);
        // Date formatting to get a presentable format
        $EventStartDate = date("l jS M Y", strtotime($assocArraykeys[1][0]["EventStartTime"]));
        $EventEndDate = date("l jS M Y", strtotime($assocArraykeys[1][0]["EventEndTime"]));
        if ($EventStartDate == $EventEndDate) {
            $EventEndTime = date("H:i", strtotime($assocArraykeys[1][0]["EventEndTime"]));
        } else {
            $EventEndTime = date("jS M, H:i", strtotime($assocArraykeys[1][0]["EventEndTime"]));
        }
        $EventStartTime = date("l jS M Y, H:i", strtotime($assocArraykeys[1][0]["EventStartTime"]));
        $fullEventsEndTime = date("l jS M Y, H:i", strtotime($assocArraykeys[1][0]["EventEndTime"]));
        $assocArraykeys[1][0]["EventStartTime"] = $EventStartTime;
        $assocArraykeys[1][0]["EventEndTime"] = $fullEventsEndTime;
        $assocArraykeys[1][0]["EventDateTime"] = ($EventStartTime." to ".$EventEndTime);
        //Location formatting to get a presentable format
        $assocArraykeys[1][0]["EventLocation"] = $assocArraykeys[1][0]["VenueName"].", ".$assocArraykeys[1][0]["Address"];
        $queryStatementTwo = $this->GetTicketDetailsQuery();
        $assocArraykeysTwo = $this->ReturnAssocArray($queryStatementTwo);
        $assocArraykeys = [$assocArraykeys, $assocArraykeysTwo];
        echo json_encode($assocArraykeys);
    }
}

$eventsData = new GetEventDetailsController($obj);
$eventsData->GetEventsDataFromDB();