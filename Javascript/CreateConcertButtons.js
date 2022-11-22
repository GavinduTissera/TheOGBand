// This file changes the class names of the buttons in 3.php when they are clicked to kickstart animations
//Sets constants
const AddNewVenueButton = document.getElementById("AddNewVenueButton")
const UseExistingVenueButton = document.getElementById("UseExistingVenueButton")
const SeperatorBar = document.getElementById("SeperatorBar")
const AddNewVenueContent = document.getElementById("AddNewVenue")
const UseExistingVenueContent = document.getElementById("UseExistingVenue")
//Adds an event listener for both the add new venue button and the use existing venue buttons. It changes the classes to include content and include animations
AddNewVenueButton.addEventListener("click", function() {
    if (AddNewVenueButton.classList.contains("deselected")) {
        //If it was deselected, Make the button and the content selected (aka shown) and hide the other button, seperator bar and content.
        AddNewVenueButton.classList.replace("deselected", "selected")
        UseExistingVenueButton.classList.replace("deselected", "hidden")
        SeperatorBar.classList.replace("deselected", "hidden")
        AddNewVenueContent.classList.replace("hide", "show")
    } else {
        //If it was already selected, hide all content, and show the AddNewVenueButton, UseExistingVenueButton, SeperatorBar on screen
        AddNewVenueButton.classList.replace("selected", "deselected")
        UseExistingVenueButton.classList.replace("hidden", "deselected")
        SeperatorBar.classList.replace("hidden", "deselected")
        AddNewVenueContent.classList.replace("show", "hide")
    }
})

//Does the same thing as above except for UseExistingVenueButton
UseExistingVenueButton.addEventListener("click", function() {
    if (UseExistingVenueButton.classList.contains("deselected")) {
        UseExistingVenueButton.classList.replace("deselected", "selected")
        AddNewVenueButton.classList.replace("deselected", "hidden")
        SeperatorBar.classList.replace("deselected", "hidden")
        UseExistingVenueContent.classList.replace("hide", "show")
    } else {
        UseExistingVenueButton.classList.replace("selected", "deselected")
        AddNewVenueButton.classList.replace("hidden", "deselected")
        SeperatorBar.classList.replace("hidden", "deselected")
        UseExistingVenueContent.classList.replace("show", "hide")
    }
})