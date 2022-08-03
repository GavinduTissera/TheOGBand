<?php
include "ini.php";

if ($_SESSION["userisadmin"] === 1) {
    include_once "C:/xampp\htdocs\Computer Science NEA\RootFolder\Assets\Classes\dbConnectorClasses.php";
    include_once "C:/xampp\htdocs\Computer Science NEA\RootFolder\Assets\Classes\AdminDashboardClasses.php";
    $salesData = new DashboardController();
    $salesData->GetSalesDataFromDB();
}
