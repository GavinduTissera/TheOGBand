

// === GALLERY SCRIPT START ===


// Auto navigation
var ImageCounter = 1;
//Every 5 seconds it checks (aka navigates to) the counter and increments the counter.
var interval = setInterval( function(){
    document.getElementById("radio" + ImageCounter).checked = true;
    ImageCounter++;
    if(ImageCounter > 5){
        ImageCounter = 1;
    }
}, 5000)


//When the left arrow is pressed in the gallery, it moves the counter to the previous image
function DecrementCounter() {
    //If the counter is 1, it wraps to the last image
    if (ImageCounter == 1) {
        ImageCounter = 5
    } else {
        ImageCounter--;
    }
    //it also stops the auto navigation for 5 seconds
    setTimeout(interval,5000)
    document.getElementById("radio" + ImageCounter).checked = true;
}

//When the right arrow is pressed in the gallery, it moves the counter to the next image
function IncrementCounter() {
    //If the counter is 5, it wraps to the first image
    if (ImageCounter == 5) {
        ImageCounter = 1
    } else {
        ImageCounter++;
    }
    //it also stops the auto navigation for 5 seconds
    setTimeout(interval,5000)
    document.getElementById("radio" + ImageCounter).checked = true;
}

// === GALLERY SCRIPT END ===