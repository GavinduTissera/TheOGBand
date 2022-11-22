<?php
include "../Includes/ini.php";
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes/CreateArrayCheckQuery.php";
include_once "C:/xampp/htdocs/ComputerScienceNEA/RootFolder/Assets/Classes/dbConnectorClasses.php";


//Makes the event public, given an event ID
class MakeEventPublic extends dbConnector
{
    //Selects the most recent event from the database, and gets its eventID
    protected function GetMostRecentEventQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT EventID FROM event ORDER BY EventID DESC LIMIT 1;");
        return $queryStatement;
    }

    //Given an eventID it sets the EventVisibility to public
    protected function MakeEventPublic($EventID)
    {
        $queryStatement = $this->connectTodb()->prepare("UPDATE event SET EventVisibility = 'Public' WHERE event.EventID = ?;");
        $queryStatement->bindParam(1,$EventID);
        return $queryStatement;
    }

    //It gets the most recent eventID and calls makeEventPublic using that ID.
    public function MakeMostRecentEventPublic()
    {
        $queryStatement = $this->GetMostRecentEventQuery();
        $queryStatement->execute();
        $assocArray = new CreateArrayCheckQuery;
        $EventArray = $assocArray->GetAssocArray($queryStatement);
        $EventID = $EventArray[0]["EventID"];
        $queryStatement = $this->MakeEventPublic($EventID);
        $queryStatement->execute();
    }


}

$makeeventpublic = new MakeEventPublic;
$makeeventpublic->MakeMostRecentEventPublic();
header("location: ../../Pages/Admin/Dashboard.php");
