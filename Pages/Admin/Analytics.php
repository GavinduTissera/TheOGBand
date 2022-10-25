<?php
    include "../../Assets/Classes/dbConnectorClasses.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../Images/Icons/TheOGBandLogoHD.png">
    <link rel="stylesheet" href="../../CSS/reset.css">
    <link rel="stylesheet" href="../../CSS/styles.css">
    <link rel="stylesheet" href="../../CSS/PagesCSS/dashboard.css">
    <link rel="stylesheet" href="../../CSS/PagesCSS/analytics.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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
                <li><a class="NavBarTour" href="CreateConcert/1.php">CREATE CONCERT</a></li>
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

    <!-- top selector content  -->

    <div class="Sidebar">
        <ul class="SideBarList">
            <!-- Boxes for the main statistics for overview section  -->
            <div class="OverviewBox">
                <li><a href="Dashboard.php" class="SideBarOverview">
                    <i class="uil uil-chart-bar"></i>
                    <h4 class="SideBarText Overview">OVERVIEW</h4>
                </a></li>
            </div>
            <div class="MyEventsBox"> 
                <li><a href="MyEvents.php" class="SideBarMyEvents">
                    <i class="uil uil-headphones"></i>
                    <h4 class="SideBarText MyEvents">MY EVENTS</h4>
                </a></li>
            </div>
            <div class="MyOrdersBox"> 
                <li><a href="MyOrders.php" class="SideBarMyEvents">
                <i class="uil uil-shopping-basket"></i>
                    <h4 class="SideBarText MyOrders">MY ORDERS</h4>
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

    <main>
        <h2 class="OverviewText">ANALYTICS</h2>
        <section class="mainGraphs">
            <!-- want to have main graphs with all the costs, as well as locations of users who have logged in by country. -->
            <!-- main graphs: total revenue, total tickets sold, total signed-up users -->
            <canvas class="totalRevenueGraph" id="totalRevenueGraph" ></canvas>
        </section>
    </main>
    <!-- Adding the link to the analytics js file -->
    <script src="../../Javascript/analytics.js"></script>
</body>
</html>