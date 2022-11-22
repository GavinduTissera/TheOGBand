<?php
    include "../Assets/Classes/dbConnectorClasses.php";
    session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/reset.css">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/PagesCSS/tour.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- === Link to javascript scroll reveal library === -->
    <script src="https://unpkg.com/scrollreveal@4"></script>
	<script>
		ScrollReveal({ 
            distance: "100px",
            duration: 1500,
            delay: 200
        })
	</script>
    <!--Document title-->
    <title>The OG Band</title>
</head>
<body>
    <div class="Wrapper">
        <!--======NAV BAR======-->
        <header>
            <nav class="NavBar">
                <!--Text that goes to home screen when clicked-->
                <a class="LogoNavBar" href="../index.php#TopOfPage">THE OG BAND</a>
                <ul class="NavBarList">
                    <!--Options that form the navigation bar-->
                    <li><a class="NavBarHome" href="../index.php#TopOfPage">HOME</a></li>
                    <li><a class="NavBarAbout" href="../index.php#AboutUsSection">ABOUT</a></li>
                    <li><a class="NavBarTour" href="tour.php">BOOK TICKETS</a></li>
                    <!-- === CONTENT THAT CHANGES DEPENDENT ON LOGIN STATUS === -->
                    <!-- If user is admin, then they get access to the dashboard when they are logged in-->
                    <?php
                        if (isset($_SESSION["userid"])) {
                            if($_SESSION["userisadmin"] === 1) {
                                echo "<li><a class='NavBarAdminDashboard' href='Admin/Dashboard.php'>DASHBOARD</a></li>";
                            }
                            /* If user is not an  admin, then they get access to logout and profile but not dashboard */
                            ?>
                            <div class="DropdownProfileMenu">
                                <li><a class='NavBarProfile' href='../index.php'>
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
                                    <li><a class="MyProfileDropdown" href="MyProfile">MY PROFILE</a></li>
                                    <li><a class="MyTicketsDropdown" href="MyTickets">MY TICKETS</a></li>
                                    <li><a class="SettingsDropdown" href="Settings">SETTINGS</a></li>
                                    <li class="LogoutButton"><a class="LogoutDropdown" href='../Assets/Includes/logoutInc.php'>LOGOUT</a></li>
                                </div>
                            </div>
                            
                    <?php
                    /* If user is not logged in, they get login&signup */
                        } else {      

                            echo "<li><a class='NavBarLoginSignup' href='login.php'>LOGIN&SIGNUP</a></li>";
                        }
                    ?>
                </ul>
            </nav>
            <hr>
        </header>
        <div class="BackgroundImage"></div>
        <div class="MyEventsSection">
            <h2 class="MyEventsText">NEXT EVENTS
            </h2>
            <!-- The script adds the table rows here -->
            <div class="MyEventsTable"></div>
        </div>
    </div>
    <script src="../Javascript/JSONRequests/concertdates.js"></script>
</body>
</html>