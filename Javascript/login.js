

// PASSWORD SHOW/HIDE BUTTON

//Labelling the arrays given by password input and showpasswordbutton
var passwordInputType = document.querySelectorAll(".PasswordInput");
var ShowPasswordButton = document.querySelectorAll(".ShowPasswordButton");

//Since there are multiple instances of both password input type and show password button you need to loop through them
for (let i = 0; i < ShowPasswordButton.length; i++) {
    //Setting an event listener
    ShowPasswordButton[i].addEventListener("click", () => {
        //if the type is password, it gets reverted to text, and vice versa
        if (passwordInputType[i].type === "password") {
            passwordInputType[i].type = "text"
            ShowPasswordButton[i].innerHTML = "<i class='uil uil-eye'></i>"
        } else {
            passwordInputType[i].type = "password"
            ShowPasswordButton[i].innerHTML = "<i class='uil uil-eye-slash'></i>"
        }
    });
}

//Switching between login and signup

//setting constants of signup and login buttons and forms
const LoginButton = document.querySelector(".LoginOpenButton")
const SignupButton = document.querySelector(".SignupOpenButton")
const LoginForm = document.querySelector(".LoginContainer")
const SignupForm = document.querySelector(".SignupContainer")

//Setting event listeners, so that if the login or signup buttons are pressed, the signup or login form is hidden, and the other one is shown

LoginButton.addEventListener("click", () => {
    SignupForm.classList.remove("show")
    SignupForm.classList.add("hide")
    LoginForm.classList.remove("hide")
    LoginForm.classList.add("show")
});

SignupButton.addEventListener("click", () => {
    LoginForm.classList.remove("show")
    LoginForm.classList.add("hide")
    SignupForm.classList.remove("hide")
    SignupForm.classList.add("show")
});

// === ERROR MESSAGES ===
//Getting the locations of the error messages in the php files
var incorrectPassword = document.querySelector(".incorrectPassword")
var userNotExists = document.querySelector(".userNotExists")
var userAlreadyExists = document.querySelector(".userAlreadyExists")
var failedToExcecute = document.querySelector(".failedToExcecute")
var passwordsDontMatch = document.querySelector(".passwordsDontMatch")
var InvalidPermissions = document.querySelector(".InvalidPermissions")
//Getting the error information from the URL
let params = new URLSearchParams(location.search)
var errorMsg = params.get("error")
//Showing the correct error message if an error did occur
if (errorMsg == "incorrectPassword") {
    incorrectPassword.style.display = "flex"
} else if (errorMsg == "userNotExists") {
    userNotExists.style.display = "flex"
} else if (errorMsg == "userAlreadyExists") {
    userAlreadyExists.style.display = "flex"
} else if (errorMsg == "failedToExcecute") {
    failedToExcecute.style.display = "flex"
} else if (errorMsg == "passwordsDontMatch") {
    passwordsDontMatch.style.display = "flex"
} else if (errorMsg == "InvalidPermissions") {
    InvalidPermissions.style.display = "flex"
}
