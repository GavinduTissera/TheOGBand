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
                <a class="LogoNavBar" href="index.php#TopOfPage">THE OG BAND</a>
                <ul class="NavBarList">
                    <!--Options that form the navigation bar-->
                    <li><a class="NavBarHome" href="index.php#TopOfPage">HOME</a></li>
                    <li><a class="NavBarAbout" href="index.php#AboutUsSection">ABOUT</a></li>
                    <li><a class="NavBarTour" href="Pages/tour.php">BOOK TICKETS</a></li>
                    <!-- === CONTENT THAT CHANGES DEPENDENT ON LOGIN STATUS === -->
                    <!-- If user is admin, then they get access to the dashboard when they are logged in-->
                    <?php
                        if (isset($_SESSION["userid"])) {
                            if($_SESSION["userisadmin"] === 1) {
                                echo "<li><a class='NavBarAdminDashboard' href='Pages/Admin/Dashboard.php'>DASHBOARD</a></li>";
                            }
                            /* If user is not an  admin, then they get access to logout and profile but not dashboard */
                            ?>
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
                                    <li><a class="MyProfileDropdown" href="Pages/MyProfile">MY PROFILE</a></li>
                                    <li><a class="MyTicketsDropdown" href="Pages/MyTickets">MY TICKETS</a></li>
                                    <li><a class="SettingsDropdown" href="Pages/Settings">SETTINGS</a></li>
                                    <li class="LogoutButton"><a class="LogoutDropdown" href='Assets/Includes/logoutInc.php'>LOGOUT</a></li>
                                </div>
                            </div>
                            
                    <?php
                    /* If user is not logged in, they get login&signup */
                        } else {      

                            echo "<li><a class='NavBarLoginSignup' href='Pages/login.php'>LOGIN&SIGNUP</a></li>";
                        }
                    ?>
                </ul>
            </nav>
            <hr>
        </header>

        <div class="MyEventsSection">
            <h3 class="MyEventsText">NEXT EVENTS</h3>
            <div class="MyEventsTable">
                <!-- displays information for event 1 -->
                <?php
                for ($i=0; $i < 5; $i++) { 
                    if (isset($_SESSION["Events-EventMonth".$i])) {
                        ?>
                        <div class="EventsTableRow">
                            <!-- date and month go into special div to contain them -->
                            <div class="DayAndMonthBox">
                                <h4 class="EventMonth">
                                    <!-- Converts the month to uppercase and also makes it 3 letters long -->
                                    <?php
                                        echo strtoupper(substr(($_SESSION["Events-EventMonth".$i]), 0, 3));
                                    ?>
                                </h4>
                                <h3 class="EventDay">
                                    <?php
                                        echo $_SESSION["Events-EventDay".$i];
                                    ?>
                                </h3>
                            </div>
                            <div class="RestOfEventContent">
                                <h3 class="EventName">
                                    <?php
                                        echo $_SESSION["Events.EventName".$i];
                                    ?>
                                </h3>
                                <div class="TimeAndCity">
                                    <h4 class="EventTime">
                                        <i class="uil uil-clock"></i>
                                        <?php
                                            echo "Start time: ".substr(($_SESSION["Events-StartTime".$i]), 0, 5);
                                        ?>
                                    </h3>
                                    <h4 class="EventVenueNameCity">
                                        <i class="uil uil-location-pin-alt"></i>
                                        <?php
                                            echo $_SESSION["Events-Venue.VenueName".$i];
                                        ?>
                                    </h4>
                                </div>
                                <!-- buttons are used to redirect to the event page and event  -->
                                <div class="Buttons">
                                    <div class="MoreDetailsButton">
                                        <a href="EDITTHISLATER.php">
                                            <button class="EventMoreDetails">
                                                <i class="uil uil-ellipsis-h"></i>
                                                MORE DETAILS
                                            </button>
                                        </a>  
                                    </div>
                                    <div class="ViewTicketPageButton">
                                        <a href="EDITTHISLATER.php">
                                            <button class="ViewTicketPage">
                                                <i class="uil uil-external-link-alt"></i>
                                                VIEW TICKET PAGE
                                            </button>
                                        </a>  
                                    </div>
                                </div>   
                            </div>
                        </div>
                    <?php
                    }     
                }
                ?>

            </div>
        </div>
    </div>
</body>
</html>