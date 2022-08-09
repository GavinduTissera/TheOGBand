<?php
include "ini.php";

if ($_SESSION["userisadmin"] === 1) {
    include_once "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes\dbConnectorClasses.php";
    include_once "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes\AdminDashboardClasses.php";
    $salesData = new SalesController();
    $salesData->GetTotalRevenueQuery();
    $salesData->GetTotalTicketsQuery();
    $salesData->GetTotalOrdersQuery();
    $salesData->GetTotalUsersQuery();
    $salesData->GetTotalRefundedQuery();
    $salesData->GetTotalOrdersIncQuery();
    $salesData->GetAvgTicketsPerOrderQuery();
    $salesData->GetAvgTicketPriceQuery();
    $eventsData = new EventsController();
    $eventsData->GetEventsDataFromDB();
}
