<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add live realtime data</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-extended.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/colors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/components.min.css')}}">
    <style>
        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }
        .hide{
            display: none;
        }
        .marker {
            background-image: url('https://maps.google.com/mapfiles/ms/icons/blue.png');
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }
        .expired {
            position: absolute;
            background: white;
            height: 100%;
            z-index: 2;
            width: 100%;
        }
        @media only screen and (min-device-width: 320px) and (max-width: 480px){
            .card-div{
                width: 100%;
            }

        }

    </style>
</head>
<body>


<div id="divi" class="expired" style="text-align: center;">
    <img src="/assets/img/expired.png" alt="Link Expired" style="width: 26%; margin-top: 200px;"><br/><br/>

    <strong><h2 class="font-weight-bold">Sorry, the link has expired.</h2></strong>
    <h4>Please contact the person who shared the link with you</h4>
</div>

<div id="map">
    <div class="card-div" style="z-index: 2; position: absolute">

                <div class="card h-100">

                    <img class="" src="/assets/img/logo_locomo.png" alt="Logo" style="padding: 10px; width: 50%">

                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">Status</h5>
                            <small class="">Expires in: <span id="demo"></span> </small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="activeProjects" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i id="vehicle_no" class="ti ti-dots-vertical ti-sm"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <li class="mb-4 d-flex">
                                <div class="d-flex w-50 align-items-center me-3">
                                    <img src="/assets/img/vue-logo.png" alt="laravel-logo" class="me-3" width="35">
                                    <div>
                                        <h6  class="mb-0">Ignition</h6>
                                        <small class="text-muted">eCommerce</small>
                                    </div>
                                </div>
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <span id="cont" ></span>
                                </div>
                            </li>
                            <li class="mb-4 d-flex">
                                <div class="d-flex w-50 align-items-center me-3">
                                    <img src="/assets/img/vue-logo.png" alt="laravel-logo" class="me-3" width="35">
                                    <div>
                                        <h6  class="mb-0">Ignition</h6>
                                        <small class="text-muted">eCommerce</small>
                                    </div>
                                </div>
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <span id="cont" ></span>
                                </div>
                            </li>
                            <li class="mb-4 d-flex">
                                <div class="d-flex w-50 align-items-center me-3">
                                    <img src="/assets/img/vue-logo.png" alt="laravel-logo" class="me-3" width="35">
                                    <div>
                                        <h6  class="mb-0">Ignition</h6>
                                        <small class="text-muted">eCommerce</small>
                                    </div>
                                </div>
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <span id="cont" ></span>
                                </div>
                            </li>
                            <li class="mb-4 d-flex">
                                <div class="d-flex w-50 align-items-center me-3">
                                    <img src="/assets/img/vue-logo.png" alt="laravel-logo" class="me-3" width="35">
                                    <div>
                                        <h6  class="mb-0">Ignition</h6>
                                        <small class="text-muted">eCommerce</small>
                                    </div>
                                </div>
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <span id="cont" ></span>
                                </div>
                            </li>
                            <li class="mb-4 d-flex">
                                <div class="d-flex w-50 align-items-center me-3">
                                    <img src="/assets/img/vue-logo.png" alt="laravel-logo" class="me-3" width="35">
                                    <div>
                                        <h6  class="mb-0">Ignition</h6>
                                        <small class="text-muted">eCommerce</small>
                                    </div>
                                </div>
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <span id="cont" ></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>


    </div>

</div>


