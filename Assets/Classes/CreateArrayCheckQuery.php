<?php
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Includes/ini.php";

class CreateArrayCheckQuery
{
    // Create an associative array of the data that is taken from the database
    public function GetAssocArray($queryStatement)
    {
        $temp = $queryStatement->fetchAll(PDO::FETCH_ASSOC);
        return $temp;
    }

    //Returns error message if database doesn't excecute the query properly
    public function CheckifExcecutableQuery($queryStatement)
    {
        if (!$queryStatement->execute()) {
            $queryStatement = null;
            exit();
        }
        $queryStatement = null;
    }

}