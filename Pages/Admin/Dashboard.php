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
    <link rel="stylesheet" href="../../CSS/PagesCSS/dashboard.css">
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
                        echo $_SESSION["userfirstname"];
                        ?>
                    </a></li>
                    <div class="DropdownContent">
                        <li><a class="MyProfileDropdown" href="Pages/MyProfile">MY PROFILE</a></li>
                        <li><a class="MyTicketsDropdown" href="Pages/MyTickets">MY TICKETS</a></li>
                        <li><a class="SettingsDropdown" href="Pages/Settings">SETTINGS</a></li>
                        <li class="LogoutButton"><a class="LogoutDropdown" href='Assets/Includes/logoutInc.php'>LOGOUT</a></li>
                    </div>
                </div>
            </ul>
        </nav>
        <hr>
    </header>

    <!-- top selector content  -->

    <div class="Sidebar">
        <ul class="SideBarList">
            <div class="OverviewBox">
                <li><a href="Dashboard.php" class="SideBarOverview">
                    <i class="uil uil-chart-bar"></i>
                    <h4 class="SideBarText Overview">OVERVIEW</h4>
                </a></li>
            </div>
            <div class="MyEventsBox"> 
                <li><a href="AdminEvents.php" class="SideBarMyEvents">
                    <i class="uil uil-headphones"></i>
                    <h4 class="SideBarText MyEvents">MY EVENTS</h4>
                </a></li>
            </div>
            <div class="AnalyticsBox">
                <li><a href="Analytics.php" class="SideBarAnalytics">
                    <i class="uil uil-chart-line"></i>
                    <h4 class="SideBarText Analytics">ANALYTICS</h4>
                </a></li>
            </div>
            <div class="SettingsBox">
                <li><a href="Settings.php" class="SideBarSettings">
                    <i class="uil uil-setting"></i>
                    <h4 class="SideBarText Settings">SETTINGS</h4>
                </a></li>
            </div>
        </ul>
        <div class="Search">
                <div class="searchButton">
                    <i class="uil uil-search"></i>
                </div>
            <input class="SearchBox" type="text" placeholder="Search...">
        </div>
        
    </div>

    <!-- Page content -->
    <section class="OverviewPage">
        <h2 class="OverviewText">OVERVIEW</h2>
        <div class="OverviewBoxes">
            <div class="RevenueBox">
                <h3 class="Topic Revenue">TOTAL TICKET REVENUE</h3>
                <p class="TotalRevenue">£
                    <?php
                        echo $_SESSION["Sales.NetEarnings"];
                    ?>
                </p>
            </div>
            <div class="TicketsSoldBox">
                <h3 class="Topic Attendees">TOTAL TICKETS SOLD</h3>
                <p class="TotalTicketsSold">
                    <?php
                        echo $_SESSION["Sales.TotalAttendees"];
                    ?>
                </p>
            </div>
            <div class="TotalOrdersBox">
                <h3 class="Topic Orders">TOTAL ORDERS</h3>
                <p class="TotalOrders">
                    <?php
                        echo $_SESSION["Sales.TotalOrders"];
                    ?>
                </p>
            </div>
            <div class="TotalRefundsBox">
                <h3 class="Topic Refunds">TOTAL REFUNDS</h3>
                <p class="TotalRefunds">
                    <?php
                        echo $_SESSION["Sales.TotalRefunded"];
                    ?>
                </p>
            </div>
        </div>
        
    </section>
</body>
</html>