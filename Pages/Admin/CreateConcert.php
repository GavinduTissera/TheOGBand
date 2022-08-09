<?php
    include "../../Assets/Classes/dbConnectorClasses.php";
    session_start();
    // Doesn't allow non admins by checking in the database if they are admin
    if ($_SESSION["userisadmin"] !== 1) {
        header("location: ../../Pages/login.php?error=InvalidPermissions");
    }
    include "../../Assets/Includes/adminDashboardInc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/reset.css">
    <link rel="stylesheet" href="../../CSS/styles.css">
    <link rel="stylesheet" href="../../CSS/PagesCSS/createconcert.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- === Link to javascript === -->
    
    <!--Document title-->
    <title>The OG Band Admin</title>
</head>
<body>


    <!--======NAV BAR======-->
    <header>
        <nav class="NavBar">
            <!--Text that goes to home screen when clicked-->
            <a class="LogoNavBar" href="Dashboard.php">THE OG BAND ADMIN</a>
            <ul class="NavBarList">
                <!--Options that form the navigation bar-->
                <li><a class="NavBarHome" href="../../index.php#TopOfPage">USER HOME</a></li>
                <li><a class="NavBarAbout" href="Dashboard.php">DASHBOARD</a></li>
                <li><a class="NavBarTour" href="CreateConcert.php">CREATE CONCERT</a></li>
                <div class="DropdownProfileMenu">
                    <li><a class='NavBarProfile' href='index.php'>
                        <?php
                        //echo's out the name of the user. If it is longer than 10 characters it is truncated to not overfill the screen
                        if (strlen($_SESSION["userfirstname"]) >= 10) {
                            echo substr($_SESSION["userfirstname"],0,10)."...";
                        } else {
                            echo $_SESSION["userfirstname"];
                        }
                        
                        ?>
                    </a></li>
                    <div class="DropdownContent">
                        <li><a class="MyProfileDropdown" href="../../Pages/MyProfile">MY PROFILE</a></li>
                        <li><a class="MyTicketsDropdown" href="../../Pages/MyTickets">MY TICKETS</a></li>
                        <li><a class="SettingsDropdown" href="../../Pages/Settings">SETTINGS</a></li>
                        <li class="LogoutButton"><a class="LogoutDropdown" href='../../Assets/Includes/logoutInc.php'>LOGOUT</a></li>
                    </div>
                </div>
            </ul>
        </nav>
        <hr>
    </header>

    <main>
        <div class="ProgressBar">
            <ul class="ProgressList">
                <div class="EventBasics">
                    <li><a href="Dashboard.php" class="SideBarOverview">
                        <i class="uil uil-chart-bar"></i>
                        <h4 class="SideBarText Overview">OVERVIEW</h4>
                    </a></li>
                </div>
            </ul>
        </div>
    </main>