//Main program calls this function when running the script
function initMap() {
    //Initialising the map
    const VenueMap = new google.maps.Map(document.getElementById("GoogleMapsVenue"), {
        //Setting the center of the map to be in the middle of the UK, as well as the zoom level to include the whole country
        center: { 
            lat: 54.37210002361962,
            lng: -4.274483229735648
        },
        zoom: 6,
    })
    //Setting the input field for the address
    const InputField = document.getElementById("addressInput")
    //Setting error message fields, venue name input field, submit button (to disable it when a non-existent address is searched for) and also where the address will be stored.
    const ErrorMessage = document.getElementById("errorMessage")
    const VenueNameInput = document.getElementById("VenueNameInput")
    const SubmitButton = document.getElementById("SubmitButton")
    const locationData = document.getElementById("locationData")
    //Setting the infowindow which is the box that comes up when clicking on a marker
    const InfoWindow = new google.maps.InfoWindow()
    const InfoWindowContent = document.getElementById("infowindowContent")
    const options = {
        fields: ["place_id", "geometry", "formatted_address", "name", "photos"],
        strictBounds: false,
    }
    //Using google maps api to include autocomplete on the address input. Using json to set output data and also to make sure the map favours the locations in the viewport but also include locations from elsewhere
    const Autocomplete = new google.maps.places.Autocomplete(InputField, options)
    
    // Binding the autocomplete bias to the places visible in the map
    Autocomplete.bindTo("bounds", VenueMap)
    //Setting the content of the infowindow
    InfoWindow.setContent(InfoWindowContent)

    const marker = new google.maps.Marker({
        map: VenueMap,
        anchorPoint: new google.maps.Point(0, -29),
    })

    //Adds an event listener when the place is changed. For example if someone searches for a new address
    Autocomplete.addListener("place_changed", () => {
        //Allowing the submit button to be clicked again
        SubmitButton.style.userSelect = "auto"
        SubmitButton.style.cursor = "pointer"
        //Setting the value for the venue name to nothing
        VenueNameInput.value = ""
        //Hides existing markers
        marker.setVisible(false)
        //Closes existing info windows
        InfoWindow.close()
        // In case there was an error before, this removes the error when the text changes
        ErrorMessage.classList.remove("hide", "show")
        ErrorMessage.classList.add("hide")
        //gets the address from the place from the autocomplete section
        var venueAddress = Autocomplete.getPlace()
        //If the place isn't real then the if statement runs
        if (!venueAddress.geometry || !venueAddress.geometry.location) {
            ErrorMessage.classList.replace("hide", "show")
            SubmitButton.style.userSelect = "none"
            SubmitButton.style.cursor = "not-allowed"
        }

        //If the searched for place is currently in the viewport then it sets the bounds around the location, else it sets the new center to be the location and zooms in
        if (venueAddress.geometry.viewport) {
            VenueMap.fitBounds(venueAddress.geometry.viewport)
        } else {
            VenueMap.setCenter(venueAddress.geometry.location)
            VenueMap.setZoom(17)
        }
        // Sets the marker in the location that is searched for
        marker.setPosition(venueAddress.geometry.location)
        marker.setVisible(true)

        //sets the info window and adds the text inside
        InfoWindowContent.children["place-name"].textContent = venueAddress.name
        InfoWindowContent.children["place-address"].textContent = venueAddress.formatted_address
        InfoWindow.open(VenueMap, marker)
        VenueNameInput.value = venueAddress.name
        locationData.value = venueAddress.geometry.location

    })
}

window.initMap = initMap;