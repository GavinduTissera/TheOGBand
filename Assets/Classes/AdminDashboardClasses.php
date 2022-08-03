<?php
include "C:/xampp\htdocs\Computer Science NEA\RootFolder\Assets\Includes/ini.php";


//Inherit from db connector class.
class DashboardController extends dbConnector
{
    //Gets all of the sales data to use on the front page
    protected function GetSalesDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT * FROM sales ORDER BY DateOfRecord DESC LIMIT 1;");
        return $queryStatement;
    }

    // Create an associative array of the data that is taken from the database
    public function GetAssocArray($queryStatement)
    {
        $temp = $queryStatement->fetchAll(PDO::FETCH_ASSOC);
        return $temp;
    }

    //Returns error message if database doesn't excecute the query properly
    protected function CheckifExcecutableQuery()
    {
        $queryStatement = $this->GetSalesDataQuery();
        if (!$queryStatement->execute()) {
            $queryStatement = null;
            exit();
        }
        $queryStatement = null;
    }

    public function GetSalesDataFromDB()
    {
        $queryStatement = $this->GetSalesDataQuery();
        $queryStatement->execute();
        $this->CheckifExcecutableQuery();
        $userArray = $this->GetAssocArray($queryStatement);
        $_SESSION["Sales.NetEarnings"] = $userArray[0]["NetEarnings"];
        $_SESSION["Sales.TotalAttendees"] = $userArray[0]["TotalAttendees"];
        $_SESSION["Sales.TotalOrders"] = $userArray[0]["TotalOrders"];
        $_SESSION["Sales.TotalRefunded"] = $userArray[0]["TotalRefunded"];
    }

}
