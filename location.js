let watchID = null;

function getLiveLocation() {
    const status = document.getElementById('status');

    if(!navigator.geolocation) {
        status.textContent = 'Geolocation is not supported by your browser';
        return
    }
    status.textContent = 'Locating...';



    watchId = navigator.geolocation.watchPosition(success, error, {
        enableHighAccuracy: true,
        maximumAge: 0,
        timeout: 5000
    });
}

function success(position) {
   const latitudeSpan = document.getElementById('latitude');
   const longitudeSpan = document.getElementById('longitude');
   const status = document.getElementById('status');

    const latitude  = position.coords.latitude;
    const longitude = position.coords.longitude;

    latitudeSpan.textContent = latitude.toFixed(6);
    longitudeSpan.textContent = longitude.toFixed(6);
    status.textContent = 'Location updated at : ${new Date().toLocaleTimeString()}';

    console.log('Lat: ${latitude}, Lon: ${longitude}');
}

function error() {
    const status = document.getElementById('status');
    

    switch (err.code) {
        case err.PERMISSION_DENIED:
            status.textContent = "User denied the request for Geolocation."
            break;
        case err.POSITION_UNAVAILABLE:
            status.textContent = "Location information is unavailable."
            break;
        case err.TIMEOUT:
            status.textContent = "The request to get user location timed out."
            break;
        default:
            status.textContent = "An unknown error occurred."
            break;
    }

    if (watchID != null) {
        navigator.geolocation.clearWatch(watchID);
        
    }
}


// code to clear previous data

function clearPreviousData() {

    const latitudeSpan = document.getElementById('latitude');
    const longitudeSpan = document.getElementById('longitude');
    const status = document.getElementById('status');
    const outputDiv = document.getElementById('output');

    if (latitudeSpan) {
        latitudeSpan.textContent = 'N/A';
    }
    if (longitudeSpan) {
        longitudeSpan.textContent = 'N/A';
    }
    if (status) {
        status.textContent = 'Data cleared.';
    }
    


    localStorage.removeItem('latitude');
    localStorage.removeItem('longitude');

    sessionStorage.removeItem('latitude');
    sessionStorage.removeItem('longitude');


    const dataForms = document.getElementsByTagName('form');
    if (dataForm) {
        dataForm
    }

    console.log('Previous location data cleared.');


}