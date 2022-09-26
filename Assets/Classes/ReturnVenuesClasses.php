<?php
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Includes/ini.php";
include_once "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes/CreateArrayCheckQuery.php";
include_once "C:/xampp/htdocs/ComputerScienceNEA/RootFolder/Assets/Classes/dbConnectorClasses.php";
class ReturnVenues extends dbConnector
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

    public function GetVenueList() {
        $queryStatement = $this->connectTodb()->prepare("SELECT VenueID, VenueName, MaxCapacity, Address, LocationData FROM `venue` ORDER BY `venue`.`VenueName` ASC");
        $assocArraykeys = $this->ReturnAssocArray($queryStatement);
        $userArray = $assocArraykeys[1];
        return $userArray;
    }
}


$test = new ReturnVenues;
$venueData = $test->GetVenueList();
$AmountOfVenues = count($venueData);
for ($i=0; $i < $AmountOfVenues; $i++) { 
    $VenueID[] = ($venueData[$i]["VenueID"]);
    $VenueMaxCapacity[] = ($venueData[$i]["MaxCapacity"]);
    $VenueName[] = $venueData[$i]["VenueName"];
    $VenueAddress[] = $venueData[$i]["Address"];
    $VenueLocationData[] = $venueData[$i]["LocationData"];
}
$test->AmountOfVenues = $AmountOfVenues;
$test->VenueID = $VenueID;
$test->VenueMaxCapacity = $VenueMaxCapacity;
$test->VenueName = $VenueName;
$test->VenueAddress = $VenueAddress;
$test->VenueLocationData = $VenueLocationData;
echo json_encode($test);

