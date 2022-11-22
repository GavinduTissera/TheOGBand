

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-signin-client_id" content="353386108292-nkn5a8fj9nmsq03saqr2svsi425meudm.apps.googleusercontent.com">
    <link rel="stylesheet" href="../CSS/reset.css">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/PagesCSS/login.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!--Document title-->
    <title>Login - The OG Band</title>
</head>
<body>


    <!--====== NAV BAR ======-->
    <header>
        <nav class="NavBar">
            <!--Text that goes to home screen when clicked-->
            <a class="LogoNavBar" href="../index.php#TopOfPage">THE OG BAND</a>
            <ul class="NavBarList">
                <!--Options that form the navigation bar-->
                <li><a class="NavBarHome" href="../index.php#TopOfPage">HOME</a></li>
                <li><a class="NavBarAbout" href="../index.php#AboutUsSection">ABOUT</a></li>
                <li><a class="NavBarTour" href="tour.php">BOOK TICKETS</a></li>
                <li><a class="NavBarLoginSignup" href="login.php">LOGIN&SIGNUP</a></li>
                
            </ul>
        </nav>
        <hr>
    </header>

    <!--====== NAV BAR END ======-->


    
    <main>
        <!--====== LOGIN BEGIN ======-->
        <div class="BackgroundImage"></div>
        <section class="Login">
            <div class="LoginContainer show">
                <div class="LoginBox">
                    <h2 class="LoginText">LOGIN</h2>
                    <div class="LoginWithGoogle">
                        <div class="errorMessages">
                            <!-- Error messages that show if the error comes up in the url-->
                            <h2 class="incorrectPassword">Your password is incorrect<br>Please try again</h2>
                            <h2 class="userNotExists">This email cannot be found<br>Please try another</h2>
                            <h2 class="userAlreadyExists">This user already exists<br>Please log in instead</h2>
                            <h2 class="failedToExcecute">The server had an error<br>Please try again later</h2>
                            <h2 class="passwordsDontMatch">The passwords don't match<br>Please try again</h2>
                            <h2 class="InvalidPermissions">Your account doesn't have permission to access that<br> <br>Please try another account</h2>
                        </div>
                        <!-- Login with google was an option here, but ended up being removed due to unnecessary complexity -->
                        <p class="EmailLogin">Login with E-Mail</p>
                    </div>
                    <!-- When the form is submitted, the form information goes to loginInc.php -->
                    <form action="../Assets/Includes/loginInc.php" method="post">
                        <div class="Input Email">
                            <i class="uil uil-envelope-alt"></i>
                            <input type="email" name="email" placeholder="E-Mail" required>
                        </div>
                        <div class="Input Password">
                            <i class="uil uil-key-skeleton"></i>
                            <input type="password" name="password" placeholder="Password" class="PasswordInput" required>
                            <div class="ShowPasswordButton"><i class="uil uil-eye-slash"></i></div>
                        </div>
                        <button class="LoginSignupSubmitButton" type="submit" name="submit">LOG IN</button>
                    </form>
                </div>
                <div class="SignupPrompt">
                    <p class="SignupPromptText">Don't have an account?</p>
                    <span class="SignupOpenButton">Sign Up!</span>
                </div>
            </div>
        </section>

        <!--====== LOGIN END ======-->

        <!--====== SIGNUP BEGIN ======-->
        <section class="Signup">
            <div class="SignupContainer hide">
                <div class="LoginPrompt">
                    <p class="LoginPromptText">Already have an account?</p>
                    <span class="LoginOpenButton">LOGIN!</span>
                </div>
                <div class="ErrorHandling">
                    
                </div>
                <div class="SignupBox">
                    <h2 class="SignupText">SIGN UP</h2>
                    <div class="SignupWithGoogle">
                        <div class="errorMessages">
                        </div>  
                        <p class="EmailSignup">Sign up with E-Mail</p>
                    </div>
                    <!-- When the form is submitted, the form information goes to signupInc.php -->
                    <form action="../Assets/Includes/signupInc.php" method="post">
                        <div class="Input Email">
                            <i class="uil uil-envelope-alt"></i>
                            <input type="email" name="email" placeholder="E-Mail" required>
                        </div>
                        <div class="Input FirstName">
                            <i class="uil uil-user"></i>
                            <input type="text" name="firstname" placeholder="First Name" required>
                        </div>
                        <div class="Input Password">
                            <i class="uil uil-key-skeleton"></i>
                            <input type="password" name="password" placeholder="Password" class="PasswordInput" required>
                            <div class="ShowPasswordButton"><i class="uil uil-eye-slash"></i></div>
                        </div>
                        <div class="Input RepeatPassword">
                            <i class="uil uil-key-skeleton"></i>
                            <input type="password" name="repeatpassword" placeholder="Repeat Password" class="PasswordInput" required>
                            <div class="ShowPasswordButton"><i class="uil uil-eye-slash"></i></div>
                        </div>
                        <button class="LoginSignupSubmitButton" type="submit" name="submit">SIGN UP</button>
                    </form>
                </div>
            </div>
        </section>
        <!--====== SIGNUP END ======-->
        
    </main>
<script type="text/javascript" src="../Javascript/login.js"></script>
</body>
</html>