<script>



    mapboxgl.accessToken = 'pk.eyJ1IjoiYmNocm9tZSIsImEiOiJjbGxtOHRtb2kyZ3BnM2hvM2ZtZGhucThuIn0.PEB7QrzJ27VEsf_BfnINfg';
    const map = new mapboxgl.Map({
        container: 'map',
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        style: 'mapbox://styles/bchrome/clih9opds007v01qv4nxo05yq',
        zoom: 17
    });



    map.on('load', async () => {
        // Get the initial location of the International Space Station (ISS).
        const geojson = await getapi();
        // Add the ISS location as a source.
        map.addSource('iss', {
            type: 'geojson',
            data: geojson
        });
        // Add the rocket symbol layer to the map.
        // map.addLayer({
        //     'id': 'iss',
        //     'type': 'symbol',
        //     'source': 'iss',
        //     'layout': {
        //         'icon-image': 'american-football',
        //         'icon-size': 5,
        //         "paint": {
        //             "fill-color": "#ff0000"
        //         }
        //     }
        // });

        map.addLayer({
            'id': 'iss',
            'type': 'circle',
            'source': 'iss',
            'paint': {
                'circle-radius': 8,
                'circle-color': '#ff0000',
                'circle-stroke-color': 'white',
                'circle-stroke-width': 3,
                'circle-stroke-opacity': 1,
                'circle-opacity': 1
            }
        });




        async function getapi() {
            // Create urlParams query string
            var urlParams = new URLSearchParams(window.location.search);

            // Get value of single parameter
            var sectionName = urlParams.get('section');

            // Output value to console
            console.log(sectionName);


            // Make a GET request to the API and return the location of the ISS.

            // Storing response


            const response = await fetch('https://neptune.sentinellab.io/api/v1/getSos?id='+ sectionName);

            // Storing data in form of JSON
            var data = await response.json();
            console.log(data);
            let dt = data["data"][0]['e_name'];
            let tt = data["data"][0]['p_name'];
            let time = new Date(data["data"][0]['expiration']);
            time.setMinutes(time.getMinutes() + 345);
            // let timeobj = time.toISOString();

            function getCurrentTimestamp () {
                var date = new Date();
                return date.toISOString()
            }
            // alert(getCurrentTimestamp());
            // alert(time.toISOString());
            // alert(data["data"][0]['expiration']);

            if (getCurrentTimestamp() < time.toISOString()) {
                $('#divi').addClass('hide');
                $.ajax({

                    url: "https://sentinel.kalperlabs.com/api/session",
                    xhrFields: {
                        withCredentials: true
                    },
                    dataType: "json",
                    type: "POST",
                    // headers: {
                    //     "Authorization": "Basic " + ("emergency@sentinellab.io" + ":" + "emergency32"),
                    //     "Accept": "application/json",
                    //     'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                    // },
                    // beforeSend: function (request) {
                    //     request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                    // },
                    data: {
                        email: dt,
                        password: tt
                    },
                    success: function(sessionResponse){
                        console.log(sessionResponse);
                        openWebsocket();
                    }
                });

                var openWebsocket = function(){
                    var ws;
                    ws = new WebSocket('wss://sentinel.kalperlabs.com/api/socket');

                    ws.onmessage =  function (evt) {
                        var received_msg = evt.data;
                        dataparsed = JSON.parse(received_msg.toString());

                        console.log(dataparsed);
                        // var lat = dataparsed["positions"][0]['latitude'];
                        // var lon = dataparsed["positions"][0]['longitude'];
                        // var ignition = dataparsed["positions"][0]['attributes']['ignition'];
                        // var vehicle_no = dataparsed["devices"][0]['name'];


                        map.getSource('iss').setData(
                            {

                                'type': 'FeatureCollection',
                                'features': [
                                    {
                                        'type': 'Feature',
                                        'geometry': {
                                            'type': 'Point',
                                            'coordinates': [dataparsed["positions"][0]['longitude'], dataparsed["positions"][0]['latitude']]
                                        }
                                    }
                                ]
                            }
                        );

                        map.flyTo({
                            center: [dataparsed["positions"][0]['longitude'], dataparsed["positions"][0]['latitude']],
                            speed: 3.5
                        });

                        document.getElementById("cont").innerHTML = dataparsed["positions"][0]['attributes']['ignition'];

                    }

                    ws.onclose = function()
                    {
                        // websocket is closed.
                        console.log("Connection is closed...");
                    };

                    window.onbeforeunload = function(event) {
                        socket.close();
                    };


                };






                // Set the date we're counting down to
                var countDownDate = new Date(data["data"][0]['expiration']).getTime();

                var x = setInterval(function() {

                    // Get today's date and time
                    var now = new Date().getTime();

                    var distance = countDownDate - now;

                    // Time calculations for days, hours, minutes and seconds
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Display the result in the element with id="demo"
                    document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                        + minutes + "m " + seconds + "s ";


                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById("demo").innerHTML = "EXPIRED";
                    }
                }, 1000);
            } else{
                alert("expired");

            }






        }




    });

    function listCookies() {
        var theCookies = document.cookie.split(';');
        var aString = '';
        for (var i = 1 ; i <= theCookies.length; i++) {
            aString += i + ' ' + theCookies[i-1] + "\n";
        }
        return aString;
    }

    console.log(listCookies());
</script>

</body>
</html>
