<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
</head>
<script>
  // Register service worker
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
    navigator.serviceWorker.register('servicefile.js').then(function(registration) {
    // Registration was successful
    console.log('ServiceWorker registration successful');
    }, function(err) {
    // registration failed 😦
    console.log('ServiceWorker registration failed: ', err);
    });
    });
    
    }
    
    // Check browser cache first, use if there and less than 10 seconds old
    if(localStorage.when != null
    && parseInt(localStorage.when) + 1000 > Date.now()) {
    let freshness = Math.round((Date.now() - localStorage.when)/1000) + " second(s)";
            document.getElementById("description").innerHTML=localStorage.description
            document.getElementById("tem").innerHTML=localStorage.tem + "°C"
            document.getElementById("humidity").innerHTML=localStorage.humidity + "%"
            document.getElementById("speed").innerHTML=localStorage.speed + "km/hr"
            document.getElementById("pressure").innerHTML=localStorage.pressure + " hPa"
            document.getElementById("dt").innerHTML=localStorage.dt
    document.getElementById("mylastupdate").innerHTML = freshness;
    // No local cache, access network
    } else {
    // Fetch weather data from API for given city
    fetch('api.php?city=Santa+Ana') //retrive the data from the php.
    // Convert response string to json object
    .then(response => response.json())
    .then(response => {
    // Copy one element of response to our HTML paragraph
            document.getElementById("description").innerHTML=response.weather
            document.getElementById("tem").innerHTML=response.temperature + "°C"
            document.getElementById("humidity").innerHTML=response.humidity + "%"
            document.getElementById("speed").innerHTML=response.wind + "km/hr"
            document.getElementById("pressure").innerHTML=response.pressure + " hPa"
            document.getElementById("dt").innerHTML=response.datetimes
    
    // Save new data to browser, with new timestamp
    localStorage.description = response.weather;
    localStorage.tem = response.temperature + '';
    localStorage.when = Date.now(); // milliseconds since January 1 1970
    localStorage.humidity = response.humidity;
    localStorage.speed = response.wind;
    localStorage.pressure = response.pressure;
    localStorage.dt = response.datetimes;
    
    
    })
    .catch(err => {
        if(localStorage.when != null) {
    // Get data from browser cache
    let freshness = Math.round((Date.now() - localStorage.when)/1000) + " second(s)";
            document.getElementById("description").innerHTML=localStorage.description
            document.getElementById("tem").innerHTML=localStorage.tem + "°C"
            document.getElementById("humidity").innerHTML=localStorage.humidity + "%"
            document.getElementById("speed").innerHTML=localStorage.speed + "km/hr"
            document.getElementById("pressure").innerHTML=localStorage.pressure + " hPa"
            document.getElementById("dt").innerHTML=localStorage.dt
            document.getElementById("mylastupdate").innerHTML = freshness; 
    } else {
    // Display errors in console
    console.log(err);
    }
    
    
    });
    }
</script>
       
<style>
    .card{
        width: 250px;
        padding: 5px 10px;
        border: 5px solid skyblue;
    }
    header{
        font-weight: bolder;
        font-size: 50px;
        padding: 10px 10px;
        text-transform: uppercase;
        word-spacing: 5px;
    }
    .icon{
        display: inline;
        height: 20px;
    }
    .location{
        font-size: 30px;
        font-weight: bold;
    }
    .weather{
        border: 2px solid skyblue;
        margin-left: 10px;
        width: 300px;
        
    }
        </style>
    <body style="background-color: burlywood">
        <header>Weather Forcast Application</header>
        <div class="container">
        <img src="./image.jpg.jpg" alt="Santa Ana" width="700px" padding="50px 10px" height="500" >
        <br>
        <div class="location"><svg class="icon"  fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>Santa Ana, California, USA</div>
        <br><br>
        <div class="weather">
            <table>
                <tr>
                    <td><img id="icon" src=""></td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td id='description'>Sunny</td>
                </tr>

                <tr>
                    <td>Temperature: </td>
                    <td id='tem'></td>
                </tr>

                <tr>
                    <td>Pressure: </td>
                    <td id='pressure'></td>
                </tr>

                <tr>
                    <td>Humidity: </td>
                    <td id='humidity'></td>
                </tr>

                <tr>
                    <td>Wind Speed: </td>
                    <td id='speed'></td>
                </tr>

                <tr>
                    <td>Dateandtimes: </td>
                    <td id='dt'></td>
                </tr>

                <tr>
                    <td>Latestupdate:</td>
                    <td id='mylastupdate'></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>
