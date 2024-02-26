<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SOS Locomo</title>
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
        #map { position: absolute; top: 0; bottom: 0; width: 100%; height: 80% }
        .header{
            z-index: 2;
            position: absolute;

        }
        .show{
            display: block !important;
        }
        .marker {
            background-image: url('https://maps.google.com/mapfiles/ms/icons/blue.png');
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }
        .card-div{
            z-index: 2;
            position: absolute;
            height: 25%;
            bottom: 0;
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
        .marker {
            background-image: url('https://www.locomo.us/wp-content/uploads/2024/02/bike_marker.png');
            background-size: cover;
            width: 30px;
            height: 30px;
            /*border-radius: 50%;*/
            cursor: pointer;
        }


    </style>
</head>
<body>
{{--<div>--}}
{{--    <div class="text-center">--}}
{{--        <div class="spinner-border" role="status">--}}
{{--            <span class="sr-only">Loading...</span>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div id="divi" class="expired" style="text-align: center; z-index: 5; display: none">
    <img src="https://www.locomo.us/wp-content/uploads/2024/01/expired.png" alt="Link Expired" style="padding: 10px;width: 33%;float: right;"><br/><br/>
    <strong><h2 class="font-weight-bold">Sorry, the link has expired.</h2></strong>
    <h4>Please contact the person who shared the link with you</h4>
</div>
<div class="header">
    <img class="" src="https://www.locomo.us/wp-content/uploads/2023/02/locomo332x114.png" alt="Logo" style="padding: 10px; width: 50%">

</div>

<div id="map">


</div>
<div class="card-div" style="">

    <div class="card h-100">


        <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
                <h5 id="vno" class="mb-0"></h5>
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
                <li class=" d-flex">
                    <div class="d-flex w-50 align-items-center me-3">
                        <img src="https://www.locomo.us/wp-content/uploads/2023/03/cropped-locomo-app-icon.png" alt="laravel-logo" class="me-3" width="35">
                        <div>
                            <h6  class="mb-0">Ignition</h6>
                            <small class="text-muted"></small>
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


</body>

<script>



    // mapboxgl.accessToken = 'pk.eyJ1IjoiYmNocm9tZSIsImEiOiJjbGxtOHRtb2kyZ3BnM2hvM2ZtZGhucThuIn0.PEB7QrzJ27VEsf_BfnINfg';
    mapboxgl.accessToken = 'pk.eyJ1IjoiYmNocm9tZSIsImEiOiJjajlzMHlkc3M2OTBoMnlsZ2Y4ZmJtbWdrIn0.cZx1MyPBu4YCOFh99qbYuw';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/bchrome/clih9opds007v01qv4nxo05yq',
        center: [-4.297239, 2.030773],
        // zoom: 8
    });

    const el = document.createElement('div');
    el.className = 'marker';
    const marker = new mapboxgl.Marker(el);
    // Add zoom and rotation controls to the map.
    map.addControl(new mapboxgl.NavigationControl());




    map.on('load', async () => {
        // Get the initial location of the International Space Station (ISS).
        await getapi();
        async function getapi() {
            // Create urlParams query string
            var urlParams = new URLSearchParams(window.location.search);

            // Get value of single parameter
            var sectionName = urlParams.get('section');
            const response = await fetch('https://neptune.sentinellab.io/api/v1/getSos?id='+ sectionName);

            // Storing data in form of JSON
            var data = await response.json();
            let dt = data["data"][0]['e_name'];
            let tt = data["data"][0]['p_name'];
            let time = data["data"][0]['expiration'];

            function getCurrentTimestamp () {
                var date = new Date();
                return date.toISOString()
            }

            if (getCurrentTimestamp() < time) {
                // $('.expired').style.display='block';
                $.ajax({

                    url: "https://sentinel.kalperlabs.com/api/session",
                    xhrFields: {
                        withCredentials: true
                    },
                    dataType: "json",
                    type: "POST",

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
                        // console.log(dataparsed.devices[0].uniqueId);



                        function animateMarker(timestamp) {

                            marker .setLngLat([dataparsed["positions"][0]['longitude'] ?? 0, dataparsed["positions"][0]['latitude'] ?? 0])
                            marker.addTo(map);
                            requestAnimationFrame(animateMarker);
                        }

                        requestAnimationFrame(animateMarker);


                        if (map.getZoom() == 0){
                            cz = 15;
                        }
                        else{
                            cz = map.getZoom();
                        }

                        map.flyTo({
                            center: [dataparsed.positions[0].longitude, dataparsed.positions[0].latitude],
                            speed: 3.5,
                            zoom: cz,
                            rotation: 90
                        });
                        marker.setRotation(dataparsed.positions[0].course);


                        document.getElementById("cont").innerHTML = dataparsed.positions[0].attributes.ignition;
                        // document.getElementById("vno").innerHTML = dataparsed.devices[0].name;




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
            }
            else{
                // alert("expired");
                document.getElementById( 'divi' ).style.display = 'block';

            }






        }




    });


    // fetch("https://sentinel.kalperlabs.com/api/devices")
    //     .then(response => response.text())
    //     .then(result => console.log(result))
    //     .catch(error => console.log('error', error));






</script>


</html>
