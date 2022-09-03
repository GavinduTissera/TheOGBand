<?php
    include "../../../Assets/Classes/dbConnectorClasses.php";
    session_start();
    // Doesn't allow non admins by checking in the database if they are admin
    if ($_SESSION["userisadmin"] !== 1) {
        header("location: ../../../Pages/login.php?error=InvalidPermissions");
    }
    include "../../../Assets/Includes/adminDashboardInc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../CSS/reset.css">
    <link rel="stylesheet" href="../../../CSS/styles.css">
    <link rel="stylesheet" href="../../../CSS/PagesCSS/createconcert.css">
    <link rel="stylesheet" href="../../../CSS/PagesCSS/createConcertPages/concert3.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://kit.fontawesome.com/62b71b12cb.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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
                <li><a class="NavBarHome" href="../../../index.php#TopOfPage">USER HOME</a></li>
                <li><a class="NavBarAbout" href="../Dashboard.php">DASHBOARD</a></li>
                <li><a class="NavBarTour" href="../CreateConcert/1.php">CREATE CONCERT</a></li>
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
                        <li><a class="MyProfileDropdown" href="../../../Pages/MyProfile">MY PROFILE</a></li>
                        <li><a class="MyTicketsDropdown" href="../../../Pages/MyTickets">MY TICKETS</a></li>
                        <li><a class="SettingsDropdown" href="../../../Pages/Settings">SETTINGS</a></li>
                        <li class="LogoutButton"><a class="LogoutDropdown" href='../../../Assets/Includes/logoutInc.php'>LOGOUT</a></li>
                    </div>
                </div>
            </ul>
        </nav>
        <hr>
    </header>

    <main>
        <div class="ProgressBar">
            <ul class="ProgressList">
                <div class="TopBar">
                    <li><a href="1.php" class="SideBarOverview One">
                        <i class="fa-solid fa-check"></i>
                        <h4 class="ProgressBarText Basics">EVENT BASICS</h4>
                    </a></li>
                    <li><a href="2.php" class="SideBarOverview Two">
                        <i class="fa-solid fa-check"></i>
                        <h4 class="ProgressBarText DateTime">DATE AND TIME</h4>
                    </a></li>
                    <li><a href="3.php" class="SideBarOverview Three">
                        <i class="fa-solid fa-3"></i>
                        <h4 class="ProgressBarText Location">LOCATION</h4>
                    </a></li>
                    <li><a href="4.php" class="SideBarOverview Four">
                        <i class="fa-solid fa-4"></i>
                        <h4 class="ProgressBarText Tickets">TICKETS</h4>
                    </a></li>
                </div>
            </ul>
            <div class="ProgressBarContainer">
                <div class="Bar"></div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <h2 class="CreateConcertTitle">LOCATION</h1>
        <div class="MainForm">
            <form action="../../../Assets/Includes/createEventInc.php" method="post">
            <div class="FormInformation">
                    <h3 class="shortDescription"> Set the name and description of your concert</h3>
                    <div class="OneLineSubmission">
                        <label for="ConcertNameInput" class="FormText">
                            <h4 class="ConcertName">What is the name of your concert? </h4>
                            <h6 class="requiredStar">*</h6>
                        </label>
                        <input type="text" name="ConcertNameInput" id="ConcertNameInput" value="<?php
                        if(isset($_SESSION["TempConcertName"])){
                            echo $_SESSION["TempConcertName"]; 
                        };?>" required>
                    </div>
                    <div class="LongTextSubmission ">
                        <label for="ConcertDescriptionInput" class="FormText">
                            <h4 class="ConcertDescription">
                                <div class="tooltip">
                                    Give a description of your concert. 
                                    <h5 class="Tooltiptext">This information will be shown to users on the events screen</h5>
                                </div>
                            </h4>
                            <h6 class="requiredStar">*</h6>
                        </label>
                        <textarea name="ConcertDescriptionInput" id="ConcertDescriptionInput" cols="130" rows="5" required><?php
                        if(isset($_SESSION["TempConcertDescription"])){
                            echo $_SESSION["TempConcertDescription"]; 
                        };?></textarea>
                    </div>
                    <div class="AutosaveMessage"></div>
                    <button class="SubmitButton" type="submit" name="submitPageOne">
                        <span class="submitting">
                            SUBMIT
                        </span>  
                    </button>
                    <div class="BottomText">
                        <div class="FormText">
                            <h6 class="requiredStar">* </h6>
                            <h5 class="SmallText"> - Required</h6>
                        </div> <br>
                        <h5 class="SmallText FormText">New events are automatically set as unlisted until made public in the events menu</h5>
                    </div>
                    
                </div>
            </form>
        </div>
    </main>
    <script type="module">
    </script>
</body>
</html>